<?php
class ControllerCheckoutSuccess extends Controller {
	public function index() {
		$this->load->language('checkout/success');
		if (isset($this->session->data['order_id'])) {
		    
			$this->cart->clear();
            
			$this->load->model('account/order');
			
			$orderInfo = $this->model_account_order->getOrder($this->session->data['order_id']);
			
			if($orderInfo){
			    // Add to activity log
			    $this->load->model('account/activity');
			    
			    if ($this->customer->isLogged()) {
			        $activity_data = array(
			            'customer_id' => $this->customer->getId(),
			            'name'        => $this->customer->getFullName(),
			            'order_id'    => $this->session->data['order_id']
			        );
			    
			        $this->model_account_activity->addActivity('order_account', $activity_data);
			    } else {
			        $activity_data = array(
			            'name'     => $this->session->data['guest']['fullname'],
			            'order_id' => $this->session->data['order_id']
			        );
			    
			        $this->model_account_activity->addActivity('order_guest', $activity_data);
			    }
			    
			    unset($this->session->data['shipping_method']);
			    unset($this->session->data['shipping_methods']);
			    unset($this->session->data['payment_method']);
			    unset($this->session->data['payment_methods']);
			    unset($this->session->data['guest']);
			    unset($this->session->data['comment']);
			    unset($this->session->data['order_id']);
			    unset($this->session->data['coupon']);
			    unset($this->session->data['reward']);
			    unset($this->session->data['voucher']);
			    unset($this->session->data['vouchers']);
			    unset($this->session->data['totals']);
			}else{
			    $this->response->redirect($this->url->link('checkout/result'));
			}
		}else{
		    $this->response->redirect($this->url->link('checkout/result'));
		}
		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('localisation/zone');
		//$orderInfo = $this->model_account_order->getOrderInfo($this->session->data['order_id']);
		 
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
		
		if ($this->customer->isLogged()) {
		    $data['orderInfo'] = $orderInfo;
		    $data['orderInfo']['total'] = sprintf("%.2f", $orderInfo['total']);
		} else {
		    $data['total'] = '￥0.00';
		    $data['orderInfo'] = array();
		}
		
		$data['continue'] = $this->url->link('common/waphome');
		
		$data['orderlist'] = $this->url->link('account/order');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}
}