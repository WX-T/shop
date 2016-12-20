<?php
/**
 * 2016-10-18:商户改版时同步上线
 * @author Administrator
 *
 */
class ControllerApiSendorders extends Controller {
    private $_app_name = 'CUS029';
    private $_app_id = 'C10FA53473B08392154C43823B5E7DE8';
    private $_secret_key = 'E77112A23EC91AC835BAB08E561B5B23';
    private $_createorder_url = 'http://192.168.5.21:8002/index.php?r=order/new';
    private $product_id = array('293294','277293',
    '278294',
    '277277',
    '278278',
    '293293',
    '294294',
    '21951',        //除1.47
    '22007',        //除1.47
    '22015',        //除1.47
    '22051'         //除1.47
    );
    private $tex_147 = array('21951','22007','22015','22051');
    private $_gener_tocken = 'U9dXKPZaCj7EndD0qc4KMg==';
    private $_gener_key    = 'E77112A23EC91AC835BAB08E561B5B23';
    public function index(){
        $curl_deal = new curl_deal();
        $this->load->model('account/order');
        $this->load->model('catalog/product');
        //查询已发货未发送订单中心的订单
        $order_info = $this->model_account_order->getOrdercenters();
        $ordersArr = array();
        $orderSourceArr = array();
        if($order_info){
            foreach($order_info as $order){
                $products = $this->model_account_order->getOrderProducts($order['order_id']);
                $source = array();
                $bonded = array();
                $line = array();
                $packagesNoArr = array();
                 
                foreach ($products as $key=>$product){
                    if($product['outofstock'] && !$product['refund']){
                        $order['total'] = floatval($order['total']) - floatval($product['total']) - floatval($product['tariff_price']);
                        $order['tariff_price'] = floatval($order['tariff_price']) - floatval($product['tariff_price']);
                        unset($products[$key]);
                        continue;
                    }elseif($product['refund'] == '1'){
                        $order['total'] = floatval($order['total']) - floatval($product['total']) - floatval($product['tariff_price']);
                        $order['tariff_price'] = floatval($order['tariff_price']) - floatval($product['tariff_price']);
                        unset($products[$key]);
                        continue;
                    }
                    if(trim($product['party_assbillno'])){
                        $packagesNoArr[] = trim($product['party_assbillno']);
                    }
					$sourceStr = strtolower(trim($product['source'])) ? strtolower(trim($product['source'])) : 'amazon';
                    $source[] = $sourceStr;
                    $bonded[] = $product['bonded'];
                    $line[] = $product['line_id'];
                }
                
                $bonded = array_unique($bonded);
				$source = array_unique($source);
				$packagesNoArr = array_unique($packagesNoArr);
				$line = array_unique($line);
                if(count($source)>1){
                    continue;
                }
                
                if(count($bonded)>1){
                    continue;
                }
                if($source[0] == 1 && $order['order_status_id'] == '1'){
                    continue;
                }
                
                if(count($line) >1){
                    continue;
                }
                
                //除直邮外，其他不发送订单中心
                if($bonded[0]>=1){
                    $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added,comment) values('".$order['order_id']."','28','".date("Y-m-d H:i:s")."','未发送订单中心，除直邮外，其他不发送订单中心.code:75 line')");
                    $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='28',send_ordercenter='2' where order_id='".$order['order_id']."'");
                    continue;
                }
                
                //国内现货不发送订单中心
                if(in_array($line[0], array(83,84,85,86,87,88,89,90,91,92,93,94,95))){
                    $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added,comment) values('".$order['order_id']."','28','".date("Y-m-d H:i:s")."','未发送订单中心，除直邮外，其他不发送订单中心.code:75 line')");
                    $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='28',send_ordercenter='2' where order_id='".$order['order_id']."'");
                    continue;
                }
                
                /* if($source[0] == 'italy'){
                    $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('".$order['order_id']."','28','".date("Y-m-d H:i:s")."')");
                    $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='28',send_ordercenter='2' where order_id='".$order['order_id']."'");
                    continue;
                } */
                
               /*  //来源包含保税
                if(strstr($source[0], 'bonded')){
                    $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('".$order['order_id']."','28','".date("Y-m-d H:i:s")."')");
                    $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='28',send_ordercenter='2' where order_id='".$order['order_id']."'");
                    continue;
                }
                 */
                $cards = $this->model_account_order->getCustomerMsg($order['customer_id']);
                if(isset($cards['cardname'])&&!empty($cards['cardname'])){
                    $cards['cardname'] = $cards['cardname'];
                }else{
                    $cards['cardname'] = '';
                }
                if(isset($cards['cardid'])&&!empty($cards['cardid'])){
                    $cards['cardid'] = $cards['cardid'];
                }else{
                    $cards['cardid'] = '';
                }
                $postData = array();
                $postData['OpType'] = 'N';
                $postData['OrderNo'] = $order['order_id'];  //订单跟踪号
                //$assbillno = $this->model_account_order->getParty_assbillno($order['order_id']);
                if(count($packagesNoArr) >= 1){
                    $postData['packagesNo'] = implode(',', $packagesNoArr);
                    $postData['packsCount'] = count($packagesNoArr);
                    $postData['TrackingNo'] = trim($packagesNoArr[0]);
                }else{
                    $postData['packagesNo'] = trim($order['assbillno']);
                    $postData['packsCount'] = '1';
                    $postData['TrackingNo'] = trim($order['assbillno']);  //国际单号 $assbillno['party_assbillno']
                }
                
                //1=amazon(商户)上线时更改1为Amazon商户的id
                if($source[0] == 'amazon'){
                    if(!$postData['packagesNo'] || !$postData['TrackingNo']){
                        continue;
                    }
                }
                
                
                /* if($source[0] == 'korea' || $source[0] == 'japan'){
                    $postData['WarehouseCode'] = 'A058';
                }elseif($source[0] == 'germany'){
                    $postData['WarehouseCode'] = 'A070';
                }else{
                    $postData['WarehouseCode'] = 'A083';
                } */
                $postData['Weight'] = 12; //重量
                $postData['ExpressName'] = 'STO';//国内快递公司(代码)
                $postData['Remark'] = ''; //电商备注
                $postData['PayMoney'] = $order['total'];
                $postData['PostalTax'] = $order['tariff_price'];
                $postData['EstimateMoney'] = ''; //物流费用金额
                if($line[0]){
                    $lineData = $this->model_account_order->getLine($line[0]);
                    $postData['WarehouseCode'] = $lineData['line_code'];
                    $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                    $postData['Shipper']['SenderCompanyName'] = 'legoods'; //发件人公司名
                    $postData['Shipper']['SenderCountry'] = $lineData['country_code']; //发件人国家代码
                    $postData['Shipper']['SenderProvince'] = $lineData['province'];    //发件人省、州
                    $postData['Shipper']['SenderCity'] = $lineData['city'];    //发件人城市
                    $postData['Shipper']['SenderAddr'] = $lineData['address'];    //发件人地址
                    $postData['Shipper']['SenderZip'] = $lineData['zipcode'];     //发件人邮编
                    $postData['Shipper']['SenderTel'] = $lineData['contacttel'];  //发件人电话
                    
                }
               /*  if($source[0] == 'korea'){
                    $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                    $postData['Shipper']['SenderCompanyName'] = 'legoods'; //发件人公司名
                    $postData['Shipper']['SenderCountry'] = 'Korea'; //发件人国家代码
                    $postData['Shipper']['SenderProvince'] = 'Gimpo-si';    //发件人省、州
                    $postData['Shipper']['SenderCity'] = 'Gochon-eup';    //发件人城市
                    $postData['Shipper']['SenderAddr'] = '3F. Hyundai logistics center,  748 Cheonho-li';    //发件人地址
                    $postData['Shipper']['SenderZip'] = '10136';     //发件人邮编
                    $postData['Shipper']['SenderTel'] = '+82-2-2170-3311';  //发件人电话
                }elseif($source[0] == 'germany'){
                    $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                    $postData['Shipper']['SenderCompanyName'] = 'legoods'; //发件人公司名
                    $postData['Shipper']['SenderCountry'] = 'Germany'; //发件人国家代码
                    $postData['Shipper']['SenderProvince'] = 'hoppstaedten';    //发件人省、州
                    $postData['Shipper']['SenderCity'] = 'hoppstaedten';    //发件人城市
                    $postData['Shipper']['SenderAddr'] = 'robinson road 15';    //发件人地址
                    $postData['Shipper']['SenderZip'] = '55768';     //发件人邮编
                    $postData['Shipper']['SenderTel'] = '+49 6782 9899009';     //发件人电话
                }elseif($source[0] == 'canada'){
                    //加拿大蒙特利尔仓
                    $postData['WarehouseCode'] = 'A072';
                    $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                    $postData['Shipper']['SenderCompanyName'] = 'legoods'; //发件人公司名
                    $postData['Shipper']['SenderCountry'] = 'CA'; //发件人国家代码
                    $postData['Shipper']['SenderProvince'] = 'Quebec';    //发件人省、州
                    $postData['Shipper']['SenderCity'] = 'Pointe-Claire(Montreal)';    //发件人城市
                    $postData['Shipper']['SenderAddr'] = '191 Brunswick';    //发件人地址
                    $postData['Shipper']['SenderZip'] = 'H9R 5N2';     //发件人邮编
                    $postData['Shipper']['SenderTel'] = '+1(514)6604320';     //发件人电话
                }elseif($source[0] == 'japan'){
                    //日本mina
                    $postData['WarehouseCode'] = 'A059';
                    $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                    $postData['Shipper']['SenderCompanyName'] = 'legoods'; //发件人公司名
                    $postData['Shipper']['SenderCountry'] = 'JP'; //发件人国家代码
                    $postData['Shipper']['SenderProvince'] = 'Chiba';    //发件人省、州
                    $postData['Shipper']['SenderCity'] = 'Narita';    //发件人城市
                    $postData['Shipper']['SenderAddr'] = 'Minamisanrizuka ';    //发件人地址
                    $postData['Shipper']['SenderZip'] = '286-0113';     //发件人邮编
                    $postData['Shipper']['SenderTel'] = '03-6262-5568';     //发件人电话
                }else{
                    $postData['Shipper']['SenderName'] = 'legoods';    //发件人姓名
                    $postData['Shipper']['SenderCompanyName'] = 'legoods'; //发件人公司名
                    $postData['Shipper']['SenderCountry'] = 'US'; //发件人国家代码
                    $postData['Shipper']['SenderProvince'] = 'Oregon';    //发件人省、州
                    $postData['Shipper']['SenderCity'] = 'Beaverton';    //发件人城市
                    $postData['Shipper']['SenderAddr'] = '7858 SW Nimbus Ave.';    //发件人地址
                    $postData['Shipper']['SenderZip'] = '97008';     //发件人邮编
                    $postData['Shipper']['SenderTel'] = '19178546636';     //发件人电话
                } */
                $postData['Cosignee']['RecPerson'] = $order['payment_fullname'];    //收货人姓名
                $postData['Cosignee']['RecPhone'] = $order['shipping_telephone'] ? $order['shipping_telephone'] : $order['telephone'];     //收货人电话
                $postData['Cosignee']['RecMail'] = $order['email'];      //收货人邮箱
                $postData['Cosignee']['RecCountry'] = 'CN';       //收货人国家代码
                $postData['Cosignee']['RecProvince'] = $order['payment_zone'] ? $order['payment_zone'] : $order['payment_city'];      //收货人省（州）
                $postData['Cosignee']['RecCity'] = $this->model_account_order->getCity($order['city_id']);//收货人城市getCity
                $postData['Cosignee']['RecAddress'] = $this->model_account_order->getCity($order['area_id']).$order['shipping_address'];       //收货地址
                $postData['Cosignee']['Name'] = $cards['cardname'];             //姓名
                $postData['Cosignee']['CitizenID'] = $cards['cardid'];        //身份证号
                $postData['Goods'] = array();
                $goodsPrice = 0;
                foreach($products as $key=>$product){
                    if($product['hscode']){
                        //查询是否有消费税
                        $gennerhscode = $this->model_catalog_product->getHscode($product['hscode']);
                        if($gennerhscode['spendtax']!=0 || $product['price']/1.119 >=2000){
                            //关闭商品
                            $this->model_catalog_product->offproduct($product['product_id'],$product['parent_id']);
                        }
                    }
                    $postData['Goods'][$key]['CommodityLinkage'] = $product['model']; //商品编号
                    $postData['Goods'][$key]['Commodity'] = $product['name'];       //商品中文名称
                    $postData['Goods'][$key]['CommodityNum'] = $product['quantity']; //商品数量
                    //不算税
                    if(Param::$counttax[$source[0]]=='1'){
                        //包邮保税
                        $make = false;
                        foreach ($this->product_id as $v){
                            if($product['product_id']==$v){
                                $make = true;
                            }
                        }
                        if($make){
                            //红酒税
                            if(in_array($product['product_id'], $this->tex_147)){
                                $postData['Goods'][$key]['CommodityUnitPrice'] = sprintf("%.2f", floatval($product['price'])/1.47);
                            }else{
                                $postData['Goods'][$key]['CommodityUnitPrice'] = sprintf("%.2f", floatval($product['price'])/1.21);
                            }
                            
                        }else{
                            $postData['Goods'][$key]['CommodityUnitPrice'] = sprintf("%.2f", floatval($product['price'])/1.119);//商品单价
                        }
                        
                    }else{
                        //算税
                        $postData['Goods'][$key]['CommodityUnitPrice'] = $product['price'];
                    }
                    //if($source[0] == 'korea' || $source[0] == 'germany'){
                        
                    //}else{
                        
                    //}
                    $goodsPrice += floatval($postData['Goods'][$key]['CommodityUnitPrice'])*$product['quantity'];
                }
                $postData['TotalPrice'] = $goodsPrice;
                $ordersArr[] = $postData;
                $orderSourceArr[$order['order_id']] = array('source'=>$source[0] , 'order_status_id'=>$order['order_status_id']);
            }
            if($ordersArr){
                $paramData = array();
                $paramData['appname'] = $this->_app_name;
                $paramData['appid'] = $this->_app_id;
                $paramData['Orders'] = $ordersArr;
                $paramStr = json_encode($paramData);
                $log = new Log('sendorders/'.date("Y-m-d").'_sendorders.log');
                $log->write('发送订单内容:'.$paramStr);
                $dataArr = array();
                $dataArr['EData'] = urldecode(urlencode(urlencode($paramStr)));
                $dataArr['SignMsg'] =  strtoupper(md5($paramStr.$this->_secret_key));
                $result = $curl_deal->postData($this->_createorder_url , $dataArr);
                $log->write('发送订单结果:'.$result);
                $jsondata = json_decode($result,true);
                //存入数据库
                if($jsondata['rtnCode']=='000000' || $jsondata['rtnCode']=='000003' || $jsondata['rtnCode']=='000002'){
    				$num = 0;
                    foreach($jsondata['orderList'] as $msg){
                        if(isset($msg['ExpressNo'])){
                            $msg['ExpressNo'] = $msg['ExpressNo'];
                        }else{
                            $msg['ExpressNo'] = '';
                        }
                        //更改状态并写入快递单号
                        if($msg['OrderNo'] && $msg['TrackingNo']){
    						$num ++;
                            $this->model_account_order->saveTraking($msg['OrderNo'],$msg['TrackingNo'],$msg['ExpressNo'] , $orderSourceArr[$msg['OrderNo']]['source'] , $orderSourceArr[$msg['OrderNo']]['order_status_id']);
                        }
                    }
    				echo '成功发送订单 '.$num.' 个';
                }else{
                    echo '订单发送失败';
                }
            }else{
                echo '无可发送订单中心的订单';
            }
        }else{
            echo '无订单';
        }
       
    }
}