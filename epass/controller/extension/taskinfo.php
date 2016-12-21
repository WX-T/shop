<?php
class ControllerExtensionTaskinfo extends Controller {
    public function index(){
        $this->document->setTitle('任务列表');

		$this->load->model('extension/buyser');

		$this->getList();
    }
    
    protected  function getList(){
        if (isset($this->request->get['filter_task_id'])) {
            $filter_task_id = $this->request->get['filter_task_id'];
        } else {
            $filter_task_id = null;
        }
        
        if (isset($this->request->get['filter_buyser_name'])) {
            $filter_buyser_name = $this->request->get['filter_buyser_name'];
        } else {
            $filter_buyser_name = null;
        }
        
        if (isset($this->request->get['filter_task_status'])) {
            $filter_task_status = $this->request->get['filter_task_status'];
        } else {
            $filter_task_status = null;
        }
        
        
        $url = '';
        
        if (isset($this->request->get['filter_task_id'])) {
            $url .= '&filter_task_id=' . $this->request->get['filter_task_id'];
        }
        
        if (isset($this->request->get['filter_buyser_name'])) {
            $url .= '&filter_buyser_name=' . $this->request->get['filter_buyser_name'];
        }
        
        if (isset($this->request->get['filter_buyser_name'])) {
            $url .= '&filter_buyser_name=' . $this->request->get['filter_buyser_name'];
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data = array();
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/buyser', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => '任务列表',
            'href' => $this->url->link('extension/buyser/index', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        
        $filter_data = array(
            'filter_task_id'          => $filter_task_id,
            'filter_buyser_name'      => $filter_buyser_name,
            'filter_task_status'      => $filter_task_status,
        );
        
        $task_total = $this->model_extension_buyser->getTaskinfoTotal($filter_data)['total'];
        $task_info = $this->model_extension_buyser->getTaskInfos($filter_data);
        
        foreach($task_info as &$v){
            if($v['status'] == 1){
                $v['status'] = '待完成';
            }elseif($v['status'] == 2){
                $v['status'] = '已购买';
            }elseif($v['status'] == 3){
                $v['status'] = '已完成';
            }
            $v['difference'] = $v['buy_price'] == $v['order_price'] ? 0 : $v['buy_price'] - $v['order_price'];
        }
        $data['task_info'] = $task_info;
        $data['heading_title'] = '任务详情';
        $data['text_list'] = '任务列表';
        

        $pagination = new Pagination();
        $pagination->total = $task_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $data['pagination'] = $pagination->render();
        
        $data['filter_task_id'] = $filter_task_id;
        $data['filter_buyser_name'] = $filter_buyser_name;
        $data['filter_task_status'] = $filter_task_status;
        
        $data['results'] = sprintf($this->language->get('text_pagination'), ($task_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($task_total - $this->config->get('config_limit_admin'))) ? $task_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $task_total, ceil($task_total / $this->config->get('config_limit_admin')));
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['token'] = $this->session->data['token'];
        
        $this->response->setOutput($this->load->view('extension/taskinfo_list.tpl', $data));
    }
}