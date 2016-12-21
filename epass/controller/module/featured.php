<?php
class ControllerModuleFeatured extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/featured');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		    if(isset($this->request->post['images'])){
		        foreach ($this->request->post['images'] as $key=>$img){
		            if(!$img['image']){
		                unset($this->request->post['images'][$key]);
		            }
		        }
		    }

			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('featured', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_product'] = $this->language->get('help_product');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/featured', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/featured', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/featured', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/featured', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['describe'])) {
			$data['describe'] = $this->request->post['describe'];
		} elseif (!empty($module_info)) {
			$data['describe'] = $module_info['describe'];
		} else {
			$data['describe'] = '';
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['title'])) {
		    $data['title'] = $this->request->post['title'];
		} elseif (!empty($module_info)) {
		    $data['title'] = $module_info['title'];
		} else {
		    $data['title'] = '';
		}

		$this->load->model('catalog/product');
		
		$data['products'] = array();
		
		if (isset($this->request->post['product'])) {
			$products = $this->request->post['product'];
		} elseif (!empty($module_info)) {
			$products = $module_info['product'];
		} else {
			$products = array();
		}	
		$this->load->model('tool/image');
		
		foreach ($products as $product_id) {
		    $productId = isset($product_id['id']) ? $product_id['id'] : $product_id;
			$product_info = $this->model_catalog_product->getProduct($productId);
			if(!$module_info['name']){
			    $module_info['chinese'] = '';
			    $module_info['english'] = '';
			}
			
			if(!isset($module_info['chinese'])){
			    $module_info['chinese'] = '';
			}
			if(!isset($module_info['english'])){
			    $module_info['english'] = '';
			}
			
			if ($product_info) {
				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
				    'image_thumb' => isset($product_id['image']) && $product_id['image'] ? $this->model_tool_image->resize($product_id['image'], 100, 100) : $this->model_tool_image->resize($product_info['image'], 100, 100),
				    'image'      => isset($product_id['image']) && $product_id['image'] ? $product_id['image'] : $product_info['image'],
				    'name'       => $product_info['name'],
				    'width'       => isset($product_id['width']) && $product_id['width'] ? $product_id['width'] : $module_info['width'],
				    'height'       => isset($product_id['height']) && $product_id['height'] ? $product_id['height'] : $module_info['height'],
				    'chinese'    => isset($product_id['chinese']) && $product_id['chinese'] ? $product_id['chinese']:$module_info['chinese'],
				    'english'    => isset($product_id['english']) && $product_id['english'] ? $product_id['english']:$module_info['english'],
				);
			}
		}
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}	
				
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}	
			
		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}		
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		if (isset($this->request->post['images'])) {
		    $imageArr = array();
		    foreach ($this->request->post['images'] as $image){
		        $image['thumb'] = $this->model_tool_image->resize($image['image'], 100, 100);
		        $imageArr[] = $image;
		    }
		    $data['images'] = $imageArr;
		    
		    
		} elseif (!empty($module_info) && isset($module_info['images'])) {
		    $imageArr = array();
		    foreach ($module_info['images'] as $image){
		        $image['thumb'] = $this->model_tool_image->resize($image['image'], 100, 100);
		        $imageArr[] = $image;
		    }
		    $data['images'] = $imageArr;
		} else {
		    $data['images'] = array();
		}
		//print_r($data['images']);die();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/featured.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/featured')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		
		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		
		return !$this->error;
	}
}