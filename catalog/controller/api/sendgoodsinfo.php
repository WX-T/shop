<?php
use Controller\api;
class ControllerApiSendgoodsinfo extends Controller
{
    private $_creategoods_url = 'http://192.168.5.21:9111/api/ReceiveGoods.html';
    public function index()
    {
        require '/goodsiscross.php';
        ControllerApiGoodsiscross::run();
        $curl_deal = new curl_deal();
        $this->load->model('catalog/product');
        // 查询未发送的商品信息
        $goods_info = $this->model_catalog_product->getProductinfo();
        if ($goods_info) {
            $goodsData = array();
            foreach ($goods_info as $order) {
               $source = strtolower(trim($order['source'])) ? strtolower(trim($order['source'])) : 'amazon';
               $product_code = $order['product_code'] ? $order['product_code'] : $order['model'];
               if($product_code){   //无原始 编号不发送
                   $goodsData[] = array(
                        'GOODNO' => $product_code, // 商品编号(必填)
                        'SKUNO' => $order['sku'], // SKU编号(非必填)
                        'EANNO'   => $order['ean'], // ean编号(非必填)
                        'BRAND' => $order['manufacturer_name'], // 商品品牌(非必填)
                        'NAMEEN' => $order['NAME'], // 商品英文名称(必填)
                        'NAMEZH' => '', // 商品中文名称(非必填)
                        'MODEL' => $order['model'], // 型号(非必填)
                        'NORMS' => '', // 规格(非必填)
                        'MADEPLACE' => Param::$origin[$source], // 产地(非必填)
                        'GOODFUNCTION' => '', // 功能(非必填)
                        'USAGE' => $order['points'], // 用途(非必填)
                        'COMPONENT' => $order['mpn'], // 成分(非必填)
                        'UNIT' => $order['taxrate'], // 商品单位(计税单位)
                        'AMOUNT' => '1', // 商品数量(必填)
                        'CNYPRICE' => $order['price'], // 单价(必填)
                        'PRODUCT_URL' => $order['out_url'], // 产品链接(非必填)
                        'WEIGHT' => $order['height'], // 商品重量(非必填)
                        'HSCODE' => $order['hscode'], //税则号
                        'GENERHSCODE' =>'',//普货税号
                        'GOODSTYPE' => '', // 平台类型(非必填)
                        'BUSINESS_TYPE' => '', // 商户类型(非必填)
                    );
               }
                /* $goodsData[] = array(
                    'GOODNO' => 'sadsaddasj', // 商品编号(必填)
                    'SKUNO' => $order['sku'], // SKU编号(非必填)
                    'BRAND' => $order['manufacturer_name'], // 商品品牌(非必填)
                    'NAMEEN' => $order['NAME'], // 商品英文名称(必填)
                    'NAMEZH' => '', // 商品中文名称(非必填)
                    'MODEL' => $order['model'], // 型号(非必填)
                    'NORMS' => '', // 规格(非必填)
                    'MADEPLACE' => $order['source'], // 产地(非必填)
                    'GOODFUNCTION' => '', // 功能(非必填)
                    'USAGE' => $order['points'], // 用途(非必填)
                    'COMPONENT' => $order['mpn'], // 成分(非必填)
                    'UNIT' => $order['taxrate'], // 商品单位(计税单位)
                    'AMOUNT' => $order['quantity'], // 商品数量(必填)
                    'CNYPRICE' => $order['price'], // 单价(必填)
                    'PRODUCT_URL' => $order['out_url'], // 产品链接(非必填)
                    'WEIGHT' => $order['height'], // 商品重量(非必填)
                    'GOODSTYPE' => '', // 平台类型(非必填)
                    'BUSINESS_TYPE' => '', // 商户类型(非必填)
                    'EANNO' => $order['upc'], // 商品条形码(非必填)
                ); */
                
            }
            $postDatas = array(
                'SignCode' => $this->_obtainSignCode(urlencode(json_encode(array(
                    'Goods' => $goodsData
                ))), md5('_HSCODE_API_SERVER_')),
                'JsonData' => urlencode(json_encode(array(
                    'Goods' => $goodsData
                )))
            );
        }
        // 发送商品信息数据
        $result = $curl_deal->postData($this->_creategoods_url, $postDatas);
        $log = new Log('sendgoods.log');
        $log->write('发送商品结果:'.$result);
        // 还原JSON字符串
        $jsondata = json_decode($result, true);
        // 更改发送成功的商品的发送状态
        if ($jsondata['result'] == '000000') {
            echo '商品信息发送成功.<br>';
            $result = $this->model_catalog_product->updateSendstatus($goods_info);
            if ($result == 'ok') {
                echo '修改发送状态成功';
            }
        } else {
            echo '商品信息发送失败';
        }
    }
    
    // 加密方式
    public function _obtainSignCode($jsonStr, $signCode)
    {
        $jsonString = base64_decode(urldecode($jsonStr));
        return strtoupper(md5($jsonString . $signCode));
    }
    
    
    
}
?>