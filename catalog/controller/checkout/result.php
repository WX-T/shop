<?php
class ControllerCheckoutResult extends Controller {
	public function index() {
	    
	    $this->load->language('checkout/success');
	    
	    if (isset($this->session->data['order_id'])) {
	        
	        $this->cart->clear();
	        
	        $this->load->model('account/order');
	        
	        $this->load->model('localisation/zone');
	        	
	        $orderInfo = $this->model_account_order->getOrderInfo($this->session->data['order_id']);
	        
	        $orderInfo['total'] = $this->currency->format($orderInfo['total']);
	        
	        if($orderInfo['city_id']){
	            $cityInfo = $this->model_localisation_zone->getZone($orderInfo['city_id']);
	            $orderInfo['city'] = $cityInfo['name'];
	        }else{
	            $orderInfo['city'] = '';
	        }
	        
	        if($orderInfo['area_id']){
	            $areaInfo = $this->model_localisation_zone->getZone($orderInfo['area_id']);
	            $orderInfo['area'] = $areaInfo['name'];
	        }else{
	            $orderInfo['area'] = '';
	        }
	        
	        $orderInfo['detail_address'] = $orderInfo['shipping_zone'].$orderInfo['city'].$orderInfo['area'].$orderInfo['shipping_address'];
	        
	        $data['orderInfo'] = $orderInfo;
	    }else{
	        unset($this->session->data['pay_error']);
	        $data['orderInfo'] = array();
	    }
		
		$this->document->setTitle($this->language->get('heading_title_failure'));


		$data['heading_title'] = $this->language->get('heading_title_failure');

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_result'), $this->url->link('information/contact', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_result'), $this->url->link('information/contact'));
		}

		$data['error']     = isset($this->session->data['pay_error']) ? $this->session->data['pay_error'] : '无此订单';
		
 		$data['orderlist'] = $this->url->link('account/order');
		
		$data['continue'] = $this->url->link('common/waphome');

		if(isset($this->session->data['payment_method']['code'])){
		    $data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);
		}else{
		    $data['payment'] = '';
		}
// 		$data['column_left'] = $this->load->controller('common/column_left');
// 		$data['column_right'] = $this->load->controller('common/column_right');
// 		$data['content_top'] = $this->load->controller('common/content_top');
// 		$data['content_bottom'] = $this->load->controller('common/content_bottom');
// 		$data['footer'] = $this->load->controller('common/footer');
// 		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/result.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/result.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/result.tpl', $data));
		}
	}
}