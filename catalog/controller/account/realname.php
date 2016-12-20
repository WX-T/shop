<?php
	class ControllerAccountRealname extends Controller {
	    //实名备案信息
	    private $_cardType = array('1'=>'身份证','2'=>'台胞证');
		public function index() {
			$this->load->model('account/customer');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$data['message'] = $this->getCard();
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/realname.tpl', $data));
		
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
		     
		    return $data;
		}

	}