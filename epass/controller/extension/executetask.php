<?php
class ControllerExtensionExecutetask extends Controller {
    public function index(){
        $this->document->setTitle('我的任务');
        $this->load->model('extension/buyser');
        
        $this->getList();
    }
    
    protected function getList() {
        $data = array();
        //查询当前登录买手信息
        $buyser_id = $this->model_extension_buyser->getLoginBuyserID($this->session->data['user_id'])['buyser_id'];
        if(!$buyser_id){
            $this->user->logout();
        
            unset($this->session->data['token']);
        
            $this->response->redirect($this->url->link('common/login', '', 'SSL'));
        }
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/executetask', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => '我的任务',
            'href' => $this->url->link('extension/executetask', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['rechargeadd_btn'] = $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'], 'SSL');
        $data['taskallocation_btn'] = $this->url->link('extension/buyser/taskallocation','token=' . $this->session->data['token'], 'SSL');
        
        $data['text_list'] = '任务列表';
        $data['heading_title'] = $this->model_extension_buyser->getBuyserInfo($buyser_id)['buyser_name'];
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
       
        
        $filter_data = array(
            'filter_buyser_id'  => $buyser_id
        );
        
        $results = $this->model_extension_buyser->getTaskInfos($filter_data);
        $this->load->model('sale/order');
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
            
            $data['amazon_list'] = $this->model_extension_buyser->getAmazonAccounts($buyser_id);
            //查询物流状态
            $tacking = $this->model_sale_order->getTackingStatus($result['tacking_status']);
            //var_dump($results);exit;
            $status = '';
            if($result['status'] == '1'){
                $status = '未完成';
            }elseif($result['status'] == '2'){
                $status = '已购买';
            }elseif($result['status'] == '3'){
                $status = '已完成';
            }
            $data['orders'][] = array(
                'task_id'          => $result['task_id'],
                'status'           => $status,
                'order_price'      => $result['order_price'],
                'order_id'         => $result['order_id'],
                'order_status_id'  => $this->db->query('SELECT order_status_id from sl_order WHERE order_id='.$result['order_id'])->row['order_status_id'],
                'status_id'        => $result['status'],
                
                /* 'order_id'      => $result['order_id'],
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
                'trackingstatus'=> $tacking['status'], */
                'products'      => $productList,
                //'expressno'     => $result['expressno'],
            );
        }
       
        $data['task_list'] = $results;
        $data['token'] = $this->session->data['token'];
        $this->response->setOutput($this->load->view('extension/executetask_list.tpl', $data));
    }
    
    /**
     * 确认购买商品
     */
    public function confirmbuy(){
        $this->load->model('sale/order');
        $this->load->model('extension/buyser');
        $order_id = $this->request->post['order_id'];
        $o_product_id = $this->request->post['o_product_id'];
        $party_order_no = $this->request->post['order_no'];
        $party_price = $this->request->post['price'];
        $amazon_id = $this->request->post['amazon_id'];
        $task_id = $this->request->post['task_id'];
        // 	    $party_assbillno = $this->request->post['assbillno'];
        if(empty($order_id) || empty($amazon_id) || empty($party_order_no) || empty($party_price) || empty($task_id)){
            $json = json_encode(array('code'=>'-1'));
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($json);
            return false;
        }
        //添加任务历史
        $rs = $this->model_sale_order->confirmBuy($order_id,$o_product_id , $party_order_no , $party_price);
        if($rs){
            $code = $this->model_sale_order->isOutOrderGoods($order_id);
            $party_price = sprintf("%.4f", $party_price);
            //扣除买手账户金额
            if($this->model_extension_buyser->confirmbuyHistory($order_id,$amazon_id,$party_price,$task_id)){
                $json = json_encode(array('code'=>$code , 'order_no'=>$party_order_no , 'price'=>$party_price));
            }else{
                $json = json_encode(array('code'=>'-1'));
            }
        }else{
            $json = json_encode(array('code'=>'-1'));
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput($json);
    }
    
    //获取修改购买信息
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
        $task_id = $this->request->post['task_id'];
        $mark = false;
        if($type && $order_id){
            $this->load->model('sale/order');
            if($this->model_sale_order->merchantSendGoods($order_id,$type,$expressno,$shipping_agents)){
                //设置任务状态
                $this->load->model('extension/buyser');
                if($this->model_extension_buyser->setTaskStatus(3,$task_id)){
                    $mark = true;
                }
            }
        }
        if($mark){
            echo json_encode(array('code'=>1,'msg'=>'成功'));
        }else{
            echo json_encode(array('code'=>0,'msg'=>'失败'));
        }
    }
    
    /**
     * 买手amazon账号
     */
    public function buyamazon() {
        $this->load->model('extension/buyser');
        $data = array();
        //查询当前登录买手
        $buyser_id = $this->model_extension_buyser->getLoginBuyserID($this->session->data['user_id'])['buyser_id'];
        
        if(!$buyser_id){
            $this->user->logout();
        
            unset($this->session->data['token']);
        
            $this->response->redirect($this->url->link('common/login', '', 'SSL'));
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/executetask', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => 'Amazon账号列表',
            'href' => $this->url->link('extension/executetask/index', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['add'] = $this->url->link('extension/executetask/addamazon', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['amazons'] = $this->model_extension_buyser->getAmazonAccounts($buyser_id);
        
        $data['text_list'] = 'Amazon账号';
        $data['heading_title'] = 'Amazon列表';
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('extension/buyser_amazon_list.tpl', $data));
    }
    
    /**
     * 添加Amazon账号
     */
    public function addamazon() {
        $this->load->model('extension/buyser');
        $data = array();
        $buyser_id = $this->model_extension_buyser->getLoginBuyserID($this->session->data['user_id'])['buyser_id'];
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            //添加到充值记录
            if($this->request->post['amazon_account']){
                if($this->model_extension_buyser->addAmazonAccount($this->request->post, $buyser_id)){
                    $this->response->redirect($this->url->link('extension/executetask/buyamazon', 'token=' . $this->session->data['token'], 'SSL'));
                }else{
                    $data['error_warning'] = '添加失败';
                }
            }else{
                $data['error_warning'] = '添加失败';
            }
        }
        
        if(!$buyser_id){
            $this->response->redirect($this->url->link('extension/executetask', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $url = '';
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => '添加',
            'href' => $this->url->link('extension/buyser/rechargeadd', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $this->error['warning'] = $this->language->get('error_warning');
        $data['text_list'] = '新增Amazon账号';
        $data['heading_title'] = '新增';
        
        $data['action'] = $this->url->link('extension/executetask/addamazon', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/add_amazon_from.tpl', $data));
    }
    
}