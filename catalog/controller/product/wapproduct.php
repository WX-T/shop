<?php
class ControllerProductWapproduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('product/product');
        $data['thisurl'] = $this->url->link('product/wapproduct','product_id= '.$this->request->get['product_id']);
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['flag'] = Param::$flag;
		//显示商品详情
        if(isset($this->request->get['showodescript'])){
            echo '<!DOCTYPE html>
            <html>
        	<head>
        		<meta charset="UTF-8">
        		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        		<title>商品详情</title>
        	</head>
        	<body>';
            $product_id = $this->request->get['product_id'];
            $this->load->model('catalog/product');
            $descript = $this->model_catalog_product->getDescription($product_id);
            echo $str = html_entity_decode($descript['description'], ENT_QUOTES, 'UTF-8');
            echo "</body></html>";
            exit;
        }
        $data['home'] = $this->url->link('common/waphome');
		$this->load->model('catalog/category');

		if (isset($this->request->get['path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);
			
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path)
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
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

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
				);
			}
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->get['manufacturer_id'])) {

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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
			if ($manufacturer_info) {
				$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
				);
			}
		}

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('product/search', $url)
			);
		}
		$this->load->model('catalog/product');
		//查询是否来自亚马逊
		if($this->request->get['search'] ||  $this->request->get['sort'] || $this->request->get['path'] || $this->request->get['is_serach'] || $this->request->get['manufacturer_id']){
		    //父商品
		    $sourc = $this->model_catalog_product->getProduct($this->model_catalog_product->parentProduct_id($this->request->get['product_id']));
		}else{
		    //子商品
		    $sourc = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}
		$sc = strtolower(trim($sourc['source'])) ? strtolower(trim($sourc['source'])) : 'amazon';
		if($sc=='amazon'){
		    if (isset($this->request->get['product_id'])) {
		        if($this->request->get['sort'] || $this->request->get['search'] || $this->request->get['path'] || $this->request->get['is_serach'] || $this->request->get['manufacturer_id']){
		            //判断来源，ture为父商品
		            $data['opurl'] = $this->url->link('product/wapproduct','product_id='.$this->request->get['product_id'].'&is_serach= ture');
		            $product_id = (int)$this->request->get['product_id'];
		        }else{
		            //子商品
		            $productmsg = $this->model_catalog_product->getParent_id($this->request->get['product_id']);
		            $product_id = (int)$productmsg['parent_id'];
		            $this->request->get['product_id'] = $productmsg['parent_id'];
		            $data['opurl'] = $this->url->link('product/wapproduct','product_id='.$this->request->get['product_id'].'&is_serach= ture');
		        }
		    } else {
		        $product_id = 0;
		        $data['opurl'] = $this->url->link('product/wapproduct','product_id= '.$this->request->get['product_id']);
		    }
		    //判断有无options值
		    if($this->request->get['options']){
		        $options = explode('-', $this->request->get['options']);
		        $option = array();
		        $selectOption = array();
		        foreach ($options as $k=>$v){
		            if($v){
		                $option_name = explode('=', $v);
		                //根据选项名查询选项ID
		                $optionDate = $this->model_catalog_product->getOptionId($option_name[0]);
		                $option[$k]['option_id'] = $optionDate['option_id'];
		                $option[$k]['value'][0]['option_value_id'] = $option_name[1];
		                $selectOption[$k]['option_id'] = $optionDate['option_id'];
		                $selectOption[$k]['option_value_id'] = $option_name[1];
		            }
		        }
		    }else{
		        //根据父ID查询选项和值
		        $option = array();
		        $optionname = $this->model_catalog_product->getParentOptionNames($product_id);
		        foreach ($optionname as $key=>$opt){
		            $option[$key]['name'] = $opt['name'];
		            $option[$key]['option_id'] = $opt['option_id'];
		            $option[$key]['value'] = $this->model_catalog_product->getParentOptionValues($product_id,$opt['option_id']);
		        }
		        $selectOption[$k]['option_id'] = $option[0]['option_id'];
		        $selectOption[$k]['option_value_id'] = $option[1]['value'][0]['option_value_id'];
		    }
		    if($selectOption){
		        $data['selectOption'] = $selectOption;
		    }else{
		        $data['selectOption'] = '';
		    }
		    
		    $optionname = $this->model_catalog_product->getParentOptionNames($product_id);
		    foreach ($optionname as $key=>$opt){
		        $optionInfo[$key]['name'] = $opt['name'];
		        $optionInfo[$key]['option_id'] = $opt['option_id'];
		        $optionInfo[$key]['value'] = $this->model_catalog_product->getParentOptionValues($product_id,$opt['option_id']);
		    }
		    //print_r($optionInfo);exit;
		    if(count($option)==1){
		        //一条选项
		        $last = array();
		        $last['option_id'] = $option[0]['option_id'];
		        $last['value_id'] = $option[0]['value'][0]['option_value_id'];
		        $option_product = $this->model_catalog_product->getOptionProduct($option[0]['option_id'],$option[0]['value'][0]['option_value_id'],$product_id);
		    }elseif (count($option)==2 || count($option)==3){
		        $last = array();
		        $last[0]['option_id'] = $option[0]['option_id'];
		        $last[0]['value_id'] = $option[0]['value'][0]['option_value_id'];
		        $last[1]['option_id'] = $option[1]['option_id'];
		        $last[1]['value_id'] = $option[1]['value'][0]['option_value_id'];
		        //获取商品ID
		        $option_product = $this->model_catalog_product->getOptionsProduct($last[0]['option_id'],$last[0]['value_id'],$last[1]['option_id'],$last[1]['value_id'],$product_id);
		        if(!$option_product){
		            //根据选项查询商品
		            $last = array();
		            $last[0]['option_id'] = $option[0]['option_id'];
		            $last[0]['value_id'] = $option[0]['value'][2]['option_value_id'];
		            $last[1]['option_id'] = $option[1]['option_id'];
		            $last[1]['value_id'] = $option[1]['value'][3]['option_value_id'];
		            $option_product = $this->model_catalog_product->getOptionsProduct($last[0]['option_id'],$last[0]['value_id'],$last[1]['option_id'],$last[1]['value_id'],$product_id);
		        }
		        //组合选项
		        $otherOption[$option[1]['option_id']] = $OtherOptions = $this->model_catalog_product->getOtherOptions($option[0]['option_id'],$option[0]['value'][0]['option_value_id']);
		        $otherOption[$option[0]['option_id']] = $OtherOptions = $this->model_catalog_product->getOtherOptions($option[1]['option_id'],$option[1]['value'][0]['option_value_id']);
		    
		        $data['OtherOptions'] = $otherOption;
		    }
		}else{
		    if($this->request->get['search'] || $this->request->get['sort'] || $this->request->get['path'] || $this->request->get['is_serach'] || $this->request->get['manufacturer_id']){
		        //判断来源，ture为父商品
		        $option_product['product_id'] = $this->model_catalog_product->parentProduct_id($this->request->get['product_id']);
		    }else{
		        //子商品
		        $option_product['product_id'] = $this->request->get['product_id'];
		    }
		}
		$product_info = $this->model_catalog_product->getProduct($option_product['product_id']);
		if ($product_info) {
			$url = '';
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => '商品详情',
				'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id'])
			);

			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');

			$data['heading_title'] = $product_info['name'];
			$data['logged'] = $this->customer->isLogged();
			$data['text_select'] = $this->language->get('text_select');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_stock'] = $this->language->get('text_stock');
			$data['text_discount'] = $this->language->get('text_discount');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_write'] = $this->language->get('text_write');
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_related'] = $this->language->get('text_related');
			$data['text_loading'] = $this->language->get('text_loading');

			$data['entry_qty'] = $this->language->get('entry_qty');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');
			$data['entry_captcha'] = $this->language->get('entry_captcha');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_upload'] = $this->language->get('button_upload');
			$data['button_continue'] = $this->language->get('button_continue');
			
			if(!isset($this->session->data['wishlist'])){
			    $this->session->data['wishlist'] = array();
			}
            
			if (in_array($product_id, $this->session->data['wishlist'])) {
			    $data['is_addwish'] = true;
			} else {
			    $data['is_addwish'] = false;
			}
			$this->load->model('catalog/review');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_attribute'] = $this->language->get('tab_attribute');
			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$option_product['product_id'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['detailed'] = $product_info['detailed'];
			$this->load->model('tool/image');
			$data['mimage'] = $this->model_tool_image->resize($product_info['mimage']);
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];

			$this->load->library('tariff');
		     
			$this->tariff = new Tariff();
			
			$product_tariff = $this->tariff->calculateGoods($product_info['special'] ? $product_info['special'] : $product_info['price']  , $product_info['hscode'] , $product_info['taxrate']);
			$product_tariff = $product_info['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
			$data['product_tariff'] = $product_tariff;
			
			if($product_info['quantity']<=0){
				$data['stocknum'] = '库存不足';
			}else{
				$data['stocknum'] = $product_info['quantity'];
			}


			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$data['popup'] = '';
			}
			$data['images'] = array();
		
			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
				$data['thumb_big'] = $this->model_tool_image->resize($product_info['image'], intval($this->config->get('config_image_popup_width'))*2, intval($this->config->get('config_image_popup_height'))*2);
				$data['images'][] = array(
				    'thumb' => $this->model_tool_image->resize($product_info['image'], 110 , 110),
				    'big' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width') , $this->config->get('config_image_popup_height')),
				    'zoom_big' => $this->model_tool_image->resize($product_info['image'], intval($this->config->get('config_image_popup_width'))*2, intval($this->config->get('config_image_popup_height'))*2)
				);
			} else {
				$data['thumb'] = '';
			}

			$results = $this->model_catalog_product->getProductImages($option_product['product_id']);
			foreach ($results as $result) {
				$data['images'][] = array(
					'thumb' => $this->model_tool_image->resize($result['image'], 110 , 110),
				    'big' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width') , $this->config->get('config_image_popup_height')),
				    'zoom_big' => $this->model_tool_image->resize($result['image'], intval($this->config->get('config_image_popup_width'))*2, intval($this->config->get('config_image_popup_height'))*2)
				);
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				$data['dprice'] = "$".(sprintf("%.2f", $product_info['price']/DOLLAR_RATE));
			} else {
				$data['price'] = false;
				$data['dprice'] = false;
			}

			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				$data['dspecial'] = "$".(sprintf("%.2f", $product_info['special']/DOLLAR_RATE));
			} else {
				$data['special'] = false;
				$data['dspecial'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
			} else {
				$data['tax'] = false;
			}

				//处理价格
				if($data['special']){
					$money = $data['special'];
				}else{
					$money = $data['price'];
				}
				$stylemoney = explode('.',$money);
				$data['money'] = $stylemoney;
			$discounts = $this->model_catalog_product->getProductDiscounts($option_product['product_id']);
			
			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}

			
			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFullName();
			} else {
				$data['customer_name'] = '';
			}
			$data['goodsid'] = $option_product['product_id'];
			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
			if($product_info['length'] && $product_info['width'] && $product_info['height']){
    			$data['attribute_groups'][] = array(
    				'attribute_group_id' => '0',
    				'name'               => '包装后尺寸(英寸)',
    				'attribute'          => array(array(
    				                        'name'=> '包装后尺寸(英寸)',
					                        'text'=> sprintf('%.2f' , $product_info['width'])."x".sprintf('%.2f' , $product_info['length'])."x".sprintf('%.2f' , $product_info['height'])
    				                    ))
    			);
			}
			if($product_info['weight']){
			    $data['attribute_groups'][] = array(
			    				'attribute_group_id' => '0',
			    				'name'               => '包装后重量(镑)',
			    				'attribute'          => array(array(
			    				    'name'=> '包装后重量(镑)',
			    				    'text'=> sprintf('%.2f' , $product_info['weight'])
			    				))
			    );
			}
			$data['source'] = strtolower(trim($product_info['source'])) ? strtolower(trim($product_info['source'])) : 'amazon';
			
			$data['options'] = $optionInfo;



