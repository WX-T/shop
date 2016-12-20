<?php
class ControllerModulehotsale extends Controller {
	public function index($setting) {
		$this->load->language('module/hotsale');
		$this->load->model('tool/image');
		$data['heading_title'] = isset($setting['name']) ? $setting['name'] : $this->language->get('heading_title');
		$data['title_url'] = $setting['title_url'];
		$data['text_tax'] = $this->language->get('text_tax');
        $data['title_img'] = $this->model_tool_image->resize(isset($setting['title_img']) ? $setting['title_img'] : '');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		$filter_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);
		if(isset($setting['product']) && is_array($setting['product'])){
		    $productIds = implode(',', $setting['product']);
		}else{
		    $productIds = '';
		}
		$data['flag'] = Param::$flag;
		$results = $this->model_catalog_product->getProductProductIds($productIds ,$filter_data);
		//if ($results) {
			foreach ($results as $result) {
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

				if ((float)$result['hotsale']) {
					$hotsale = $this->currency->format($this->tax->calculate($result['hotsale'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$hotsale = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['hotsale'] ? $result['hotsale'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'hotsale'     => $hotsale,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/wapproduct', 'product_id=' . $result['product_id']),
				    'source'      => strtolower(trim($result['source'])) ? strtolower(trim($result['source'])) : 'amazon',
				);
			}
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/hotsale.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/hotsale.tpl', $data);
			} else {
				return $this->load->view('default/template/module/hotsale.tpl', $data);
			}
		//}
	}
}