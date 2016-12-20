<?php
/**
 * 查询商品是否在正面清单并关闭商品
 * @author Administrator
 *
 */

class ControllerApiGoodsiscross extends Controller{
    public function run(){
       $this->load->model('account/order');
       $products = $this->model_account_order->getAmazons();
       foreach ($products as $product){
           if($this->model_account_order->getIscross($product['product_id'])['iscross']== 0){
               //不在正面清单关闭商品
               $this->model_account_order->setStatus($product['product_id'],'0');
           }
           //设置已查询
           $this->model_account_order->setiscross($product['product_id']);
       }
    }
}