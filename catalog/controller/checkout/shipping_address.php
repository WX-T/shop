<?php
class ControllerCheckoutShippingAddress extends Controller {
    private $_cardType = array('1'=>'身份证','2'=>'台胞证');
	public function index() {
		$this->load->language('checkout/checkout');

		$data['text_address_existing'] = $this->language->get('text_address_existing');
		$data['text_address_new'] = $this->language->get('text_address_new');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_shipping_telephone'] = $this->language->get('entry_shipping_telephone');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->session->data['shipping_address']['address_id'])) {
			$data['address_id'] = $this->session->data['shipping_address']['address_id'];
		} else {
			$data['address_id'] = $this->customer->getAddressId();
		}
		$this->load->model('account/address');

		$data['addresses'] = $this->model_account_address->getAddresses();
		if($data['addresses'] && !array_key_exists($data['address_id'], $data['addresses'])){
		    if(array_key_exists($this->customer->getAddressId(), $data['addresses'])){
		        $address_id = $this->customer->getAddressId();
		    }else{
		        $firAddress = current($data['addresses']);
		        $address_id = $firAddress['address_id'];
		    }
		    $data['address_id'] = $address_id;
		    $this->session->data['shipping_address'] = $this->model_account_address->getAddress($address_id);
		}
		$data['modify_url'] = $this->url->link('account/address/edit', '', 'SSL');
		$data['addresslist_url'] = $this->url->link('account/address', '', 'SSL');
		
		if (isset($this->session->data['shipping_address']['postcode'])) {
			$data['postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
		
		if (isset($this->session->data['shipping_address']['shipping_telephone'])) {
			$data['shipping_telephone'] = $this->session->data['shipping_address']['shipping_telephone'];
		} else {
			$data['shipping_telephone'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if($this->customer->getCardType()){
		    $cardVal = $this->_cardType[$this->customer->getCardType()];
		}else{
		    $cardVal = '';
		}
		$data['cardinfo'] = array('cardType'=>$this->customer->getCardType() , 'cardVal'=> $cardVal, 'cardName'=>$this->customer->getCardName()  , 'cardID'=>$this->customer->getCardID());
		$data['cardtype'] = $this->_cardType;
		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
		if (isset($this->session->data['shipping_address']['custom_field'])) {
			$data['shipping_address_custom_field'] = $this->session->data['shipping_address']['custom_field'];
		} else {
			$data['shipping_address_custom_field'] = array();
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping_address.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/shipping_address.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/shipping_address.tpl', $data));
		}
	}
    
	//获取身份证信息
	public function getCard(){
	    if($this->customer->getCardType()){
	        $cardVal = $this->_cardType[$this->customer->getCardType()];
	    }else{
	        $cardVal = '';
	    }
	    $data['cardinfo'] = array('cardType'=>$this->customer->getCardType() , 'cardVal'=> $cardVal, 'cardName'=>$this->customer->getCardName()  , 'cardID'=>$this->customer->getCardID());
	    $data['cardtype'] = $this->_cardType;
	    // Custom Fields
	    $this->load->model('account/custom_field');
	    
	    $data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
	    if (isset($this->session->data['shipping_address']['custom_field'])) {
	        $data['shipping_address_custom_field'] = $this->session->data['shipping_address']['custom_field'];
	    } else {
	        $data['shipping_address_custom_field'] = array();
	    }
	    
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/card.tpl')) {
	        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/card.tpl', $data));
	    } else {
	        $this->response->setOutput($this->load->view('default/template/checkout/card.tpl', $data));
	    }
	}
	
	public function save() {
		$this->load->language('checkout/checkout');
		$json = array();
		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
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
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}
		if (!$json) {
		    if(!isset($this->request->post['company'])){
		        $this->request->post['company'] = '';
		    }
			if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
				$this->load->model('account/address');
				
				if (empty($this->request->post['address_id'])) {
					$json['error']['warning'] = $this->language->get('error_address');
				} elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
					$json['error']['warning'] = $this->language->get('error_address');
				}
				if (!$json) {
					// Default Shipping Address
					$this->load->model('account/address');

					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);
                    
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);
					
					$this->model_account_address->setDefaultAddress($this->request->post['address_id']);
					
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
				}
			} else {
				if ((utf8_strlen(trim($this->request->post['fullname'])) < 2) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
					$json['error']['fullname'] = $this->language->get('error_fullname');
				}
			    if (!preg_match("/[\x{4e00}-\x{9fa5}\w]+$/u", $this->request->post['fullname'])){  
                    $json['error']['fullname'] = '收货人不能为空或包含特殊字符'; 
                }  
				
                if(!preg_match("/^1[0-9][0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$this->request->post['shipping_telephone']))
                {
                    $json['error']['shipping_telephone'] = '手机格式不正确';
                }
                
				if ((utf8_strlen($this->request->post['shipping_telephone']) < 3) || (utf8_strlen($this->request->post['shipping_telephone']) > 32)) {
					$json['error']['shipping_telephone'] = $this->language->get('error_shipping_telephone');
				}

				if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
					$json['error']['address'] = $this->language->get('error_address');
				}

				if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
					$json['error']['city'] = $this->language->get('error_city');
				}
				
				$this->load->model('localisation/country');

				$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

				if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
					$json['error']['postcode'] = $this->language->get('error_postcode');
				}

				if ($this->request->post['country_id'] == '') {
					$json['error']['country'] = $this->language->get('error_country');
				}
				if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
					$json['error']['zone'] = $this->language->get('error_zone');
				}

				// Custom field validation
				$this->load->model('account/custom_field');

				$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
				foreach ($custom_fields as $custom_field) {
					if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
						$json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
					}
				}
				
				if (!$json) {
					// Default Shipping Address
					$this->load->model('account/address');

					$address_id = $this->model_account_address->addAddress($this->request->post);

					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($address_id);

					$this->session->data['payment_address'] = $this->model_account_address->getAddress($address_id);
					
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);

					$this->load->model('account/activity');

					$activity_data = array(
						'customer_id' => $this->customer->getId(),
						'name'        => $this->customer->getFullName()
					);

					$this->model_account_activity->addActivity('address_add', $activity_data);
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/**
	 * 校验身份证信息
	 */
	public function checkcardid()
	{
	    $cardNo = $this->request->post['cardid'];
	    $curlDeal = new curl_deal();
	    $url = "http://www.cz88.net/tools/id.php";
	    $param['in_id'] = $cardNo;
	    $json = array();
	    $result = $curlDeal->postData($url, $param);
	    if (strstr($result, iconv("UTF-8", "gbk", "输入的身份证号码校验位错误")) || strstr($result, iconv("UTF-8", "gbk", "你输入的身份证号码错误，请重新输入"))) {
	        $json['error'] = "身份证号码校验错误！";
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	
	
	/**
	 * 保存用户身份信息
	 */
	public function addusercardinfo()
	{
	    $json = array();
	    $cardId   = $this->request->post['cardid'];
	    $cardType = $this->request->post['cardtype'];
	    $cardName = $this->request->post['cardname'];
	    $customerId = $this->customer->getId();
	    $this->load->model('account/customer');
	    $this->model_account_customer->modifyUserinfo($cardType , $cardName , $cardId , $customerId);
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	
	//获取子地域信息
	public function zoomeinfo(){
	    $zoome_id = $this->request->post['zoome_id']?$this->request->post['zoome_id']:0;
	    $this->load->model('account/address');
	    $resoult = $this->model_account_address->getzoomeinfo($zoome_id);
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($resoult));
	}
}