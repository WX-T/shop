<?php
class ControllerUserMerchant extends Controller {
    private $error = array();
	public function index(){
	    $this->load->language('user/user');
	    $this->document->setTitle('商户列表');
	     
	    //$this->load->model('user/merchant');
	    
	    $this->getList();
	}
	
	public function add(){
	    $this->document->setTitle('添加商户');
	    $this->load->model('user/merchant');
	    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	        $this->model_user_merchant->addMerchant($this->request->post);
	        $url = '';
	        $this->response->redirect($this->url->link('user/merchant', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	    }
	    
	    $this->getForm();
	}
	
	public function edit(){
	    $this->load->language('user/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/merchant');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_merchant->editMerchant($this->request->get['merchant_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('user/merchant', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	protected function getList(){
	    $this->load->model('user/merchant');
	    if (isset($this->request->get['sort'])) {
	        $sort = $this->request->get['sort'];
	    } else {
	        $sort = 'username';
	    }
	    
	    if (isset($this->request->get['order'])) {
	        $order = $this->request->get['order'];
	    } else {
	        $order = 'ASC';
	    }
	    
	    if (isset($this->request->get['page'])) {
	        $page = $this->request->get['page'];
	    } else {
	        $page = 1;
	    }
	    
	    $url = '';
	    
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
	        'text' => '商户列表',
	        'href' => $this->url->link('user/merchant', 'token=' . $this->session->data['token'] . $url, 'SSL')
	    );
	    
	    
	    $filter_data = array(
	        'sort'  => $sort,
	        'order' => $order,
	        'start' => ($page - 1) * $this->config->get('config_limit_admin'),
	        'limit' => $this->config->get('config_limit_admin')
	    );
	    
	    $result = $this->model_user_merchant->getMerchants($filter_data);
	    $data['add'] = $this->url->link('user/merchant/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $data['delete'] = $this->url->link('user/merchant/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    
	    $data['users'] = array();
	    
	    $data['text_no_results'] = $this->language->get('text_no_results');
	    $data['text_confirm'] = $this->language->get('text_confirm');
	    
	    $data['column_username'] = $this->language->get('column_username');
	    $data['column_status'] = $this->language->get('column_status');
	    $data['column_date_added'] = $this->language->get('column_date_added');
	    $data['column_action'] = $this->language->get('column_action');
	    
	    $data['button_add'] = $this->language->get('button_add');
	    $data['button_edit'] = $this->language->get('button_edit');
	    $data['button_delete'] = $this->language->get('button_delete');
	    $this->load->model('catalog/product');
	    $this->load->model('sale/order');
	    foreach($result as &$v){
	        $v['edit']= $this->url->link('user/merchant/edit', 'token=' . $this->session->data['token'] . '&merchant_id='.$v['merchant_id'], 'SSL');
	        //商品总数
	        $v['product_count'] = $this->model_catalog_product->getTotalProducts(array('mercahnt_id'=>$v['merchant_id']));
	        //订单总数
	        $v['order_count'] = $this->model_sale_order->getTotalOrders(array('merchant_id'=>$v['merchant_id']));
	    }
	    $data['mercahnts'] = $result;
	    $data['header'] = $this->load->controller('common/header');
	    $data['column_left'] = $this->load->controller('common/column_left');
	    $data['footer'] = $this->load->controller('common/footer');
	    $this->response->setOutput($this->load->view('user/merchant_list.tpl', $data));
	}
	
	protected function getForm(){
		$this->load->model('user/merchant');
		$data['token'] = $this->session->data['token'];
	    //国家列表
	    $data['country_list'] = $this->model_user_merchant->getCountryList();
	    //模式列表
	    $data['model_list'] = $this->model_user_merchant->getModel();
	    $url = '';
	    if($this->request->get['merchant_id']){
	        //获取商户信息
	        $merchantInfo = $this->model_user_merchant->getMerchant($this->request->get['merchant_id']);
	        $data['merchant_id'] = $this->request->get['merchant_id'];
	        $data['heading_title'] = '修改商户';
	    }else{
	        $data['heading_title'] = '添加商户';
	    }
	    if (isset($this->request->get['sort'])) {
	        $url .= '&sort=' . $this->request->get['sort'];
	    }
	    $data['breadcrumbs'] = array();
	    $data['breadcrumbs'][] = array(
	        'text' => $this->language->get('text_home'),
	        'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
	    );
	    
	    $data['breadcrumbs'][] = array(
	        'text' => $this->language->get('heading_title'),
	        'href' => $this->url->link('user/merchant', 'token=' . $this->session->data['token'] . $url, 'SSL')
	    );
	    
	    if (isset($this->error['merchant_name'])) {
	        $data['error_merchant_name'] = $this->error['merchant_name'];
	    } else {
	        $data['error_merchant_name'] = '';
	    }
	    
	    if (isset($this->error['country'])) {
	        $data['error_country'] = $this->error['country'];
	    } else {
	        $data['error_country'] = '';
	    }
	    
	    
	    if (!isset($this->request->get['merchant_id'])) {
	        $data['action'] = $this->url->link('user/merchant/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    } else {
	        $data['action'] = $this->url->link('user/merchant/edit', 'token=' . $this->session->data['token'] . '&merchant_id=' . $this->request->get['merchant_id'] . $url, 'SSL');
	    }
	    
	    
	    if (isset($this->request->post['merchant_name'])) {
	        $data['merchant_name'] = $this->request->post['merchant_name'];
	    }elseif(!empty($merchantInfo)){
	        $data['merchant_name'] = $merchantInfo['merchant_name'];
	    } else {
	        $data['merchant_name'] = '';
	    }
	    
	    if (isset($this->request->post['country'])) {
	        $data['country'] = $this->request->post['country'];
	        //预加载线路
	        foreach ($data['country'] as &$c){
	            //查询对应线路
	            $c['list'] = $this->model_user_merchant->getLines($c['name']);
	        }
	    }elseif(!empty($merchantInfo)){
	       //查询国家线路
	       $country_lines = $this->model_user_merchant->getCountryLines($this->request->get['merchant_id']);
	       $country = array();
	       foreach($country_lines as $key=>$li){
	           $country[$key]['name'] = $li['country_id'];
	           $country[$key]['list'] = $this->model_user_merchant->getLines($li['country_id']);
	           //$country[$key]['lines'] = unserialize($li['lines']);
	           foreach (unserialize($li['lines']) as $line){
	               $country[$key]['lines'][] = $line['line_id'];
	           }
	       }
	       $data['country'] = $country;
	    } else {
	        $data['country'] = '';
	    }
	    
	    
	    if (isset($this->request->post['tel'])) {
	        $data['merchant_tel'] = $this->request->post['tel'];
	    }elseif(!empty($merchantInfo)){
	        $data['merchant_tel'] = $merchantInfo['telphone'];
	    } else {
	        $data['merchant_tel'] = '';
	    }
	    
	    
	    if (isset($this->request->post['email'])) {
	        $data['merchant_email'] = $this->request->post['email'];
	    }elseif(!empty($merchantInfo)){
	        $data['merchant_email'] = $merchantInfo['email'];
	    } else {
	        $data['merchant_email'] = '';
	    }
	    
	    if (isset($this->request->post['app_id'])) {
	        $data['merchant_appid'] = $this->request->post['app_id'];
	    }elseif(!empty($merchantInfo)){
	        $data['merchant_appid'] = $merchantInfo['app_id'];
	    } else {
	        $data['merchant_appid'] = '';
	    }
	    
	    if (isset($this->request->post['app_name'])) {
	        $data['merchant_appname'] = $this->request->post['app_name'];
	    }elseif(!empty($merchantInfo)){
	        $data['merchant_appname'] = $merchantInfo['app_name'];
	    } else {
	        $data['merchant_appname'] = '';
	    }
	    
	    
	    if (isset($this->request->post['model'])) {
	        $data['merchant_model'] = $this->request->post['model'];
	    }elseif(!empty($merchantInfo)){
	        $data['merchant_model'] = $merchantInfo['model_id'];
	    } else {
	        $data['merchant_model'] = '';
	    }
	    $data['cancel'] = $this->url->link('user/merchant', 'token=' . $this->session->data['token'] . $url, 'SSL');
	     
	    $data['header'] = $this->load->controller('common/header');
	    $data['column_left'] = $this->load->controller('common/column_left');
	    $data['footer'] = $this->load->controller('common/footer');
	    $this->response->setOutput($this->load->view('user/merchant_form.tpl', $data));
	}
	
	public function getlines(){
	    $this->load->model('user/merchant');
	    $country_id = $this->request->get['country_id'];
	    if($country_id){
	        $result = $this->model_user_merchant->getLines($country_id);
	        echo json_encode($result);
	    }
	}
	
	protected function validateForm(){
	    if(empty($this->request->post['merchant_name']) || utf8_strlen($this->request->post['merchant_name'])<3){
	        $this->error['merchant_name'] = '商户名不能小于3个字符';
	    }
	    
	    if(empty($this->request->post['country'])){
	        $this->error['country'] = '国家线路不能为空';
	    }
	    
	    foreach ($this->request->post['country'] as $v){
	        if(!$v['name']){
	            $this->error['country'] = '国家不能为空';
	            continue;
	        }
	        if(empty($v['lines'])){
	            $this->error['country'] = '线路不能为空';
	            continue;
	        }
	    }
	    return !$this->error;
	}
}