<?php
class ControllerProductManufacturer extends Controller {
	public function index() {
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_index'] = $this->language->get('text_index');
		$data['text_empty'] = $this->language->get('text_empty');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => $this->url->link('product/manufacturer')
		);

		

		$data['categories'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers();
		foreach ($results as $result) {

			

			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0 - 9';
			}else{
				/* if (preg_match("/[\x7f-\xff]/", $result['name'][0])) { //判断第一个字母是否为中文 
					$key= $this->getFirstCharter($result['name']);		//取出第一个汉字的字母
				}else{ */
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
				//}
			}

			if (!isset($data['categories'][$key])) {
				$data['categories'][$key]['name'] = $key;
			}

			if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 265, 265);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 265, 265);
				}
				
			$data['categories'][$key]['manufacturer'][] = array(
				'name' => $result['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),

				'image' =>$image
			);
		}

		//var_dump($data);

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/manufacturer_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/manufacturer_list.tpl', $data));
		}
	}

	//获取中文品牌名的首字母
	public function getFirstCharter($str){  
		if(empty($str)){return '';}  
		$fchar=ord($str{0});  
		if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});  
		$s1=iconv('UTF-8','gb2312',$str);  
		$s2=iconv('gb2312','UTF-8',$s1);  
		$s= $s2==$str?$s1:$str;  
		$asc=ord($s{0})*256+ord($s{1})-65536;  
		if($asc>=-20319&&$asc<=-20284) return 'A';  
		if($asc>=-20283&&$asc<=-19776) return 'B';  
		if($asc>=-19775&&$asc<=-19219) return 'C';  
		if($asc>=-19218&&$asc<=-18711) return 'D';  
		if($asc>=-18710&&$asc<=-18527) return 'E';  
		if($asc>=-18526&&$asc<=-18240) return 'F';  
		if($asc>=-18239&&$asc<=-17923) return 'G';  
		if($asc>=-17922&&$asc<=-17418) return 'H';  
		if($asc>=-17417&&$asc<=-16475) return 'J';  
		if($asc>=-16474&&$asc<=-16213) return 'K';  
		if($asc>=-16212&&$asc<=-15641) return 'L';  
		if($asc>=-15640&&$asc<=-15166) return 'M';  
		if($asc>=-15165&&$asc<=-14923) return 'N';  
		if($asc>=-14922&&$asc<=-14915) return 'O';  
		if($asc>=-14914&&$asc<=-14631) return 'P';  
		if($asc>=-14630&&$asc<=-14150) return 'Q';  
		if($asc>=-14149&&$asc<=-14091) return 'R';  
		if($asc>=-14090&&$asc<=-13319) return 'S';  
		if($asc>=-13318&&$asc<=-12839) return 'T';  
		if($asc>=-12838&&$asc<=-12557) return 'W';  
		if($asc>=-12556&&$asc<=-11848) return 'X';  
		if($asc>=-11847&&$asc<=-11056) return 'Y';  
		if($asc>=-11055&&$asc<=-10247) return 'Z';  
		return null;  
   }  


	public function info() {
	    
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
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

		//品牌下所有商品url
		$data['goodslist'] = $this->url->link('product/manufacturer/info');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if(isset($this->request->get['category']) && $this->request->get['category']){
		    $this->load->model('catalog/category');
		    $categoryInfo = $this->model_catalog_category->getCategory($this->request->get['category']);
		    if($categoryInfo){
    		    $data['breadcrumbs'][] = array(
    		        'text' => $categoryInfo['name'],
    		        'href' => $this->url->link('product/category' , 'path=' . $categoryInfo['category_id'])
    		    );
    		    $data['category'] = trim($this->request->get['category']);
		    }
		}else{
		    $data['breadcrumbs'][] = array(
		        'text' => $this->language->get('text_brand'),
		        'href' => $this->url->link('product/manufacturer')
		    );
		}

		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

		if ($manufacturer_info) {
			$this->document->setTitle($manufacturer_info['name']);
			$this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']), 'canonical');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
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
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			if(isset($this->request->get['manufacturer_id'])){
			    $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $manufacturer_info['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url),
				'detailed'=>$manufacturer_info['detailed']
			);


			$data['heading_title'] = $manufacturer_info['name'];
			$data['detailed'] = $manufacturer_info['detailed'];

			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
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

			$data['compare'] = $this->url->link('product/compare');

			$data['manufacturer_id'] = $manufacturer_id;
			
			$data['route'] = 'product/manufacturer/info';

			$data['products'] = array();

			$filter_data = array(
				'filter_manufacturer_id' => $manufacturer_id,
				'sort'                   => $sort,
				'order'                  => $order,
			    'start_price'            => $start_price,
			    'end_price'              => $end_price,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);
            
			
			
			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
			//所有品牌
			$data['brands'] = $this->model_catalog_manufacturer->getManufacturers();

			$results = $this->model_catalog_product->getProducts($filter_data);
		    $data['flag'] = Param::$flag;
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
                   //预计关税
				$this->tariff = new Tariff();
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


			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if(isset($this->request->get['page'])){
				$url .= '&page='.$this->request->get['page'];
			}
			//当前排序规则
			if(isset($this->request->get['sort'])){
				$data['rule'] = $this->request->get['sort'];
			}else{
				$data['rule'] = 0;
			}


			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC' . $url)
			);

			//高价排序
			$data['costliness'] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id']. '&sort=p.price&order=ASC' . $url)
			);

			//低价排序
			$data['lowpric'] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id']. '&sort=p.price&order=DESC' . $url)
			);

			//高销量
			$data['bsales'] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']. '&sort=rating&order=ASC' . $url)
				);
			//低销量
			$data['ssales'] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id']. '&sort=rating&order=DESC' . $url)
				);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/manufacturer/info'. 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC' . $url)
			);

			//综合排序
			$data['colligate'] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id']. 'sort=p.sort_order&order=ASC' . $url)
			);

			//最新排序
			$data['date_added'] = array(
				'text' => 'text_date_added',
				'value' => 'p.date_added-ASC',
				'href'  => $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.date_added&order=DESC' . $url)
			);


			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

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
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['start_price'])) {
			    $url .= '&start_price=' . $this->request->get['start_price'];
			}
			
			if (isset($this->request->get['end_price'])) {
			    $url .= '&end_price=' . $this->request->get['end_price'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			if(isset($this->request->get['category']) && $this->request->get['category']){
			    $url.="&category=".$this->request->get['category'];
			}

			
			$data['url'] = $this->url->link('product/manufacturer/page','manufacturer_id='.$this->request->get['manufacturer_id'].$url.'&page=');
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] .  $url . '&page={page}');

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

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
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
				'href' => $this->url->link('product/manufacturer/info', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
	
	public function page(){
	    $this->load->language('product/manufacturer');
	    
	    $this->load->model('catalog/manufacturer');
	    
	    $this->load->model('catalog/product');
	    
	    $this->load->model('tool/image');
	    
	    if (isset($this->request->get['manufacturer_id'])) {
	        $manufacturer_id = (int)$this->request->get['manufacturer_id'];
	    } else {
	        $manufacturer_id = 0;
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
	    
	    //品牌下所有商品url
	    $data['goodslist'] = $this->url->link('product/manufacturer/info');
	    
	    $data['breadcrumbs'] = array();
	    
	    $data['breadcrumbs'][] = array(
	        'text' => $this->language->get('text_home'),
	        'href' => $this->url->link('common/home')
	    );
	    
	    if(isset($this->request->get['category']) && $this->request->get['category']){
	        $this->load->model('catalog/category');
	        $categoryInfo = $this->model_catalog_category->getCategory($this->request->get['category']);
	        if($categoryInfo){
	            $data['breadcrumbs'][] = array(
	                'text' => $categoryInfo['name'],
	                'href' => $this->url->link('product/category' , 'path=' . $categoryInfo['category_id'])
	            );
	            $data['category'] = trim($this->request->get['category']);
	        }
	    }else{
	        $data['breadcrumbs'][] = array(
	            'text' => $this->language->get('text_brand'),
	            'href' => $this->url->link('product/manufacturer')
	        );
	    }
	    
	    $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
	    
	    if ($manufacturer_info) {
	        $this->document->setTitle($manufacturer_info['name']);
	        $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']), 'canonical');
	    
	        $url = '';
	    
	        if (isset($this->request->get['sort'])) {
	            $url .= '&sort=' . $this->request->get['sort'];
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
	            $url .= '&order=' . $this->request->get['order'];
	        }
	    
	        if (isset($this->request->get['page'])) {
	            $url .= '&page=' . $this->request->get['page'];
	        }
	    
	        if (isset($this->request->get['limit'])) {
	            $url .= '&limit=' . $this->request->get['limit'];
	        }
	        
	        if (isset($this->request->get['manufacturer_id'])) {
	            $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
	        }
	        
	        $data['breadcrumbs'][] = array(
	            'text' => $manufacturer_info['name'],
	            'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url),
	            'detailed'=>$manufacturer_info['detailed']
	        );
	    
	        $data['products'] = array();
	    
	        $filter_data = array(
	            'filter_manufacturer_id' => $manufacturer_id,
	            'sort'                   => $sort,
	            'order'                  => $order,
	            'start_price'            => $start_price,
	            'end_price'              => $end_price,
	            'start'                  => ($page - 1) * $limit,
	            'limit'                  => $limit
	        );
	    
	        	
	        	
	        $product_total = $this->model_catalog_product->getTotalProducts($filter_data);
	        //所有品牌
	        $data['brands'] = $this->model_catalog_manufacturer->getManufacturers();
	    
	        $results = $this->model_catalog_product->getProducts($filter_data);
	        $data['flag'] = Param::$flag;
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
	            //预计关税
	            $this->tariff = new Tariff();
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
}