// 			var_dump($data['options'][0]['product_option_value']);die();
// 			print_r($data['attribute_groups']);die();
			$data['products'] = array();
			$results = $this->model_catalog_product->getProductRelated($option_product['product_id']);
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
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
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
            

				$data['products'][] = array(
				    'tariff'      => $product_tariff,
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => sprintf("%.2f", $price),
					'special'     => sprintf("%.2f", $special),
					'money'		  => $stylemoney,
					'tax'         => sprintf("%.2f", $tax),
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
// 			var_dump($data);die();
			$data['tags'] = array();
			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);
			$this->model_catalog_product->updateViewed($option_product['product_id']);
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/product.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/product.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function review() {
		$this->load->language('product/product');

		$this->load->model('catalog/review');

		$data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['reviews'] = array();

		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['reviews'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/review.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/review.tpl', $data));
		}
	}
	
	public function getprice(){
	    if(isset($this->request->post['product_id'])){
	        $this->load->model('catalog/product');
	        $product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);
	        $price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
	        $option_price = 0;
	        if(isset($this->request->post['option'])){
	            foreach ($this->request->post['option'] as $option){
	                $option_value = $this->model_catalog_product->getOptionValue($option);
	                if ($option_value['price_prefix'] == '+') {
	                    $option_price += $option_value['price'];
	                } elseif ($option_value['price_prefix'] == '-') {
	                    $option_price -= $option_value['price'];
	                }
	            }
	        }
	        $price = $this->currency->format($price + $option_price);
	        //处理价格
	        $stylemoney = explode('.',$price);
	        $json = array('info'=>array('price'=>$price , 'totalmoney'=>$stylemoney));
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}

	public function getRecurringDescription() {
		$this->language->load('product/product');
		$this->load->model('catalog/product');

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->post['recurring_id'])) {
			$recurring_id = $this->request->post['recurring_id'];
		} else {
			$recurring_id = 0;
		}

		if (isset($this->request->post['quantity'])) {
			$quantity = $this->request->post['quantity'];
		} else {
			$quantity = 1;
		}

		$product_info = $this->model_catalog_product->getProduct($product_id);
		$recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

		$json = array();

		if ($product_info && $recurring_info) {
			if (!$json) {
				$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year'),
				);

				if ($recurring_info['trial_status'] == 1) {
					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
					$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
				} else {
					$trial_text = '';
				}

				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));

				if ($recurring_info['duration']) {
					$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				} else {
					$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				}

				$json['success'] = $text;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function write() {
		$this->load->language('product/product');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

			if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
				$json['error'] = $this->language->get('error_captcha');
			}

			unset($this->session->data['captcha']);

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');

				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function buymustknow(){
	    $data['special'] = array();
	    $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/shoppingnotice.tpl', $data));
	}
}
