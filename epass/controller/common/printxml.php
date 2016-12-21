<?php
class ControllerCommonPrintxml extends Controller{
    public function index(){
        $order_id = $this->request->get['order_id'];
        //查询订单信息
        $this->load->model('sale/order');
        $orderInfo = $this->model_sale_order->getOrder($order_id);
        //查询商品信息
        $products = $this->model_sale_order->getOrderProducts($order_id);
        $count = 0;
        foreach ($products as $product){
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
            }else{
                $count += $product['quantity'];
            }
        }
        $xmlStr = "<xml>\n";
        $xmlStr .= "<_grparam>";
        $xmlStr .= "<TrackId>".$orderInfo['trackingno']."</TrackId>";
        $xmlStr .= "<datafrom>ZHONGYIN</datafrom>";
        $xmlStr .= "<shipfrom>Legoods</shipfrom>";
        $xmlStr .= "<deliverto>收件人姓名 :{$orderInfo['payment_fullname']}\n收件人地址:{$orderInfo['payment_zone']} {$orderInfo['payment_city']} {$orderInfo['payment_address']}\n收件人电话:{$orderInfo['shipping_telephone']}\n收货人邮编：{$orderInfo['payment_postcode']}</deliverto>";
        $xmlStr .= "<Value>￥".round($orderInfo['total'],2)."</Value>";
        $xmlStr .= "<PrintDate>".date('Y-m-d H:i:s')."</PrintDate>";
        $xmlStr .= "<Weight></Weight>";
        $xmlStr .= "<Count>{$count}件</Count>";
        $xmlStr .= "<shipmentref>{$products[0]['name']}</shipmentref>";
        $xmlStr .= "<MarkDestination>上海</MarkDestination>";
        $xmlStr .= "<shipping_agents>".$orderInfo['shipping_agents']."</shipping_agents>";
        $xmlStr .= "<trackingID>".$orderInfo['trackingno']."</trackingID>";
        $xmlStr .= "<expresscode>".$orderInfo['trackingno']."</expresscode>";
        $xmlStr .= "<expressno>".$orderInfo['expressno']."</expressno>";
        $xmlStr .= "<OrderNo>".$orderInfo['order_id']."</OrderNo>";
        $xmlStr .= "</_grparam>\n";
        $xmlStr .="</xml>\n";
        echo $xmlStr;
    }
}