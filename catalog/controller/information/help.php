<?php
class ControllerInformationHelp extends Controller {
	public function index() {
	    
	    $this->document->setTitle('帮助中心');
	    
	    if(isset($this->request->get['nav'])){
	        $nav = $this->request->get['nav'];
	    }else{
	        $nav = '';
	    }
	    if(isset($this->request->get['first'])){
	        $first = $this->request->get['first'];
	    }else{
	        $first = 0;
	    }
	    
	    $data['first'] = $first;
	    $data['nav'] = $nav;
	    
	    $data['breadcrumbs'] = array();
	    
	    $data['breadcrumbs'][] = array(
	        'text' => '首页',
	        'href' => $this->url->link('common/home')
	    );
	    
	    $data['breadcrumbs'][] = array(
	        'text' => '帮助中心',
	        'href' => $this->url->link('information/help')
	    );
	    
	    if($nav){
	        $navArr = array('guide'=>'购物指南','delivery'=>'配送方式','pay'=>'支付方式','aftersale'=>'售后服务','contact'=>'联系我们','protocol'=>'注册协议');
	        $data['breadcrumbs'][] = array(
	            'text' => $navArr[$nav] ? $navArr[$nav] : $nav[0],
	            'href' => 'javascript:void(0)'
	        );
	    }
	    $data['tel'] = $this->config->get('config_tel');
	    $data['url'] = $_SERVER['SERVER_NAME'];  
	    $data['column_left'] = $this->load->controller('common/column_left');
	    $data['column_right'] = $this->load->controller('common/column_right');
	    $data['content_top'] = $this->load->controller('common/content_top');
	    $data['content_bottom'] = $this->load->controller('common/content_bottom');
	    $data['footer'] = $this->load->controller('common/footer');
	    $data['header'] = $this->load->controller('common/header');
	    
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/help.tpl')) {
	        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/help.tpl', $data));
	    } else {
	        $this->response->setOutput($this->load->view('default/template/information/help.tpl', $data));
	    }
	}
}