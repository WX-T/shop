<?php
class ControllerCheckoutCart extends Controller {
	public function index() {
	    $this->load->language('checkout/cart');
		$this->document->setTitle($this->language->get('heading_title'));

		$app_customer_id = $this->customer->getAppCustomerId();
		
		if($app_customer_id){
		    $this->common_app_login($app_customer_id);
		}
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);
		if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_next'] = $this->language->get('text_next');
			$data['text_next_choice'] = $this->language->get('text_next_choice');

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_update'] = $this->language->get('button_update');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');
            
			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit', '', true);

			if ($this->config->get('config_cart_weight')) {
				$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$data['weight'] = '';
			}

			$this->load->model('tool/image');
			$this->load->model('tool/upload');

			$data['products'] = array();

			$products = $this->cart->getProducts();

			if(isset($this->session->data['wishlist'])){
				$wishlist = $this->session->data['wishlist'];
            }else{
				$wishlist = array();
			}
			$discount   = 0;
			//获取关税
			/* $tariffGoods = array();
			$discount   = 0;
			foreach ($products as $product){
			    $tariffGoods[] = array('price'=>$product['price'] * $product['quantity'] , 'hscode'=>$product['hscode'] , 'taxrate'=>$product['taxrate']);
			    $discount += $product['discount']*$product['quantity'];
			} */
			
			
			/* $order_tariff = $this->tariff->calculateOrder($tariffGoods);
			if($order_tariff != -1){
			    $data['order_tariff'] = $this->currency->format($order_tariff).$this->tariff->getTariffSuff($order_tariff);
			    $order_tariff = $this->tariff->getRealTariff($order_tariff);
		    }else{
		        $order_tariff = 0;
		        $data['order_tariff'] = '';
		    } */
			if(!isset($this->session->data['checklist'])){
			    $this->session->data['checklist'] = $this->session->data['cart'];
			}
			$data['discount'] =$discount?$discount:0;
			$data['format_discount'] = $this->currency->format($discount);
			$data['total']  = 0;
			foreach ($products as $product) {
				$product_total = 0;
				foreach($wishlist as $k=>$v){
					if($v==$product['product_id']){
						$product['wishlist'] = true;
					}
				}
				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
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

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				// Display prices
				if ($product['listprice']!=$product['price']) {
				    $listprice = $this->currency->format($this->tax->calculate($product['listprice'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
				    $listprice = false;
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
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

				if(!isset($product['wishlist'])){
					$product['wishlist'] = false;
				}
				
				$this->load->library('tariff');
				$this->tariff = new Tariff();
				
				$product_tariff = $this->tariff->calculateGoods($product['special'] ? $product['special'] : $product['price']  , $product['hscode'] , $product['taxrate']);
	            $product_tariff = $product['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
				
	            if(array_key_exists($product['key'], $this->session->data['checklist'])){
				    $data['total'] += $product['quantity'];
	            }
				$data['products'][] = array(
				    'tariff'      => $product_tariff,
					'wishlist'  => $product['wishlist'],
					'key'       => $product['key'],
				    'product_id'=> $product['product_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'recurring' => $recurring,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
				    'listprice' => $listprice,
				    'is_check'  => array_key_exists($product['key'], $this->session->data['checklist']),
 				    'tariff'    => $product_tariff,
				    'dprice'    => "$".(sprintf("%.2f", $product['price']/DOLLAR_RATE)),
					'total'     => $total,
				    'dtotal'    => "$".(sprintf("%.2f", $product['price'] * $product['quantity']/DOLLAR_RATE)),
					'href'      => $this->url->link('product/wapproduct', 'product_id=' . $product['product_id']),
				    'source'    => $product['source']
				);
			}
			//$data['count'] = $product_total;
			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			// Totals
			$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
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
						   // $total = $total+$order_tariff;
						}
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}
			$data['totals'] = array();
			foreach ($total_data as $total) {
				$data['totals'][$total['code']] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value']),
				    'dtext' => "$".(sprintf("%.2f", $total['value']/DOLLAR_RATE))
				);
			}
			$data['continue'] = $this->url->link('common/home');

			$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

			$this->load->model('extension/extension');

			$data['checkout_buttons'] = array();
			$data['coupon'] = $this->load->controller('checkout/coupon');
			$data['voucher'] = $this->load->controller('checkout/voucher');
			$data['reward'] = $this->load->controller('checkout/reward');
			$data['shipping'] = $this->load->controller('checkout/shipping');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$data['userstatus'] = $this->customer->getUserStatus();
			$data['appindex_url'] = APP_INDEX_URL;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/cart.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/checkout/cart.tpl', $data));
			}
		} else {
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_error'] = $this->language->get('text_empty');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			$data['home'] = $this->url->link('common/home', '', 'SSL');
			$data['products'] = array();
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$data['userstatus'] = $this->customer->getUserStatus();
			$data['appindex_url'] = APP_INDEX_URL;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/cart.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
	
	/**
	 * 更新选中购物车
	 */
	public function checkchange(){
	    $keys = $this->request->post['keys'];
	    $products = $this->cart->getProducts();
	    $data['total'] = 0;
	    if($keys){
	        foreach ($this->session->data['checklist'] as $key=>$checklist){
	            if(!array_key_exists($key, $keys)){
	                unset($this->session->data['checklist'][$key]);
	            }
	        }
	        foreach ($keys as $pkey){
	            $product = $products[$pkey];
	            if(!array_key_exists($pkey, $this->session->data['checklist'])){
	                $this->session->data['checklist'][$pkey] = $this->session->data['cart'][$pkey];
	            }
	            $data['total'] += $product['quantity'];
	        }
	    }else{
	        $this->session->data['checklist'] = array();
	    }
	    $total_data = array();
	    $total = 0;
	    $taxes = $this->cart->getTaxes();
	    $this->load->model('extension/extension');
	    // Display prices
	    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	        $sort_order = array();
	    
	        $results = $this->model_extension_extension->getExtensions('total');
	        foreach ($results as $key => $value) {
	            $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
	        }
	        array_multisort($sort_order, SORT_ASC, $results);
	        foreach ($results as $result) {
	            if ($this->config->get($result['code'] . '_status')) {
	                $this->load->model('total/' . $result['code']);
	                $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
	            }
	        }
	        $sort_order = array();
	    
	        foreach ($total_data as $key => $value) {
	            $sort_order[$key] = $value['sort_order'];
	        }
	    
	        array_multisort($sort_order, SORT_ASC, $total_data);
	    }
	    $data['totals'] = array();
	    foreach ($total_data as $total) {
	        $data['totals'][$total['code']] = array(
	            'title' => $total['title'],
	            'text'  => $this->currency->format($total['value']),
	        );
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($data));
	    
	}

	public function add() {
		$this->load->language('checkout/cart');
		$json = array();
		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		$this->load->model('catalog/product');
		$this->load->model('account/customer');
		$product_info = $this->model_catalog_product->getProduct($product_id);
		if ($product_info) {
			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}


			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			//$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			//判断是否选择颜色和尺寸
			/* foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			} */

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}
			
			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);
			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}
			if(intval($product_info['quantity']) < 1){
			    $json['error']['quantity'] = '<h3>加入购物车失败</h3><p class="explan">商品库存不足，无法加入购物车</p><p class="gotoshoppingcar" style="width:100px;margin-left:25%;"></p>';
			}
			
			if((int)$this->request->post['quantity'] > intval($product_info['maxmum'])){
			    $json['error']['quantity'] = '<p class="explan">此商品最多购买'.$product_info['maxmum'].'个，无法加入购物车</p><p class="gotoshoppingcar" style="width:100px;margin-left:25%;"></p>';
			}
			
			//单个商品大于2000无法购买
			if($product_info['price'] >=2000){
			    $json['error']['quantity'] = '<h3>加入购物车失败</h3><p class="explan">商品价格大于2000,无法购买</p><p class="gotoshoppingcar" style="width:100px;margin-left:25%;"></p>';
			}
			
			foreach ($this->session->data['cart'] as $k=>$v){
			    if(unserialize(base64_decode($k))['product_id'] == $product_id){
			        if($v >= intval($product_info['maxmum'])){
			            $json['error']['quantity'] = '<p class="explan">此商品最多购买'.$product_info['maxmum'].'个，无法加入购物车</p><p class="gotoshoppingcar" style="width:100px;margin-left:25%;"></p>';
			        }
			    }
			}
			//$json['error']['quantity'] = '<p class="explan">此商品最多购买'.$this->request->post['quantity'].'个，无法加入购物车</p><p class="gotoshoppingcar" style="width:100px;margin-left:25%;"></p>';
			if (!$json) {
			    
				$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);
				$this->model_account_customer->modifyUserCart($this->customer->getId());
				$json['success'] = sprintf($this->language->get('text_success'),$this->cart->countProducts() ,$this->currency->format($this->cart->getTotal()));

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('extension/extension');

				$total_data = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);

							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
					}

					$sort_order = array();

					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data);
				}

				$json['total'] = $this->language->get('text_items')+$this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('checkout/cart');
		$json = array();
		// Update
		if (!empty($this->request->post['quantity'])) {
	        foreach ($this->request->post['quantity'] as $key => $value) {
	            $max = $this->cart->getMaxNum(unserialize(base64_decode($key))['product_id']);
	            //unserialize(base64_decode('YToxOntzOjEwOiJwcm9kdWN0X2lkIjtpOjE4NzI4O30='));
	            if($value <=$max['maxmum']){
                    $this->cart->update($key, $value);
	            }
	        }
	        unset($this->session->data['shipping_method']);
	        unset($this->session->data['shipping_methods']);
	        unset($this->session->data['payment_method']);
	        unset($this->session->data['payment_methods']);
	        unset($this->session->data['reward']);

			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
    
	//删除多个
	public function removeall(){
	    $this->load->language('checkout/cart');
	    
	    $json = array();
	    $key = $this->request->post['key'];
	    $key = explode(',',$key);
	    // Remove
	    if (isset($this->request->post['key'])) {
	        for($i=0;$i<count($key);$i++){
	            $this->cart->remove($key[$i]);
	            unset($this->session->data['vouchers'][$key[$i]]);
	        }
	        
	        $this->session->data['success'] = $this->language->get('text_remove');
	    
	        unset($this->session->data['shipping_method']);
	        unset($this->session->data['shipping_methods']);
	        unset($this->session->data['payment_method']);
	        unset($this->session->data['payment_methods']);
	        unset($this->session->data['reward']);
	    
	        // Totals
	        $this->load->model('extension/extension');
	    
	        $total_data = array();
	        $total = 0;
	        $taxes = $this->cart->getTaxes();
	    
	        // Display prices
	        if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	            $sort_order = array();
	    
	            $results = $this->model_extension_extension->getExtensions('total');
	    
	            foreach ($results as $key => $value) {
	                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
	            }
	    
	            array_multisort($sort_order, SORT_ASC, $results);
	    
	            foreach ($results as $result) {
	                if ($this->config->get($result['code'] . '_status')) {
	                    $this->load->model('total/' . $result['code']);
	    
	                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
	                }
	            }
	    
	            $sort_order = array();
	    
	            foreach ($total_data as $key => $value) {
	                $sort_order[$key] = $value['sort_order'];
	            }
	    
	            array_multisort($sort_order, SORT_ASC, $total_data);
	        }
	    
	        $json['total'] = $this->cart->countProducts();
	    }
	    
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
    }
	
	public function remove() {
		$this->load->language('checkout/cart');

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			$this->cart->remove($this->request->post['key']);

			unset($this->session->data['vouchers'][$this->request->post['key']]);

			$this->session->data['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			// Totals
			$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$json['total'] = $this->cart->countProducts();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
