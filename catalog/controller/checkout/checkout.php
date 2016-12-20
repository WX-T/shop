<?php
class ControllerCheckoutCheckout extends Controller {
	public function index() {
	    $data['logged'] = $this->customer->isLogged();
	   /*  if(!$data['logged']){
	        $this->session->data['redirect'] = $this->url->link('checkout/checkout');
 	        $this->response->redirect(APP_LOGIN_URL); 
// 	        $this->response->redirect($this->url->link('account/login'));
	    } */
	    $userstatus = $this->customer->getUserStatus();
	    if(in_array($userstatus, array('2','3','4'))){
	        $this->response->redirect($this->url->link('checkout/cart'));
	    }
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}
		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();
	
		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
 
			if ($product['minimum'] > $product_total) {
				$this->response->redirect($this->url->link('checkout/cart'));
			}
		}

		$data['product_total'] = $product_total;
		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		// Required by klarna
		if ($this->config->get('klarna_account') || $this->config->get('klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_checkout_option'] = $this->language->get('text_checkout_option');
		$data['text_checkout_account'] = $this->language->get('text_checkout_account');
		$data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
		$data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
		$data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');
		$data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');
		$data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');

		if($this->customer->getCardType()){
		    $cardVal = $this->_cardType[$this->customer->getCardType()];
		}else{
		    $cardVal = '';
		}
		
		$data['cardinfo'] = array('cardType'=>$this->customer->getCardType() , 'cardVal'=> $cardVal, 'cardName'=>$this->customer->getCardName()  , 'cardID'=>$this->customer->getCardID());
		
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}
		$data['shipping_required'] = $this->cart->hasShipping();
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/checkout.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/checkout.tpl', $data));
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	/**
	 * 发送验证码
	 */
	public function sendverif(){
	    echo 1;exit;
	        $log = new Log('verifcode/verifcode'.date('Ymd').'.log');
	        //贷款账户账号
			$loanAcctNo = $this->customer->getLoanAcctno();
			//app客户编号
			$app_customerid = $this->customer->getAppCustomerId();
			$log->write('Verifcode :: customerId:'.$app_customerid);
			$mobilephone = $this->customer->getTelephone();
			$xmlStr= '<?xml version="1.0" encoding="UTF-8" ?>';
			$xmlStr.= '<message>';
			$xmlStr.= '<head>';
			$xmlStr.= '<transCode>1011</transCode>';                                  //交易代码
			$xmlStr.= '<transReqTime>'.date('YmdHis').'</transReqTime>';              //交易请求时间
			$xmlStr.= '<transSeqNo>'.date('YmdHis').rand(10000,99999).'</transSeqNo>';                   //交易流水号，输入报文流水号
			$xmlStr.= '<merchantId>'.$this->merchantId.'</merchantId>';               //商户代码
			$xmlStr.= '<customerId>'.$app_customerid.'</customerId>';                 //客户ID（申请编号）
			$xmlStr.= '<version>1.0</version>';                                       //版本号
			$xmlStr.= '</head>';
			$xmlStr.= '<body>';
			$xmlStr.= '<acctNo>'.$loanAcctNo.'</acctNo>';                        //贷款账户账号
			$xmlStr.= '<mobileNo>'.$mobilephone.'</mobileNo>';                        //手机号码
			$xmlStr.= '</body>';
			$xmlStr.= '</message>';
			$xmlStr = preg_replace("/(\r\n|\n|\r|\t)/i", '', $xmlStr);
			
			$curlDeal = new curl_deal();
			//decrypt
			$xmlSignature = $curlDeal->postData('http://192.168.5.18:8080/tan-springmvc-book/book.do?method=encrypt' , array('content'=>$xmlStr));
			
			$postUrl = APP_PAYMENT_HOST;
 		    $curl = curl_init();
            //设置url
            //curl_setopt($curl, CURLOPT_URL,$postUrl);
             //设置发送方式：
             //curl_setopt($curl, CURLOPT_POST, true);
             //设置发送数据
             //curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlSignature);
 		    //$result = curl_exec($curl);
			$log->write('Verifcode :: xmlSignature:'.$xmlSignature);
			$header[] = "Content-type: text/xml";        //定义content-type为xml,注意是数组
			$ch = curl_init ($postUrl);
			curl_setopt($ch, CURLOPT_URL, $postUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlSignature);
			$response = curl_exec($ch);
			$log->write('Verifcode :: response:'.$response);
			$result = simplexml_load_string($response);
			$log->write('Verifcode :: result:'.$result->head->returnCode.PHP_EOL);
			//echo strval($result->head->returnCode);
			if(strval($result->head->returnCode)=='000000'){
			    //验证码发送成功
			    $this->session->data['is_verif'] = true;
			    echo '1';
			}else{
			    $this->session->data['is_verif'] = false;
			    echo '0';
			}
			if(curl_errno($ch)){
			    print curl_error($ch);
			}
			curl_close($ch);
	}
	
	/**
	 * 判断是否成功发送验证码
	 */
	public function is_send(){
	    echo 1;exit;
	   if(isset($this->session->data['is_verif']) && $this->session->data['is_verif']){
	        echo '1';
	        unset($this->session->data['is_verif']);
	    }else{
	        echo '0';
	    }
	}
}