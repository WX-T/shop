<?php
/**
 * 自动判断是否可走跨境电商
 */
class ControllerApiJudgedeclartype extends Controller {
    public function index(){
        $this->load->model('account/order');
        //
        $orders = $this->model_account_order->getDeclarType();
        foreach ($orders as $v){
            $iscroll = true;
            //$total = 0;
            $determined = false;
            $orderproduct = $this->model_account_order->getOrderProducts($v['order_id']);
            foreach($orderproduct as $product){
                //$total += floatval($product['total']);
               //包含负面清单商品
                $negative = $this->model_account_order->getNegative($product['model']);
                if($negative){
                    $iscroll = false;
                }
                //查询是否在正面清单
                $orderproduct = $this->model_account_order->getIscross($product['product_id']);
                if($orderproduct){
                    if($orderproduct['iscross']=='0'){
                        $iscroll = false;
                    }
                }else{
                    $determined = true;
                }
                
            }
           //都在正面清单，金额大于2000
            if(($v['total']-$v['tariff_price']) > 2000){
                $iscroll = false;
            }
            
            if($determined){
                $this->model_account_order->setDeclartype($v['order_id'],'0');
            }else{
                if($iscroll){
                    $this->model_account_order->setDeclartype($v['order_id'],'1');
                }else{
                    $this->model_account_order->setDeclartype($v['order_id'],'5');
                }
            }
        }
    }
}