<?php
class ControllerModuleCategory extends Controller {
	public function index() {
		$this->load->language('module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		
		$data['categories'] = array();
		$categories = $this->model_catalog_category->getCategories(0);
		foreach ($categories as $category) {
			$children_data = array();

			//if ($category['category_id'] == $data['category_id']) {
				/* $children = $this->model_catalog_category->getCategories($category['category_id']);
				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);
                    $chcate = $this->model_catalog_category->getCategories($child['category_id']);
                    $ch_data = array();
                    foreach ($chcate as $ch){
                        $ch_data[] = array(
                            'category_id' => $ch['category_id'],
                            'name' => $ch['name'],
                            'href' => $this->url->link('product/categorylist', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' .$ch['category_id'] ),
                            'image'=> $category['image']
                            
                        );
                    }
					$children_data[] = array(
					    'recommend'=> unserialize($child['recommend']),
						'category_id' => $child['category_id'], 
						'name' => $child['name'],// . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''), 
						'href' => $this->url->link('product/categorylist', 'path=' . $category['category_id'] . '_' . $child['category_id']),
					    'image'=> $category['image'],
					    'children' =>  $ch_data
					);
				} */
			//}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);
			/* if($category['recommend']){
			    $recommend = unserialize($category['recommend']);
			    $recomArr = array();
			    if($recommend){
    			    foreach ($recommend as $recom){
    			        $recom['href'] = $this->model_tool_image->resize($recom['image'], 85, 70);
    			        $recomArr[intval($recom['sort_order'])] = $recom;
    			    }
			    }
			    ksort($recomArr);
			    $recommend = $recomArr;
			}else{
			    $recommend = array();
			} */
			
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],// . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				//'children'    => $children_data,
			    'image'       => $category['image'],
			    //'recommend'   => $recommend,
				'href'        => $this->url->link('product/categorylist', 'path=' . $category['category_id'])
			);
		}
		$this->load->model('design/layout');;
		if (isset($this->request->get['route'])) {
		    $route = (string)$this->request->get['route'];
		} else {
		    $route = 'common/home';
		}
		
		$layout_id = 0;
		
		
		if (!$layout_id) {
		    $layout_id = $this->model_design_layout->getLayout($route);
		}
		
		if (!$layout_id) {
		    $layout_id = $this->config->get('config_layout_id');
		}
		
		
		$this->load->model('extension/module');
		
		$data['modules'] = '';
		
		$modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_top');
	    foreach ($modules as $module) {
			$part = explode('.', $module['code']);
			if(isset($part[0]) && $part[0] == 'html'){
    			if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
    				$data['modules'] = $this->load->controller('module/' . $part[0]);
    			}
    			
    			if (isset($part[1])) {
    				$setting_info = $this->model_extension_module->getModule($part[1]);
    				
    				if ($setting_info && $setting_info['status']) {
    					$data['modules'] = $this->load->controller('module/' . $part[0], $setting_info);
    				}
    			}
			}
		}
		
		$this->load->model('catalog/manufacturer');
		
		$filter_data = array(
		    'sort'               => 'm.sort_order',
			'order'              => 'ASC',
			'start'              => 0,
			'limit'              => 18
		);
		$manufacturers = $this->model_catalog_manufacturer->getManufacturers($filter_data);
		foreach ($manufacturers as &$manufacturer){
		    $manufacturer['href'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']);
		}
		$data['manufacturers'] = $manufacturers;
		$data['more_manufacturers'] = $this->url->link('product/manufacturer');
		$data['search'] = $this->load->controller('common/search');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/category.tpl', $data);
		} else {
			return $this->load->view('default/template/module/category.tpl', $data);
		}
	}
}