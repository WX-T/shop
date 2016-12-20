<?php
/**
 * 电子产品h5页面
 * @author changxianyang
 *
 */
class ControllerSpecialElectronics extends Controller {
    public function index() {
        $data['special'] = array();
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/special/Electronics.tpl', $data));
    }


}