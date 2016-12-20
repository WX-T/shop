<?php
class ControllerProductWapSearch extends Controller {
	public function index() {
		$this->load->language('product/search');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		}
		/* if(empty($search)){
		    //$this->searchPage();
		    $this->load->model('catalog/search');
			$this->response->redirect($this->url->link('product/wapsearch/searchpage', '', 'SSL'));
			exit;
		} */
		//插入搜索记录
		if($search && isset($this->session->data['customer_id'])){
		    $this->load->model('catalog/search');
		    $this->model_catalog_search->addSearchHistory($this->session->data['customer_id'],$search);
		}
		
		$data['flag'] = Param::$flag;
		$data['search'] = $search;
		if(isset($this->session->data['wishlist'])){
		    $wishlist = $this->session->data['wishlist'];
		}else{
		    $wishlist = array();
		}
		
		if (isset($this->request->get['tag'])) {
			$tag = $this->request->get['tag'];
		} elseif (isset($this->request->get['search'])) {
			$tag = $this->request->get['search'];
		} else {
			$tag = '';
		}

		if (isset($this->request->get['description'])) {
			$description = $this->request->get['description'];
		} else {
			$description = '';
		}

		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}

		if (isset($this->request->get['sub_category'])) {
			$sub_category = $this->request->get['sub_category'];
		} else {
			$sub_category = '';
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
		
		if (isset($this->request->get['start_price'])) {
			$start_price = $this->request->get['start_price'];
		} else {
			$start_price = '';
		}
		
		if (isset($this->request->get['end_price'])) {
			$end_price = $this->request->get['end_price'];
		} else {
			$end_price = '';
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

		if (isset($this->request->get['search'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['search']);
		} elseif (isset($this->request->get['tag'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		//$data['url'] = $this->url->link('product/wapsearch');
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$url = '';

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/wapsearch', $url)
		);

		if (isset($this->request->get['search'])) {
			$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['search'];
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}
		
		
		$data['url'] = $this->url->link('product/wapsearch/page','path='.$this->request->get['path'].$url.'&page=');
		
		
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_search'] = $this->language->get('text_search');
		$data['text_keyword'] = $this->language->get('text_keyword');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_sub_category'] = $this->language->get('text_sub_category');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');

		$data['entry_search'] = $this->language->get('entry_search');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['button_search'] = $this->language->get('button_search');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');
		$this->tariff = new Tariff();
		$data['compare'] = $this->url->link('product/compare');

		$this->load->model('catalog/category');

		// 3 Level Category Search
		$data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['category_id'],
						'name'        => $category_3['name'],
					);
				}

				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);
			}

			$data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}

		$data['products'] = array();

		if (isset($search) || isset($this->request->get['tag'])) {
			$filter_data = array(
				'filter_name'         => $search,
				'filter_tag'          => $tag,
				'filter_description'  => $description,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => $sub_category,
			    'start_price'        => $start_price,
			    'end_price'          => $end_price,
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
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
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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
				$product_tariff = $this->tariff->calculateGoods($result['special'] ? $result['special'] : $result['price']  , $result['hscode'] , $result['taxrate']);
				$product_tariff = $result['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
				
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
					'href'        => $this->url->link('product/wapproduct', 'product_id=' . $result['product_id'] . $url),
				    'source'      => strtolower(trim($result['location'])) ? strtolower(trim($result['location'])) : 'amazon',
				);
			}

			$url = '';
            $data['thistitle'] = $this->request->get['search'];
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();
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
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('product/wapsearch', '&sort=p.date_added&order=DESC' . $url)
			);

			//综合排序
			$data['colligate'] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.sort_order&order=ASC' . $url)
			);
			
			//综合排序倒序
			$data['colligatedesc'] = array(
			    'text'  => $this->language->get('text_default'),
			    'value' => 'p.sort_order-ASC',
			    'href'  => $this->url->link('product/wapsearch', 'sort=p.sort_order&order=DESC' . $url)
			);
			
			//高价排序
			$data['costliness'] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.price&order=ASC' . $url)
			);
			$data['home'] = $this->url->link('common/home','','SSL');
			$data['mycart'] = $this->url->link('checkout/cart','','SSL');
			//低价
			$data['lowpric'] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.price&order=DESC' . $url)
			);

			//高销量
			$data['bsales'] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/wapsearch', 'sort=rating&order=ASC' . $url)
				);
			//低销量
			$data['ssales'] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/wapsearch', 'sort=rating&order=DESC' . $url)
				);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/wapsearch', 'sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/wapsearch', 'sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/wapsearch', 'sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/wapsearch', 'sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/wapsearch', 'sort=p.model&order=DESC' . $url)
			);

			$url = '';
			

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));
            
			sort($limits);
			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/wapsearch', $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
			$data['pageurl'] = $this->url->link('product/wapsearch/page', $url . '&page=');
			$pagination->url = $this->url->link('product/wapsearch', $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
		}
		$data['search'] = $search;
		$data['description'] = $description;
		$data['category_id'] = $category_id;
		$data['sub_category'] = $sub_category;

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['start_price'] = $start_price;
		$data['end_price'] = $end_price;
		$data['limit'] = $limit;
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
		}
	}
	
	//分页
	public function Page(){
	    $this->load->language('product/search');
	    
	    $this->load->model('catalog/category');
	    
	    $this->load->model('catalog/product');
	    
	    $this->load->model('tool/image');
	    
	    if (isset($this->request->get['search'])) {
	        $search = $this->request->get['search'];
	    } else {
	        $search = '';
	    }
	    
	    if(isset($this->session->data['wishlist'])){
	        $wishlist = $this->session->data['wishlist'];
	    }else{
	        $wishlist = array();
	    }
	    
	    if (isset($this->request->get['tag'])) {
	        $tag = $this->request->get['tag'];
	    } elseif (isset($this->request->get['search'])) {
	        $tag = $this->request->get['search'];
	    } else {
	        $tag = '';
	    }
	    
	    if (isset($this->request->get['description'])) {
	        $description = $this->request->get['description'];
	    } else {
	        $description = '';
	    }
	    
	    if (isset($this->request->get['category_id'])) {
	        $category_id = $this->request->get['category_id'];
	    } else {
	        $category_id = 0;
	    }
	    
	    if (isset($this->request->get['sub_category'])) {
	        $sub_category = $this->request->get['sub_category'];
	    } else {
	        $sub_category = '';
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
	    
	    if (isset($this->request->get['start_price'])) {
	        $start_price = $this->request->get['start_price'];
	    } else {
	        $start_price = '';
	    }
	    
	    if (isset($this->request->get['end_price'])) {
	        $end_price = $this->request->get['end_price'];
	    } else {
	        $end_price = '';
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
	    
	    if (isset($this->request->get['search'])) {
	        $this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['search']);
	    } elseif (isset($this->request->get['tag'])) {
	        $this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
	    } else {
	        $this->document->setTitle($this->language->get('heading_title'));
	    }
	    
	    
	    $url = '';
	    
	    if (isset($this->request->get['search'])) {
	        $url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
	    }
	    
	    if (isset($this->request->get['tag'])) {
	        $url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
	        'text' => $this->language->get('heading_title'),
	        'href' => $this->url->link('product/wapsearch', $url)
	    );
	    
	    if (isset($this->request->get['search'])) {
	        $data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['search'];
	    } else {
	        $data['heading_title'] = $this->language->get('heading_title');
	    }
	    $this->tariff = new Tariff();
	    
	    $this->load->model('catalog/category');
	    
	    // 3 Level Category Search
	    $data['categories'] = array();
	    
	    $categories_1 = $this->model_catalog_category->getCategories(0);
	    
	    foreach ($categories_1 as $category_1) {
	        $level_2_data = array();
	    
	        $categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
	    
	        foreach ($categories_2 as $category_2) {
	            $level_3_data = array();
	    
	            $categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
	    
	            foreach ($categories_3 as $category_3) {
	                $level_3_data[] = array(
	                    'category_id' => $category_3['category_id'],
	                    'name'        => $category_3['name'],
	                );
	            }
	    
	            $level_2_data[] = array(
	                'category_id' => $category_2['category_id'],
	                'name'        => $category_2['name'],
	                'children'    => $level_3_data
	            );
	        }
	    
	        $data['categories'][] = array(
	            'category_id' => $category_1['category_id'],
	            'name'        => $category_1['name'],
	            'children'    => $level_2_data
	        );
	    }
	    
	    $data['products'] = array();
	    
	    if (isset($search) || isset($this->request->get['tag'])) {
	        $filter_data = array(
	            'filter_name'         => $search,
	            'filter_tag'          => $tag,
	            'filter_description'  => $description,
	            'filter_category_id'  => $category_id,
	            'filter_sub_category' => $sub_category,
	            'start_price'        => $start_price,
	            'end_price'          => $end_price,
	            'sort'                => $sort,
	            'order'               => $order,
	            'start'               => ($page - 1) * $limit,
	            'limit'               => $limit
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
	                $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
	            } else {
	                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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
	            //关税
	            $product_tariff = $this->tariff->calculateGoods($result['special'] ? $result['special'] : $result['price']  , $result['hscode'] , $result['taxrate']);
	            $product_tariff = $result['hscode'] ? $this->currency->format($product_tariff)/*.$this->tariff->getTariffSuff($product_tariff)*/ : '';
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
	                'href'        => $this->url->link('product/wapproduct', 'product_id=' . $result['product_id'] . $url),
	                'source'      => strtolower(trim($result['source'])) ? strtolower(trim($result['source'])) : 'amazon',
	            );
	        }
	    
	    }
	    
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($data['products']));
	}
	
	public function searchPage(){
	    $data['header'] = $this->load->controller('common/wapheader');
	    $data['url'] = $this->url->link('product/wapsearch');
	    $data['searchurl'] = $this->url->link('product/wapsearch/autocomplete');
	    
	    if(isset($this->session->data['customer_id'])){
	        $this->load->model('catalog/search');
	        //获取搜索记录
	        $data['history'] =  $this->model_catalog_search->getSearchHistory($this->session->data['customer_id']);
	    }
	    $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/searchPage.tpl', $data));
	}
	/**
	 * 自动获取商品名
	 */
	public function autocomplete() {
	    $json = array();
	
	    if (isset($this->request->get['filter_name'])) {
	        $this->load->model('catalog/product');
	        $data = $this->model_catalog_product->getProductName($this->request->get['filter_name']);
	    }
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($data));
	}
}