<?php
class ControllerCheckoutConfirm extends Controller {
	public function index() {
		$redirect = '';
		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.
			if (!isset($this->session->data['shipping_address'])) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
			// Validate if shipping method has been set.
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
		// Validate if payment address has been set.
		/* if (!isset($this->session->data['payment_address'])) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		} */

		// Validate if payment method has been set.
		if (!isset($this->session->data['payment_method'])) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');
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
				$redirect = $this->url->link('checkout/cart');

				break;
			}
		}
		if (!$redirect) {
			$order_data = array();

			$order_data['totals'] = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			$discount   = 0;
			//获取关税
			 $tariffGoods = array();
			$discount   = 0;
			foreach ($this->cart->getProducts() as $product){
			    if(array_key_exists($product['key'], $this->session->data['checklist'])){
    			    $tariffGoods[] = array('price'=>round($product['price'],2) * $product['quantity'] , 'hscode'=>$product['hscode'] , 'taxrate'=>$product['taxrate']);
    			    $discount += round($product['discount'],2)*$product['quantity'];
			    }
			} 
			$this->load->library('tariff');
			
			$this->tariff = new Tariff();
			$product['source'] = strtolower(trim($product['source'])) ? strtolower(trim($product['source'])) : 'amazon';
			if(isset(Param::$counttax[$product['source']]) && Param::$counttax[$product['source']]=='1'){
			     $order_tariff = 0;
			}else{
			    $order_tariff = $this->tariff->calculateOrder($tariffGoods);
			    if($order_tariff != -1){
			        $order_data['has_tariff'] = '1';
			        $data['order_tariff'] = $this->currency->format($order_tariff).$this->tariff->getTariffSuff($order_tariff);
			    }else{
			        $order_tariff = 0;
			        $order_data['has_tariff'] = '0';
			        $data['order_tariff'] = '';
			    }
			}
			
			$data['discount'] =$discount;
				
			$data['format_discount'] = $this->currency->format($discount);
			
			$this->load->model('extension/extension');

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			array_multisort($sort_order, SORT_ASC, $results);
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
					if($result['code'] == 'total'){
					   $total = round($total,2)+round($order_tariff,2);
					}
					$this->{'model_total_' . $result['code']}->getTotal($order_data['totals'], $total, $taxes);
				}
			}
			$sort_order = array();
			foreach ($order_data['totals'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $order_data['totals']);

			$this->load->language('checkout/checkout');

			$order_data['tariff_price']   = round($order_tariff,2);
			$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$order_data['store_id'] = $this->config->get('config_store_id');
			$order_data['store_name'] = $this->config->get('config_name');

			if ($order_data['store_id']) {
				$order_data['store_url'] = $this->config->get('config_url');
			} else {
				$order_data['store_url'] = HTTP_SERVER;
			}

			if ($this->customer->isLogged()) {
				$this->load->model('account/customer');

				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

				$order_data['customer_id'] = $this->customer->getId();
				$order_data['customer_group_id'] = $customer_info['customer_group_id'];
				$order_data['fullname'] = $customer_info['fullname'];
				$order_data['email'] = $customer_info['email'];
				$order_data['telephone'] = $customer_info['telephone'];
				$order_data['fax'] = $customer_info['fax'];
				$order_data['custom_field'] = unserialize($customer_info['custom_field']);
			} elseif (isset($this->session->data['guest'])) {
				$order_data['customer_id'] = 0;
				$order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
				$order_data['fullname'] = $this->session->data['guest']['fullname'];
				$order_data['email'] = $this->session->data['guest']['email'];
				$order_data['telephone'] = $this->session->data['guest']['telephone'];
				$order_data['fax'] = $this->session->data['guest']['fax'];
				$order_data['custom_field'] = $this->session->data['guest']['custom_field'];
			}
			$this->load->model('account/customer');
			$order_data['payment_fullname'] = $this->session->data['payment_address']['fullname'];
			$order_data['payment_company'] = $this->session->data['payment_address']['company'];
			$order_data['payment_address'] = $this->session->data['payment_address']['address'];
			$order_data['payment_city'] = $this->model_account_customer->getCityname($this->session->data['shipping_address']['city_id'])['name'];
			$order_data['payment_postcode'] = $this->session->data['payment_address']['postcode'];
			$order_data['payment_zone'] = $this->session->data['payment_address']['zone'];
			$order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
			$order_data['payment_country'] = $this->session->data['payment_address']['country'];
			$order_data['payment_country_id'] = $this->session->data['payment_address']['country_id'];
			$order_data['payment_address_format'] = $this->session->data['payment_address']['address_format'];
			$order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());

			if (isset($this->session->data['payment_method']['title'])) {
				$order_data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$order_data['payment_method'] = '';
			}

			if (isset($this->session->data['payment_method']['code'])) {
				$order_data['payment_code'] = $this->session->data['payment_method']['code'];
			} else {
				$order_data['payment_code'] = '';
			}

			if ($this->cart->hasShipping()) { 
			    $order_data['city_id'] = $this->session->data['shipping_address']['city_id'];
			    $order_data['area_id'] = $this->session->data['shipping_address']['area_id'];
				$order_data['shipping_fullname'] = $this->session->data['shipping_address']['fullname'];
				$order_data['shipping_company'] = $this->session->data['shipping_address']['company'];
				$order_data['shipping_address'] = $this->session->data['shipping_address']['address'];
				$order_data['shipping_city'] = $this->session->data['shipping_address']['city'];
				$order_data['shipping_postcode'] = $this->session->data['shipping_address']['postcode'];
				$order_data['shipping_telephone'] = $this->session->data['shipping_address']['shipping_telephone'];
				$order_data['shipping_zone'] = $this->session->data['shipping_address']['zone'];
				$order_data['shipping_zone_id'] = $this->session->data['shipping_address']['zone_id'];
				$order_data['shipping_country'] = $this->session->data['shipping_address']['country'];
				$order_data['shipping_country_id'] = $this->session->data['shipping_address']['country_id'];
				$order_data['shipping_address_format'] = $this->session->data['shipping_address']['address_format'];
				$order_data['shipping_custom_field'] = (isset($this->session->data['shipping_address']['custom_field']) ? $this->session->data['shipping_address']['custom_field'] : array());

				if (isset($this->session->data['shipping_method']['title'])) {
					$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$order_data['shipping_method'] = '';
				}

				if (isset($this->session->data['shipping_method']['code'])) {
					$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
				} else {
					$order_data['shipping_code'] = '';
				}
			} else {
				$order_data['shipping_fullname'] = '';
				$order_data['shipping_company'] = '';
				$order_data['shipping_address'] = '';
				$order_data['shipping_city'] = '';
				$order_data['shipping_postcode'] = '';
				$order_data['shipping_telephone'] = '';
				$order_data['shipping_zone'] = '';
				$order_data['shipping_zone_id'] = '';
				$order_data['shipping_country'] = '';
				$order_data['shipping_country_id'] = '';
				$order_data['shipping_address_format'] = '';
				$order_data['shipping_custom_field'] = array();
				$order_data['shipping_method'] = '';
				$order_data['shipping_code'] = '';
			}
			
			
			$order_data['products'] = array();
			
			$this->load->model('tool/image');
			
			foreach ($this->cart->getProducts() as $product) {
			    if(array_key_exists($product['key'], $this->session->data['checklist'])){ 
    			    $option_data = array();
    			
    			    foreach ($product['option'] as $option) {
    			        $option_data[] = array(
    			            'product_option_id'       => $option['product_option_id'],
    			            'product_option_value_id' => $option['product_option_value_id'],
    			            'option_id'               => $option['option_id'],
    			            'option_value_id'         => $option['option_value_id'],
    			            'name'                    => $option['name'],
    			            'value'                   => $option['value'],
    			            'type'                    => $option['type']
    			        );
    			    }
    			    if($order_data['has_tariff'] && $order_tariff>0){
    			        $product['source'] = strtolower(trim($product['source'])) ? strtolower(trim($product['source'])) : 'amazon';
    			        if(isset(Param::$counttax[$product['source']]) && Param::$counttax[$product['source']]=='1'){
    			            $product_tariff = 0;
    			        }else{
    			            $product_tariff = $this->tariff->calculateGoods(round($product['price'],2) * $product['quantity'] , $product['hscode'] , $product['taxrate']);
    			        }
    			        
    			    }else{
    			        $product_tariff = 0;
    			    }
    			    $order_data['products'][] = array(
    			        'product_id' => $product['product_id'],
    			        'name'       => $product['name'],
    			        'model'      => $product['model'],
    			        'option'     => $option_data,
    			        'download'   => $product['download'],
    			        'quantity'   => $product['quantity'],
    			        'subtract'   => $product['subtract'],
    			        'price'      => $product['price'],
    			        'tariff_price' => $product_tariff,
    			        'total'      => $product['total'],
    			        'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
    			        'reward'     => $product['reward']
    			    );
			    }
			}
			// Gift Voucher
			$order_data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$order_data['vouchers'][] = array(
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],
						'amount'           => $voucher['amount']
					);
				}
			}

			if(isset($this->session->data['comment'])){
			    $order_data['comment'] = $this->session->data['comment'];
			}else{
			    $order_data['comment'] = '';
			}
			$order_data['total'] = $total;
			if (isset($this->request->cookie['tracking'])) {
				$order_data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
				} else {
					$order_data['affiliate_id'] = 0;
					$order_data['commission'] = 0;
				}

				// Marketing
				$this->load->model('checkout/marketing');

				$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

				if ($marketing_info) {
					$order_data['marketing_id'] = $marketing_info['marketing_id'];
				} else {
					$order_data['marketing_id'] = 0;
				}
			} else {
				$order_data['affiliate_id'] = 0;
				$order_data['commission'] = 0;
				$order_data['marketing_id'] = 0;
				$order_data['tracking'] = '';
			}

			$order_data['language_id'] = $this->config->get('config_language_id');
			$order_data['currency_id'] = $this->currency->getId();
			$order_data['currency_code'] = $this->currency->getCode();
			$order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$order_data['ip'] = $this->request->server['REMOTE_ADDR'];

			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
			} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
			} else {
				$order_data['forwarded_ip'] = '';
			}

			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
			} else {
				$order_data['user_agent'] = '';
			}

			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
			} else {
				$order_data['accept_language'] = '';
			}
			$this->load->model('checkout/order');
			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$this->load->model('tool/upload');

			$data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
			    if(array_key_exists($product['key'], $this->session->data['checklist'])){
    			    if ($product['image']) {
    			        $image = $this->model_tool_image->resize($product['image'], 120, 120);
    			    } else {
    			        $image = '';
    			    }
    			    
    				$option_data = array();
    				foreach ($product['option'] as $option) {
    				    
    					if ($option['type'] != 'file') {
    						$value = $option['value'];
    					} else {
    						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
    
    						if ($upload_info) {
    							$value = $upload_info['name'];
    						} else {
    							$value = '';
    						}
    					}
    
    					$option_data[] = array(
    						'name'  => $option['name'],
    						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
    					);
    				}
    				$recurring = '';
    				if ($product['recurring']) {
    					$frequencies = array(
    						'day'        => $this->language->get('text_day'),
    						'week'       => $this->language->get('text_week'),
    						'semi_month' => $this->language->get('text_semi_month'),
    						'month'      => $this->language->get('text_month'),
    						'year'       => $this->language->get('text_year'),
    					);
   
    					if ($product['recurring']['trial']) {
    						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
    					}
    
    					if ($product['recurring']['duration']) {
    						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
    					} else {
    						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
    					}
    				}
    				
    				$product['source'] = strtolower(trim($product['source'])) ? strtolower(trim($product['source'])) : 'amazon';
    				if(isset(Param::$counttax[$product['source']]) && Param::$counttax[$product['source']]==1){
    				    $product_tariff = 0;
    				}else{
    				    $product_tariff = $this->tariff->calculateGoods($product['price'] * $product['quantity'] , $product['hscode'] , $product['taxrate']);
    				    $product_tariff = $product['hscode'] ? $this->currency->format($product_tariff) : $this->currency->format('0.00');
    				}
    				
    				$data['products'][] = array(
    					'key'        => $product['key'],
    					'product_id' => $product['product_id'],
    				    'thumb'      => $image,
    					'name'       => $product['name'],
    					'model'      => $product['model'],
    					'option'     => $option_data,
    					'recurring'  => $recurring,
    					'quantity'   => $product['quantity'],
    					'subtract'   => $product['subtract'],
    					'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
    				    'dprice'     => "$".(sprintf("%.2f", $product['price']/DOLLAR_RATE)),
    				    'listprice'  => $product['listprice'] ? $this->currency->format($this->tax->calculate($product['listprice'], $product['tax_class_id'], $this->config->get('config_tax'))) : '',
    					'total'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']),
    				    'dtotal'     => "$".(sprintf("%.2f", ($product['price']/DOLLAR_RATE)*$product['quantity'])),
    				    'href'       => $this->url->link('product/wapproduct', 'product_id=' . $product['product_id']),
    				    'tariff'    => $product_tariff,
    				    'source'    => strtolower(trim($product['source'])) ? strtolower(trim($product['source'])) : 'amazon',
    				);
			    }
			}

			// Gift Voucher
			/* $data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
					    'damount'     => "$".(sprintf("%.2f", $voucher['amount']/DOLLAR_RATE)),
					);
				}
			} */

			if (isset($this->session->data['comment'])) {
			    $data['comment'] = $this->session->data['comment'];
			} else {
			    $data['comment'] = '';
			}
			
			/* $data['totals'] = array();
			foreach ($order_data['totals'] as $total) {
				$data['totals'][$total['code']] = array(
				    'code'  => $total['code'],
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'])
				);
			} */
			//$data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);
		} else {
			$data['redirect'] = $redirect;
		}
		
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		
		//$data['submit_action'] = $this->url->link('checkout/submitted');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/confirm.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/confirm.tpl', $data));
		}
	}
	
	
	public function total(){
	    $this->load->model('account/order');
	    
	    $this->load->library('tariff');
	    
	    $tariff = new Tariff();
	    
	    $order_id = $this->session->data['order_id'];
	    
	    $order_info = $this->model_account_order->getOrderInfo($order_id);
	    $order_info['total'] = $this->currency->format($order_info['total']);
	    $data['order_info'] = $order_info;
	    
	    $products = $this->cart->getProducts();
	    $data['product_total'] = 0;
	    
	    $tariffGoods = array();
	    
	    foreach ($products as $product) {
	        if(array_key_exists($product['key'], $this->session->data['checklist'])){
	            $data['product_total'] += $product['quantity'];
	        }
	    }
	    
	    $data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);
	    
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/order_total.tpl')) {
	        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/order_total.tpl', $data));
	    } else {
	        $this->response->setOutput($this->load->view('default/template/checkout/order_total.tpl', $data));
	    }
	    
	}
	
	/**
	 * 添加评论
	 */
	public function comment(){
	    
	    $comment = $this->request->post['comment'];
	    
	    $this->load->model('checkout/order');
	    
	    $this->model_checkout_order->addComment($this->session->data['order_id'] , $comment);
	}
	
	/**
	 * 获取选择的支付方式，构造表单
	 */
	public function payment(){
	    
	    
	    $order_id = $this->request->get['order_id'];
	    
	    $this->session->data['order_id'] = $order_id;
	    
	    $payment_code = $this->request->get['code'];
	    
	    $data['payment'] = $this->load->controller('payment/' . $payment_code);
	    
	    $data['type'] = 'paynow';
	    
	    $data['payment_code'] = $payment_code;
	    
	    $this->load->model('account/order');
	    
	    $orderInfo = $this->model_account_order->getOrder($order_id);
	    
	    $total = $orderInfo['total'];
	    
	    $shipping_address = array();
	    
	    $shipping_address['fullname'] = $orderInfo['shipping_fullname'];
	    $shipping_address['country_id'] = $orderInfo['shipping_country_id'];
	    $shipping_address['country'] = $orderInfo['shipping_country'];
	    $shipping_address['zone_id'] = $orderInfo['shipping_zone_id'];
	    
	    $this->load->model('payment/' . $payment_code);
	    
	    $method = $this->{'model_payment_' . $payment_code}->getMethod($shipping_address, $total);
	    
	    $this->session->data['payment_method']['code'] = $payment_code;
	    
	    //unset($this->session->data['order_id']);
	    
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm_payment.tpl')) {
	        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/confirm_payment.tpl', $data));
	    } else {
	        $this->response->setOutput($this->load->view('default/template/checkout/confirm_payment.tpl', $data));
	    }
	}
	
	public function defepayment(){
	     
	    if(isset($this->request->get['order_id'])){
	        $order_id = $this->request->get['order_id'];
	        $this->session->data['order_id'] = $order_id;
	    }else{
	        $order_id = -1;
	    }
	    $this->load->model('account/order');
	    
	    $orderInfo = $this->model_account_order->getOrder($order_id);
	    
	    $address = array();
	    $address['fullname']   = $orderInfo['shipping_fullname'];
	    $address['country_id'] = $orderInfo['shipping_country_id'];
	    $address['country']    = $orderInfo['shipping_country'];
	    $address['zone_id']    = $orderInfo['shipping_zone_id'];
	    
	    
	    $total = $orderInfo['total'];
	    
	    $this->load->model('payment/' . $orderInfo['payment_code']);
	    
	    $data['payment_code'] = $orderInfo['payment_code'];
	    
	    $data['type'] = 'defepay';
	    
	    $method = $this->{'model_payment_' . $orderInfo['payment_code']}->getMethod($address, $total);
	    
	    $this->session->data['payment_method']['code'] = $orderInfo['payment_code'];
	    
	    $data['payment'] = $this->load->controller('payment/' . $orderInfo['payment_code']);
	    
	    //unset($this->session->data['order_id']);
	    
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm_payment.tpl')) {
	        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/confirm_payment.tpl', $data));
	    } else {
	        $this->response->setOutput($this->load->view('default/template/checkout/confirm_payment.tpl', $data));
	    }
	}
}