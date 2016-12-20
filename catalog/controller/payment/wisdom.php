<?php
/**
 * 智慧支付接口
 * @author binzhao
 * @createTime 2015-12-10
 *
 */
class ControllerPaymentWisdom extends Controller {
	public function index() {
        
		$this->load->helper('wisdom_algorithm');
		
		$this->load->helper('DoBackgroundRequest');
		
		$this->language->load('payment/wisdom');

		$data['button_confirm']       = $this->language->get('button_confirm');
		
		$this->load->model('account/order');

		$order_id = $this->session->data['order_id'];

		$order_info = $this->model_account_order->getOrder($order_id);
		
		$products   = $this->model_account_order->getOrderProducts($order_id);

		$item_name = $this->config->get('config_name');
		
		$bankList = $this->config->get('wisdom_banks') ? unserialize($this->config->get('wisdom_banks')) : array();
		
		$this->load->model('tool/image');
		
		$banks = array();
		
		foreach ($bankList as $key=>$bank){
		     if ($bank['image']){
		         $bank['thumb'] = $this->model_tool_image->resize($bank['image'], 138, 48);
		     }else{
		         $bank['thumb'] = $this->model_tool_image->resize('no_image.png', 138, 48);
		     }
		     $banks[$key] = $bank;
		     
		}
		ksort($banks);
		$data['bankList'] = $banks;
		
		$fullname = $order_info['payment_fullname'];
		
		$this->load->model('account/order');

		$shipping_cost = 0;

		$totals = $this->model_account_order->getOrderTotals($order_id);

		foreach ($totals as $total) {
			
			if($total['title'] == 'shipping') {
				
				$shipping_cost = $total['value'];
				
			}
		}
		
		$out_trade_no = $this->getOutTradeNo();
        
		$this->model_account_order->setOutTradeNoByOrderNo($order_id , $out_trade_no);
		
		//参数封装
		$interfaceName         = 'PayOrder_NS';
		//$nodeAuthorizationURL  = 'http://124.207.79.67:8086/pay/preprocess.do';                 //请求地址
		$nodeAuthorizationURL  = 'https://www.chinagpay.com/pay/preprocess.do';                   //请求地址
		$keyValue		       = $this->config->get('wisdom_security_code');                      //用户密钥
		$merId	               = $this->config->get('wisdom_partner');                            //商户ID
		$curType               = 'CNY';                                                           //货币类型
		$merURL                = $this->url->link('checkout/success');                            //支付完成后跳转地址
		$serverNotifyURL       = HTTPS_SERVER.'catalog/controller/payment/wisdom_callback.php';
		$bankId                = '102';
		//$remark                = 'pay';
		$version               = 'B2C1.0';
		
		
		$transactionDataStr = '<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq>';
		$transactionDataStr .= "<merId>".$merId."</merId>";
		$transactionDataStr .= "<curType>".$curType."</curType>";
		$transactionDataStr .= '<orderNo>'.$out_trade_no.'</orderNo>';
		$transactionDataStr .= '<orderAmt>'.sprintf("%.2f", $order_info['total']).'</orderAmt>';
		$transactionDataStr .= '<goodsName>'.iconv('UTF-8', 'GBK', str_replace(array('|','&','=') , '', $products[0]['name'])).'</goodsName>';
		$transactionDataStr .= '<goodsDesc></goodsDesc>';
		$transactionDataStr .= '<mallUserName>'.$this->customer->getEmail().'</mallUserName>';
		$transactionDataStr .= '<remark>B2C</remark>';
		$transactionDataStr .= "<returnURL>".$merURL."</returnURL>";
		$transactionDataStr .= "<notifyURL>".$serverNotifyURL."</notifyURL>";
		$transactionDataStr .= '<reserved1></reserved1>';
		$transactionDataStr .= '<reserved2></reserved2>';
		$transactionDataStr .= "</B2CReq>";       // 支付通道编码
		
		
		// 获得MD5-HMAC签名
		$hmac = HmacMd5($transactionDataStr,$keyValue);
		
		$tranData =  base64_encode($transactionDataStr);
        
		$parameter = array(
				"interfaceName"         => $interfaceName,
				"bankId"	            => $bankId,
				"version"	            => $version,
		        "tranData"              => $tranData,
				"merSignMsg"	        => $hmac,
				"merchantId"   	        => $merId
		);
		
		$data['html_text'] = $this->buildRequestForm($nodeAuthorizationURL, $parameter);
		
		
		$data['result_url'] = $this->url->link('checkout/result');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/wisdom.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/wisdom.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/wisdom.tpl', $data);
		}
		
	}
	
	
	public function getOutTradeNo(){
	    return date("YmdHis").rand(10000,99999);
	}
	
	/**
	 * 封装支付表单
	 * @param unknown $nodeAuthorizationURL
	 * @param unknown $param
	 */
	public function buildRequestForm($nodeAuthorizationURL , $param){
	    $sHtml = '<form id="wisdomsubmit" name="wisdomsubmit" action="'.$nodeAuthorizationURL.'" method="POST">';
	    while (list ($key, $val) = each($param)) {
	        $sHtml.= "<input type='hidden' name='".$key."' id='".$key."' value='".$val."'/>";
	    }
	    $sHtml = $sHtml."</form>";
	    return $sHtml;
	}
	
	
    public function callback() {
        
		$log = $this->config->get('wisdom_log');
		if($log) {
			$this->log->write('Wisdom :: One: ');
		}
		if(isset($this->request->post['signData'])) {
		    $keyValue		       = $this->config->get('wisdom_security_code');
			$params = $this->request->post;
			$key = $this->config->get('wisdom_security_code');
			$checkSign = $params['signData'];
			if($log) {
				$this->log->write('Wisdom :: Two: ' . $checkSign);
			}
			$transData = base64_decode($params['tranData']);
			
			$this->load->helper('wisdom_algorithm');
			// 获得MD5-HMAC签名
			$hmac = HmacMd5($transData,$keyValue);
			if($log) {
				$this->log->write('Wisdom :: Three: ' . $hmac);
			}
			if($checkSign == $hmac){
			    $dataObject = simplexml_load_string($transData);
				if(isset($dataObject->orderNo)) {
				    $this->load->model('account/order');
				    $orderIdInfo = $this->model_account_order->getOrderInfoByOutTradeNo($dataObject->orderNo);
				    $order_id = $orderIdInfo['order_id'];
				}else{
					$order_id = 0;
				}
				if($log) {
					$this->log->write('Wisdom :: Four: ' . $order_id);
				}
				$this->load->model('checkout/order');
				$order_info = $this->model_checkout_order->getOrder($order_id);
				if ($order_info) {
					if($log) {
						$this->log->write('Wisdom :: Five: ');
					}
					$order_status_id = $this->config->get('wisdom_trade_paid_status_id');
					if (!$order_info['order_status_id']) {
						$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);
						if($log) {
							$this->log->write('Wisdom :: Six: ');
						}
					} else {
						$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);
						if($log) {
							$this->log->write('Wisdom :: Seven: ');
						}
					}
					echo $dataObject->merchantId;
				}else{
					if($log) {
						$this->log->write('Wisdom :: Eight: ');
					}
				}
			}else{
				if($log) {
					$this->log->write('Wisdom :: Nine: ');
				}	
			}
		}else{
			if($log) {
				$this->log->write('Wisdom :: Ten: ');
			}
		}
	}

	
}