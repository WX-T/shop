<?php
class ControllerActivityEleven extends Controller{
    public function index(){
        $data = array();
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/activity/eleven.tpl', $data));
    }
}