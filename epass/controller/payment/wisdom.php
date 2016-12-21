<?php 
class ControllerPaymentWisdom extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/wisdom');

		$this->document->settitle($this->language->get('heading_title'));
		
		if (isset($this->error['secrity_code'])) {
			$data['error_secrity_code'] = $this->error['secrity_code'];
		} else {
			$data['error_secrity_code'] = '';
		}


		if (isset($this->error['partner'])) {
			$data['error_partner'] = $this->error['partner'];
		} else {
			$data['error_partner'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/wisdom', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/wisdom', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->load->model('setting/setting');
			
		$this->load->model('tool/image');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
		    
			$this->load->model('setting/setting');
			
			$wisdom_banks = array();
			if(isset($this->request->post['wisdom_banks'])){
			    foreach ($this->request->post['wisdom_banks'] as $bank){
			        
			        if(trim($bank['bank_id']) && trim($bank['bank_name']) && $bank['image']){
			            
			            $wisdom_banks[$bank['sort_order'] ? $bank['sort_order'] : 0] = $bank;
			        }
			    }
			}
			$this->request->post['wisdom_banks'] = serialize($wisdom_banks);
			
			$this->model_setting_setting->editSetting('wisdom', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
		$data['entry_wisdom_security_code'] = $this->language->get('entry_wisdom_security_code');
		$data['entry_wisdom_partner'] = $this->language->get('entry_wisdom_partner');
		$data['entry_wisdom_trade_type'] = $this->language->get('entry_wisdom_trade_type');
			
		$data['entry_wisdom_status'] = $this->language->get('entry_wisdom_status');
		$data['entry_wisdom_sort_order'] = $this->language->get('entry_wisdom_sort_order');
		$data['entry_total'] = $this->language->get('entry_total');
		
		$data['entry_trade_paid_status'] = $this->language->get('entry_trade_paid_status');
		$data['entry_trade_finished_status'] = $this->language->get('entry_trade_finished_status');
		$data['entry_log'] = $this->language->get('entry_log');
		
		
		$data['help_total'] = $this->language->get('help_total');
		$data['help_trade_finished'] = $this->language->get('help_trade_finished');
		$data['help_trade_paid'] = $this->language->get('help_trade_paid');
		$data['help_log'] = $this->language->get('help_log');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_order_status'] = $this->language->get('tab_order_status');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		
		if (isset($this->error['security_code'])) {
			$data['error_wisdom_security_code'] = $this->error['security_code'];
		} else {
			$data['error_wisdom_security_code'] = '';
		}
		
		if (isset($this->error['partner'])) {
			$data['error_wisdom_partner'] = $this->error['partner'];
		} else {
			$data['error_wisdom_partner'] = '';
		}

		if (isset($this->request->post['wisdom_security_code'])) {
			$data['wisdom_security_code'] = $this->request->post['wisdom_security_code'];
		} else {
			$data['wisdom_security_code'] = $this->config->get('wisdom_security_code');
		}

		if (isset($this->request->post['wisdom_partner'])) {
			$data['wisdom_partner'] = $this->request->post['wisdom_partner'];
		} else {
			$data['wisdom_partner'] = $this->config->get('wisdom_partner');
		}		
		
		if (isset($this->request->post['wisdom_total'])) {
			$data['wisdom_total'] = $this->request->post['wisdom_total'];
		} else {
			$data['wisdom_total'] = $this->config->get('wisdom_total');
		}
		
		if (isset($this->request->post['wisdom_log'])) {
			$data['wisdom_log'] = $this->request->post['wisdom_log'];
		} else {
			$data['wisdom_log'] = $this->config->get('wisdom_log');
		}

		if (isset($this->request->post['wisdom_trade_paid_status_id'])) {
			$data['wisdom_trade_paid_status_id'] = $this->request->post['wisdom_trade_paid_status_id'];
		} elseif($this->config->get('wisdom_trade_paid_status_id')) {
			$data['wisdom_trade_paid_status_id'] = $this->config->get('wisdom_trade_paid_status_id'); 
		} else {
			$data['wisdom_trade_paid_status_id'] = 5;//complete
		}
		
		
		if (isset($this->request->post['wisdom_trade_finished_status_id'])) {
			$data['wisdom_trade_finished_status_id'] = $this->request->post['wisdom_trade_finished_status_id'];
		} elseif($this->config->get('wisdom_trade_finished_status_id')) {
			$data['wisdom_trade_finished_status_id'] = $this->config->get('wisdom_trade_finished_status_id'); 
		} else {
			$data['wisdom_trade_finished_status_id'] = 5;//complete
		}

		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
		if (isset($this->request->post['wisdom_geo_zone_id'])) {
			$data['wisdom_geo_zone_id'] = $this->request->post['wisdom_geo_zone_id'];
		} else {
			$data['wisdom_geo_zone_id'] = $this->config->get('wisdom_geo_zone_id');
		}
		

		if (isset($this->request->post['wisdom_status'])) {
			$data['wisdom_status'] = $this->request->post['wisdom_status'];
		} else {
			$data['wisdom_status'] = $this->config->get('wisdom_status');
		}
		
		if (isset($this->request->post['wisdom_sort_order'])) {
			$data['wisdom_sort_order'] = $this->request->post['wisdom_sort_order'];
		} else {
			$data['wisdom_sort_order'] = $this->config->get('wisdom_sort_order');
		}
		
		if (isset($this->request->post['wisdom_banks'])) {
		    $data['wisdom_banks'] = $this->request->post['wisdom_banks'];
		} else {
		     $wisdom_banks = $this->config->get('wisdom_banks');
		     if($wisdom_banks){
		         $wisdom_banks = unserialize($wisdom_banks);
		         foreach ($wisdom_banks as $key=>&$bank){
		             if ($bank['image']){
		                 $bank['thumb'] = $this->model_tool_image->resize($bank['image'], 100, 100);
		             }else{
		                 $bank['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		             }
		         }
		         $data['wisdom_banks'] = $wisdom_banks;
		     }else{
		         $data['wisdom_banks'] = array();
		     }
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/wisdom.tpl', $data));
		
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/wisdom')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['wisdom_security_code']) {
			$this->error['security_code'] = $this->language->get('error_wisdom_security_code');
		}

		if (!$this->request->post['wisdom_partner']) {
			$this->error['partner'] = $this->language->get('error_wisdom_partner');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>