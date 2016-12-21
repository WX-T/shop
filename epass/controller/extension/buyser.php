<?php
class ControllerExtensionBuyser extends Controller{
    public function index(){
		$this->document->setTitle('买手管理');

		$this->load->model('extension/buyser');

		$this->getList();
    }
    
    public function getList(){
        $data = array();
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => '买手列表',
            'href' => $this->url->link('extension/buyser/index', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['add'] = $this->url->link('extension/buyser/add', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['rechargeadd_btn'] = $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'], 'SSL');
        $data['taskallocation_btn'] = $this->url->link('extension/buyser/taskallocation','token=' . $this->session->data['token'], 'SSL');
        
        $result = $this->model_extension_buyser->getBuyserList();
        foreach($result as &$val){
            $val['price'] = $this->model_extension_buyser->getBuyserPrice($val['buyser_id'])['price'];
            //未完成总数
            $val['backlog_num'] = $this->model_extension_buyser->getBacklog($val['buyser_id'])['number'];
            $val['task_num'] = $this->model_extension_buyser->getTaskNum($val['buyser_id'])['number'];
        }
        $data['buyser_list'] = $result;
        $data['text_list'] = '买手详细';
        $data['heading_title'] = '买手列表';
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('extension/buyser_list.tpl', $data));
    }
    
    /**
     * 买手充值充值
     */
    
    public function rechargeadd(){
        
        $this->load->model('extension/buyser');
        $data = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            //添加到充值记录
            if($this->request->post['buyser_id'] && $this->request->post['amazon'] && $this->request->post['cardno'] && $this->request->post['pass'] && $this->request->post['price']){
                if($this->model_extension_buyser->paycheck($this->request->post)){
                    $this->response->redirect($this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL'));
                }
            }else{
                $data['error_warning'] = '充值失败';
            }
        }
        
        $buyser_id = $this->request->get['buyer_id'];
        
        if(!$buyser_id){
            $this->response->redirect($this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $url = '&buyer_id='.$buyser_id;
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => '充值',
            'href' => $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $this->error['warning'] = $this->language->get('error_warning');
        $data['text_list'] = '账户充值';
        $data['heading_title'] = '充值';
        
        $data['buyser_id'] = $buyser_id;
        $data['buyser_info'] = $this->model_extension_buyser->getBuyserInfo($buyser_id);
        $data['amazon_list'] = $this->model_extension_buyser->getAmazonAccounts($buyser_id);
        
        $data['action'] = $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/recharge_add.tpl', $data));
    }
    
    /**
     * 任务分配
     */
    public function taskallocation(){
        $this->load->model('extension/buyser');
        $postData = $this->request->post;
        $data = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            //添加到任务
            if($this->request->post['buyser_id'] && $this->request->post['order']){
                foreach ($postData['order'] as $val){
                    $sqlData = array();
                    //查询订单金额
                    $sqlData['price'] = $this->model_extension_buyser->getOrderPrice($val)['total'];
                    $sqlData['order_id'] = $val;
                    //创建任务
                    $this->model_extension_buyser->CreateTask($this->request->post['buyser_id'],1,$sqlData);
                   //设置订单任务状态
                    $this->model_extension_buyser->updateOrderStatus($val,1);
                }
                $this->response->redirect($this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL'));
            }else{
                $data['error_warning'] = '任务添加失败';
            }
        }
        $buyser_id = $this->request->get['buyer_id'];
        if(!$buyser_id){
            $this->response->redirect($this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $url = '&buyer_id='.$buyser_id;
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => '任务分配',
            'href' => $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $this->error['warning'] = $this->language->get('error_warning');
        $data['token'] = $this->session->data['token'];
        $data['text_list'] = '任务分配';
        $data['heading_title'] = '任务分配';
        $data['buyser_id'] = $buyser_id;
        $data['buyser_info'] = $this->model_extension_buyser->getBuyserInfo($buyser_id);
        $data['amazon_list'] = $this->model_extension_buyser->getAmazonAccounts($buyser_id);
        
        $data['action'] = $this->url->link('extension/buyser/taskallocation', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/task_allocation.tpl', $data));
    }
    
    /**
     * 加载所有未分配的订单信息
     */
    public function getOrderAll(){
        $this->load->model('extension/buyser');
        $resoult = $this->model_extension_buyser->getNoTaskOrders();
        echo json_encode($resoult);
    }
    
    /**
     * 添加
     */
    public function add(){
        $this->load->model('extension/buyser');
        $data = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            //添加到充值记录
            if($this->request->post['buyser_name']){
                //储存
                if($this->model_extension_buyser->addBuyser($this->request->post['buyser_name'])){
                    $this->response->redirect($this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL'));
                }else {
                    $data['error_warning'] = '添加失败';
                }
            }else{
                $data['error_warning'] = '添加失败';
            }
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL')
        );
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => '新增买手',
            'href' => $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $this->error['warning'] = $this->language->get('error_warning');
        $data['token'] = $this->session->data['token'];
        $data['text_list'] = '新增买手';
        $data['heading_title'] = '新增买手';
        
        $data['action'] = $this->url->link('extension/buyser/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/add_from.tpl', $data));
    }
    
}