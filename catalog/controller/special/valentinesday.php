<?php
/**
 * 七夕专题
 * @author changxianyang
 *
 */
class ControllerSpecialValentinesday extends Controller {
    public function index() {
        $data['special'] = array();
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/special/valentinesday.tpl', $data));
    }


}