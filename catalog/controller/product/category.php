<?php
class ControllerProductCategory extends Controller {
	public function index() {
		$this->load->language('product/category');

		$this->load->model('catalog/manufacturer');
		
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if(isset($this->session->data['wishlist'])){
			$wishlist = $this->session->data['wishlist'];
        }else{
			$wishlist = array();
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['start_price']) && floatval($this->request->get['start_price'])) {
		    $start_price = floatval($this->request->get['start_price']);
		} else {
		    $start_price = '';
		}
		
		if (isset($this->request->get['end_price']) && floatval($this->request->get['end_price'])) {
		    $end_price = floatval($this->request->get['end_price']);
		} else {
		    $end_price = '';
		}
		
		if (isset($this->request->get['order'])) {
		    $order = $this->request->get['order'];
		} else {
		    $order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_product_limit');
		}
		$data['thisurl'] =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$data['breadcrumbs'] = array();

		$data['flag'] = Param::$flag;
		$data['breadcrumbs'][] = array(
			'text' => '首页',
			'href' => $this->url->link('common/home')
		);
		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = $partArr = explode('_', (string)$this->request->get['path']);
			
			$category_id = (int)array_pop($parts);
			
			if(count($partArr)>1){
			    $cateIds = (int)$parts[0];
			}else{
			    $cateIds = $category_id;
			}
			
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);
              
				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
			$cateIds = 0;
		}
		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->document->setTitle($category_info['meta_title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path']), 'canonical');
			$data['heading_title'] = $category_info['name'];

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_complex'] = $this->language->get('text_complex');
			$data['text_sale'] = $this->language->get('text_sale');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');
			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			} else {
				$data['thumb'] = '';
			}
            
			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');
			$url = '';
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$data['brands'] = array();
			$brandsArr = $this->model_catalog_manufacturer->getCategoryManufacturer($category_id);
// 			var_dump($brandsArr);
			foreach ($brandsArr as $brand) {
			    $data['brands'][] = array(
			        'name'  => $brand['name'],
			        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] .'&brand=' . $brand['manufacturer_id'] . $url)
			    );
			}
			$pathStr = '';
			$parts = explode('_', (string)$this->request->get['path']);
			if(count($parts)>1){
			    $pathStr = (int)$parts[0];
			}else{
			    $pathStr = (int)array_pop($parts);
			}
			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($cateIds);
			
			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);
				$data['categories'][] = array(
					'name'  => $result['name'], // . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
					'href'  => $this->url->link('product/category', 'path=' . $pathStr . '_' . $result['category_id'] . $url),
				    'path'  => $pathStr . '_' . $result['category_id'],
				);
			}
			$data['products'] = array();
			$brandId = '';
			if (isset($this->request->get['brand'])) {
			    $brandId = $this->request->get['brand'];
			}
			
			$data['brandId'] = $brandId;
		    //查询父分类下所有子分类的商品
		    $categorys = $this->model_catalog_category->getCcategorys($category_id);
			$filter_data = array(
			    'filter_manufacturer_id'=> $brandId,
				'filter_category_id' => $categorys,
				'filter_filter'      => $filter,
			    'start_price'        => $start_price,
			    'end_price'          => $end_price,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
			
			$results = $this->model_catalog_product->getProducts($filter_data);
			foreach ($results as $result) {
				foreach($wishlist as $k=>$v){
					if($v==$result['product_id']){
						$result['wishlist'] = true;
					}
				}
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 300, 300);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 300, 300);
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
		
				$this->tariff = new Tariff();
    			$product_tariff = $this->tariff->calculateGoods($result['special'] ? $result['special'] : $result['price']  , $result['hscode'] , $result['taxrate']);
    			$product_tariff = $result['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				//处理价格
				if($special){
					$money = $special;
				}else{
					$money = $price;
				}
				$stylemoney = explode('.',$money);
				if(!isset($result['wishlist'])){
					$result['wishlist'] = false;
				}
				
				$data['products'][] = array(  
				    'tariff'      => $product_tariff,
					'wishlist'    => $result['wishlist'],
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'money'       => $stylemoney,
					'tax'         => $tax,
				    'min_price'   => sprintf("%.2f", $result['min_price']),
				    'max_price'   => sprintf("%.2f", $result['max_price']),
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/wapproduct', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
				    'source'      => strtolower(trim($result['source'])) ? strtolower(trim($result['source'])) : 'amazon',
				);
			}
        
			
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
			if(isset($this->request->get['path'])){
			    $data['path']  = $this->request->get['path'];
			}else{
			    $data['path'] = '';
			}
			//当前排序规则
			if(isset($this->request->get['sort'])){
				$data['rule'] = $this->request->get['sort'];
			}else{
				$data['rule'] = 0;
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			//最新排序
			$data['date_added'] = array(
				'text' => 'text_date_added',
				'value' => 'p.date_added-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.date_added&order=DESC' . $url)
			);

			//综合排序		
			$data['colligate'] = array(
				'text'  => $this->language->get('text_default_asc'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default_desc'),
				'value' => 'p.sort_order-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=DESC' . $url)
			);

