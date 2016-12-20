<?php
/**
 * 
 * 物流追踪
 * 
 */
class ControllerAccountTracking extends Controller {
    
    private $_app_name = 'CUS029';
    private $_app_id = 'C10FA53473B08392154C43823B5E7DE8';
    private $_secret_key = 'E77112A23EC91AC835BAB08E561B5B23';
    private $_createorder_url = 'http://192.168.5.21:8002/index.php?r=order/track';
  
    public function index(){
        $curl_deal = new curl_deal();
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
        $orderProduct = $this->model_account_order->getOrderProductList($order_id); 
        $data = array();
        $status = $this->model_account_order->getStatus($order_info['order_status_id']);
        //获取商品
        $productImage = $this->model_account_order->getOrderProductsList($order_id)[0]['image'];
        $this->load->model('tool/image');
        $data['order_image'] = $this->model_tool_image->resize($productImage);
        $data['order_statust'] = $status ? $status : '';
       /* if(!count($orderProduct)>1 || $orderProduct[0]['party_assbillno'] == ''){
            $data['list'][1]['Remark'] ='您的宝贝已起运，正在发往中国';
            $data['list'][1]['Createtime'] = date("Y-m-d H:i:s");*/
        if(!$order_info['trackingno']){
            $data['list'][1]['Remark'] ='您的宝贝已起运，正在发往中国';
            $data['list'][1]['Createtime'] = date("Y-m-d H:i:s");
        }else{
            //判断是否为登录用户的订单
            $customerID = $this->session->data['customer_id'];
            $postdata = array();
            if($customerID == $order_info['customer_id']){
                $psotdata['appname'] = $this->_app_name;
                $postdata['appid'] = $this->_app_id;
                $postdata['TrackingID'] = $order_info['trackingno'];//$orderProduct[0]['party_assbillno']
                $paramStr = json_encode($postdata);
                $dataArr = array();
                $dataArr['EData'] = urlencode($paramStr);
                $dataArr['SignMsg'] =  strtoupper(md5($paramStr.$this->_secret_key));
                $result = $curl_deal->postData($this->_createorder_url , $dataArr);
            }
            $jsondata = json_decode($result,true);
           /*  $jsondata['rtnCode'] = '000000';
            $jsondata['rtnList'][1]['Remark'] ='[威盛上海仓] 您的宝贝已出库 申通快递：139291010099999';
            $jsondata['rtnList'][1]['Createtime'] = date("Y-m-d H:i:s");
            $jsondata['rtnList'][2]['Remark'] ='[威盛上海仓] 您的宝贝已出库 申通快递：139291010099999';
            $jsondata['rtnList'][2]['Createtime'] = date("Y-m-d H:i:s");
            $jsondata['rtnList'][3]['Remark'] ='[威盛上海仓] 您的宝贝已出库 申通快递：139291010099999';
            $jsondata['rtnList'][3]['Createtime'] = date("Y-m-d H:i:s");
            $jsondata['rtnList'][4]['Remark'] ='[威盛上海仓] 您的宝贝已出库 申通快递：139291010099999';
            $jsondata['rtnList'][4]['Createtime'] = date("Y-m-d H:i:s"); */
            if($jsondata['rtnCode']=='000000'){
                $data['list']  = $jsondata['rtnList'];
            }else{
                $data['list'][1]['Remark'] ='暂无物流信息';
                $data['list'][1]['Createtime'] = date("Y-m-d H:i:s");
            }
        }
        $data['content_top'] = $this->load->controller('common/content_top');
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/tracking.tpl', $data));
    }
}