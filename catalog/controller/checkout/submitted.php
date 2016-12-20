<?php
/**
 * 中银消费支付类，调用中银支付消费接口
 * @author Administrator
 *
 */
class ControllerCheckoutSubmitted extends Controller {
	public function index() {
	    
		if (isset($this->session->data['order_id'])) {
            
			$this->load->model('account/order');
			
			$this->load->model('checkout/order');
			
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_submitted'));
			
			$order_id = $this->session->data['order_id'];
			
			$out_trade_no = $this->getOutTradeNo();
			
			$this->model_account_order->setOutTradeNoByOrderNo($order_id , $out_trade_no);
			
			$orderInfo = $this->model_account_order->getOrder($order_id);
			
			$products   = $this->model_account_order->getOrderProducts($order_id);
			
			
			// Add to activity log
			$this->load->model('account/activity');
            
			if ($this->customer->isLogged()) {
				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFullName(),
					'order_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_account', $activity_data);
			} else {
				$activity_data = array(
					'name'     => $this->session->data['guest']['fullname'],
					'order_id' => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_guest', $activity_data);
			}
			//贷款账户账号
			$loanAcctNo = $this->customer->getLoanAcctno();
			//app客户编号
			$app_customerid = $this->customer->getAppCustomerId();
			
			$mobilephone    = $this->customer->getTelephone();
			$verif_code = '';
			if(isset($this->request->post['verif'])){
			    $verif_code = intval($this->request->post['verif']);
			}
			$xmlStr= '<?xml version="1.0" encoding="UTF-8" ?>';
			$xmlStr.= '<message>';
			$xmlStr.= '<head>';
			$xmlStr.= '<transCode>3223</transCode>';                                  //交易代码
			$xmlStr.= '<transReqTime>'.date('YmdHis').'</transReqTime>';              //交易请求时间
			$xmlStr.= '<transSeqNo>'.date('YmdHis').rand(10000,99999).'</transSeqNo>';                   //交易流水号，输入报文流水号
			$xmlStr.= '<merchantId>'.$this->merchantId.'</merchantId>';               //商户代码
			$xmlStr.= '<customerId>'.$app_customerid.'</customerId>';                 //客户ID（申请编号）
			$xmlStr.= '<version>1.0</version>';                                       //版本号
			$xmlStr.= '</head>';
			$xmlStr.= '<body>';
			$xmlStr.= '<loanAcctNo>'.$loanAcctNo.'</loanAcctNo>';                        //贷款账户账号
			$xmlStr.= '<merchantCode>'.$this->merchantCode.'</merchantCode>';            //支付商户商户号
			$xmlStr.= '<payAmount>'.floatval(sprintf('%.2f' , $orderInfo['total'])*100).'</payAmount>'; //消费支付金额（单位：分）
			$xmlStr.= '<dynamicPwdCheck>Y</dynamicPwdCheck>';                          //是否需要验证动态密码标记
			$xmlStr.= '<dynamicPwd>'.$verif_code.'</dynamicPwd>';                      //动态密码
			$xmlStr.= '<merchantOrderId>'.$out_trade_no.'</merchantOrderId>';          //商品购买交易訂单号
			$xmlStr.= '<payType>1</payType>';                                          //消费支付类型1：消费信用支付 2：账户充值
			$xmlStr.= '<chargeType>1</chargeType>';                                     //账户充值类型1：账户贷款充值 9：退货溢出款充值
			$xmlStr.= '<currency>001</currency>';                                      //此栏位默认值：001（人民币）
			$xmlStr.= '<useTempCreLine>N</useTempCreLine>';                            //是否同意加额？
			$xmlStr.= '<payDescription>'.urlencode($products[0]['name']).'</payDescription>';     //用途说明
			$xmlStr.= '</body>';
			$xmlStr.= '</message>';
			$log = new Log('pay/pay'.date('Ymd').'.log');
			$log->write('pay :: app_customerid:'.$app_customerid);
			$log->write('pay :: order_id:'.$order_id);
			$log->write('pay :: sendxml:'.$xmlStr);
			//print_r($xmlStr);die();
			$xmlStr = preg_replace("/(\r\n|\n|\r|\t)/i", '', $xmlStr);
			$curlDeal = new curl_deal();
			//decrypt
			$xmlSignature = $curlDeal->postData('http://192.168.5.18:8080/tan-springmvc-book/book.do?method=encrypt' , array('content'=>$xmlStr));
			$log->write('pay :: xmlSignature:'.$xmlSignature);
			$postUrl = APP_PAYMENT_HOST;
			// 		    $curl = curl_init();
			//             //设置url
			//             curl_setopt($curl, CURLOPT_URL,$postUrl);
			//             //设置发送方式：
			//             curl_setopt($curl, CURLOPT_POST, true);
			//             //设置发送数据
			//             curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlSignature);
			// 		    $result = curl_exec($curl);
			
			$header[] = "Content-type: text/xml";        //定义content-type为xml,注意是数组
			$ch = curl_init ($postUrl);
			curl_setopt($ch, CURLOPT_URL, $postUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlSignature);
			$response = curl_exec($ch);
			if(curl_errno($ch)){
			    print curl_error($ch);
			}
			curl_close($ch);
		
		    $log->write('pay :: response:'.$response);
// 		    print_r($response);die();
			// Payment Methods
			/*$response = '<?xml version="1.0" encoding="UTF-8"?><message><head><transCode>3223</transCode><transReqTime>20160330144402</transReqTime><transRepTime>20160330151427</transRepTime><transSeqNo>2016033014440253601</transSeqNo><transRepSeqNo>20160330151427914000000004256136</transRepSeqNo><merchantId>N03020100000000</merchantId><customerId>0000000000000067</customerId><version>1.0</version><returnCode>000000</returnCode><errorMsg/></head><body><loanAcctNo>6010005055837</loanAcctNo><amount>220</amount><merchantOrderId>2016033014440253601</merchantOrderId><payGateOrderId>20160330151427282000000000004749</payGateOrderId><merchantCode>N03020100000010</merchantCode></body><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>xnj2+rewvzs20zh8i1me5puA4U0=</DigestValue></Reference></SignedInfo><SignatureValue>JOPWa46ORxkEhxfSzjHUDDg51YS61CpqAiTr888kbAHPLTPsrB3GSOFRutnpLGye+uGUyLGf3OJL
                        4VW0O8Hk1GvvFwR0NnYDPBBe2Ebq8wRKdn05D5yO0cnXfzt1yXnOFSTeLalM0gsFHytsHc2Rl1Gb
                        +EgesX+szuVaj+Mw9qg=</SignatureValue></Signature></message>';
			
			$response = '<?xml version="1.0" encoding="UTF-8"?><message><head><transCode>3223</transCode><transReqTime>20160330150001
                        </transReqTime><transRepTime>20160330153026</transRepTime><transSeqNo>2016033015000184869</transSeqNo
                        ><transRepSeqNo/><merchantId>N0302010000000022</merchantId><customerId>000000000000006722</customerId
                        ><version>1.0</version><returnCode>100001</returnCode><errorMsg>数字签名错误</errorMsg></head><Signature xmlns
                        ="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org
                        /TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"
                        /><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"
                        /></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>WRkWYRQ40hPAN
                        /0a0Xspxm0Q+fg=</DigestValue></Reference></SignedInfo><SignatureValue>A6ApGs7O0M8NJIDNAcerE8xS791w0pB46GTRFJwtGb1aYnZZcU5mbcRhor9lxhHfBxCnFhuQQxcp
                        
                        zIuTt2xp7E+nisT+ECXRhULmuOXWUxz1Q/Abx3QUFJ4QKKRqMY1rLbxkQLu0td7q/mDZTpAjwt7R
                        MEZfxjQeVRpyfGowHwg=</SignatureValue></Signature></message>';*/
		    $result = simplexml_load_string($response);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			//unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
			$log->write('pay :: result:'.strval($result->head->returnCode));
			if(strval($result->head->returnCode) == '000000'){
			    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'));
			    $json['result']   = '000000';
			    $json['redirect'] = $this->url->link('checkout/success');
			    $json['error'] 	  =  '';
			}else{
			    $json['result']   = '000001';
			    $json['redirect'] = $this->url->link('checkout/result');
			    $this->session->data['pay_error'] = strval($result->head->errorMsg);
			    $json['error'] = strval($result->head->errorMsg);
			}
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	
	
	public function getOutTradeNo(){
	    return date("YmdHis").rand(10000,99999);
	}
}