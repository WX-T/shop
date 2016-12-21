<?php
class ControllerUserSendorders extends Controller {
    private $_app_name = 'CUS029';
    private $_app_id = 'C10FA53473B08392154C43823B5E7DE8';
    private $_secret_key = 'E77112A23EC91AC835BAB08E561B5B23';
    private $_createorder_url = 'http://api.kuajing56.com:8002/index.php?r=order/new';
    
    private $_gener_tocken = 'U9dXKPZaCj7EndD0qc4KMg==';
    private $_gener_key    = 'E77112A23EC91AC835BAB08E561B5B23';
    public function index(){
        $curl_deal = new curl_deal();
        $this->load->model('sale/order');
        //查询已发货未发送订单中心的订单
        $order_info = $this->model_sale_order->getOrdercenters();
        $ordersArr = array();
        if($order_info){
            foreach($order_info as $order){
                $cards = $this->model_sale_order->getCustomerMsg($order['customer_id']);
                $postData = array();
                $postData['OpType'] = 'N';
                $postData['OrderNo'] = $order['order_id'];
                $postData['TrackingNo'] = $order['order_id']; //订单跟踪号
                $postData['WarehouseCode'] = 'A083';
                $postData['Weight'] = 12; //重量
                $postData['ExpressName'] = 'YTO';//国内快递公司(代码)
                $postData['Remark'] = ''; //电商备注
                $postData['TotalPrice'] = $order['total'];
                $postData['EstimateMoney'] = ''; //物流费用金额
                $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                $postData['Shipper']['SenderCompanyName'] = '乐购'; //发件人公司名
                $postData['Shipper']['SenderCountry'] = 'CN'; //发件人国家代码
                $postData['Shipper']['SenderProvince'] = '上海';    //发件人省、州
                $postData['Shipper']['SenderCity'] = '上海市';    //发件人城市
                $postData['Shipper']['SenderAddr'] = '浦东新区锦安东路593弄2号602室';    //发件人地址
                $postData['Shipper']['SenderZip'] = '201204';     //发件人邮编
                $postData['Shipper']['SenderTel'] = '13524239791';     //发件人电话
                $postData['Cosignee']['RecPerson'] = $order['payment_fullname'];    //收货人姓名
                $postData['Cosignee']['RecPhone'] = $order['shipping_telephone'];     //收货人电话
                $postData['Cosignee']['RecMail'] = $order['email'];      //收货人邮箱
                $postData['Cosignee']['RecCountry'] = 'CN';       //收货人国家代码
                $postData['Cosignee']['RecProvince'] = $order['payment_zone'];      //收货人省（州）
                $postData['Cosignee']['RecCity'] = $this->model_sale_order->getCity($order['city_id']);//收货人城市getCity
                $postData['Cosignee']['RecAddress'] = $this->model_sale_order->getCity($order['area_id']).$order['shipping_address'];       //收货地址
                $postData['Cosignee']['Name'] = $cards['cardname'];             //姓名
                $postData['Cosignee']['CitizenID'] = $cards['cardid'];        //身份证号
                $products = $this->model_sale_order->getOrderProducts($order['order_id']);
                $postData['Goods'] = array();
                foreach($products as $key=>$product){
                    $postData['Goods'][$key]['CommodityLinkage'] = $product['model']; //商品编号
                    $postData['Goods'][$key]['Commodity'] = $product['name'];       //商品中文名称
                    $postData['Goods'][$key]['CommodityNum'] = $product['quantity']; //商品数量
                    $postData['Goods'][$key]['CommodityUnitPrice'] = $product['price'];//商品单价
                }
                $ordersArr[] = $postData;
            }
            $paramData = array();
            $paramData['appname'] = $this->_app_name;
            $paramData['appid'] = $this->_app_id;
            $paramData['Orders'] = $ordersArr;
            $paramStr = json_encode($paramData);
            $dataArr = array();
            $dataArr['EData'] = urlencode($paramStr);
            $dataArr['SignMsg'] =  strtoupper(md5($paramStr.$this->_secret_key));
            $result = $curl_deal->postData($this->_createorder_url , $dataArr);
            print_r($result);
            $jsondata = json_decode($result,true);
            //存入数据库
            if($jsondata['rtnCode']=='000000'){
                foreach($jsondata['orderList'] as $msg){
                    //更改状态并写入快递单号
                    if($msg['OrderNo'] && $msg['TrackingNo'] && $msg['ExpressNo']){
                        $this->model_sale_order->saveTraking($msg['OrderNo'],$msg['TrackingNo'],$msg['ExpressNo']);
                    }
                }
            }
        }
       
    }
}