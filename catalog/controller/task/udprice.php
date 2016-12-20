<?php
class ControllerTaskUdprice extends Controller{
	private $error = array();

	public function index() {
	    $v = isset($this->request->get['v']) ? $this->request->get['v'] : '';
	    if($v != md5("_TASK_UDPRICE_")){   //869c391dfb5661d61b6f6a06c5260d98
	        echo false;
	        exit();
	    }
	    
		$this->load->model('catalog/product');
		
		$productList = $this->model_catalog_product->getAllProducts(" AND TO_DAYS(update_date)!=TO_DAYS(NOW()) OR TO_DAYS(update_date) IS NULL");
		foreach ($productList as $product){
		    if($product['out_url']){
    		    $post_url = "http://52.26.22.11:9002/udprice.php";
    		    $curlDeal = new curl_deal();
    		    $jsonData = $curlDeal->postData($post_url , array('url'=>$product['out_url']));
    		    $jsonArr = json_decode($jsonData , true);
    		    //价格
    		    $listprice = str_replace(array('Was',':','Now'), '', isset($jsonArr['listprice']) ? $jsonArr['listprice'] : '');
    		    $price = str_replace(array('Was',':','Now'), '', isset($jsonArr['price']) ? $jsonArr['price'] : '');
    		    
    		    $listprice = floatval($listprice)*DOLLAR_RATE;
    		    $price     = floatval($price)*DOLLAR_RATE;
    		    
    		    $this->model_catalog_product->updateProductPrice($product['product_id'] , $listprice , $price);
    		    
		    }
		}
	}
}