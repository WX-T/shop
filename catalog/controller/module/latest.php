<?php
class ControllerModuleLatest extends Controller {
	public function index($setting) {
		$this->load->language('module/latest');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
        $data['flag'] = Param::$flag;
		$data['products'] = array();

		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => $setting['status'],
			'limit' => $setting['limit'],
		);
		$str = '';
		foreach($setting['product'] as $k=>$v) {
			$str .= $k.',';
		}
		$ids = rtrim($str,',');
		//获取商品信息
		$results = $this->model_catalog_product->getProductProductIds($ids , $filter_data);
		//如果moduls有图片的话就用moduls内的图片
		foreach ($results as $k=> &$v) {
			if($setting['product'][$k]['image']){
				$v['image'] = $setting['product'][$k]['image'];
			}
		}
		if ($results) {
		    $i = 0;
			foreach ($results as $result) {
			    //判断图片
		        if ($result['image']) {
		            $image = $this->model_tool_image->resize($result['image']);
		        } else {
		            $image = $this->model_tool_image->resize('placeholder.png');
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
				if(isset($this->session->data['wishlist'])){
				    if (in_array($result['product_id'], $this->session->data['wishlist'])) {
				        $is_addwish = true;
				    } else {
				        $is_addwish = false;
				    }  
				}else{
				    $is_addwish = false;
				}

				$this->tariff = new Tariff();
				$product_tariff = $this->tariff->calculateGoods($result['special'] ? $result['special'] : $result['price']  , $result['hscode'] , $result['taxrate']);
				$product_tariff = $result['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
				
				$data['products'][] = array(
				    'tariff'      => $product_tariff,
				    'is_addwish'  => $is_addwish,
					'product_id'  => $result['product_id'],
					'manufacturer'=> $result['manufacturer'],
				    'manufacturer_href'=> $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['meta_description'], ENT_QUOTES, 'UTF-8')), 0, 190),
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/wapproduct', 'product_id=' . $result['product_id']),
				    'source'      => strtolower(trim($result['source'])) ? strtolower(trim($result['source'])) : 'amazon',
				);
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/latest.tpl', $data);
			} else {
				return $this->load->view('default/template/module/latest.tpl', $data);
			}
		}
	}
}