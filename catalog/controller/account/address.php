<?php
class ControllerAccountAddress extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');
			$this->response->redirect(APP_LOGIN_URL);
			//$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/address');

		$this->getList();
	}

	public function add() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/address');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		    if(!isset($this->request->post['company'])){
		        $this->request->post['company'] = '';
		    }
			$this->model_account_address->addAddress($this->request->post);

			$this->session->data['success'] = $this->language->get('text_add');

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFullName()
			);

			$this->model_account_activity->addActivity('address_add', $activity_data);

			echo "<script>window.parent.location.href='".$this->url->link('account/address', '', 'SSL')."';window.parent.closeLayer();</script>";
			exit();
		}

		$this->getForm();
	}

	public function edit() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->load->language('account/address');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/address');
      
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		    if(!isset($this->request->post['company'])){
		        $this->request->post['company'] = '';
		    }
			$this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);
			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}
			if(isset($this->request->get['address_id'])){
			    $this->session->data['shipping_address']['address_id'] = $this->request->get['address_id'];
			}
			

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFullName()
			);

			$this->model_account_activity->addActivity('address_edit', $activity_data);

			if (isset($this->request->get['tp']) && $this->request->get['tp'] == 'checkout') {
			    $json = array('status'=>'success');
		        echo json_encode($json);
		        exit();
			}else{
			    $this->session->data['success'] = $this->language->get('text_edit');
			    echo "<script>window.parent.location.href='".$this->url->link('account/address', '', 'SSL')."';window.parent.closeLayer();</script>";
			    exit();
			}
		}
		if (isset($this->request->get['tp']) && $this->request->get['tp'] == 'checkout') {
		    if($this->error){
		        $json = array('error'=>$this->error);
		        echo json_encode($json);
		        exit();
		    }
		}

		$this->getForm();
	}

	public function delete() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/address');

		if (isset($this->request->get['address_id']) && $this->validateDelete()) {
			$this->model_account_address->deleteAddress($this->request->get['address_id']);

			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				unset($this->session->data['shipping_address']);
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				unset($this->session->data['payment_address']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}

			$this->session->data['success'] = $this->language->get('text_delete');

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFullName()
			);
            echo 1;
			/* $this->model_account_activity->addActivity('address_delete', $activity_data);

			$this->response->redirect($this->url->link('account/address', '', 'SSL')); */
		}else{
		    echo 0;
		}
		
	}

	protected function getList() {
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/edit', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/address', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_address_book'] = $this->language->get('text_address_book');
		$data['text_empty'] = $this->language->get('text_empty');

		$data['button_new_address'] = $this->language->get('button_new_address');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_back'] = $this->language->get('button_back');

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

		$data['addresses'] = array();

		$results = $this->model_account_address->getAddresses();
		foreach ($results as $result) {
			if ($result['address_format']) {
				$format = $result['address_format'];
			} else {
				$format = '<b>收货人：</b>{fullname}' . "<br/>" . '<b>联系电话：</b>{shipping_telephone}'."<br/>" . '<b>详细地址：</b>{company}' . "\n" . '{address}' . "\n" .  '{city}  {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{fullname}',
			    '{shipping_telephone}',
				'{company}',
				'{address}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'fullname' => $result['fullname'],
			    'shipping_telephone' => $result['shipping_telephone'],
				'company'   => $result['company'],
				'address' => $result['address'],
				'city'      => $result['city'],
				'postcode'  => $result['postcode'],
				'zone'      => $result['zone'],
				'zone_code' => $result['zone_code'],
				'country'   => $result['country']
			);
			$data['addresses'][] = array(
			    'fullname'   => $result['fullname'],
			    'city'  => $result['city_name'],
			    'zone'  => $result['zone_name'],
			    'area'  => $result['area_name'],
			    'shipping_telephone' => $result['shipping_telephone'],
			    'add'    => $result['address'],
			    'zone_id'    => $result['zone_id'],
			    'city_id'    => $result['city_id'],
			    'area_id'    => $result['area_id'],
			    'postcode'   => $result['postcode'],
 				'address_id' => $result['address_id'],
				'address'    => str_replace(array("\r\n", "\r", "\n"), '&nbsp;&nbsp;', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '&nbsp;&nbsp;', trim(str_replace($find, $replace, $format)))),
				'update'     => $this->url->link('account/address/edit', 'address_id=' . $result['address_id'], 'SSL'),
				'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
			);
		}
		$data['add'] = $this->url->link('account/address/add', '', 'SSL');
		$data['back'] = $this->url->link('account/edit', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/address_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/address_list.tpl', $data));
		}
	}

	protected function getForm() {
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/edit', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/address', '', 'SSL')
		);

		if (!isset($this->request->get['address_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_edit_address'),
				'href' => $this->url->link('account/address/add', '', 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_edit_address'),
				'href' => $this->url->link('account/address/edit', 'address_id=' . $this->request->get['address_id'], 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit_address'] = $this->language->get('text_edit_address');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
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
		$data['entry_default'] = $this->language->get('entry_default');
		$data['entry_shipping_telephone'] = $this->language->get('entry_shipping_telephone');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->error['fullname'])) {
			$data['error_fullname'] = $this->error['fullname'];
		} else {
			$data['error_fullname'] = '';
		}
		
		if (isset($this->error['shipping_telephone'])) {
			$data['error_shipping_telephone'] = $this->error['shipping_telephone'];
		} else {
			$data['error_shipping_telephone'] = '';
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		if(isset($this->request->get['address_id'])){
		    $data['address_id'] = $this->request->get['address_id'];
		}
		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}
		if (isset($this->error['custom_field'])) {
			$data['error_custom_field'] = $this->error['custom_field'];
		} else {
			$data['error_custom_field'] = array();
		}
		
		if (!isset($this->request->get['address_id'])) {
			$data['action'] = $this->url->link('account/address/add', '', 'SSL');
		} else {
		    if (isset($this->request->get['tp'])) {
		        $action_url = $this->url->link('account/address/edit', 'tp='.$this->request->get['tp'].'&address_id=' . $this->request->get['address_id'], 'SSL');
		    } else {
		        $action_url = $this->url->link('account/address/edit', 'address_id=' . $this->request->get['address_id'], 'SSL');
		    }
			$data['action'] = $action_url;
		}

		if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
		}

		if (isset($this->request->post['fullname'])) {
			$data['fullname'] = $this->request->post['fullname'];
		} elseif (!empty($address_info)) {
			$data['fullname'] = $address_info['fullname'];
		} else {
			$data['fullname'] = '';
		}
		
		if (isset($this->request->post['shipping_telephone'])) {
			$data['shipping_telephone'] = $this->request->post['shipping_telephone'];
		}  elseif (!empty($address_info)) {
			$data['shipping_telephone'] = $address_info['shipping_telephone'];
		} else {
			$data['shipping_telephone'] = '';
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (!empty($address_info)) {
			$data['company'] = $address_info['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($address_info)) {
			$data['address'] = $address_info['address'];
		} else {
			$data['address'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($address_info)) {
			$data['postcode'] = $address_info['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($address_info)) {
			$data['city'] = $address_info['city'];
		} else {
			$data['city'] = '';
		}
		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		}  elseif (!empty($address_info)) {
			$data['country_id'] = $address_info['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		}  elseif (!empty($address_info)) {
			$data['zone_id'] = $address_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
		
		if (isset($this->request->post['city_id'])) {
		    $data['city_id'] = $this->request->post['city_id'];
		}  elseif (!empty($address_info)) {
		    $data['city_id'] = $address_info['city_id'];
		} else {
		    $data['city_id'] = '';
		}
		
		if (isset($this->request->post['area_id'])) {
		    $data['area_id'] = $this->request->post['area_id'];
		}  elseif (!empty($address_info)) {
		    $data['area_id'] = $address_info['area_id'];
		} else {
		    $data['area_id'] = '';
		}
		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
		// Custom fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		if (isset($this->request->post['custom_field'])) {
			$data['address_custom_field'] = $this->request->post['custom_field'];
		} elseif (isset($address_info)) {
			$data['address_custom_field'] = $address_info['custom_field'];
		} else {
			$data['address_custom_field'] = array();
		}
		if (isset($this->request->post['default'])) {
			$data['default'] = $this->request->post['default'];
		} elseif (isset($this->request->get['address_id'])) {
			$data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
		} else {
			$data['default'] = false;
		}
		$data['back'] = $this->url->link('account/address', '', 'SSL');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_form.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/address_form.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/address_form.tpl', $data));
		}
	}
	
	public function getEditAddressData(){
	    $data['heading_title'] = $this->language->get('heading_title');
	    
	    $this->load->model('account/address');
	    
	    if (!isset($this->request->get['address_id'])) {
	        $data['action'] = $this->url->link('account/address/add', '', 'SSL');
	    } else {
	        if (isset($this->request->get['tp'])) {
	            $action_url = $this->url->link('account/address/edit', 'tp='.$this->request->get['tp'].'&address_id=' . $this->request->get['address_id'], 'SSL');
	        } else {
	            $action_url = $this->url->link('account/address/edit', 'address_id=' . $this->request->get['address_id'], 'SSL');
	        }
	        $data['action'] = $action_url;
	    }
	    
	    if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
	        $address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
	        $cityname = $this->model_account_address->getzoomeinfo($address_info['city_id']);
	    }
        
	    
	    
	    if (isset($this->request->post['fullname'])) {
	        $data['fullname'] = $this->request->post['fullname'];
	    } elseif (!empty($address_info)) {
	        $data['fullname'] = $address_info['fullname'];
	    } else {
	        $data['fullname'] = '';
	    }
	    
	    if (isset($this->request->post['shipping_telephone'])) {
	        $data['shipping_telephone'] = $this->request->post['shipping_telephone'];
	    }  elseif (!empty($address_info)) {
	        $data['shipping_telephone'] = $address_info['shipping_telephone'];
	    } else {
	        $data['shipping_telephone'] = '';
	    }
	    
	    if (isset($this->request->post['company'])) {
	        $data['company'] = $this->request->post['company'];
	    } elseif (!empty($address_info)) {
	        $data['company'] = $address_info['company'];
	    } else {
	        $data['company'] = '';
	    }
	    
	    if (isset($this->request->post['address'])) {
	        $data['address'] = $this->request->post['address'];
	    } elseif (!empty($address_info)) {
	        $data['address'] = $address_info['address'];
	    } else {
	        $data['address'] = '';
	    }
	    
	    if (isset($this->request->post['postcode'])) {
	        $data['postcode'] = $this->request->post['postcode'];
	    } elseif (!empty($address_info)) {
	        $data['postcode'] = $address_info['postcode'];
	    } else {
	        $data['postcode'] = '';
	    }
	    
	    if (isset($this->request->post['city'])) {
	        $data['city'] = $this->request->post['city'];
	    } elseif (!empty($address_info)) {
	        $data['city'] = $address_info['city'];
	    } else {
	        $data['city'] = '';
	    }
	    
	    if (isset($this->request->post['country_id'])) {
	        $data['country_id'] = $this->request->post['country_id'];
	    }  elseif (!empty($address_info)) {
	        $data['country_id'] = $address_info['country_id'];
	    } else {
	        $data['country_id'] = $this->config->get('config_country_id');
	    }
	    
	    if (isset($this->request->post['zone_id'])) {
	        $data['zone_id'] = $this->request->post['zone_id'];
	    }  elseif (!empty($address_info)) {
	        $data['zone_id'] = $address_info['zone_id'];
	    } else {
	        $data['zone_id'] = '';
	    }
	    
	    if (isset($this->request->post['city_id'])) {
	        $data['city_id'] = $this->request->post['city_id'];
	    }  elseif (!empty($address_info)) {
	        $data['city_id'] = $address_info['city_id'];
	        
	    } else {
	        $data['city_id'] = '';
	    }
	    $data['city_name'] = $cityname;
	    if (isset($this->request->post['area_id'])) {
	        $data['area_id'] = $this->request->post['area_id'];
	    }  elseif (!empty($address_info)) {
	        $data['area_id'] = $address_info['area_id'];
	    } else {
	        $data['area_id'] = '';
	    }
	    
	    if (isset($this->request->post['default'])) {
	        $data['default'] = $this->request->post['default'];
	    } elseif (isset($this->request->get['address_id'])) {
	        $data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
	    } else {
	        $data['default'] = false;
	    }
	    
	    $data['back'] = $this->url->link('account/address', '', 'SSL');
	    
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($data));
	}

	protected function validateForm() {
		if ((utf8_strlen(trim($this->request->post['fullname'])) < 2) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
			$this->error['fullname'] = $this->language->get('error_fullname');
		}
		
		if (!preg_match("/[\x{4e00}-\x{9fa5}\w]+$/u", $this->request->post['fullname'])){
		    $this->error['fullname'] = '收货人不能有特殊字符';
		}
		
		if ((utf8_strlen($this->request->post['shipping_telephone']) < 3) || (utf8_strlen($this->request->post['shipping_telephone']) > 32)) {
			$this->error['shipping_telephone'] = $this->language->get('error_shipping_telephone');
		}
		if(!preg_match("/^1[0-9][0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$this->request->post['shipping_telephone'])){
		    $this->error['shipping_telephone'] = '手机格式不正确';
		}
		if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
			$this->error['address'] = $this->language->get('error_address');
		}


		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

		if ($this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		// Custom field validation
		$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		foreach ($custom_fields as $custom_field) {
			if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
				$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if ($this->model_account_address->getTotalAddresses() == 1) {
			$this->error['warning'] = $this->language->get('error_delete');
		}

		if ($this->customer->getAddressId() == $this->request->get['address_id']) {
			$this->error['warning'] = $this->language->get('error_default');
		}

		return !$this->error;
	}
}
