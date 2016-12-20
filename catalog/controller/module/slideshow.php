<?php
class ControllerModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
		
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);
		foreach ($results as $result) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'])
				);
		}
		// Menu
		$this->load->model('catalog/category');
		
		$this->load->model('catalog/product');
		
		$data['categories'] = array();
		
		$categories = $this->model_catalog_category->getCategories(0);
		
		foreach ($categories as $category) {
		    if ($category['top']) {
		        // Level 2
		        $children_data = array();
		
		        $children = $this->model_catalog_category->getCategories($category['category_id']);
		
		        foreach ($children as $child) {
		            $filter_data = array(
		                'filter_category_id'  => $child['category_id'],
		                'filter_sub_category' => true
		            );
		
		            $children_data[] = array(
		                'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
		                'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
		            );
		        }
		
		        // Level 1
		        $data['categories'][] = array(
		            'name'     => $category['name'],
		            'children' => $children_data,
		            'column'   => $category['column'] ? $category['column'] : 1,
		            'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
		        );
		    }
		}
		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = ltrim($this->load->controller('common/cart'));
		// For page specific css
		if (isset($this->request->get['route'])) {
		    if (isset($this->request->get['product_id'])) {
		        $class = '-' . $this->request->get['product_id'];
		    } elseif (isset($this->request->get['path'])) {
		        $class = '-' . $this->request->get['path'];
		    } elseif (isset($this->request->get['manufacturer_id'])) {
		        $class = '-' . $this->request->get['manufacturer_id'];
		    } else {
		        $class = '';
		    }
		
		    $data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
		    $data['class'] = 'common-home';
		}
		
		$this->load->model('extension/module');
		
		$setting_info = $this->model_extension_module->getModule(30);
		
		if ($setting_info && $setting_info['status']) {
		    $category  = $this->load->controller('module/category', $setting_info);
		}
		$data['category'] = $category;
		$data['module'] = $module++;
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshow.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/slideshow.tpl', $data);
		} else {
			return $this->load->view('default/template/module/slideshow.tpl', $data);
		}
	}
}