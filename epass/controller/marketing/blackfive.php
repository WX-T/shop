<?php

/***
 * 黑五活动主页
 * @author Administrator
 * @deprecated 2016-11-18 
 */
class ControllerMarketingBlackfive extends Controller{
    public function index(){
        $this->load->language('marketing/blackfive');
        
        $this->document->setTitle('黑色星期五活动');
        
        $this->load->model('marketing/blackfive');
        
        $this->getForm();
    }
    
    
    public function getForm(){
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['heading_title'] = '黑五活动编辑页';
        $data['token'] = $this->session->data['token'];
        $data['text_form'] = '编辑';
        $data['breadcrumbs'] = array();
        $data['products'] = array();
        $sql = "select * from sl_blackfive_product order by add_date asc";
        $data['products'] =  $this->db->query($sql)->rows;
        $data['image'] = $this->db->query("select image from sl_voucher_theme where voucher_theme_id = 100")->row['image'];
        $data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('marketing/blackfive', 'token=')
        );
        $this->response->setOutput($this->load->view('marketing/blackfive_form.tpl', $data));
    }
    
    /**
     * 添加商品
     */
    public function addproduct(){
        $time = date('Y-m-d H:i:s');
        $product_id = $this->request->post['product_id'];
        $product_name = $this->request->post['product_name'];
        if($product_id){
            //存至黑五活动表
            $sql = "insert into sl_blackfive_product (product_id,add_date,product_name) values (". (int) $product_id .",'{$time}','{$product_name}')";
            if($this->db->query($sql)){
                echo json_encode(['code'=>'1','msg'=>'success']);
            }else{
                echo json_encode(['code'=>'0','msg'=>'fail']);
            }
        }
    }
    
    /**
     * 删除商品
     */
    public function delproduct() {
        $product_id = $this->request->post['product_id'];
        if($product_id){
            $sql = "delete from sl_blackfive_product where product_id=".(int) $product_id;
            if($this->db->query($sql)) {
                 echo json_encode(['code'=>'1','msg'=>'success']);
            }else{
                 echo json_encode(['code'=>'0','msg'=>'fail']);
            }
        }
    }
    
    /**
     * 修改商品详情
     */
    public function editproduct(){
        $this->load->model('marketing/blackfive');
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->get['product_id']) {
            //保存
            $this->model_marketing_blackfive->editProduct( $this->request->post );
            //exit;
            $this->session->data['success'] = $this->language->get('text_success');
        
            $url = '';
        
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
        
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
        
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->response->redirect($this->url->link('marketing/blackfive', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getProductForm();
    }
    
    /**
     * 商品详情表单
     */
    public function getProductForm(){
        $data['heading_title'] = '商品描述';
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->get['product_id'])) {
            $data['product_id'] = $this->request->get['product_id'];
        } else {
            $data['product_id'] = 0;
        }
        
        if (isset($this->request->get['product_id'])) {
            $url .= '&product_id=' . $this->request->get['product_id'];
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        
        if($data['product_id']){
            $product_descInfo = $this->db->query('select * from sl_blackfive_product_desc where product_id = ' . (int) $data['product_id'])->row;
        }
        $this->load->model('tool/image');
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($product_descInfo)) {
            $data['name'] = $product_descInfo['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['hot_name'])) {
            $data['hot_name'] = $this->request->post['hot_name'];
        } elseif (!empty($product_descInfo)) {
            $data['hot_name'] = $product_descInfo['hot_name'];
        } else {
            $data['hot_name'] = '';
        }
        
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($product_descInfo)) {
            $data['image'] = $product_descInfo['image'];
            $data['thumb'] = $this->model_tool_image->resize($product_descInfo['image'], 100, 100);
        } else {
            $data['image'] = '';
        }
        
        if (isset($this->request->post['desc'])) {
            $data['desc'] = $this->request->post['desc'];
        } elseif (!empty($product_descInfo)) {
            $data['desc'] = $product_descInfo['desc'];
        } else {
            $data['desc'] = '';
        }
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('marketing/blackfive_product_form.tpl', $data));
    }
    
    public function setimage(){
        $sql = "update sl_voucher_theme set image ='".$this->request->get['image']."' where voucher_theme_id = 100";
        $this->db->query($sql);
    }
}