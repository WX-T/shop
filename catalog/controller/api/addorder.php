<?php
/**
 * 添加订单
 * @author Administrator
 *
 */
class ControllerApiAddorder extends Controller {
    public function index(){
        $data = array();
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/api/addorder.tpl', $data));
    }
}