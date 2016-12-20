<?php
/**
 * 父亲节专题活动页面
 * @author changxianyang
 *
 */
class ControllerSpecialFatherday extends Controller {
    public function index() {
        $data['special'] = array();
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/special/fatherday.tpl', $data));
    }


}