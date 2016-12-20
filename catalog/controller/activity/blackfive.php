<?php
/**
 * 黑五活动
 */
class ControllerActivityBlackfive extends Controller{
    public function index(){
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        
        $data = array();
        //查询banner
		$data['banner'] = $this->model_tool_image->resize($this->db->query('select * from sl_voucher_theme where voucher_theme_id = 100')->row['image']);
        $product_ids = $this->db->query('SELECT t1.product_id,t1.add_date,t2.hot_name,t2.`name`,t3.image,t1.product_name from sl_blackfive_product t1 LEFT JOIN sl_blackfive_product_desc t2 ON t1.product_id=t2.product_id LEFT JOIN sl_product t3 ON t1.product_id=t3.product_id order by t1.add_date desc')->rows;
        $data['products'] = array();
        foreach ($product_ids as $key=>$p){
            //$image = '';
            $productInfo = $this->model_catalog_product->getProduct($p['product_id']);
            $data['products'][$key]['product_id'] = $p['product_id'];
            $data['products'][$key]['name'] = empty($p['name']) ? $p['product_name'] : $p['name'];
            $data['products'][$key]['product_id'] = $p['product_id'];
            $data['products'][$key]['price'] = sprintf("%.2f", $productInfo['price']);
            $data['products'][$key]['hot_name'] = $p['hot_name'];
           /*  if(fopen($p['image'], 'r')){
                $image = $p['image'];
            }else {
                $image = $this->model_tool_image->resize($p['image']);
            }
            $data['products'][$key]['image'] = $image; */
            $data['products'][$key]['image'] = $p['image'];
            $data['products'][$key]['add_date'] = date('m/d H:i',strtotime($p['add_date']));
            $data['products'][$key]['link'] = $this->url->link('activity/blackfive/description', '&product_id=' . $p['product_id']);
        }
		$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/activity/blackfive.tpl', $data));
    }
    
    public function description(){
        $this->load->model('tool/image');
        
        $data = array();
        $product_id = $this->request->get['product_id'];
        $product_info = $this->db->query('SELECT t1.product_id,t2.hot_name,t2.desc,t1.add_date,t3.price,t2.`name`,t3.image,t1.product_name from sl_blackfive_product t1 LEFT JOIN sl_blackfive_product_desc t2 ON t1.product_id=t2.product_id LEFT JOIN sl_product t3 ON t1.product_id=t3.product_id where t1.product_id ='.(int) $product_id)->row;
        $data['product_id'] = $product_info['product_id'];
        $data['name'] = empty($product_info['name']) ? $product_info['product_name'] : $product_info['name'];
        //$data['image'] = fopen($product_info['image'],'r') ? $product_info['image'] : $this->model_tool_image->resize($product_info['image']);
        $data['image'] = $product_info['image'];
        $data['hot_name'] = $product_info['hot_name'];
        $data['add_date'] = date('m/d H:i',strtotime($product_info['add_date']));
        $data['desc'] = html_entity_decode($product_info['desc'], ENT_QUOTES, 'UTF-8');
        $data['href'] = $this->url->link('product/wapproduct', 'product_id=' . $product_id);
        $data['price'] = sprintf("%.2f", $product_info['price']);
        
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/activity/product_desc.tpl', $data));
    }
}