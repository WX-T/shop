<?php
class ControllerGoodsCapturelist extends Controller {
    //抓取商品
    public function index(){
       
		$this->document->setTitle('商品抓取列表');

		$data['heading_title'] = $this->language->get('商品抓取列表');

		$data['text_not_found'] = $this->language->get('text_not_found');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('商品抓取列表'),
			'href' => $this->url->link('goods/capturelist', 'token=' . $this->session->data['token'], 'SSL')
		);
		

		if (isset($this->request->get['filter_asin'])) {
		    $filter_asin = $this->request->get['filter_asin'];
		} else {
		    $filter_asin = null;
		}
		
		if (isset($this->request->get['filter_start_time'])) {
		    $filter_start_time = $this->request->get['filter_start_time'];
		} else {
		    $filter_start_time = null;
		}
		
		if (isset($this->request->get['filter_end_time'])) {
		    $filter_end_time = $this->request->get['filter_end_time'];
		} else {
		    $filter_end_time = null;
		}
		
		if (isset($this->request->get['filter_type'])) {
		    $filter_type = $this->request->get['filter_type'];
		} else {
		    $filter_type = '1';
		}
		
		if (isset($this->request->get['filter_status'])) {
		    $filter_status = $this->request->get['filter_status'];
		} else {
		    $filter_status = null;
		}
		
		if (isset($this->request->get['page'])) {
		    $page = $this->request->get['page'];
		} else {
		    $page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_asin'])) {
		    $url .= '&filter_asin=' . $this->request->get['filter_asin'];
		}
		
		if (isset($this->request->get['filter_start_time'])) {
		    $url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
		    $url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}
		
		if (isset($this->request->get['filter_type'])) {
		    $url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		
		if (isset($this->request->get['filter_status'])) {
		    $url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['page'])) {
		    $url .= '&page=' . $this->request->get['page'];
		}
		
		$this->load->model('goods/capture');
		
		$filter_data = array(
		    'filter_asin'      => $filter_asin,
		    'filter_start_time'=> $filter_start_time,
		    'filter_end_time'  => $filter_end_time,
		    'filter_type'	   => $filter_type,
		    'filter_status'    => $filter_status,
		    'start'            => ($page - 1) * $this->config->get('config_limit_admin'),
		    'limit'            => $this->config->get('config_limit_admin')
		);
		
		$data['filter_type'] = $filter_type;
		$data['filter_status'] = $filter_status;
		$data['filter_asin'] = $filter_asin;
		$data['filter_start_time'] = $filter_start_time;
		$data['filter_end_time'] = $filter_end_time;
		
		$goodlist = $this->model_goods_capture->getcaptureList($filter_data);
		$order_total = $this->model_goods_capture->getcaptureListCount($filter_data);
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('goods/capturelist', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));
		if($filter_type=='2'){
		    foreach($goodlist as &$v){
		      //取父商品asin
		      $asin = $this->model_goods_capture->getParentAsin($v['head_id']);
		      $v['pasin'] = $asin;
		    }
		}
		
		
		$data['goods'] = $goodlist;
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		
		$this->response->setOutput($this->load->view('goods/capturelist.tpl', $data));
    }
}