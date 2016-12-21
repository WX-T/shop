<?php
header("Content-Type:text/html;charset=utf-8"); 

class ControllerSaleOrder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getList();
	}

	public function add() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		unset($this->session->data['cookie']);

		if ($this->validate()) {
			// API
			$this->load->model('user/api');

			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

			if ($api_info) {
				$curl = curl_init();

				// Set SSL if required
				if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
					curl_setopt($curl, CURLOPT_PORT, 443);
				}

				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

				$json = curl_exec($curl);

				if (!$json) {
					$this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
				} else {
					$response = json_decode($json, true);

					if (isset($response['cookie'])) {
						$this->session->data['cookie'] = $response['cookie'];
					}

					curl_close($curl);
				}
			}
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		unset($this->session->data['cookie']);

		if ($this->validate()) {
			// API
			$this->load->model('user/api');

			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

			if ($api_info) {
				$curl = curl_init();

				// Set SSL if required
				if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
					curl_setopt($curl, CURLOPT_PORT, 443);
				}

				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

				$json = curl_exec($curl);

				if (!$json) {
					$this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
				} else {
					$response = json_decode($json, true);

					if (isset($response['cookie'])) {
						$this->session->data['cookie'] = $response['cookie'];
					}

					curl_close($curl);
				}
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		unset($this->session->data['cookie']);

		if (isset($this->request->get['order_id']) && $this->validate()) {
			// API
			$this->load->model('user/api');

			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

			if ($api_info) {
				$curl = curl_init();

				// Set SSL if required
				if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
					curl_setopt($curl, CURLOPT_PORT, 443);
				}

				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

				$json = curl_exec($curl);

				if (!$json) {
					$this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
				} else {
					$response = json_decode($json, true);

					if (isset($response['cookie'])) {
						$this->session->data['cookie'] = $response['cookie'];
					}

					curl_close($curl);
				}
			}
		}

		if (isset($this->session->data['cookie'])) {
			$curl = curl_init();

			// Set SSL if required
			if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
				curl_setopt($curl, CURLOPT_PORT, 443);
			}

			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLINFO_HEADER_OUT, true);
			curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/order/delete&order_id=' . $this->request->get['order_id']);
			curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . $this->session->data['cookie'] . ';');

			$json = curl_exec($curl);

			if (!$json) {
				$this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
			} else {
				$response = json_decode($json, true);

				curl_close($curl);

				if (isset($response['error'])) {
					$this->error['warning'] = $response['error'];
				}
			}
		}

		if (isset($response['error'])) {
			$this->error['warning'] = $response['error'];
		}

		if (isset($response['success'])) {
			$this->session->data['success'] = $response['success'];

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset($this->request->get['filter_customer_telephone'])) {
		    $filter_customer_telephone = $this->request->get['filter_customer_telephone'];
		} else {
		    $filter_customer_telephone = null;
		}
		
		if (isset($this->request->get['filter_customer_expressno'])) {
		    $filter_customer_expressno = $this->request->get['filter_customer_expressno'];
		} else {
		    $filter_customer_expressno = null;
		}
		//
		
		if (isset($this->request->get['filter_line_id'])) {
		    $filter_line_id = $this->request->get['filter_line_id'];
		} else {
		    $filter_line_id = null;
		}
		
		if (isset($this->request->get['filter_party_assbillno'])) {
		    $filter_party_assbillno = $this->request->get['filter_party_assbillno'];
		} else {
		    $filter_party_assbillno = null;
		}
		
		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}
		
		if (isset($this->request->get['filter_order_declartype'])) {
		    $filter_order_declartype = $this->request->get['filter_order_declartype'];
		} else {
		    $filter_order_declartype = null;
		}
		
		if (isset($this->request->get['filter_center_orderno'])) {
		    $filter_center_orderno = $this->request->get['filter_center_orderno'];
		} else {
		    $filter_center_orderno = null;
		}
		
		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}
		
		if (isset($this->request->get['filter_start_time'])) {
		    $filter_start_time = $this->request->get['filter_start_time'];
		} else {
		    $filter_start_time = null;
		}
		
		if (isset($this->request->get['filter_end_time'])) {
		    $filter_end_time = $this->request->get['filter_end_time'];
		} else {
		    $filter_end_time = null;
		}
		
		if (isset($this->request->get['filter_party_order'])) {
		    $filter_party_order = $this->request->get['filter_party_order'];
		} else {
		    $filter_party_order = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_telephone'])) {
		    $url .= '&filter_customer_telephone=' . $this->request->get['filter_customer_telephone'];
		}
		
		if (isset($this->request->get['filter_customer_expressno'])) {
		    $url .= '&filter_customer_expressno=' . $this->request->get['filter_customer_expressno'];
		}
		
		if (isset($this->request->get['filter_line_id'])) {
		    $url .= '&filter_line_id=' . $this->request->get['filter_line_id'];
		}
		
		
		if (isset($this->request->get['filter_party_assbillno'])) {
		    $url .= '&filter_party_assbillno=' . $this->request->get['filter_party_assbillno'];
		}
		
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		
		if (isset($this->request->get['filter_order_declartype'])) {
		    $url .= '&filter_order_declartype=' . $this->request->get['filter_order_declartype'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['filter_start_time'])) {
		    $url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
		    $url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}
		
		if (isset($this->request->get['filter_party_order'])) {
		    $url .= '&filter_party_order=' . $this->request->get['filter_party_order'];
		}
		
		if (isset($this->request->get['filter_center_orderno'])) {
		    $url .= '&filter_center_orderno=' . $this->request->get['filter_center_orderno'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
		$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'], 'SSL');
		$data['add'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], 'SSL');
		$data['xmlUrl'] = HTTP_SERVER;
		$data['orders'] = array();
        //查询merchant_id
        if($this->session->data['user_id'] >1){
            $this->load->model('user/user');
            $merchant_id = $this->model_user_user->getUser($this->session->data['user_id'])['merchant_id'];
        }else{
            $merchant_id = 0;
        }
        $data['user_id'] = $this->session->data['user_id'];
		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
		    'filter_customer_telephone'      => $filter_customer_telephone,
			'filter_order_status'  => $filter_order_status,
		    'filter_order_declartype'  => $filter_order_declartype,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
		    'filter_start_time'    => $filter_start_time,
		    'filter_end_time'      => $filter_end_time,
		    'filter_party_assbillno'   => $filter_party_assbillno,
		    'filter_party_order'    => $filter_party_order,
		    'filter_center_orderno'=> $filter_center_orderno,
		    'merchant_id'          => $merchant_id,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin'),
		    'filter_line_id'       => $filter_line_id,
		    'filter_customer_expressno' => $filter_customer_expressno
		);
		
		$data['merchant_id'] = $merchant_id;
		$order_total = $this->model_sale_order->getTotalOrders($filter_data);

		$results = $this->model_sale_order->getOrders($filter_data);
		foreach ($results as $result) {
		    
		    $productList = array();
		    $products = $this->model_sale_order->getOrderProducts($result['order_id']);
		    foreach ($products as $product) {
		        $option_data = array();
		        $options = $this->model_sale_order->getOrderOptions($result['order_id'], $product['order_product_id']);
		        foreach ($options as $option) {
		            if ($option['type'] != 'file') {
		                $option_data[] = array(
		                    'name'  => $option['name'],
		                    'value' => $option['value'],
		                    'type'  => $option['type']
		                );
		            } else {
		                $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
		    
		                if ($upload_info) {
		                    $option_data[] = array(
		                        'name'  => $option['name'],
		                        'value' => $upload_info['name'],
		                        'type'  => $option['type'],
		                        'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], 'SSL')
		                    );
		                }
		            }
		        }
		        $productList[] = array(
		            'order_product_id' => $product['order_product_id'],
		            'product_id'       => $product['product_id'],
		            'name'    	 	   => $product['name'],
		            'model'    		   => $product['model'],
		            'option'   		   => $option_data,
		            'quantity'		   => $product['quantity'],
		            'source'           => $this->model_sale_order->getSourceName($product['source'])['country_name'],
		            'confirm_buy'      => $product['confirm_buy'],
		            'outofstock'       => $product['outofstock'],
		            'refund'           => $product['refund'],
		            'out_url'          => $product['out_url'],
		            'h5url'            => HTTP_CATALOG."index.php?route=product/wapproduct&product_id={$product['product_id']}",
		            'assbillno'        => $product['party_assbillno'],
		            'party_order_no'   => $product['party_order_no'],
		            'party_price'      => sprintf("%.2f", $product['party_price']),
		            'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $result['currency_code'], $result['currency_value']),
		            'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $result['currency_code'], $result['currency_value']),
		            'href'     		   => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL')
		        );
		    }
		    //查询物流状态
		    $tacking = $this->model_sale_order->getTackingStatus($result['tacking_status']);
		    //var_dump($results);exit;
			$data['orders'][] = array(
			    'merchant_name' => $this->model_sale_order->getMerchantName($result['merchant_id'])['merchant_name'],
			    'line_name'     => $this->model_sale_order->getLineName($result['line_id'])['title'],
				'order_id'      => $result['order_id'],
			    'center_orderno'=> $result['center_orderno'],
				'customer'      => $result['customer'],
				'status'        => $result['status'],
			    'order_status_id'=>$result['order_status_id'],
			    'telephone'     => $result['telephone'],
			    'shipping_agents' => $result['shipping_agents'],
			    'assbillno'     => $result['assbillno'],
			    'declartype'    => $result['declartype'],
			    'ship_price'    => $result['ship_price'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
// 				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
// 				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
			    'date_added'    => $result['date_added'],
			    'date_modified' => $result['date_modified'],
			    'shipping_code' => $result['shipping_code'],
			    'trackingno'    => $result['trackingno'],
			    'trackingstatus'=> $tacking['status'],
			    'products'      => $productList,  
			    'expressno'     => $result['expressno'],
			    'shipping_agents'=>$result['shipping_agents'],
				'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL'),
				'edit'          => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL'),
				'delete'        => $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$data['xmlUrl'] = HTTP_SERVER;
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_sure'] = $this->language->get('text_sure');
		$data['text_cancel'] = $this->language->get('text_cancel');
		
		$data['text_confirm_buy'] = $this->language->get('text_confirm_buy');
		$data['text_outofstock'] = $this->language->get('text_outofstock');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_telephone'] = $this->language->get('column_telephone');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');
		//所有线路
		$data['all_lines'] = $this->model_sale_order->getLines($data['token'] = $this->session->data['user_id']);
		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_source'] = $this->language->get('column_source');
		$data['column_outurl'] = $this->language->get('column_outurl');
		$data['column_party_order_no'] = $this->language->get('column_party_order_no');
		$data['column_party_price'] = $this->language->get('column_party_price');
		$data['column_control'] = $this->language->get('column_control');

		$data['entry_return_id'] = $this->language->get('entry_return_id');
		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');
		$data['entry_party_order_no'] = $this->language->get('entry_party_order_no');
		$data['entry_party_price'] = $this->language->get('entry_party_price');
		$data['entry_party_assbillno'] = $this->language->get('entry_party_assbillno');
        $data['party_assbillno']       = $this->language->get('party_assbillno');
		
		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_Export'] = $this->language->get('button_Export');
		$data['button_ExportHot'] = $this->language->get('button_ExportHot');
		$data['button_ExportReturn'] = $this->language->get('button_ExportReturn');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_confirm_buy'] = $this->language->get('button_confirm_buy');
		$data['button_confirm_order'] = $this->language->get('button_confirm_order');
		$data['button_outofstock'] = $this->language->get('button_outofstock');
		$data['button_shipping'] = $this->language->get('button_shipping');
		$data['button_arrive'] = $this->language->get('button_arrive');
		$data['part_order_no'] = $this->language->get('part_order_no');
	    $data['button_edit_buy']= $this->language->get('button_edit_buy');
		$data['button_import'] = $this->language->get('button_import');
		$data['order_ExportHot'] = $this->language->get('order_ExportHot');
		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_telephone'])) {
		    $url .= '&filter_customer_telephone=' . $this->request->get['filter_customer_telephone'];
		}
		
		if (isset($this->request->get['filter_customer_expressno'])) {
		    $url .= '&filter_customer_expressno=' . $this->request->get['filter_customer_expressno'];
		}
		
		
		if (isset($this->request->get['filter_line_id'])) {
		    $url .= '&filter_line_id=' . $this->request->get['filter_line_id'];
		}
		
		if (isset($this->request->get['filter_party_assbillno'])) {
		    $url .= '&filter_party_assbillno=' . $this->request->get['filter_party_assbillno'];
		}
		
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		
		if (isset($this->request->get['filter_order_declartype'])) {
		    $url .= '&filter_order_declartype=' . $this->request->get['filter_order_declartype'];
		}
		
		if (isset($this->request->get['filter_center_orderno'])) {
		    $url .= '&filter_center_orderno=' . $this->request->get['filter_center_orderno'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}
		
		if (isset($this->request->get['filter_start_time'])) {
		    $url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
		    $url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}
		
		if (isset($this->request->get['filter_party_no'])) {
		    $url .= '&filter_party_no=' . $this->request->get['filter_party_no'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_line_id'])) {
		    $url .= '&filter_line_id=' . $this->request->get['filter_line_id'];
		}
		
		if (isset($this->request->get['filter_customer_telephone'])) {
		    $url .= '&filter_customer_telephone=' . $this->request->get['filter_customer_telephone'];
		}
		
		if (isset($this->request->get['filter_customer_expressno'])) {
		    $url .= '&filter_customer_expressno=' . $this->request->get['filter_customer_expressno'];
		}
		
		
		if (isset($this->request->get['filter_party_assbillno'])) {
		    $url .= '&filter_party_assbillno=' . $this->request->get['filter_party_assbillno'];
		}
		
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		
		if (isset($this->request->get['filter_order_declartype'])) {
		    $url .= '&filter_order_declartype=' . $this->request->get['filter_order_declartype'];
		}
		
		if (isset($this->request->get['filter_center_orderno'])) {
		    $url .= '&filter_center_orderno=' . $this->request->get['filter_center_orderno'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}
		
		if (isset($this->request->get['filter_start_time'])) {
		    $url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
		    $url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}
		
		if (isset($this->request->get['filter_party_no'])) {
		    $url .= '&filter_party_no=' . $this->request->get['filter_party_no'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
  
		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_customer_telephone'] = $filter_customer_telephone;
		$data['filter_customer_expressno'] = $filter_customer_expressno;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;
		$data['filter_order_declartype'] = $filter_order_declartype;
		$data['filter_start_time'] = $filter_start_time;
		$data['filter_end_time'] = $filter_end_time;
		$data['filter_party_order'] = $filter_party_order;
		$data['filter_party_assbillno'] = $filter_party_assbillno;
		$data['filter_center_orderno'] = $filter_center_orderno;
		$data['filter_line_id'] = $filter_line_id;
		//var_dump($data['filter_customer_telephone']);
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		array_push($data['order_statuses'],array('order_status_id'=>'backproduct','name'=>'部分退货'));
		$data['sort'] = $sort;
		$data['order'] = $order;

// 		var_dump($data['orders']);die();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_list.tpl', $data));
	}

	public function getForm() {
		$this->load->model('sale/customer');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_order'] = $this->language->get('text_order');

		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_shipping_telephone'] = $this->language->get('entry_shipping_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_to_name'] = $this->language->get('entry_to_name');
		$data['entry_to_email'] = $this->language->get('entry_to_email');
		$data['entry_from_name'] = $this->language->get('entry_from_name');
		$data['entry_from_email'] = $this->language->get('entry_from_email');
		$data['entry_theme'] = $this->language->get('entry_theme');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$data['entry_coupon'] = $this->language->get('entry_coupon');
		$data['entry_voucher'] = $this->language->get('entry_voucher');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_order_status'] = $this->language->get('entry_order_status');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_product_add'] = $this->language->get('button_product_add');
		$data['button_voucher_add'] = $this->language->get('button_voucher_add');

		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_order'] = $this->language->get('tab_order');
		$data['tab_customer'] = $this->language->get('tab_customer');
		$data['tab_payment'] = $this->language->get('tab_payment');
		$data['tab_shipping'] = $this->language->get('tab_shipping');
		$data['tab_product'] = $this->language->get('tab_product');
		$data['tab_voucher'] = $this->language->get('tab_voucher');
		$data['tab_total'] = $this->language->get('tab_total');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		
		if (isset($this->request->get['filter_order_declartype'])) {
		    $url .= '&filter_order_declartype=' . $this->request->get['filter_order_declartype'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
		    $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}

		if (!empty($order_info)) {
			$data['order_id'] = $this->request->get['order_id'];
			$data['store_id'] = $order_info['store_id'];

			$data['customer'] = $order_info['customer'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['customer_group_id'] = $order_info['customer_group_id'];
			$data['fullname'] = $order_info['fullname'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['fax'] = $order_info['fax'];
			$data['account_custom_field'] = $order_info['custom_field'];

			$this->load->model('sale/customer');

			$data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);

			$data['payment_fullname'] = $order_info['payment_fullname'];
			$data['payment_company'] = $order_info['payment_company'];
			$data['payment_address'] = $order_info['payment_address'];
			$data['payment_city'] = $order_info['payment_city'];
			$data['payment_postcode'] = $order_info['payment_postcode'];
			$data['payment_country_id'] = $order_info['payment_country_id'];
			$data['payment_zone_id'] = $order_info['payment_zone_id'];
			$data['payment_custom_field'] = $order_info['payment_custom_field'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['payment_code'] = $order_info['payment_code'];

			$data['shipping_fullname'] = $order_info['shipping_fullname'];
			$data['shipping_telephone'] = $order_info['shipping_telephone'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address'] = $order_info['shipping_address'];
			$data['shipping_city'] = $order_info['shipping_city'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_country_id'] = $order_info['shipping_country_id'];
			$data['shipping_zone_id'] = $order_info['shipping_zone_id'];
			$data['shipping_custom_field'] = $order_info['shipping_custom_field'];
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['shipping_code'] = $order_info['shipping_code'];

			// Add products to the API
			$data['order_products'] = array();
			
			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$data['order_products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
					'quantity'   => $product['quantity'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'reward'     => $product['reward']
				);
			}

			// Add vouchers to the API
			$data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';

			$data['order_totals'] = array();

			$order_totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');

				if ($start && $end) {
					if ($order_total['code'] == 'coupon') {
						$data['coupon'] = substr($order_total['title'], $start, $end - $start);
					}

					if ($order_total['code'] == 'voucher') {
						$data['voucher'] = substr($order_total['title'], $start, $end - $start);
					}

					if ($order_total['code'] == 'reward') {
						$data['reward'] = substr($order_total['title'], $start, $end - $start);
					}
				}
			}

			$data['order_status_id'] = $order_info['order_status_id'];
			$data['comment'] = $order_info['comment'];
			$data['affiliate_id'] = $order_info['affiliate_id'];
			$data['affiliate'] = $order_info['affiliate_fullname'];
			$data['currency_code'] = $order_info['currency_code'];
		} else {
			$data['order_id'] = 0;
			$data['store_id'] = '';
			$data['customer'] = '';
			$data['customer_id'] = '';
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$data['fullname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['fax'] = '';
			$data['customer_custom_field'] = array();

			$data['addresses'] = array();

			$data['payment_fullname'] = '';
			$data['payment_company'] = '';
			$data['payment_address'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_country_id'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_custom_field'] = array();
			$data['payment_method'] = '';
			$data['payment_code'] = '';

			$data['shipping_fullname'] = '';
			$data['shipping_telephone'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_custom_field'] = array();
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';

			$data['order_products'] = array();
			$data['order_vouchers'] = array();
			$data['order_totals'] = array();

			$data['order_status_id'] = $this->config->get('config_order_status_id');
			$data['comment'] = '';
			$data['affiliate_id'] = '';
			$data['affiliate'] = '';
			$data['currency_code'] = $this->config->get('config_currency');

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
		}

		// Stores
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		// Customer Groups
		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		// Custom Fields
		$this->load->model('sale/custom_field');

		$data['custom_fields'] = array();

		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);

		$custom_fields = $this->model_sale_custom_field->getCustomFields($filter_data);

		foreach ($custom_fields as $custom_field) {
			$data['custom_fields'][] = array(
				'custom_field_id'    => $custom_field['custom_field_id'],
				'custom_field_value' => $this->model_sale_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
				'name'               => $custom_field['name'],
				'value'              => $custom_field['value'],
				'type'               => $custom_field['type'],
				'location'           => $custom_field['location'],
				'sort_order'         => $custom_field['sort_order']
			);
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
		
		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['voucher_min'] = $this->config->get('config_voucher_min');

		$this->load->model('sale/voucher_theme');

		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_form.tpl', $data));
	}

	public function info() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->load->language('sale/order');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_invoice_date'] = $this->language->get('text_invoice_date');
			$data['text_store_name'] = $this->language->get('text_store_name');
			$data['text_store_url'] = $this->language->get('text_store_url');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_customer_group'] = $this->language->get('text_customer_group');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_total'] = $this->language->get('text_total');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_order_status'] = $this->language->get('text_order_status');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_affiliate'] = $this->language->get('text_affiliate');
			$data['text_commission'] = $this->language->get('text_commission');
			$data['text_ip'] = $this->language->get('text_ip');
			$data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
			$data['text_user_agent'] = $this->language->get('text_user_agent');
			$data['text_accept_language'] = $this->language->get('text_accept_language');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_date_modified'] = $this->language->get('text_date_modified');
			$data['text_fullname'] = $this->language->get('text_fullname');
			$data['text_company'] = $this->language->get('text_company');
			$data['text_address'] = $this->language->get('text_address');
			$data['text_city'] = $this->language->get('text_city');
			$data['text_postcode'] = $this->language->get('text_postcode');
			$data['text_zone'] = $this->language->get('text_zone');
			$data['text_zone_code'] = $this->language->get('text_zone_code');
			$data['text_country'] = $this->language->get('text_country');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_shipping_telephone'] = $this->language->get('text_shipping_telephone');

			$data['column_product'] = $this->language->get('column_product');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['entry_order_status'] = $this->language->get('entry_order_status');
			$data['entry_notify'] = $this->language->get('entry_notify');
			$data['entry_comment'] = $this->language->get('entry_comment');

			$data['button_invoice_print'] = $this->language->get('button_invoice_print');
			$data['button_shipping_print'] = $this->language->get('button_shipping_print');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_generate'] = $this->language->get('button_generate');
			$data['button_reward_add'] = $this->language->get('button_reward_add');
			$data['button_reward_remove'] = $this->language->get('button_reward_remove');
			$data['button_commission_add'] = $this->language->get('button_commission_add');
			$data['button_commission_remove'] = $this->language->get('button_commission_remove');
			$data['button_history_add'] = $this->language->get('button_history_add');

			$data['tab_order'] = $this->language->get('tab_order');
			$data['tab_payment'] = $this->language->get('tab_payment');
			$data['tab_shipping'] = $this->language->get('tab_shipping');
			$data['tab_product'] = $this->language->get('tab_product');
			$data['tab_history'] = $this->language->get('tab_history');
			$data['tab_fraud'] = $this->language->get('tab_fraud');
			$data['tab_action'] = $this->language->get('tab_action');

			$data['token'] = $this->session->data['token'];

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_party_assbillno'])) {
			    $url .= '&filter_party_assbillno=' . $this->request->get['filter_party_assbillno'];
			}
			
			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);

			$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$data['edit'] = $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

			$data['order_id'] = $this->request->get['order_id'];

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['store_name'] = $order_info['store_name'];
			$data['store_url'] = $order_info['store_url'];
			$data['fullname'] = $order_info['fullname'];

			if ($order_info['customer_id']) {
				$data['customer'] = $this->url->link('sale/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], 'SSL');
			} else {
				$data['customer'] = '';
			}

			$this->load->model('sale/customer_group');

			$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($order_info['customer_group_id']);

			if ($customer_group_info) {
				$data['customer_group'] = $customer_group_info['name'];
			} else {
				$data['customer_group'] = '';
			}

			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['fax'] = $order_info['fax'];
			$data['shipping_telephone'] = $order_info['shipping_telephone'];
			$data['logistics'] = $order_info['logistics'];
			$data['account_custom_field'] = $order_info['custom_field'];
			
			// Uploaded files
			$this->load->model('tool/upload');
		
		
			// Custom Fields
			$this->load->model('sale/custom_field');
			
			$data['account_custom_fields'] = array();

			$custom_fields = $this->model_sale_custom_field->getCustomFields();

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'account' && isset($order_info['custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_sale_custom_field->getCustomFieldValue($order_info['custom_field'][$custom_field['custom_field_id']]);
						
						if ($custom_field_value_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name']
							);
						}
					}
					
					if ($custom_field['type'] == 'checkbox' && is_array($order_info['custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_sale_custom_field->getCustomFieldValue($custom_field_value_id);
							
							if ($custom_field_value_info) {						
								$data['account_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name']
								);	
							}
						}
					}
										
					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['account_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['custom_field'][$custom_field['custom_field_id']]
						);						
					}
					
					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name']
							);							
						}
					}
				}
			}
			
			$data['comment'] = nl2br($order_info['comment']);
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

			$this->load->model('sale/customer');

			$data['reward'] = $order_info['reward'];

			$data['reward_total'] = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

			$data['affiliate_fullname'] = $order_info['affiliate_fullname'];

			if ($order_info['affiliate_id']) {
				$data['affiliate'] = $this->url->link('marketing/affiliate/edit', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], 'SSL');
			} else {
				$data['affiliate'] = '';
			}

			$data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

			$this->load->model('marketing/affiliate');

			$data['commission_total'] = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

			$this->load->model('localisation/order_status');

			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);

			if ($order_status_info) {
				$data['order_status'] = $order_status_info['name'];
			} else {
				$data['order_status'] = '';
			}

			$data['ip'] = $order_info['ip'];
			$data['forwarded_ip'] = $order_info['forwarded_ip'];
			$data['user_agent'] = $order_info['user_agent'];
			$data['accept_language'] = $order_info['accept_language'];
			$data['date_added'] = $order_info['date_added'];
			$data['date_modified'] = $order_info['date_modified'];
			
			// Payment
			$data['payment_fullname'] = $order_info['payment_fullname'];
			$data['payment_company'] = $order_info['payment_company'];
			$data['payment_address'] = $order_info['payment_address'];
			$data['payment_city'] = $order_info['payment_city'];
			
			if($data['payment_city']=='0' || !$data['payment_city']){
			    $data['payment_city'] = $this->model_sale_order->getCityname($order_info['city_id'])['name'];
			}
			$data['payment_postcode'] = $order_info['payment_postcode'];
			$data['payment_zone'] = $order_info['payment_zone'];
			$data['payment_zone_code'] = $order_info['payment_zone_code'];
			$data['payment_country'] = $order_info['payment_country'];
			$data['shipping_agents'] = $order_info['shipping_agents'];
			// Custom fields
			$data['payment_custom_fields'] = array();

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_sale_custom_field->getCustomFieldValue($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['payment_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_sale_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['payment_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['payment_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['payment_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}			
			
			// Shipping
			$data['shipping_fullname'] = $order_info['shipping_fullname'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address'] = $order_info['shipping_address'];
			$data['shipping_city'] = $order_info['shipping_city'];
			if($data['shipping_city']=='0' || !$data['shipping_city']){
			    $data['shipping_city'] = $this->model_sale_order->getCityname($order_info['city_id'])['name'];
			}
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_zone'] = $order_info['shipping_zone'];
			$data['shipping_zone_code'] = $order_info['shipping_zone_code'];
			$data['shipping_country'] = $order_info['shipping_country'];
			
			$data['shipping_custom_fields'] = array();
			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_sale_custom_field->getCustomFieldValue($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

						if ($custom_field_value_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}

					if ($custom_field['type'] == 'checkbox' && is_array($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['shipping_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_sale_custom_field->getCustomFieldValue($custom_field_value_id);

							if ($custom_field_value_info) {
								$data['shipping_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}

					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['shipping_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['shipping_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}

					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

						if ($upload_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}				

			$data['products'] = array();

			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $upload_info['name'],
								'type'  => $option['type'],
								'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], 'SSL')
							);
						}
					}
				}

				$data['products'][] = array(
					'order_product_id' => $product['order_product_id'],
					'product_id'       => $product['product_id'],
					'name'    	 	   => $product['name'],
					'model'    		   => $product['model'],
					'option'   		   => $option_data,
					'quantity'		   => $product['quantity'],
					'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'href'     		   => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}
			$data['vouchers'] = array();
			$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					'href'        => $this->url->link('sale/voucher/edit', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], 'SSL')
				);
			}
			
			$data['totals'] = array();

			$totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}

			$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

			$data['order_status_id'] = $order_info['order_status_id'];

			// Unset any past sessions this page date_added for the api to work.
			unset($this->session->data['cookie']);

			// Set up the API session
			if ($this->user->hasPermission('modify', 'sale/order')) {
				$this->load->model('user/api');

				$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

				if ($api_info) {
					$curl = curl_init();

					// Set SSL if required
					if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
						curl_setopt($curl, CURLOPT_PORT, 443);
					}

					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLINFO_HEADER_OUT, true);
					curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

					$json = curl_exec($curl);

					if (!$json) {
						$data['error_warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
					} else {
						$response = json_decode($json, true);
					}

					if (isset($response['cookie'])) {
						$this->session->data['cookie'] = $response['cookie'];
					}
				}
			}

			if (isset($response['cookie'])) {
				$this->session->data['cookie'] = $response['cookie'];
			} else {
				$data['error_warning'] = $this->language->get('error_permission');
			}

			$data['payment_action'] = $this->load->controller('payment/' . $order_info['payment_code'] . '/action');

			$data['frauds'] = array();

			$this->load->model('extension/extension');

			$extensions = $this->model_extension_extension->getInstalled('fraud');

			foreach ($extensions as $extension) {
				if ($this->config->get($extension . '_status')) {
					$this->load->language('fraud/' . $extension);

					$content = $this->load->controller('fraud/' . $extension . '/order');

					if ($content) {
						$data['frauds'][] = array(
							'code'    => $extension,
							'title'   => $this->language->get('heading_title'),
							'content' => $content
						);
					}
				}
			}

			
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('sale/order_info.tpl', $data));
		} else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found.tpl', $data));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function createInvoiceNo() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} elseif (isset($this->request->get['order_id'])) {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$invoice_no = $this->model_sale_order->createInvoiceNo($order_id);

			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addReward() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
				$this->load->model('sale/customer');

				$reward_total = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($order_id);

				if (!$reward_total) {
					$this->model_sale_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['reward'], $order_id);
				}
			}

			$json['success'] = $this->language->get('text_reward_added');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeReward() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('sale/customer');

				$this->model_sale_customer->deleteReward($order_id);
			}

			$json['success'] = $this->language->get('text_reward_removed');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addCommission() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('marketing/affiliate');

				$affiliate_total = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($order_id);

				if (!$affiliate_total) {
					$this->model_marketing_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['commission'], $order_id);
				}
			}

			$json['success'] = $this->language->get('text_commission_added');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCommission() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$this->load->model('marketing/affiliate');

				$this->model_marketing_affiliate->deleteTransaction($order_id);
			}

			$json['success'] = $this->language->get('text_commission_removed');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
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

	public function history() {
		$this->load->language('sale/order');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$this->load->model('sale/order');

		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => $result['date_added']
			);
		}

		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('sale/order_history.tpl', $data));
	}

	public function invoice() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_invoice');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_to'] = $this->language->get('text_to');
		$data['text_ship_to'] = $this->language->get('text_ship_to');
		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_comment'] = $this->language->get('column_comment');

		$this->load->model('sale/order');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

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

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{fullname}' . "\n" . '{company}' . "\n" . '{address}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}' . "\n" . '{shipping_telephone}';
				}

				$find = array(
					'{fullname}',
					'{company}',
					'{address}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}',
					'{shipping_telephone}'
				);

				$replace = array(
					'fullname' => $order_info['shipping_fullname'],
					'company'   => $order_info['shipping_company'],
					'address' => $order_info['shipping_address'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country'],
					'shipping_address'   => $order_info['shipping_telephone']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

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
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$voucher_data = array();

				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$total_data = array();

				$totals = $this->model_sale_order->getOrderTotals($order_id);

				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				$data['orders'][] = array(
					'order_id'	         => $order_id,
					'invoice_no'         => $invoice_no,
// 					'date_added'         => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
				    'date_added'         => $order_info['date_added'],
				    'store_name'         => $order_info['store_name'],
					'store_url'          => rtrim($order_info['store_url'], '/'),
					'store_address'      => nl2br($store_address),
					'store_email'        => $store_email,
					'store_telephone'    => $store_telephone,
					'store_fax'          => $store_fax,
					'email'              => $order_info['email'],
					'telephone'          => $order_info['telephone'],
					'shipping_address'   => $shipping_address,
					'shipping_method'    => $order_info['shipping_method'],
					'payment_address'    => $payment_address,
					'payment_method'     => $order_info['payment_method'],
					'product'            => $product_data,
					'voucher'            => $voucher_data,
					'total'              => $total_data,
					'comment'            => nl2br($order_info['comment'])
				);
			}
		}

		$this->response->setOutput($this->load->view('sale/order_invoice.tpl', $data));
	}

	public function shipping() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_shipping');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_shipping'] = $this->language->get('text_shipping');
		$data['text_picklist'] = $this->language->get('text_picklist');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_from'] = $this->language->get('text_from');
		$data['text_to'] = $this->language->get('text_to');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_sku'] = $this->language->get('text_sku');
		$data['text_upc'] = $this->language->get('text_upc');
		$data['text_ean'] = $this->language->get('text_ean');
		$data['text_jan'] = $this->language->get('text_jan');
		$data['text_isbn'] = $this->language->get('text_isbn');
		$data['text_mpn'] = $this->language->get('text_mpn');
		$data['text_shipping_telephone'] = $this->language->get('text_shipping_telephone');

		$data['column_location'] = $this->language->get('column_location');
		$data['column_reference'] = $this->language->get('column_reference');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_weight'] = $this->language->get('column_weight');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_comment'] = $this->language->get('column_comment');

		$this->load->model('sale/order');

		$this->load->model('catalog/product');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			// Make sure there is a shipping method
			if ($order_info && $order_info['shipping_code']) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
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
					'fullname' => $order_info['shipping_fullname'],
					'company'   => $order_info['shipping_company'],
					'address' => $order_info['shipping_address'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);

					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

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
							'value' => $value
						);
					}

					$product_data[] = array(
						'name'     => $product_info['name'],
						'model'    => $product_info['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'location' => $product_info['location'],
						'sku'      => $product_info['sku'],
						'upc'      => $product_info['upc'],
						'ean'      => $product_info['ean'],
						'jan'      => $product_info['jan'],
						'isbn'     => $product_info['isbn'],
						'mpn'      => $product_info['mpn'],
						'weight'   => $this->weight->format($product_info['weight'], $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'))
					);
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => $order_info['date_added'],
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_telephone' => $order_info['shipping_telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'product'          => $product_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

		$this->response->setOutput($this->load->view('sale/order_shipping.tpl', $data));
	}

	public function api() {
		$this->load->language('sale/order');
		if ($this->validate()) {
		    //保存国内物流信息
		    if($this->request->post['order_status_id']=='29' && $this->request->post['shipping_agents'] && $this->request->post['logistics']){
		        $this->load->model('sale/order');
		        $row = $this->model_sale_order->setLogistics($this->request->get['order_id'],$this->request->post['shipping_agents'],$this->request->post['logistics']);
		    }
			// Store
			if (isset($this->request->get['store_id'])) {
				$store_id = $this->request->get['store_id'];
			} else {
				$store_id = 0;
			}

			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($store_id);

			if ($store_info) {
				$url = $store_info['ssl'];
			} else {
				$url = HTTPS_CATALOG;
			}

			if (isset($this->session->data['cookie']) && isset($this->request->get['api'])) {
				// Include any URL perameters
				$url_data = array();

				foreach($this->request->get as $key => $value) {
					if ($key != 'route' && $key != 'token' && $key != 'store_id') {
						$url_data[$key] = $value;
					}
				}

				$curl = curl_init();

				// Set SSL if required
				if (substr($url, 0, 5) == 'https') {
					curl_setopt($curl, CURLOPT_PORT, 443);
				}

				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, $url . 'index.php?route=' . $this->request->get['api'] . ($url_data ? '&' . http_build_query($url_data) : ''));
				if ($this->request->post) {
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->request->post));
				}

				curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . $this->session->data['cookie'] . ';');

				$json = curl_exec($curl);

				curl_close($curl);
			}
		} else {
			$response = array();
			
			$response['error'] = $this->error;

			$json = json_encode($response);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput($json);
	}
	
	

	
	/**
	 * 确认购买商品
	 */
	public function confirmbuy(){
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $o_product_id = $this->request->post['o_product_id'];
	    $party_order_no = $this->request->post['order_no'];
	    $party_price = $this->request->post['price'];
// 	    $party_assbillno = $this->request->post['assbillno'];
	    $rs = $this->model_sale_order->confirmBuy($order_id,$o_product_id , $party_order_no , $party_price);
	    if($rs){
	        $code = $this->model_sale_order->isOutOrderGoods($order_id);
	        $party_price = sprintf("%.4f", $party_price);
	        $json = json_encode(array('code'=>$code , 'order_no'=>$party_order_no , 'price'=>$party_price));
	    }else{
	        $json = json_encode(array('code'=>'-1'));
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	public function getbuy(){
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $o_product_id = $this->request->post['o_product_id'];
	    $getdata = $this->model_sale_order->getBuy($o_product_id);
	    $json = json_encode($getdata);
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	/**
	 * 修改已确认购买的商品信息
	 */
	public function editbuy(){
	    $this->load->model('sale/order');
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $o_product_id = $this->request->post['o_product_id'];
	    $party_order_no = $this->request->post['order_no'];
	    $party_price = $this->request->post['price'];
	    $party_assbillno = $this->request->post['party_assbillno'];
	    $this->model_sale_order->editBuy($order_id , $o_product_id , $party_order_no , $party_price ,$party_assbillno);
	    $json = json_encode(array('code'=>'3'));
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	/**
	 * 商品缺货
	 */
	public function outofstock(){
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $o_product_id = $this->request->post['o_product_id'];
	    $rs = $this->model_sale_order->outOfStock($o_product_id);
	    if($rs){
	        $code = $this->model_sale_order->isOrderDeal($order_id);
    	    $json = json_encode(array('code'=>$code , 'order_id'=>$order_id , 'product_id'=>$o_product_id));
	    }else{
	        $json = json_encode(array('code'=>'-1'));
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	/**
	 * 商品已退款
	 */
	public function refund(){
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $o_product_id = $this->request->post['o_product_id'];
	    
        //退款接口操作
        $log = new Log('return/return'.date('Ymd').'.log');
        
        $this->load->model('sale/order');
        
        $this->load->model('sale/customer');
        //获取订单信息
        $orderInfo = $this->model_sale_order->getOrderInfo($order_id);
        
        if($orderInfo['order_status_id'] == '0'){
            $json = json_encode(array('resunt'=>'01','code'=>'退款失败，此订单已拆分，请按子订单退款！'));
            $this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput($json);
        }
        if($o_product_id){
            //订单商品
            $orderProductInfo = $this->model_sale_order->getOrderProductInfo($o_product_id);
            $returnPrice = $this->model_sale_order->returnGoodsPrice($order_id , $o_product_id);
            $log->write('return-back :: order_id:'.$order_id." order_product_id:".$o_product_id);
        }else{
            $query = $this->db->query("SELECT sum(total+tariff_price) as total FROM " . DB_PREFIX . "order_product where order_id='".$order_id."' and refund='1'");
            $refundInfo = $query->row;
            if($refundInfo['total']){
                $returnPrice = $orderInfo['total'] - sprintf('%.2f' , $refundInfo['total']);
            }else{
                $returnPrice = $orderInfo['total'];
            }
            $log->write('return-back :: order_id:'.$order_id);
        }
        //获取订单支付信息，支付时间信息
        $historyInfo = $this->model_sale_order->getHistoryInfo($order_id , '1');
        //获取用户信息
        $customerInfo = $this->model_sale_customer->getCustomer($orderInfo['customer_id']);
        //贷款账户账号
        $loanAcctNo = $customerInfo['loanacctno'];
        //app客户编号
        $app_customerid = $customerInfo['app_customerid'];
        
        
        $log->write('return-back :: customerId:'.$app_customerid);
        $log->write('return-back :: price:'.$returnPrice);
         
        $out_trade_no = $this->getOutTradeNo();
        
        $xmlStr= '<?xml version="1.0" encoding="UTF-8" ?>';
        $xmlStr.= '<message>';
        $xmlStr.= '<head>';
        $xmlStr.= '<transCode>3312</transCode>';                                  //交易代码
        $xmlStr.= '<transReqTime>'.date('YmdHis').'</transReqTime>';              //交易请求时间
        $xmlStr.= '<transSeqNo>'.date('YmdHis').rand(10000,99999).'</transSeqNo>';                   //交易流水号，输入报文流水号
        $xmlStr.= '<merchantId>'.APP_EPASS_MERCHANTID.'</merchantId>';               //商户代码
        $xmlStr.= '<customerId>'.$app_customerid.'</customerId>';                 //客户ID（申请编号）
        $xmlStr.= '<version>1.0</version>';                                       //版本号
        $xmlStr.= '</head>';
        $xmlStr.= '<body>';
        $xmlStr.= '<merchantCode>'.APP_EPASS_MERCHANTCODE.'</merchantCode>';
        $xmlStr.= '<merchantOrderId>'.$out_trade_no.'</merchantOrderId>';               //退款交易订单号码
        $xmlStr.= '<oriMerchantOrderId>'.$orderInfo['out_trade_no'].'</oriMerchantOrderId>';  //原消费交易订单号码
        $xmlStr.= '<oriPayTime>'.date('YmdHis' , strtotime($historyInfo['date_added'])).'</oriPayTime>';//原放款交易时间
        $xmlStr.= '<returnAmt>'.floatval(round($returnPrice,2)*100).'</returnAmt>';
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
        //echo $response;
        $log->write('return-back :: response:'.$response);
        $result = simplexml_load_string($response);
        $log->write('return-back :: result:'.$result->head->returnCode.PHP_EOL);
        //echo strval($result->head->returnCode);
        if(strval($result->head->returnCode)=='000000'){
            if($o_product_id){
                //修改订单状态为已退款
                $rs = $this->model_sale_order->refund($o_product_id);
                //退款接口操作
                $code = $this->model_sale_order->isOutOrderGoods($order_id);
            }else{
                //更改订单状态为已退款
                $this->model_sale_order->addOrderHistoryStatus($order_id , '11');
                $code = '退货成功';
            }
            $json = json_encode(array('resunt'=>'00','code'=>$code));
        }else{
            $json = json_encode(array('resunt'=>'01','code'=>'退款失败，请联系IT人员'));
        }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	
	/**
	 * 时间订单号
	 */
	public function getOutTradeNo(){
	    return date("YmdHis").rand(10000,99999);
	}
	
	/**
	 * 订单发货
	 */
	public function shipment(){
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $is_party_assinllno = true;
	    //查询是否有物流单号
	    $orderList = $this->model_sale_order->getOrderProduct($order_id);
	    foreach ($orderList as $order){
	        if($order['party_assbillno']){
	            $is_party_assinllno = false;
	        }
	    }
	    $assbillno = trim($this->request->post['assbillno']);
	    if($is_party_assinllno){
	        // 	    $shipping_agents = $this->request->post['shipping_agents'];
	        // 	    $ship_price = $this->request->post['ship_price'];
	        $party_assbillno = $this->request->post['party_assbillno'];
	        $this->model_sale_order->shipment($order_id , $party_assbillno);
	        $this->model_sale_order->shipment($order_id , $assbillno , $party_assbillno);
	        $assbillno = isset($this->request->post['assbillno']) ? $this->request->post['assbillno'] : $party_assbillno;
	        $this->model_sale_order->shipment($order_id , $assbillno , $party_assbillno);
	        $json = json_encode(array('code'=>'1'));
	    }else{
	        $this->model_sale_order->setSendProduct($order_id,$party_assbillno);
	        $json = json_encode(array('code'=>'1'));
	    }

	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	/**
	 * 订单到货
	 */
	
	public function goodsarrive(){
	    $this->load->model('sale/order');
	    $order_id = $this->request->post['order_id'];
	    $date_arrive = $this->request->post['date_arrive'];
	    $this->model_sale_order->goodsarrive($order_id , $date_arrive);
	    $json = json_encode(array('code'=>'2'));
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput($json);
	}
	
	/**
	 * 商户导出订单列表
	 */
	public function merchantdoexport(){
	    $this->load->model('sale/order');
	    include './PHPExcel/PHPExcel.php';
	    $objPHPExcel = new PHPExcel();
	    
	    
	    if($this->request->post['filter_start_time']){
	        $filter_start_time = $this->request->post['filter_start_time'];
	    } else {
	        $filter_start_time = null;
	    }
	    if($this->request->post['filter_end_time']){
	        $filter_end_time = $this->request->post['filter_end_time'];
	    } else {
	        $filter_end_time = null;
	    }
	    if (trim($this->request->post['filter_order_id'])) {
	        $filter_order_id = $this->request->post['filter_order_id'];
	    } else {
	        $filter_order_id = null;
	    }
	    if (trim($this->request->post['filter_customer'])) {
	        $filter_customer = urldecode(html_entity_decode(trim($this->request->post['filter_customer']), ENT_QUOTES, 'UTF-8'));
	    } else {
	        $filter_customer = null;
	    }
	    if (trim($this->request->post['filter_customer_telephone'])) {
	        $filter_customer_telephone = $this->request->post['filter_customer_telephone'];
	    } else {
	        $filter_customer_telephone = null;
	    }
	    // var_dump($filter_customer_telephone);
	    if ($this->request->post['filter_order_status'] != '*') {
	        $filter_order_status = $this->request->post['filter_order_status'];
	    } else {
	        $filter_order_status = null;
	    }
	    if ($this->request->post['filter_order_declartype']) {
	        $filter_order_declartype = $this->request->post['filter_order_declartype'];
	    } else {
	        $filter_order_declartype = null;
	    }
	     
	    if ($this->request->post['filter_line_id']) {
	        $filter_line_id = $this->request->post['filter_line_id'];
	    } else {
	        $filter_line_id = null;
	    }
	     
	    if ($this->request->post['filter_total']) {
	        $filter_total = $this->request->post['filter_total'];
	    } else {
	        $filter_total = null;
	    }
	     
	    if ($this->request->post['filter_date_added']) {
	        $filter_date_added = $this->request->post['filter_date_added'];
	    } else {
	        $filter_date_added = null;
	    }
	     
	    if ($this->request->post['filter_date_modified']) {
	        $filter_date_modified = $this->request->post['filter_date_modified'];
	    } else {
	        $filter_date_modified = null;
	    }
	     
	    if ($this->request->post['filter_party_order']) {
	        $filter_party_order = $this->request->post['filter_party_order'];
	    } else {
	        $filter_party_order = null;
	    }
	     
	    if($this->session->data['user_id'] >1){
	        $this->load->model('user/user');
	        $merchant_id = $this->model_user_user->getUser($this->session->data['user_id'])['merchant_id'];
	    }else{
	        $merchant_id = 0;
	    }
	     
	    $filter_data = array(
	        'filter_order_id'             => $filter_order_id,
	        'filter_customer'	          => $filter_customer,
	        'filter_customer_telephone'	  => $filter_customer_telephone,
	        'filter_order_status'         => $filter_order_status,
	        'filter_order_declartype'     => $filter_order_declartype,
	        'filter_total'                => $filter_total,
	        'filter_date_added'           => $filter_date_added,
	        'filter_date_modified'        => $filter_date_modified,
	        'filter_start_time'           => $filter_start_time,
	        'filter_end_time'             => $filter_end_time,
	        'filter_party_order'          => $filter_party_order,
	        'merchant_id'                 => $merchant_id,
	        'filter_line_id'              => $filter_line_id
	    );
	    $exportdata = $this->model_sale_order->getmerchantexpdata($filter_data);
	    //设置表头名称
	    $objPHPExcel->getActiveSheet()->setTitle('订单列表');
	    //表格标题栏
	    $objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');
	    $objPHPExcel->getActiveSheet()->setCellValue('B1', '商品中文名称');
	    $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品英文名称');
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', '商品编号');
	    $objPHPExcel->getActiveSheet()->setCellValue('E1', '数量');
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', '订单状态');
	    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'WSE单号');
	    $objPHPExcel->getActiveSheet()->setCellValue('H1', '线路');
	    $objPHPExcel->getActiveSheet()->setCellValue('I1', '下单日期');
	    $objPHPExcel->getActiveSheet()->setCellValue('J1', '修改日期');
	    $objPHPExcel->getActiveSheet()->setCellValue('K1', '收货人姓名');
	    $objPHPExcel->getActiveSheet()->setCellValue('L1', '州/省/地区');
	    $objPHPExcel->getActiveSheet()->setCellValue('M1', '城市');
	    $objPHPExcel->getActiveSheet()->setCellValue('N1', '地址');
	    $objPHPExcel->getActiveSheet()->setCellValue('O1', '邮政编码');
	    $objPHPExcel->getActiveSheet()->setCellValue('P1', '收货人电话');
	    //设置宽度
	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
	    $i = 2;
	    foreach ($exportdata as $key=>$val){
	        $name = '';
	        if(!$val['name_en'] && $val['model']){
	            $curl_deal = new curl_deal();
	            $resoult = $curl_deal->file_get_contents_post('https://192.168.5.21:9112/api/GoodsNameEn?v=112a8792da1fe1778df628e847c0cf41',array('goodno'=>trim($val['model'])));
	            $json = base64_decode($resoult);
	            if($json){
	                $name = json_decode($json,true);
	            }
	            if($name['NAMEEN']){
	                $val['name_en'] = $name['NAMEEN'];
	            }
	        }
	        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i,$val['order_id']);
	        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i,$val['name']);
	        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i,$val['name_en']);
	        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i,$val['model']);
	        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i,$val['quantity']);
	        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i,$val['orderstaus']);
	        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i,$val['trackingno']);
	        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i,$val['title']);
	        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i,$val['date_added']);
	        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i,$val['date_modified']);
	        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i,$val['shipping_fullname']);
	        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i,$val['shipping_zone']);
	        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, !empty($val['shipping_city']) ? $val['shipping_city'] : $val['payment_city']);
	        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, !empty($val['shipping_address']) ? $val['shipping_address'] : $val['payment_address']);
	        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, !empty($val['shipping_postcode']) ? $val['shipping_postcode'] : $val['payment_postcode'] );
	        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i,$val['telephone']);

	        $i++;
	        unset($val['model']);
	    }
	    
	    $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
	    $objWriter->save("xxx.xlsx");
	     
	    //直接输出到浏览器
	    $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
	    header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	    header("Content-Type:application/force-download");
	    header("Content-Type:application/vnd.ms-execl");
	    header("Content-Type:application/octet-stream");
	    header("Content-Type:application/download");
	    header('Content-Disposition:attachment;filename="order.xls"');
	    header("Content-Transfer-Encoding:binary");
	    $objWriter->save('php://output');
	}
	
	
	/**
	 * 管理员导出订单列表
	 */
	public function doexport(){
	    $this->load->model('sale/order');
	    include './PHPExcel/PHPExcel.php';
	    $objPHPExcel = new PHPExcel();
	    $type = '';
	    if(isset($this->request->get['type'])){
	        $type = $this->request->get['type'];
	    }
	    if($this->request->post['filter_start_time']){
	        $filter_start_time = $this->request->post['filter_start_time'];
	    } else {
			$filter_start_time = null;
		}
		if($this->request->post['filter_end_time']){
		    $filter_end_time = $this->request->post['filter_end_time'];
		} else {
		    $filter_end_time = null;
		}
	    if (trim($this->request->post['filter_order_id'])) {
			$filter_order_id = $this->request->post['filter_order_id'];
		} else {
			$filter_order_id = null;
		}
	    if (trim($this->request->post['filter_customer'])) {
	        $filter_customer = urldecode(html_entity_decode(trim($this->request->post['filter_customer']), ENT_QUOTES, 'UTF-8'));
	    } else {
	        $filter_customer = null;
	    }
	    if (trim($this->request->post['filter_customer_telephone'])) {
	        $filter_customer_telephone = $this->request->post['filter_customer_telephone'];
	    } else {
	        $filter_customer_telephone = null;
	    }
	   // var_dump($filter_customer_telephone);
	    if ($this->request->post['filter_order_status'] != '*') {
	        $filter_order_status = $this->request->post['filter_order_status'];
	    } else {
	        $filter_order_status = null;
	    }
	    if ($this->request->post['filter_order_declartype']) {
	        $filter_order_declartype = $this->request->post['filter_order_declartype'];
	    } else {
	        $filter_order_declartype = null;
	    }
	    
	    if ($this->request->post['filter_line_id']) {
	        $filter_line_id = $this->request->post['filter_line_id'];
	    } else {
	        $filter_line_id = null;
	    }
	    
	    if ($this->request->post['filter_total']) {
	        $filter_total = $this->request->post['filter_total'];
	    } else {
	        $filter_total = null;
	    }
	    
	    if ($this->request->post['filter_date_added']) {
	        $filter_date_added = $this->request->post['filter_date_added'];
	    } else {
	        $filter_date_added = null;
	    }
	    
	    if ($this->request->post['filter_date_modified']) {
	        $filter_date_modified = $this->request->post['filter_date_modified'];
	    } else {
	        $filter_date_modified = null;
	    }
	    
	    if ($this->request->post['filter_party_order']) {
	        $filter_party_order = $this->request->post['filter_party_order'];
	    } else {
	        $filter_party_order = null;
	    }
	    
	    if($this->session->data['user_id'] >1){
	        $this->load->model('user/user');
	        $merchant_id = $this->model_user_user->getUser($this->session->data['user_id'])['merchant_id'];
	    }else{
	        $merchant_id = 0;
	    }
	    
	    $filter_data = array(
	        'filter_order_id'             => $filter_order_id,
	        'filter_customer'	          => $filter_customer,
	        'filter_customer_telephone'	  => $filter_customer_telephone,
	        'filter_order_status'         => $filter_order_status,
	        'filter_order_declartype'     => $filter_order_declartype,
	        'filter_total'                => $filter_total,
	        'filter_date_added'           => $filter_date_added,
	        'filter_date_modified'        => $filter_date_modified,
	        'filter_start_time'           => $filter_start_time,
	        'filter_end_time'             => $filter_end_time,
	        'filter_party_order'          => $filter_party_order,
	        'filter_type'                 => $type,
	        'merchant_id'                 => $merchant_id,
	        'filter_line_id'              => $filter_line_id
	    );
	    if($type =='return'){
	        $exportdata = $this->model_sale_order->getexportReturndata($filter_data);
	    }else{
	        $exportdata = $this->model_sale_order->getexportdata($filter_data);
	    }
// 	    var_dump($exportdata);die();
	    $count = count($exportdata);
	    //设置表头名称
	    $objPHPExcel->getActiveSheet()->setTitle('订单列表');
	    //表格标题栏
	    $objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');
	    $objPHPExcel->getActiveSheet()->setCellValue('B1', '用户名');
	    $objPHPExcel->getActiveSheet()->setCellValue('C1', '联系电话');
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', '商品名称');
	    $objPHPExcel->getActiveSheet()->setCellValue('E1', '商品编号');
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', '数量');
	    $objPHPExcel->getActiveSheet()->setCellValue('G1', '商品单价');
	    $objPHPExcel->getActiveSheet()->setCellValue('H1', '是否在正面清单');
	    $objPHPExcel->getActiveSheet()->setCellValue('I1', '商品税费');
	    $objPHPExcel->getActiveSheet()->setCellValue('J1', '第三方链接');
	    $objPHPExcel->getActiveSheet()->setCellValue('K1', '订单总价');
	    $objPHPExcel->getActiveSheet()->setCellValue('L1', '是否走跨境电商');
	    $objPHPExcel->getActiveSheet()->setCellValue('M1', '订单总运费');
	    $objPHPExcel->getActiveSheet()->setCellValue('N1', '物流单号');
	    $objPHPExcel->getActiveSheet()->setCellValue('O1', 'amazon订单号');
	    $objPHPExcel->getActiveSheet()->setCellValue('P1', '订单状态');
	    $objPHPExcel->getActiveSheet()->setCellValue('Q1', '下单日期');
	    $objPHPExcel->getActiveSheet()->setCellValue('R1', '修改日期');
	    $objPHPExcel->getActiveSheet()->setCellValue('S1', '订单已确认，待备货时间');
	    $objPHPExcel->getActiveSheet()->setCellValue('T1', '到达美国仓填入的 时间 ');
	    $objPHPExcel->getActiveSheet()->setCellValue('U1', '分类ID');
	    $objPHPExcel->getActiveSheet()->setCellValue('V1', '一级分类');
	    $objPHPExcel->getActiveSheet()->setCellValue('W1', '收货人姓名');
	    $objPHPExcel->getActiveSheet()->setCellValue('X1', '州/省/地区');
	    $objPHPExcel->getActiveSheet()->setCellValue('Y1', '城市');
	    $objPHPExcel->getActiveSheet()->setCellValue('Z1', '地址');
	    $objPHPExcel->getActiveSheet()->setCellValue('AA1', '邮政编码');
	    $objPHPExcel->getActiveSheet()->setCellValue('AB1', '收货人电话');
	   //设置表格宽度
	   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
	   $orderIDArr = array();
        // 循环输出数据到excel
        for ($i = 2; $i <= $count + 1; $i ++) {
            if(!in_array($exportdata[$i - 2]['order_id'], $orderIDArr)){
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $exportdata[$i - 2]['order_id']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $exportdata[$i - 2]['fullname']);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $i,$exportdata[$i - 2]['telephone'],PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $exportdata[$i - 2]['NAME']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $exportdata[$i - 2]['model']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $exportdata[$i - 2]['quantity']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, sprintf("%.2f" , $exportdata[$i - 2]['price']));
                $iscross = '';
                if($exportdata[$i - 2]['iscross'] == '1'){
                    $iscross = '是';
                }elseif($exportdata[$i - 2]['iscross'] == '0' && $exportdata[$i - 2]['iscross'] != ''){
                    $iscross = '否';
                }else{
                    $iscross = '未确定';
                }
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $iscross);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, sprintf("%.2f" , $exportdata[$i - 2]['tariff_price']));
                
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $exportdata[$i - 2]['out_url']);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, sprintf("%.2f" , $exportdata[$i - 2]['total']));
                if($exportdata[$i - 2]['declartype'] == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '是');
                }elseif($exportdata[$i - 2]['declartype'] == '5'){
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '否');
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '未确定');
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, sprintf("%.2f" , $exportdata[$i - 2]['totaltariffprice']));
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('N' . $i,$exportdata[$i - 2]['party_assbillno'],PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $exportdata[$i - 2]['party_order_no']);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $exportdata[$i - 2]['orderstaus']);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $exportdata[$i - 2]['date_added']);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $exportdata[$i - 2]['date_modified']);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $exportdata[$i - 2]['order_status_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $exportdata[$i - 2]['date_arrive']);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $exportdata[$i - 2]['category_id']);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $exportdata[$i - 2]['categoryname']);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $exportdata[$i - 2]['shipping_fullname']);
                $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $exportdata[$i - 2]['shipping_zone']);
                $city = empty($exportdata[$i - 2]['shipping_city'])?$exportdata[$i - 2]['payment_city']:$exportdata[$i - 2]['shipping_city'];
                $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $city);
                $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $exportdata[$i - 2]['shipping_address']);
                $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $exportdata[$i - 2]['shipping_postcode']);
                //shipping_telephone
                $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $exportdata[$i - 2]['shipping_telephone']);
                $orderIDArr[] = $exportdata[$i - 2]['order_id'];
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $exportdata[$i - 2]['order_id']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $exportdata[$i - 2]['fullname']);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $i,$exportdata[$i - 2]['telephone'],PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $exportdata[$i - 2]['NAME']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $exportdata[$i - 2]['model']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $exportdata[$i - 2]['quantity']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, sprintf("%.2f" , $exportdata[$i - 2]['price']));
                $iscross = '';
                if($exportdata[$i - 2]['iscross'] == '1'){
                    $iscross = '是';
                }elseif($exportdata[$i - 2]['iscross'] == '0' && $exportdata[$i - 2]['iscross'] != ''){
                    $iscross = '否';
                }else{
                    $iscross = '未确定';
                }
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $iscross);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, sprintf("%.2f" , $exportdata[$i - 2]['tariff_price']));
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $exportdata[$i - 2]['out_url']);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '');
                if($exportdata[$i - 2]['declartype'] == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '是');
                }elseif($exportdata[$i - 2]['declartype'] == '5'){
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '否');
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '未确定');
                }
               
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $exportdata[$i - 2]['orderstaus']);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $exportdata[$i - 2]['category_id']);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $exportdata[$i - 2]['categoryname']);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i,'');
                $objPHPExcel->getActiveSheet()->setCellValue('X' . $i,'');
                $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i,'');
                $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i,'');
                $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i,'');
            }
        }
	    $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
	    $objWriter->save("xxx.xlsx");
	    
	    //直接输出到浏览器
	    $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
	    header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	    header("Content-Type:application/force-download");
	    header("Content-Type:application/vnd.ms-execl");
	    header("Content-Type:application/octet-stream");
	    header("Content-Type:application/download");
	    header('Content-Disposition:attachment;filename="order.xls"');
	    header("Content-Transfer-Encoding:binary");
	    $objWriter->save('php://output');
	}
	
	public function dohotexport(){
	    $this->load->model('sale/order');
	    include './PHPExcel/PHPExcel.php';
	    $objPHPExcel = new PHPExcel();
	    $exportdata = $this->model_sale_order->gethotexportdata();
// 	    print_r($exportdata);die();
	    $count = count($exportdata);
	    //设置表头名称
	    $objPHPExcel->getActiveSheet()->setTitle('销量统计');
	    //表格标题栏
	    $objPHPExcel->getActiveSheet()->setCellValue('A1', '商品ID');
	    $objPHPExcel->getActiveSheet()->setCellValue('B1', '商品名称');
	    $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品编号');
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', '销量');
	    $objPHPExcel->getActiveSheet()->setCellValue('E1', '分类');
	     
	    //设置表格宽度
	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	    $orderIDArr = array();
	    for ($i = 2; $i <= $count + 1; $i ++) {
	            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $exportdata[$i - 2]['product_id']);
	            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $exportdata[$i - 2]['name']);
	            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i,$exportdata[$i - 2]['model']);
	            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $exportdata[$i - 2]['totalamount']);
	            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $exportdata[$i - 2]['catetoryname']);
	    }
	    $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
	    $objWriter->save("xxx.xlsx");
	     
	    //直接输出到浏览器
	    $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
	    header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	    header("Content-Type:application/force-download");
	    header("Content-Type:application/vnd.ms-execl");
	    header("Content-Type:application/octet-stream");
	    header("Content-Type:application/download");
	    header('Content-Disposition:attachment;filename="salesnumber.xls"');
	    header("Content-Transfer-Encoding:binary");
	    $objWriter->save('php://output');
	    
	}
	
	//导入缺少分类的商品
	public function dpimport(){
	    $this->load->model('sale/order');
	    include './PHPExcel/PHPExcel.php';
	    if (!$_FILES['post_file']['name']) {
	        echo '<script>alert("请上传文件！");history.back(); </script>';
	    }
	    $extend = pathinfo($_FILES['post_file']['name']);
	    $extend = strtolower($extend["extension"]);
	    if (! in_array($extend, array(
	        "xls",
	        "xlsx"
	    ))) {
	        echo '<script>alert("上传文件格式不正确！");history.back(); </script>';
	        exit();
	    } else {
	        $objPHPExcel = new PHPExcel();
	        $data = $objPHPExcel->importExcel($_FILES);
	        $title = array_shift($data);
	        $titArr = array(
	            '商品ID',
	            '商品型号',
	            '三级分类编号'
	        );
	        $failArr = array();
	        foreach ($titArr as $tit) {
	            if (! in_array($tit, $title)) {
	                $failArr[] = $tit;
	            }
	        }
	        if ($failArr) {
                echo '<script>alert("文件数据缺少，缺少数据：' . implode('，', $failArr) . '！");history.back(); </script>';
                exit();
            }
	    }
            $succ  = 0;
            $fall = 0;
	     foreach ($data as $info) {
                $paramData = array();
                if(trim($info[0])){
                     $goodsInfo =  $this->model_sale_order->getone(trim($info[0]));
                      if(empty($goodsInfo)){
                            $goods1 =  $this->model_sale_order->addfirstclass(trim($info[0]),trim($info[2]));
                            $succ++;
                      }elseif($goodsInfo[1]['parent_id'] == ''){
                            $goods2 =  $this->model_sale_order->addfirstclass(trim($info[0]),trim($info[2]));
                            $succ++;
                      }elseif($goodsInfo[2]['parent_id'] == ''){
                            $goods3 =  $this->model_sale_order->addfirstclass(trim($info[0]),trim($info[2]));
                            $succ++;
                      }else{
                         $fall++;
                      }
                }
	     }
	   if ($succ) {
            echo '<script>alert("导入完成！成功：'.$succ.'条，失败：'.$fall.'条！");history.back();</script>';
	   } else {
	       echo '<script">alert("导入失败，失败：'.$fall.'条！"); history.back();</script>';
	   }
	   
	}
	//订单导出
	public function orderexport(){
	   $this->load->model('sale/order');
	   include './PHPExcel/PHPExcel.php';
	   $objPHPExcel = new PHPExcel();
	   $exportdata = $this->model_sale_order->getorderdate();
	   $count = count($exportdata);
	   //设置表头名称
	   $objPHPExcel->getActiveSheet()->setTitle('订单列表');
	   //表格标题栏
	   $objPHPExcel->getActiveSheet()->setCellValue('A1', '商户订单号(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单ID');
	   $objPHPExcel->getActiveSheet()->setCellValue('C1', '订单追踪号');
	   $objPHPExcel->getActiveSheet()->setCellValue('D1', '物流分运单号');
	   $objPHPExcel->getActiveSheet()->setCellValue('E1', '订单提交时间');
	   $objPHPExcel->getActiveSheet()->setCellValue('F1', '发件人姓名(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('G1', '发件人电话');
	   $objPHPExcel->getActiveSheet()->setCellValue('H1', '发件方公司名称(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('I1', '发件人地址(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('J1', '发件地邮编(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('K1', '发件地城市(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('L1', '发件地省/州名(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('M1', '发件地国家(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('N1', '订单商品信息简述');
	   $objPHPExcel->getActiveSheet()->setCellValue('O1', '物流运费');
	   $objPHPExcel->getActiveSheet()->setCellValue('P1', '其它费用');
	   $objPHPExcel->getActiveSheet()->setCellValue('Q1', '收货人姓名(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('R1', '收货人身份证号(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('S1', '收货人电话(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('T1', '收货地国家(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('U1', '收货地省/州(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('V1', '收货地城市(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('W1', '收货地地址(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('X1', '收货地邮编');
	   $objPHPExcel->getActiveSheet()->setCellValue('Y1', '单项购买商品名称(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('Z1', '单项购买商品编号(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('AA1', '单项购买商品行邮税号');
	   $objPHPExcel->getActiveSheet()->setCellValue('AB1', '单项购买商品数量(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('AC1', '单项购买商品单价(*)');
	   $objPHPExcel->getActiveSheet()->setCellValue('AD1', '商品美元单价');
	   $objPHPExcel->getActiveSheet()->setCellValue('AE1', '支付方式');
	   $objPHPExcel->getActiveSheet()->setCellValue('AF1', '企业支付名称');
	   $objPHPExcel->getActiveSheet()->setCellValue('AG1', '企业支付编号');
	   $objPHPExcel->getActiveSheet()->setCellValue('AH1', '支付总金额');
	   $objPHPExcel->getActiveSheet()->setCellValue('AI1', '付款币种');
	   $objPHPExcel->getActiveSheet()->setCellValue('AJ1', '支付交易号');
	   $objPHPExcel->getActiveSheet()->setCellValue('AK1', '支付交易时间');
	   $objPHPExcel->getActiveSheet()->setCellValue('AL1', '预计重量');
	   $objPHPExcel->getActiveSheet()->setCellValue('AM1', '实际重量');
	   $objPHPExcel->getActiveSheet()->setCellValue('AN1', '计费重量');
	   $objPHPExcel->getActiveSheet()->setCellValue('AO1', '发货人邮箱');
	   $objPHPExcel->getActiveSheet()->setCellValue('AP1', '收货人邮箱');
	   $objPHPExcel->getActiveSheet()->setCellValue('AQ1', '包裹数量');
	   $objPHPExcel->getActiveSheet()->setCellValue('AR1', '分包裹编号');
	   
	   //设置表格宽度
	   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(35);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(45);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(25);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(10);
	   $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(10);
	   for ($i = 2; $i <= $count + 1; $i ++) {
	           $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $i, 'LG' . $exportdata[$i - 2]['party_assbillno'],PHPExcel_Cell_DataType::TYPE_STRING);
	           $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $exportdata[$i - 2]['order_id']);
	           $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $i,$exportdata[$i - 2]['party_assbillno'],PHPExcel_Cell_DataType::TYPE_STRING);
	           $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $exportdata[$i - 2]['date_added']);
	           $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, 'legoods');
	           $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $i, '19178546636');
	           $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, 'legoods');
	           $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, '7858 SW Nimbus Ave.');
	           $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, '97008');
	           $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, 'Beaverton');
	           $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, 'Oregon');
	           $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, 'US');
	           $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $exportdata[$i - 2]['productdetail']);
	           $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $exportdata[$i - 2]['tariff_price']);
	           $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $exportdata[$i - 2]['shipping_fullname']);
	           $objPHPExcel->getActiveSheet()->setCellValueExplicit('R' . $i,$exportdata[$i - 2]['cardid'],PHPExcel_Cell_DataType::TYPE_STRING);
	           $objPHPExcel->getActiveSheet()->setCellValueExplicit('S' . $i,$exportdata[$i - 2]['shipping_telephone'],PHPExcel_Cell_DataType::TYPE_STRING);
	           $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $exportdata[$i - 2]['shipping_country']);
	           $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $exportdata[$i - 2]['shipping_zone']);
	           if($exportdata[$i - 2]['shipping_city']=='0' || !$exportdata[$i - 2]['shipping_city']){
	               $data['shipping_city'] = $this->model_sale_order->getCityname($exportdata[$i - 2]['city_id'])['name'];
	               $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $data['shipping_city']);
	           }else{
	               $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $exportdata[$i - 2]['shipping_city']);
	           }
	           $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $exportdata[$i - 2]['shipping_address']);
	           if($exportdata[$i - 2]['shipping_postcode'] == ''){
	               $objPHPExcel->getActiveSheet()->setCellValueExplicit('X' . $i,'200000',PHPExcel_Cell_DataType::TYPE_STRING);
	           }else{
	               $objPHPExcel->getActiveSheet()->setCellValueExplicit('X' . $i,$exportdata[$i - 2]['shipping_postcode'],PHPExcel_Cell_DataType::TYPE_STRING);
	           }
	           $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $exportdata[$i - 2]['name']);
	           $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $exportdata[$i - 2]['model']);
	           $objPHPExcel->getActiveSheet()->setCellValueExplicit('AA' . $i,$exportdata[$i - 2]['hscode'],PHPExcel_Cell_DataType::TYPE_STRING);
	           $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $exportdata[$i - 2]['quantity']);
	           $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, sprintf("%.2f" , $exportdata[$i - 2]['price']));
	           $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $exportdata[$i - 2]['party_price']);
	           $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, '');
	           $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, '');
	           
	   }
	   $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
	   $objWriter->save("orderdetail.xlsx");
	   //直接输出到浏览器
	   $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
	   header("Pragma: public");
	   header("Expires: 0");
	   header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	   header("Content-Type:application/force-download");
	   header("Content-Type:application/vnd.ms-execl");
	   header("Content-Type:application/octet-stream");
	   header("Content-Type:application/download");
	   header('Content-Disposition:attachment;filename="orderdetail.xls"');
	   header("Content-Transfer-Encoding:binary");
	   $objWriter->save('php://output');
	}
	
	//导入订单号，圆通单号
    public function impportorderno(){
        $this->load->model('sale/order');
        include './PHPExcel/PHPExcel.php';
        if (!$_FILES['post_file']['name']) {
            echo '<script>alert("请上传文件！");history.back(); </script>';
        }
        $extend = pathinfo($_FILES['post_file']['name']);
        $extend = strtolower($extend["extension"]);
        if (! in_array($extend, array(
            "xls",
            "xlsx"
        ))) {
            echo '<script>alert("上传文件格式不正确！");history.back(); </script>';
            exit();
        } else {
            $objPHPExcel = new PHPExcel();
            $data = $objPHPExcel->importExcel($_FILES);
            $title = array_shift($data);
            $titlearray = array();
            foreach ($title as $titlearr) {
                $titlearray[] = trim($titlearr);
            }
//             var_dump($titlearray);die();
            $titArr = array(
                '中银订单号',
                '圆通单号',
            );
            $failArr = array();
            foreach ($titArr as $tit) {
                if (! in_array($tit, $titlearray)) {
                    $failArr[] = $tit;
                }
            }
            if ($failArr) {
                echo '<script>alert("文件数据缺少，缺少数据：' . implode('，', $failArr) . '！");history.back(); </script>';
                exit();
            }
        }
        $succ  = 0;
        $fall = 0;
        foreach ($data as $info) {
            $paramData = array();
            if($info){
                $orderinfo =  $this->model_sale_order->updateorderno($info);
                $succ++;
            }else{
                $fall++;
            }
        }
        if ($succ) {
            echo '<script>alert("导入完成！成功：'.$succ.'条！");history.back();</script>';
        }  else {
            echo '<script">alert("导入失败，失败：'.$fall.'条！"); history.back();</script>';
        }
    }
	
    
   /*  //生成条码
    public function getbarcode()
    {
        $order_id  =  $this->request->get['order_id'];
//         var_dump($order_id);
//         exit;
        // 引用class文件夹对应的类
        include './BarCode/class/BCGFont.php';
        include './BarCode/class/BCGColor.php';
        include './BarCode/class/BCGDrawing.php';
        
        // 条形码的编码格式
        include './BarCode/class/BCGcode39.barcode.php';
        
        //颜色条形码
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        
        $drawException = null;
        try {
            $code = new BCGcode39();
            $code->setScale(2);
            $code->setThickness(50); // 条形码的厚度
            $code->setForegroundColor($color_black); // 条形码颜色
            $code->setBackgroundColor($color_white); // 空白间隙颜色
            $code->parse($order_id); // 条形码需要的数据内容
        } catch(Exception $exception) {
            $drawException = $exception;
        }
        
        //根据以上条件绘制条形码
        $drawing = new BCGDrawing('', $color_white);
        if($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->draw();
        }
        
        // 生成PNG格式的图片
        header('Content-Type: image/png');
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    } */
    
    //打印订单页
    public function printOrders(){
        $data = array();
        $data['order_ids'] = $this->request->get['order_ids'];
        $data['token'] = $this->session->data['token'];
        $data['xmlUrl'] = HTTP_SERVER;
        $this->response->setOutput($this->load->view('sale/print_order.tpl', $data));
        
    }
    
    /**
     * 判断是否是国内现货
     */
    public function judgestock(){
        $order_id = $this->request->post['order_id'];
        if(!$order_id){
            return false;
        }
        //查询订单线路
        $this->load->model('sale/order');
        $line_id = $this->model_sale_order->OrderLine($order_id)['line_id'];
        if($line_id){
            if(in_array($line_id, array(83,84,85,86,87,88,89,90,91,92,93,94,95))){           //判断是否属于国内现货
                echo json_encode(array('code'=>1,'msg'=>'国内现货'));
            }else{
                echo json_encode(array('code'=>0,'msg'=>'非国内现货'));
            }
        }else{
            echo json_encode(array('code'=>0,'msg'=>'非国内现货'));
        }
        
    }
    
    /**
     * 商户发货
     */
    public function merchantsendgoods(){
        $type = $this->request->post['type'];
        $order_id = $this->request->post['order_id'];
        $shipping_agents = trim($this->request->post['shipping_agents']);
        $expressno = trim($this->request->post['expressno']);
        $mark = false;
        if($type && $order_id){
            $this->load->model('sale/order');
            if($this->model_sale_order->merchantSendGoods($order_id,$type,$expressno,$shipping_agents)){
                $mark = true;
            }
        }
        if($mark){
            echo json_encode(array('code'=>1,'msg'=>'成功'));
        }else{
            echo json_encode(array('code'=>0,'msg'=>'失败'));
        }
    }
}