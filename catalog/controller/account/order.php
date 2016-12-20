<?php
class ControllerAccountOrder extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');
			$this->response->redirect(APP_LOGIN_URL);
			//$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/order', '', 'SSL')
		);

		$url = '';
		
		$status = '';
		if (isset($this->request->get['status'])) {
		    $url .= '&status=' . $this->request->get['status'];
		    $status = $this->request->get['status'];
		}

		$data['status'] = $status;
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/order', $url, 'SSL')
		);
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_total'] = $this->language->get('column_total');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['text_logged'] = $this->customer->getFullName();
		$data['href_center'] = $this->url->link('account/order', '', 'SSL');
		$data['href_logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['text_wishlist'] = isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
		
		$data['text_username'] = $this->customer->getFullName();

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['orders'] = array();

		$this->load->model('account/order');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
        if($status=='3'){
            $status = '3,24,28';
        }elseif($status=='24'){
            $status = '25,27,26';
        }
		$order_total = $this->model_account_order->getTotalOrders($status);
		$results = $this->model_account_order->getOrders(($page - 1) * 10, 10 , $status);
		$this->tariff = new Tariff();
		foreach ($results as $result) {
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);
			$goods = $this->model_account_order->getOrderProductsList($result['order_id']);
			foreach ($goods as &$good){
			    $product_info = $this->model_catalog_product->getProduct($good['product_id']);
			    if ($product_info['image']) {
			        $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			    } else {
			        $image = '';
			    }
// 			    $product_tariff = $this->tariff->calculateGoods($product_info['special'] ? $product_info['special'] : $product_info['price']  , $product_info['hscode'] , $product_info['taxrate']);
//     			$product_tariff = $product_info['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
// 			    $good['tariff'] = $product_tariff;
			    $good['thumb'] = $image;
			    $good['option'] = $this->model_account_order->getOrderOptions($result['order_id'] , $good['order_product_id']);
			    $good['href'] = $this->url->link('product/wapproduct', 'product_id=' . $good['product_id']);
			    $good['price'] = sprintf('%.2f' , $good['price']);
			}
			
			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['fullname'],
			    'status_id'  => $result['order_status_id'],
 				'status'     => $result['status'],
				'goods'		 => $goods,
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
				'products'   => ($product_total + $voucher_total),
				'total'      => $this->currency->format(sprintf('%.2f' , $result['total']), $result['currency_code'], $result['currency_value']),
				'href'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'),
			    'tracking'   => $this->url->link('account/tracking', 'order_id=' . $result['order_id'], 'SSL'),
			    'shipping_agents'=> $result['shipping_agents'],
			    'logistics'  => $result['logistics'],
			    'expressno'  => $result['expressno'],
			);
		}
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/order', 'page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($order_total - 10)) ? $order_total : ((($page - 1) * 10) + 10), $order_total, ceil($order_total / 10));

		$data['continue'] = $this->url->link('account/order', '', 'SSL');
		
		$data['address'] = $this->url->link('account/address', '', 'SSL');
		
		$data['cart'] = $this->url->link('checkout/cart', '', 'SSL');
		
		$data['orderurl'] = $this->url->link('account/order', '', 'SSL');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/order_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/order_list.tpl', $data));
		}
	}

	public function info($order_id='') {
	    $this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
	    
	    

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');
			$this->response->redirect(APP_LOGIN_URL);
			//$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/order', '', 'SSL')
			);

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/order', $url, 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_order'),
				'href' => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, 'SSL')
			);

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');
			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{fullname}' . "\n" . '{company}' . "\n" . '{address}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{fullname}',
				'{company}',
				'{address}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'fullname' => $order_info['payment_fullname'],
				'company'   => $order_info['payment_company'],
				'address' => $order_info['payment_address'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '<label>收货人：</label>{fullname}' . "<br/>" . '<label>手机：</label>{shipping_telephone}' . "<br/>" .'<label>地址：</label>{address}' . "\n". '{country}'. "\n" . '{city}' . "\n" . '{zone}' ."\n".'邮编：{postcode}'."\n" .  '{company}';
			}

			$find = array(
				'{fullname}',
				'{company}',
				'{shipping_telephone}',
				'{address}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);
			$replace = array(
				'fullname' => $order_info['shipping_fullname'],
				'company'   => $order_info['shipping_company'],
			    'shipping_telephone'   => $order_info['shipping_telephone'],
				'address' => $order_info['shipping_address'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);
			$data['order_status_id'] = $order_info['order_status_id'];
			$data['status'] = $this->model_account_order->getStatus($data['order_status_id']);
			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '&nbsp;&nbsp;', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '&nbsp;&nbsp;', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_info['shipping_method'];
			//var_dump($order_info);
			$data['name'] = $order_info['shipping_fullname'];
			$data['address'] = $order_info['shipping_country'].$order_info['shipping_zone'].$order_info['shipping_city'].$order_info['shipping_address'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_telephone'] = $order_info['shipping_telephone'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['date_modified'] = $order_info['date_modified'];
			$data['comment'] = $order_info['comment'];

			$data['shipping_agents'] = $order_info['shipping_agents'];
			$data['assbillno'] = $order_info['assbillno'];
			
			$data['continuebuy'] = $this->url->link('common/home', '', 'SSL');
			
			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			$this->load->model('account/return');
			
			$this->load->model('tool/image');
			// Products
			$data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
            $discount = 0;
			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
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
                
				$product_info = $this->model_catalog_product->getProduct($product['product_id']);
                //计算折扣
				$discount += ($product_info['price']-($product_info['special']?$product_info['special']:0))*$product['quantity'];
				
				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], 'SSL');
				} else {
					$reorder = '';
				}
				
				$returnInfo = $this->model_account_return->checkGoodsIsReturn($this->request->get['order_id'] , $product['product_id']);
				$returnUrl = '';
				if(!$returnInfo){
				    $returnUrl = $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL');
				}elseif(isset($returnInfo['return_status_id']) && $returnInfo['return_status_id'] == '3'){
				    $returnUrl = $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL');
				}
				if ($product_info['image']) {
				    $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
				    $image = '';
				}
				    
				
				$data['products'][] = array(
					'product_id' =>$product['product_id'],
					'name'     => $product['name'],
					'model'    => $product['model'],
				    'thumb'     => $image,
					'option'   => $option_data,
				    'has_wish' => in_array($product['product_id'], $this->session->data['wishlist']) ? true : false,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format(sprintf("%.2f",$product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value'])),
// 					'dprice'   => "$".(sprintf("%.2f", ($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0))/DOLLAR_RATE)),
				    'tariff_price' => $this->currency->format($product['tariff_price']),
				    'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					//'dtotal'   => "$".(sprintf("%.2f", ($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0))/DOLLAR_RATE)),
				    'reorder'  => $reorder,
					'return'   => $returnUrl,
				    'href'     => $this->url->link('product/wapproduct', 'product_id=' . $product['product_id'])
				);
			}
            $data['discount'] = $discount;
			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
			foreach ($totals as $total) {
				$data['totals'][$total['code']] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				    'dtext' => "$".(sprintf("%.2f", $total['value']/DOLLAR_RATE))
				);
			}
			
			$data['has_tariff'] = $order_info['has_tariff'];
			$data['tariff_price'] = $this->currency->format($order_info['tariff_price'], $order_info['currency_code'], $order_info['currency_value']);
			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			$data['continue'] = $this->url->link('account/order', '', 'SSL');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/order_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/account/order_info.tpl', $data));
			}
		} else {
			$this->document->setTitle($this->language->get('text_order'));

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/order', '', 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/order', '', 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_order'),
				'href' => $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL')
			);
			$data['continue'] = $this->url->link('account/order', '', 'SSL');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}


    public function reorder() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			if (isset($this->request->get['order_product_id'])) {
				$order_product_id = $this->request->get['order_product_id'];
			} else {
				$order_product_id = 0;
			}

			$order_product_info = $this->model_account_order->getOrderProduct($order_id, $order_product_id);

			if ($order_product_info) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($order_product_info['product_id']);

				if ($product_info) {
					$option_data = array();

					$order_options = $this->model_account_order->getOrderOptions($order_product_info['order_id'], $order_product_id);

					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}

					$this->cart->add($order_product_info['product_id'], $order_product_info['quantity'], $option_data);

					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), preg_replace("/(\r\n|\n|\r|\t)/i", '', $product_info['name']), $this->url->link('checkout/cart'));
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				} else {
					$this->session->data['error'] = sprintf($this->language->get('error_reorder'), $order_product_info['name']);
				}
			}
		}

		$this->response->redirect($this->url->link('account/order/info', 'order_id=' . $order_id));
	}
	
	/**
	 * 取消订单
	 */
	public function cancel(){
	    if (isset($this->request->get['order_id'])) {
	        $order_id = $this->request->get['order_id'];
	    } else {
	        $order_id = '';
	    }
	    $json = array();
	    if($order_id){
	        $this->load->model('checkout/order');
	        $status_id = $this->config->get('config_order_cancel') ? $this->config->get('config_order_cancel') : '7';
	        $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('config_order_cancel'));
	    }else{
	        $json['error'] = '取消失败，请稍候重试！';
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	
	/**
	 * 确认收货订单
	 */
	public function confirm(){
	    if (isset($this->request->get['order_id'])) {
	        $order_id = $this->request->get['order_id'];
	    } else {
	        $order_id = 0;
	    }
	    
	    //修改定单状态并且判断订单是否是当前用户
	   $customer_id = $this->session->data['customer_id'];
	   $this->load->model('account/order');
	   $order_customerid = $this->model_account_order->getOrderCustomer_id($order_id);
	   if($order_customerid['customer_id']==$customer_id){
	       $this->model_account_order->confirmOrder($order_id,$customer_id);
	       echo '1';
	       exit;
	   }else{
	       echo '0';
	       exit;
	   }
	}
	
	/**
	 * 用户退货
	 */
	public function returnGoods(){
	    if (isset($this->request->get['order_id'])) {
	        $order_id = $this->request->get['order_id'];
	    } else {
	        $order_id = '';
	    }
	    $json = array();
	    if($order_id){
	        $log = new Log('return/return'.date('Ymd').'.log');
	        
	        $this->load->model('checkout/order');
	        
	        $this->load->model('account/order');
	        //获取订单信息
	        $orderInfo = $this->model_account_order->getOrderInfo($order_id);
	        if($orderInfo['order_status_id'] == '0'){
	            $json['error'] = '退货失败，此订单已拆分，请按子订单退货！';
	            $this->response->addHeader('Content-Type: application/json');
	            $this->response->setOutput(json_encode($json));
	        }
	        //获取订单支付信息，支付时间信息
	        $historyInfo = $this->model_account_order->getHistoryInfo($order_id , '1');
	        //贷款账户账号
	        $loanAcctNo = $this->customer->getLoanAcctno();
	        //app客户编号
	        $app_customerid = $this->customer->getAppCustomerId();
	        
	        $log->write('return :: customerId:'.$app_customerid);
	        
	        $out_trade_no = $this->getOutTradeNo();
	        
	        $xmlStr= '<?xml version="1.0" encoding="UTF-8" ?>';
	        $xmlStr.= '<message>';
	        $xmlStr.= '<head>';
	        $xmlStr.= '<transCode>3312</transCode>';                                  //交易代码
	        $xmlStr.= '<transReqTime>'.date('YmdHis').'</transReqTime>';              //交易请求时间
	        $xmlStr.= '<transSeqNo>'.date('YmdHis').rand(10000,99999).'</transSeqNo>';                   //交易流水号，输入报文流水号
	        $xmlStr.= '<merchantId>'.$this->merchantId.'</merchantId>';               //商户代码
	        $xmlStr.= '<customerId>'.$app_customerid.'</customerId>';                 //客户ID（申请编号）
	        $xmlStr.= '<version>1.0</version>';                                       //版本号
	        $xmlStr.= '</head>';
	        $xmlStr.= '<body>';
	        $xmlStr.= '<merchantCode>'.$this->merchantCode.'</merchantCode>';              
	        $xmlStr.= '<merchantOrderId>'.$out_trade_no.'</merchantOrderId>';               //退款交易订单号码
	        $xmlStr.= '<oriMerchantOrderId>'.$orderInfo['out_trade_no'].'</oriMerchantOrderId>';  //原消费交易订单号码
	        $xmlStr.= '<oriPayTime>'.date('YmdHis' , strtotime($historyInfo['date_added'])).'</oriPayTime>';//原放款交易时间
	        $xmlStr.= '<returnAmt>'.intval($orderInfo['total']*100).'</returnAmt>';
	        $xmlStr.= '</body>';
	        $xmlStr.= '</message>';
	        $xmlStr = preg_replace("/(\r\n|\n|\r|\t)/i", '', $xmlStr);
	        	
	        $curlDeal = new curl_deal();
	        //decrypt
	        $xmlSignature = $curlDeal->postData('http://192.168.5.18:8080/tan-springmvc-book/book.do?method=encrypt' , array('content'=>$xmlStr));
	        	
	        $postUrl = APP_PAYMENT_HOST;
	        
	        $curl = curl_init();
	        $log->write('Verifcode :: xmlSignature:'.$xmlSignature);
	        $header[] = "Content-type: text/xml";        //定义content-type为xml,注意是数组
	        $ch = curl_init ($postUrl);
	        curl_setopt($ch, CURLOPT_URL, $postUrl);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlSignature);
	        $response = curl_exec($ch);
	        $log->write('return :: response:'.$response);
	        $result = simplexml_load_string($response);
	        $log->write('return :: result:'.$result->head->returnCode.PHP_EOL);
	        //echo strval($result->head->returnCode);
	        if(strval($result->head->returnCode)=='000000'){
	            $json['success'] = '退货并退款成功！';
	            //修改订单状态为已退款
	            $status_id = '11';
	            $sql  = "update sl_order_product set refund='1' where order_id='".$order_id."'";
	            $this->db->query($sql);
	            $query_childOrder = $this->db->query("select order_id from sl_order where parent_order_id='".$order_id."'");
	            if($query_childOrder->rows){
	                foreach ($query_childOrder->rows as $order){
	                    $oSql = "update sl_order set order_status_id='".$status_id."' where order_id='".$order['order_id']."'";
	                    $this->db->query($oSql);
	                    $opSql = "update sl_order_product set refund='1' where order_id='".$order['order_id']."'";
	                    $this->db->query($opSql);
	                }
	            }
	            $this->model_checkout_order->addOrderHistory($order_id, $status_id);
	        }else{
	            $json['error'] = '退货失败，请联系客服！';
	        }
	    }else{
	        $json['error'] = '退货失败，请联系客服！';
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	
	/**
	 * 时间订单号
	 */
	public function getOutTradeNo(){
	    return date("YmdHis").rand(10000,99999);
	}
	
}