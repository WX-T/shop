<?php
class ControllerModuleBestSeller extends Controller {
	public function index($setting) {
		$this->load->language('module/bestseller');

		$data['heading_title'] = isset($setting['name']) ? $setting['name'] : $this->language->get('heading_title');
    
		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		if(isset($this->session->data['wishlist'])){
			$wishlist = $this->session->data['wishlist'];
        }else{
			$wishlist = array();
		}
		$data['products'] = array();

		$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);
		if ($results) {
			foreach ($results as $result) {
				foreach($wishlist as $k=>$v){
					if($v==$result['product_id']){
						$result['wishlist'] = true;
					}
				}
				
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				if(!isset($result['wishlist'])){
					$result['wishlist'] = false;
				
				}
				if(isset($this->session->data['wishlist'])){
				    if (in_array($result['product_id'], $this->session->data['wishlist'])) {
				        $is_addwish = true;
				    } else {
				        $is_addwish = false;
				    }
				}else{
				    $is_addwish = false;
				}
				
				
				$sales =$this->model_catalog_product->getSales($result['product_id']);
				$data['products'][] = array(
				    'is_addwish'  => $is_addwish,
				    'sales'       => $sales['sales'],
					'wishlist'    => $result['wishlist'],
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/wapproduct', 'product_id=' . $result['product_id']),
				);
			}
			//var_dump($data);exit;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/bestseller.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/bestseller.tpl', $data);
			} else {
				return $this->load->view('default/template/module/bestseller.tpl', $data);
			}
		}
	}
}