// 			$data['sorts'][] = array(
// 				'text'  => $this->language->get('text_name_asc'),
// 				'value' => 'pd.name-ASC',
// 				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
// 			);

// 			$data['sorts'][] = array(
// 				'text'  => $this->language->get('text_name_desc'),
// 				'value' => 'pd.name-DESC',
// 				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
// 			);

			//高价排序
			$data['costliness'] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			//低价
			$data['lowpric'] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);
			
			//高销量
			$data['bsales'] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			//低销量
			$data['ssales'] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);
			
			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}



			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['brand'])) {
			    $url .= '&brand=' . $this->request->get['brand'];
			}
			
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['start_price'])) {
			    $url .= '&start_price=' . $this->request->get['start_price'];
			}
				
			if (isset($this->request->get['end_price'])) {
			    $url .= '&end_price=' . $this->request->get['end_price'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$data['pageinfo'] = ['limit'=>$limit,'total'=>$product_total];
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
            $data['url'] = $this->url->link('product/category/page','path='.$this->request->get['path'].$url.'&page=');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['start_price'] = $start_price;
			$data['end_price'] = $end_price;
			$data['limit'] = $limit;
			$data['continue'] = $this->url->link('common/home');
			 
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
				'href' => $this->url->link('product/category', $url)
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
	
	//分页
    	public function Page(){
    	   
    	    $this->load->language('product/category');
    	    
    	    $this->load->model('catalog/manufacturer');
    	    
    	    $this->load->model('catalog/category');
    	    
    	    $this->load->model('catalog/product');
    	    
    	    $this->load->model('tool/image');
    	    
    	    if (isset($this->request->get['filter'])) {
    	        $filter = $this->request->get['filter'];
    	    } else {
    	        $filter = '';
    	    }
    	    
    	    if(isset($this->session->data['wishlist'])){
    	        $wishlist = $this->session->data['wishlist'];
    	    }else{
    	        $wishlist = array();
    	    }
    	    
    	    if (isset($this->request->get['sort'])) {
    	        $sort = $this->request->get['sort'];
    	    } else {
    	        $sort = 'p.sort_order';
    	    }
    	    
    	    if (isset($this->request->get['order'])) {
    	        $order = $this->request->get['order'];
    	    } else {
    	        $order = 'ASC';
    	    }
    	    
    	    if (isset($this->request->get['start_price']) && floatval($this->request->get['start_price'])) {
    	        $start_price = floatval($this->request->get['start_price']);
    	    } else {
    	        $start_price = '';
    	    }
    	    
    	    if (isset($this->request->get['end_price']) && floatval($this->request->get['end_price'])) {
    	        $end_price = floatval($this->request->get['end_price']);
    	    } else {
    	        $end_price = '';
    	    }
    	    
    	    if (isset($this->request->get['order'])) {
    	        $order = $this->request->get['order'];
    	    } else {
    	        $order = 'ASC';
    	    }
    	    
    	    if (isset($this->request->get['page'])) {
    	        $page = $this->request->get['page'];
    	    } else {
    	        $page = 1;
    	    }
    	    
//     	    var_dump($this->request->get['limit']);
    	    if (isset($this->request->get['limit'])) {
    	        $limit = $this->request->get['limit'];
    	    } else {
    	        $limit = $this->config->get('config_product_limit');
    	    }
    	    
    	    if (isset($this->request->get['path'])) {
    	        $url = '';
    	    
    	        if (isset($this->request->get['sort'])) {
    	            $url .= '&sort=' . $this->request->get['sort'];
    	        }
    	    
    	        if (isset($this->request->get['order'])) {
    	            $url .= '&order=' . $this->request->get['order'];
    	        }
    	    
    	        if (isset($this->request->get['limit'])) {
    	            $url .= '&limit=' . $this->request->get['limit'];
    	        }
    	    
    	        $path = '';
    	    
    	        $parts = $partArr = explode('_', (string)$this->request->get['path']);
    	        	
    	        $category_id = (int)array_pop($parts);
    	        	
    	        if(count($partArr)>1){
    	            $cateIds = (int)$parts[0];
    	        }else{
    	            $cateIds = $category_id;
    	        }
    	        	
    	        foreach ($parts as $path_id) {
    	            if (!$path) {
    	                $path = (int)$path_id;
    	            } else {
    	                $path .= '_' . (int)$path_id;
    	            }
    	    
    	            $category_info = $this->model_catalog_category->getCategory($path_id);
    	    
    	            if ($category_info) {
    	                $data['breadcrumbs'][] = array(
    	                    'text' => $category_info['name'],
    	                    'href' => $this->url->link('product/category', 'path=' . $path . $url)
    	                );
    	            }
    	        }
    	    } else {
    	        $category_id = 0;
    	        $cateIds = 0;
    	    }
    	    $category_info = $this->model_catalog_category->getCategory($category_id);
    	    
    	    if ($category_info) {
    	        // Set the last category breadcrumb
    	        $url = '';
    	        if (isset($this->request->get['filter'])) {
    	            $url .= '&filter=' . $this->request->get['filter'];
    	        }
    	    
    	        if (isset($this->request->get['sort'])) {
    	            $url .= '&sort=' . $this->request->get['sort'];
    	        }
    	    
    	        if (isset($this->request->get['order'])) {
    	            $url .= '&order=' . $this->request->get['order'];
    	        }
    	        	
    	        if (isset($this->request->get['limit'])) {
    	            $url .= '&limit=' . $this->request->get['limit'];
    	        }
    	        	
    	        	
    	        $brandsArr = $this->model_catalog_manufacturer->getCategoryManufacturer($category_id);
    	        	
    	        $pathStr = '';
    	        $parts = explode('_', (string)$this->request->get['path']);
    	        if(count($parts)>1){
    	            $pathStr = (int)$parts[0];
    	        }else{
    	            $pathStr = (int)array_pop($parts);
    	        }
    	    
    	        $results = $this->model_catalog_category->getCategories($cateIds);
    	    
    	        $data['products'] = array();
    	        //查询父分类下所有子分类的商品
    	        $categorys = $this->model_catalog_category->getCcategorys($category_id);
    	        $filter_data = array(
    	            'filter_category_id' => $categorys,
    	            'filter_filter'      => $filter,
    	            'start_price'        => $start_price,
    	            'end_price'          => $end_price,
    	            'sort'               => $sort,
    	            'order'              => $order,
    	            'start'              => ($page - 1) * $limit,
    	            'limit'              => $limit
    	        );
    	        $product_total = $this->model_catalog_product->getTotalProducts($filter_data);
    	    
    	        $results = $this->model_catalog_product->getProducts($filter_data);
    	    
    	        foreach ($results as $result) {
    	            foreach($wishlist as $k=>$v){
    	                if($v==$result['product_id']){
    	                    $result['wishlist'] = true;
    	                }
    	            }
    	            if ($result['image']) {
    	                $image = $this->model_tool_image->resize($result['image'], 300, 300);
    	            } else {
    	                $image = $this->model_tool_image->resize('placeholder.png', 300, 300);
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
    	    
    	            $this->tariff = new Tariff();
    	            $product_tariff = $this->tariff->calculateGoods($result['special'] ? $result['special'] : $result['price']  , $result['hscode'] , $result['taxrate']);
    	            $product_tariff = $result['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
    	    
    	            if ($this->config->get('config_review_status')) {
    	                $rating = (int)$result['rating'];
    	            } else {
    	                $rating = false;
    	            }
    	    
    	            //处理价格
    	            if($special){
    	                $money = $special;
    	            }else{
    	                $money = $price;
    	            }
    	            $stylemoney = explode('.',$money);
    	            if(!isset($result['wishlist'])){
    	                $result['wishlist'] = false;
    	            }
    	    
    	    
    	            $data['products'][] = array(
    	                'tariff'      => $product_tariff,
    	                'wishlist'    => $result['wishlist'],
    	                'product_id'  => $result['product_id'],
    	                'thumb'       => $image,
    	                'name'        => $result['name'],
    	                'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
    	                'price'       => $price,
    	                'min_price'   => sprintf("%.2f",$result['min_price']),
    	                'max_price'   => sprintf("%.2f",$result['max_price']),
    	                'special'     => $special,
    	                'money'       => $stylemoney,
    	                'tax'         => $tax,
    	                'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
    	                'rating'      => $result['rating'],
    	                'href'        => $this->url->link('product/wapproduct', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
    	                'source'      => strtolower(trim($result['source'])) ? strtolower(trim($result['source'])) : 'amazon',
    	                
    	            );
    	        }
    	    
    	        $this->response->addHeader('Content-Type: application/json');
    	        $this->response->setOutput(json_encode($data['products']));
    	        
    	    } 
    	       
    	}
 }