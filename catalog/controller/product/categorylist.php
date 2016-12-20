<?php
/**
 *
 * 根据父分类path获取字分类名和商品信息
 *
 */
class ControllerProductCategorylist extends Controller {
    public function index(){
        /**
		 *
		 * 获取所有分类
		 * @var unknown
		 */
		// Menu
		$this->load->model('catalog/category');
			
		$this->load->model('catalog/product');
		$data['url'] = $this->url->link('product/wapsearch');
		$data['list'] = array();
		$data['urlpath'] = $this->request->get['path'];
		$list = $this->model_catalog_category->getCategories();
		foreach ($list as $category) {
		    if (!$category['top']) {
		        // Level 2
		       // $children_data = array();
		        	
		        //$children = $this->model_catalog_category->getCategories($category['category_id']);
		        	
		       /*  foreach ($children as $child) {
		            $filter_data = array(
		                'filter_category_id'  => $child['category_id'],
		                'filter_sub_category' => true
		            );
		            	
		            $children_data[] = array(
		                'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
		                'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
		            );
		        } */
		        	 
		        // Level 1
		        $data['list'][] = array(
		            'name'     => $category['name'],
		            //'children' => $children_data,
		            'column'   => $category['column'] ? $category['column'] : 1,
		            'href'     => $this->url->link('product/category', 'path=' . $category['category_id']),
		            'path'     => $category['category_id'],
		        );
		    }
		}
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/categorylist.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/categorylist.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/categorylist.tpl', $data));
		}
    }
    public function getChild(){
        //查询子分类
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/manufacturer');
        $this->load->model('tool/image');
        $list = array();
        if($this->request->get['path']=='manufacturer'){
            //查询品牌
            $list['results'] = $this->model_catalog_manufacturer->getManufacturers();
            foreach ($list['results'] as &$v){
                if ($v['image']) {
                    $image = $this->model_tool_image->resize($v['image']);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png');
                }
                $v['image'] = $image;
                $v['href'] = $this->url->link('product/wapmanufacturer/info', 'manufacturer_id=' . $v['manufacturer_id']);
            }
        }else{
            $children = $this->model_catalog_category->getCategories($this->request->get['path']);
            foreach ($children as $k=>$category){
                $child = $this->model_catalog_category->getCategories($category['category_id']);
                foreach($child as $key=>&$v){
                    $counts = $this->model_catalog_category->getEnabledGoodsCount($v['category_id']);
                    if($counts>0){
                        $goods = $this->model_catalog_category->getgoods($v['category_id']);
                        if($goods){
                            if ($v['image']) {
                                $image = $this->model_tool_image->resize($v['image']);
                            } else {
                                $image = $this->model_tool_image->resize('placeholder.png');
                            }
                            $v['href'] = $this->url->link('product/category', 'path=' . $this->request->get['path'].'_'.$category['category_id'].'_'.$v['category_id']);
                            $v['image'] = $image;
                        }else{
                            $v='';
                        }
                    }else{
                        unset($child[$key]['name']);
                    }
                }
                $list[] = array(
                    'name' => $category['name'],
                    'category_id'=>$category['category_id'],
                    'child' => $child,
                );
            }
        }
        
      
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($list));
    }
    
}