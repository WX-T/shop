<?php
/**
 * 热销活动页面
 * @author Administrator
 *
 */
class ControllerActivityHotsale extends Controller {
	public function index() {
	    $data['checkout'] = array();
	    $this->document->setTitle($this->config->get('热卖界面'));
	    if (isset($this->request->get['route'])) {
	        $this->document->addLink(HTTP_SERVER, 'canonical');
	    }
	    $data['column_left'] = $this->load->controller('common/column_left');
	    $data['column_right'] = $this->load->controller('common/column_right');
	    $data['content_top'] = $this->load->controller('common/content_top');
	    $data['content_bottom'] = $this->load->controller('common/content_bottom');
	    $data['footer'] = $this->load->controller('common/footer');
	    $data['header'] = $this->load->controller('common/wapheader');
	    $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/activity/hotsale.tpl', $data));
	}
}