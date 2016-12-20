<?php
class ControllerModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/featured');

		//$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_title'] = $setting['name'];
        
		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		if(isset($this->session->data['token'])){
		    $data['cart'] = $this->url->link('checkout/cart', 'token=' . $this->session->data['token'], 'SSL');
		}else{
		    $data['cart'] = $this->url->link('checkout/cart');
		}

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}
        $data['order'] = isset($setting['order']) ? $setting['order'] : '1';
        $data['title'] = isset($setting['title']) ? $setting['title'] : '';
        $data['describe'] = isset($setting['describe']) ? $setting['describe'] : '';
		if (!empty($setting['product'])) {
		   
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);
			foreach ($products as $product_id) {
			    
			    $productId = isset($product_id['id']) ? $product_id['id'] : $product_id;
				$product_info = $this->model_catalog_product->getProduct($productId);
				if ($product_info) {
// 				    if(isset($product_id['image']) && $product_id['image']){
// 				        $image = $this->model_tool_image->resize($product_id['image'], $product_id['width'], $product_id['height']);
// 				    }else{
//     					if ($product_info['image']) {
//     						$image = $this->model_tool_image->resize($product_info['image'], $product_id['width'], $product_id['height']);
//     					} else {
//     						$image = $this->model_tool_image->resize('placeholder.png', $product_id['width'], $product_id['height']);
//     					}
// 				    }
				    if(isset($product_id['image']) && $product_id['image']){
				        $image = $this->model_tool_image->resize($product_id['image']);
				    }else{
				        if ($product_info['image']) {
				            $image = $this->model_tool_image->resize($product_info['image']);
				        } else {
				            $image = $this->model_tool_image->resize('placeholder.png', $product_id['width'], $product_id['height']);
				        }
				    }
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}
					
					if($setting['name'] != 'HOT'){
					    $product_id['chinese'] = '';
					    $product_id['english'] = '';
					}
					//if(isset($products))
					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
					    'chinese'     => $product_id['chinese'],
					    'english'     => $product_id['english'],
						'meta_description'=>$product_info['meta_description'],
						'name'        => $product_info['name'],
					    'meta_title'  => $product_info['meta_title'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
					    'dprice'      => "$".(sprintf("%.2f", $product_info['price']/DOLLAR_RATE)),
						'special'     => $special,
					    'dspecial'    => "$".(sprintf("%.2f", $product_info['special']/DOLLAR_RATE)),
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/wapproduct', 'product_id=' . $product_info['product_id']),
					    'source'      => strtolower(trim($product_info['source'])) ? strtolower(trim($product_info['source'])) : 'amazon',
					                 
					);
				}
			}
		}
		if(isset($setting['images'])){
		    foreach ($setting['images'] as $images){
		        //$images['image'] = $this->model_tool_image->resize($images['image'], 310, 420);
		        $images['image'] = $this->model_tool_image->resize($images['image']);
		        $imgArr[intval($images['sort_order'])] = $images;
		    }
		    ksort($imgArr);
		    $data['images'] = $imgArr;
		}else{
		    $data['images'] = array();
		}
		if ($data['products']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
			} else {
				return $this->load->view('default/template/module/featured.tpl', $data);
			}
		}
	}
}