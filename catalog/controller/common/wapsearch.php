<?php
class ControllerCommonWapsearch extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/search.tpl', $data);
		} else {
			return $this->load->view('default/template/common/search.tpl', $data);
		}
	}
	
	//搜素页面
	public function searchPage(){
	    $data['header'] = $this->load->controller('common/wapheader');
	    return $this->load->view($this->config->get('config_template') . '/template/common/searchPage.tpl',$data);
	}
}