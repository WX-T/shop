<?php
class ControllerGoodsCapture extends Controller {
    protected $api_url = 'http://localhost/legoodsdata/AmazonOptionsProduct';
    //发送至通过服务平台
    protected $put_epass_api_url = "http://localhost/legoodsdata/Importtranslation";
    //取出翻译完成商品
    protected $call_finish_aip_url = "http://localhost/legoodsdata/ExpClassifLegoods";
    //导入归类完成商品
    protected $call_get_classif_url = "http://localhost/legoodsdata/ParentProduct";
    //抓取商品
    public function index(){
       
		$this->document->setTitle('商品抓取');

		$data['heading_title'] = $this->language->get('商品抓取');

		$data['text_not_found'] = $this->language->get('text_not_found');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('商品抓取'),
			'href' => $this->url->link('goods/capture', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['put_epass_api'] = $this->url->link('goods/capture/dogetPutepassApi', 'token=' . $this->session->data['token'], 'SSL');
		$data['call_finish_aip_url'] = $this->url->link('goods/capture/callfinish', 'token=' . $this->session->data['token'], 'SSL');
		$data['call_classif_aip_url'] = $this->url->link('goods/capture/callclassiffinish', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('goods/capture.tpl', $data));
    }
    
    //调用发送到通关服务平台接口
    public function dogetPutepassApi(){
        $data = $this->postData($this->put_epass_api_url,array('asin'=>''));
        print_r($data);
    }
    
    //调用取出翻译完成商品接口
    public function callfinish(){
        $data = $this->postData($this->call_finish_aip_url,array('asin'=>''));
        print_r($data);
    }
    
    //调用导入归类完成商品
    public function callclassiffinish(){
        $data = $this->postData($this->call_get_classif_url,array('asin'=>''));
        print_r($data);
    }
    
    //抓取商品
    public function CaptureApi(){
        //取出asin
        //https://www.amazon.com/Lacoste-Mens-Marice-Dark-Blue/dp/B00FEM2OCG/ref=lp_14151090011_1_2?s=apparel&ie=UTF8&qid=1469168904&sr=1-2&nodeID=14151090011
        $url_array = parse_url($this->request->post['url']);
        preg_match_all("/\/dp\/(.*)[^>]*/i",$url_array['path'],$match);
        if($match[1][0]){
            $asin = explode('/', $match[1][0])[0];
        }
        
        if(!$asin){
            echo json_encode(array('code'=>'01','msg'=>'找不到商品编码'));
            exit;
        }
        //调用抓取接口
        $jsonstr = $this->postData($this->api_url,array('asin'=>$asin));
        echo $jsonstr;
    }
    
    function postData($url , $data = '')
    {
        $o = '';
        foreach ($data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        //为了支持cookie
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
    
        return $result;
        curl_close($ch);
    }
}