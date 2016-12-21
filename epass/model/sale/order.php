<?php
class ModelSaleOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT c.fullname FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			if ($order_query->row['affiliate_id']) {
				$affiliate_id = $order_query->row['affiliate_id'];
			} else {
				$affiliate_id = 0;
			}

			$this->load->model('marketing/affiliate');

			$affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

			if ($affiliate_info) {
				$affiliate_fullname = $affiliate_info['fullname'];
			} else {
				$affiliate_fullname = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';
				$language_directory = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'customer'                => $order_query->row['customer'],
				'customer_group_id'       => $order_query->row['customer_group_id'],
				'fullname'               => $order_query->row['fullname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => unserialize($order_query->row['custom_field']),
				'payment_fullname'       => $order_query->row['payment_fullname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address'       => $order_query->row['payment_address'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => unserialize($order_query->row['payment_custom_field']),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_fullname'      => $order_query->row['shipping_fullname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address'      => $order_query->row['shipping_address'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
			    'shipping_agents'         => $order_query->row['shipping_agents'],
			    'assbillno'               => $order_query->row['assbillno'],
			    'ship_price'              => $order_query->row['ship_price'], 
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => unserialize($order_query->row['shipping_custom_field']),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'shipping_telephone'      => $order_query->row['shipping_telephone'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'affiliate_fullname'     => $affiliate_fullname,
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified'],
			    'city_id'                 => $order_query->row['city_id'],
			    'logistics'               => $order_query->row['logistics'],
			    'trackingno'              => $order_query->row['trackingno'],
			    'expressno'               => $order_query->row['expressno'],
			);
		} else {
			return;
		}
	}

	public function getOrders($data = array()) {
		$seq = "SELECT o.merchant_id,o.line_id,o.tacking_status,o.order_id,o.center_orderno,o.shipping_agents,o.expressno, o.fullname AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.shipping_code, o.declartype , o.total, o.currency_code,o.currency_value,o.telephone,o.shipping_agents,o.assbillno,o.ship_price, o.date_added, o.date_modified,o.trackingno,o.order_status_id FROM `" . DB_PREFIX . "order` o";
		$where = ' WHERE 1=1';
		if (!empty($data['filter_party_order'])) {
		    $sql .= " AND o.order_id IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE party_order_no = '" . trim($data['filter_party_order']) . "')";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		
		if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
		    $sql .= " AND o.declartype = '" . $data['filter_order_declartype'] . "'";
		}
		
		if (!empty($data['filter_center_orderno'])) {
		    $sql .= " AND o.center_orderno like '%" . $data['filter_center_orderno'] . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND o.fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_customer_telephone'])) {
		    $sql .= " AND o.telephone = '" . $data['filter_customer_telephone'] . "'";
		}
		
		if (!empty($data['filter_customer_expressno'])) {
		    $sql .= " AND o.expressno = '" . $data['filter_customer_expressno'] . "'";
		}
		
		if (!empty($data['filter_line_id'])) {
		    $sql .= " AND o.line_id = '" . $data['filter_line_id'] . "'";
		}
		
		if(!empty($data['filter_party_assbillno'])){
		    $sql .= " AND o.order_id IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE party_assbillno like '%" . trim($data['filter_party_assbillno']) . "%')";
		}
		
		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}
		
		if (!empty($data['filter_start_time'])) {
		    $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
		}
		
		if($data['merchant_id'] >0){
		    $sql .= " AND o.merchant_id = '" . $data['merchant_id'] . "' AND o.is_split='1'";
		}
		
	   if (!empty($data['filter_end_time'])) {
			$sql .= " AND DATE(o.date_modified) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
		}
		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		
		if (isset($data['filter_order_status'])) {
		    if($data['filter_order_status']=='backproduct'){
		       $seq = "select o.order_id,o.fullname AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.shipping_code, o.declartype , o.total, o.currency_code,o.currency_value,o.telephone,o.shipping_agents,o.assbillno,o.ship_price, o.date_added, o.date_modified,o.trackingno,o.order_status_id from sl_order o where (order_status_id='11' OR (select count(*) from sl_order_product where order_id=o.order_id and refund='1')>0)"; 
		       $where = '';
		    }else{
		        $implode = array();
		        
		        $order_statuses = explode(',', $data['filter_order_status']);
		        foreach ($order_statuses as $order_status_id) {
		            $implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
		        }
		        
		        if ($implode) {
		            $sql .= " AND (" . implode(" OR ", $implode) . ")";
		        } else {
		        
		        }
		    }
		    
		} else {
		    $sql .= " AND o.order_status_id > '0'";
		}
		
		$sort_data = array(
			'o.order_id',
			'customer',
			'status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 2;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($seq.$where.$sql);
		//echo $seq.$where.$sql;exit;
// 		var_dump($sql);die();
		return $query->rows;
	}

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT op.*,p.source,p.out_url FROM " . DB_PREFIX . "order_product op," . DB_PREFIX . "product p WHERE p.product_id=op.product_id and order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOption($order_id, $order_option_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_option_id = '" . (int)$order_option_id . "'");

		return $query->row;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderVoucherByVoucherId($voucher_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
	    $seq = "SELECT count(*) AS total FROM `" . DB_PREFIX . "order` o";
		$where = ' WHERE 1=1';
		if (!empty($data['filter_party_order'])) {
		    $sql .= " AND o.order_id IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE party_order_no = '" . trim($data['filter_party_order']) . "')";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		
		if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
		    $sql .= " AND o.declartype = '" . $data['filter_order_declartype'] . "'";
		}
		
		if (!empty($data['filter_center_orderno'])) {
		    $sql .= " AND o.center_orderno like '%" . $data['filter_center_orderno'] . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND o.fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}
		
		if (!empty($data['filter_customer_telephone'])) {
		    $sql .= " AND o.telephone = '" . $data['filter_customer_telephone'] . "'";
		}
		
		if (!empty($data['filter_customer_expressno'])) {
		    $sql .= " AND o.expressno = '" . $data['filter_customer_expressno'] . "'";
		}
		
		if (!empty($data['filter_line_id'])) {
		    $sql .= " AND o.line_id = '" . $data['filter_line_id'] . "'";
		}

		if(!empty($data['filter_party_assbillno'])){
		    $sql .= " AND o.order_id IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE party_assbillno = '" . trim($data['filter_party_assbillno']) . "')";
		}
		
		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}
		
		if (!empty($data['filter_start_time'])) {
		    $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
		}
		
		if($data['merchant_id'] > 0){
		    $sql .= " AND o.merchant_id = '" . $data['merchant_id'] . "' AND o.is_split='1'";
		}
	   if (!empty($data['filter_end_time'])) {
			$sql .= " AND DATE(o.date_modified) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
		}
		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}
		if (isset($data['filter_order_status'])) {
		    if($data['filter_order_status']=='backproduct'){
		       $seq = "select count(*) AS total from sl_order o where (order_status_id='11' OR (select count(*) from sl_order_product where order_id=o.order_id and refund='1')>0)"; 
		       $where = '';
		    }else{
		        $implode = array();
		        
		        $order_statuses = explode(',', $data['filter_order_status']);
		        foreach ($order_statuses as $order_status_id) {
		            $implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
		        }
		        
		        if ($implode) {
		            $sql .= " AND (" . implode(" OR ", $implode) . ")";
		        } else {
		        
		        }
		    }
		    
		} else {
		    $sql .= " AND o.order_status_id > '0'";
		}
		//echo $seq.$where.$sql;exit;
		$query = $this->db->query($seq.$where.$sql);
		return $query->row['total'];
	}

	public function getTotalOrdersByStoreId($store_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByProcessingStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_processing_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode));

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByCompleteStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode) . "");

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByLanguageId($language_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByCurrencyId($currency_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function createInvoiceNo($order_id) {
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['invoice_no']) {
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

			if ($query->row['invoice_no']) {
				$invoice_no = $query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

			return $order_info['invoice_prefix'] . $invoice_no;
		}
	}

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}

	public function getEmailsByProductsOrdered($products, $start, $end) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);

		return $query->rows;
	}

	public function getTotalEmailsByProductsOrdered($products) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

		return $query->row['total'];
	}
	
	
	public function confirmBuy($order_id,$o_product_id , $party_order_no , $party_price,$comment = '', $notify = false){
	    if(!$o_product_id ) return false;
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set confirm_buy='1',party_order_no='". trim($party_order_no) ."',party_price='". trim($party_price) ."' where order_product_id='".$o_product_id."'");
	    $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '". $order_id ."', order_status_id = '3', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	    return true;
	}
	
	public function editBuy($order_id,$o_product_id,$party_order_no,$party_price ,$party_assbillno){
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set party_order_no = '" . trim($party_order_no) . "' , party_price = '" . $party_price . "' , party_assbillno = '" . trim($party_assbillno) . "' where order_product_id = '" . $o_product_id . "'");
	}
	
	public function getBuy($o_product_id){
	    $query = $this->db->query("SELECT party_order_no , party_price , party_assbillno FROM `" . DB_PREFIX . "order_product`  where order_product_id = '" . $o_product_id . "'");
	    return $query->rows[0];
	}
	
	public function outOfStock($o_product_id){
	    if(!$o_product_id) return false;
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set outofstock='1' where order_product_id='".$o_product_id."'");
	    return true;
	}
	
	public function refund($o_product_id){
	    if(!$o_product_id) return false;
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set refund='1' where order_product_id='".$o_product_id."'");
	    return true;
	}
	
	
	public function isOrderDeal($order_id){
	    $query = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."' and confirm_buy='1'");
	    $nNums = $query->row['cnts'];
	    if($nNums == '0'){
	        $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='22' where order_id='".$order_id."'");
	        $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','22','".date("Y-m-d H:i:s")."')");
	        return '缺货退款中';
	    }else{
	        return '部分备货';
	    }
	}
	
	public function isOutOrderGoods($order_id){
	    $query1 = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."'");
	    $nums = $query1->row['cnts'];
	    $query2 = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."' and outofstock='1' AND refund='1'");
	    $fundNums = $query2->row['cnts'];
	    $query3 = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."' and outofstock='1'");
	    $outNums = $query3->row['cnts'];
	    $this->db->query("update `" . DB_PREFIX . "order` date_modified = NOW() where order_id='".$order_id."'");
	    if($fundNums == $nums){
	        $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='11',date_modified = NOW() where order_id='".$order_id."'");
	        $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','11','".date("Y-m-d H:i:s")."')");
	        return '已退款';
	    }else{
	        $query = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."' and confirm_buy='1'");
	        $nNums = $query->row['cnts'];
	        if($nNums>0 && $nNums!=$nums && ($nNums+$fundNums)!=$nums){
	            $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='18' where order_id='".$order_id."'");
	            $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','18','".date("Y-m-d H:i:s")."')");
	            return '部分备货';
	        }elseif($nNums == $nums || ($nNums+$fundNums)==$nums){
	            $oQuery = $this->db->query("select o.order_status_id,os.name from `" . DB_PREFIX . "order` o,`" . DB_PREFIX . "order_status` os where o.order_status_id=os.order_status_id and order_id='".$order_id."'");
	            $orderInfo = $oQuery->row;
	            if(!in_array($orderInfo['order_status_id'], array('3','24','25','5'))){
    	            $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='17' where order_id='".$order_id."'");
    	            $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','17','".date("Y-m-d H:i:s")."')");
    	            return '订单已确认，待备货';
	            }else{
	                return $orderInfo['name'];
	            }
	        }else{
	            return '缺货退款中';
	        }
	    }
	}
	
	//1id，2物流公司，3运单号，4运费    商品发货
	public function shipment($order_id , $party_assbillno,$comment = '', $notify = false){
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` set order_status_id='3' where order_id='".$order_id."'");
	    $sql = "SELECT party_assbillno FROM sl_order_product WHERE order_id = $order_id";
	    $query = $this->db->query($sql);
	    foreach($query->rows as $data){
	        if($data['party_assbillno'] == null){
	            $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set party_assbillno='". trim($party_assbillno)."' where order_id='".$order_id."'");
	            $this->db->query("UPDATE `" . DB_PREFIX . "order` set assbillno = '" . trim($party_assbillno) . "' where order_id = '" .$order_id. "'");
	            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '3', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	        }else{
	            $this->db->query("UPDATE `" . DB_PREFIX . "order` set assbillno = '" . trim($party_assbillno) . "' where order_id = '" .$order_id. "'");
	            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '3', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	        }
	    }
	}
	
	//设置发货
	public function setSendProduct($order_id,$party_assbillno){
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` set order_status_id='3',assbillno='" . trim($party_assbillno) ."' where order_id='".$order_id."'");
	    $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '25', date_added = NOW()");
	}
	
	//确认商品到达美国仓
	public function goodsarrive($order_id , $date_arrive,$comment = '', $notify = false){
	    $this->db->query("UPDATE `" . DB_PREFIX . "order` set order_status_id='25',date_arrive = '" .$date_arrive. "' where order_id='".$order_id."'");
	    $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '25', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	}
	
	//商户获取导出的订单信息
	public function getmerchantexpdata($data = array()){
	    $sql = "SELECT
                    	A.order_id,
                      B. `name`,
                      DT.name_en,
                    	B.model,
                      B.quantity,
                      D. NAME AS orderstaus,
                      A.trackingno,
                      LI.title,
                    	A.date_added,
                    	A.date_modified,
                    	A.shipping_fullname,
                    	A.shipping_zone,
                    	A.payment_city,
                    	A.shipping_city,
                    	A.shipping_address,
	                    A.payment_address,
                    	A.shipping_postcode,
	                    A.payment_postcode,
	                    A.telephone
                    FROM
                    	sl_order A
                    LEFT JOIN sl_order_product B ON A.order_id = B.order_id
                    AND B.refund = 0
                    AND B.outofstock = 0
                    LEFT JOIN sl_product C ON B.product_id = C.product_id
                    LEFT JOIN sl_generhscode G ON C.hscode = G.generhscode
                    LEFT JOIN sl_order_status D ON A.order_status_id = D.order_status_id
                    LEFT JOIN dt_product DT ON B.model= DT.asin
                    LEFT JOIN sl_lines LI ON LI.line_id = A.line_id ";
	     
        if (!empty($data['filter_order_status'])) {
            $sql .= " WHERE D.order_status_id = '" . (int)$data['filter_order_status'] . "'";
        }else{
            $sql .= " WHERE D.order_status_id > '0'";
        }
        
	    if (!empty($data['filter_order_id'])) {
	        $sql .= " AND A.order_id = '" . (int)$data['filter_order_id'] . "'";
	    }
	     
	    if (!empty($data['merchant_id'])) {
	        $sql .= " AND A.merchant_id = '" . (int)$data['merchant_id'] . "'";
	    }
	     
	    if (!empty($data['filter_customer'])) {
	        $sql .= " AND A.fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
	    }
	     
	    if (!empty($data['filter_customer_telephone'])) {
	        $sql .= " AND A.telephone = '" . $this->db->escape($data['filter_customer_telephone']) . "'";
	    }
	     
	    if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
	        $sql .= " AND A.declartype = '" . $data['filter_order_declartype'] . "'";
	    }
	     
	    if ($data['filter_line_id'] == '0' || !empty($data['filter_line_id'])) {
	        $sql .= " AND A.line_id = '" . $data['filter_line_id'] . "'";
	    }
	     
	    if (!empty($data['filter_start_time'])) {
	        $sql .= " AND DATE(A.date_added) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
	    }
	     
	    if (!empty($data['filter_end_time'])) {
	        $sql .= " AND DATE(A.date_modified) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
	    }
	     
	    if (!empty($data['filter_date_added'])) {
	        $sql .= " AND DATE(A.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
	    }
	     
	    if (!empty($data['filter_date_modified'])) {
	        $sql .= " AND DATE(A.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
	    }
	     
	    if (!empty($data['filter_total'])) {
	        $sql .= " AND A.total = '" . (float)$data['filter_total'] . "'";
	    }
	     
	    if(!empty($data['filter_party_order'])){
	        $sql .= " AND B.party_order_no = '" . trim($data['filter_party_order']) . "'";
	    }
	     
	    $sql .= " ORDER BY A.order_id DESC";
	    //echo $sql;exit;
	    $query = $this->db->query($sql);
	    return $query->rows;
	}
	
    //管理员获取需要导出的订单信息
	public function getexportdata($data = array()){
	    $sql = "SELECT
                	A.order_id,
	                A.shipping_telephone,
                	A.fullname,
                	A.telephone,
                	A.total,
                	A.date_added,
                	A.date_modified,
                	A.declartype,
	                A.shipping_fullname,
	                A.shipping_zone,
        	        A.payment_city,
	                A.shipping_city,
        	        A.shipping_address,
        	        A.shipping_postcode,
	                A.date_arrive,
                	B.order_id AS od_id,
                	B.product_id,
                	B.model,
                	B.NAME,
                	B.quantity,
                	B.price,
                	A.tariff_price AS totaltariffprice,
                	B.tariff_price,
                	B.party_assbillno,
                	B.party_order_no,
	                H.date_added AS order_status_time,
                	C.out_url,
                	D.NAME AS orderstaus,
                	E.category_id,
                	E.`name` AS categoryname,
	                G.iscross
                FROM
                	sl_order A
                LEFT JOIN sl_order_product B ON A.order_id = B.order_id AND B.refund=0 AND B.outofstock=0
	            LEFT JOIN sl_product C ON B.product_id = C.product_id
	            LEFT JOIN sl_generhscode G ON C.hscode=G.generhscode
                LEFT JOIN sl_order_status D ON A.order_status_id = D.order_status_id
                LEFT JOIN (
                	SELECT
                		A.product_id,
                		A.category_id,
                		C.`name`
                	FROM
                		sl_product_to_category A,
                		sl_category B,
                		sl_category_description C
                	WHERE
                		A.category_id = B.category_id
                	AND B.category_id = C.category_id
                	AND B.parent_id = '0'
                ) E ON C.product_id = E.product_id
				LEFT JOIN sl_order_history H ON A.order_id = H.order_id AND H.order_status_id = 17	
	            ";
	    
	    if($data['filter_type'] == 'return'){
	        $sql .= " WHERE (A.order_status_id='11' OR B.refund='1')";
	    }else{
    	    if (!empty($data['filter_order_status'])) {
    	        $sql .= " WHERE D.order_status_id = '" . (int)$data['filter_order_status'] . "'";
    	    }else{
    	        $sql .= " WHERE D.order_status_id > '0'";
    	    }
	    }
	    if (!empty($data['filter_order_id'])) {
	        $sql .= " AND A.order_id = '" . (int)$data['filter_order_id'] . "'";
	    }
	    
	    if (!empty($data['merchant_id'])) {
	        $sql .= " AND A.merchant_id = '" . (int)$data['merchant_id'] . "'";
	    }
	    
	    if (!empty($data['filter_customer'])) {
	        $sql .= " AND A.fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
	    }
	    
	    if (!empty($data['filter_customer_telephone'])) {
	        $sql .= " AND A.telephone = '" . $this->db->escape($data['filter_customer_telephone']) . "'";
	    }
	    
	    if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
	        $sql .= " AND A.declartype = '" . $data['filter_order_declartype'] . "'";
	    }
	    
	    if ($data['filter_line_id'] == '0' || !empty($data['filter_line_id'])) {
	        $sql .= " AND A.line_id = '" . $data['filter_line_id'] . "'";
	    }
	    
	    if (!empty($data['filter_start_time'])) {
	        $sql .= " AND DATE(A.date_added) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
	    }
	    
	    if (!empty($data['filter_end_time'])) {
	        $sql .= " AND DATE(A.date_modified) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
	    }
	    
	    if (!empty($data['filter_date_added'])) {
	        $sql .= " AND DATE(A.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
	    }
	    
	    if (!empty($data['filter_date_modified'])) {
	        $sql .= " AND DATE(A.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
	    }
	    
	    if (!empty($data['filter_total'])) {
	        $sql .= " AND A.total = '" . (float)$data['filter_total'] . "'";
	    }
	    
	    if(!empty($data['filter_party_order'])){
	        $sql .= " AND B.party_order_no = '" . trim($data['filter_party_order']) . "'";
	    }
	    
	    $sql .= " ORDER BY A.order_id DESC";
	    //echo $sql;exit;
	    $query = $this->db->query($sql);
	    return $query->rows;
	 }
	 
	 /**
	  * 导出已退款订单
	  */
	 public function getexportReturndata($data){
	     $sql = "SELECT
                	A.order_id,
                	A.fullname,
                	A.telephone,
                	A.total,
                	A.date_added,
                	A.date_modified,
                	A.declartype,
	                A.shipping_fullname,
	                A.shipping_zone,
        	        A.payment_city,
        	        A.shipping_address,
        	        A.shipping_postcode,
	                A.date_arrive,
                	B.order_id AS od_id,
                	B.product_id,
                	B.model,
                	B.NAME,
                	B.quantity,
                	B.price,
                	A.tariff_price AS totaltariffprice,
                	B.tariff_price,
                	B.party_assbillno,
                	B.party_order_no,
	                H.date_added AS order_status_time,
                	C.out_url,
                	D.NAME AS orderstaus,
                	E.category_id,
                	E.`name` AS categoryname,
	                G.iscross
                FROM
                	sl_order A
                LEFT JOIN sl_order_product B ON A.order_id = B.order_id
	            LEFT JOIN sl_product C ON B.product_id = C.product_id
	            LEFT JOIN sl_generhscode G ON C.hscode=G.generhscode
                LEFT JOIN sl_order_status D ON A.order_status_id = D.order_status_id
                LEFT JOIN (
                	SELECT
                		A.product_id,
                		A.category_id,
                		C.`name`
                	FROM
                		sl_product_to_category A,
                		sl_category B,
                		sl_category_description C
                	WHERE
                		A.category_id = B.category_id
                	AND B.category_id = C.category_id
                	AND B.parent_id = '0'
                ) E ON C.product_id = E.product_id
				LEFT JOIN sl_order_history H ON A.order_id = H.order_id AND H.order_status_id = 17
	            ";
	      
	     if($data['filter_type'] == 'return'){
	         $sql .= " WHERE (A.order_status_id='11' OR B.refund='1')";
	     }
	     
	     if (!empty($data['filter_order_id'])) {
	         $sql .= " AND A.order_id = '" . (int)$data['filter_order_id'] . "'";
	     }
	      
	     if (!empty($data['filter_customer'])) {
	         $sql .= " AND A.fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
	     }
	     
	     
	     if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
	         $sql .= " AND A.declartype = '" . $data['filter_order_declartype'] . "'";
	     }
	      
	     if (!empty($data['filter_start_time'])) {
	         $sql .= " AND DATE(A.date_added) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
	     }
	      
	     if (!empty($data['filter_end_time'])) {
	         $sql .= " AND DATE(A.date_modified) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
	     }
	      
	     if (!empty($data['filter_date_added'])) {
	         $sql .= " AND DATE(A.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
	     }
	      
	     if (!empty($data['filter_date_modified'])) {
	         $sql .= " AND DATE(A.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
	     }
	      
	     if (!empty($data['filter_total'])) {
	         $sql .= " AND A.total = '" . (float)$data['filter_total'] . "'";
	     }
	      
	     if(!empty($data['filter_party_order'])){
	         $sql .= " AND B.party_order_no = '" . trim($data['filter_party_order']) . "'";
	     }
	      
	     $sql .= " ORDER BY A.order_id DESC";
	     //echo $sql;exit;
	     $query = $this->db->query($sql);
	     return $query->rows;
	 }
	
	 //获取商品销量信息
	   public function gethotexportdata(){
	       $sql = "select T3.product_id,T4.`name`,T3.model,sum(T2.quantity) as totalamount,T8.name as catetoryname from sl_order T1,sl_order_product T2,sl_product T3,sl_product_description T4,
            sl_product_to_category T5,sl_category T6,sl_category_path T7,sl_category_description T8
            where T1.order_id=T2.order_id and T2.product_id=T3.product_id and T3.product_id=T4.product_id 
            and T3.product_id =T5.product_id and T5.category_id=T6.category_id and T6.parent_id='0' 
            and T7.category_id = T6.category_id and T7.path_id = T5.category_id and T7.`level`='0'
            and T8.category_id = T6.category_id and T1.order_status_id in ('2','3','5','1','15','17','18','24','25','26')
            group by T2.product_id order by sum(T2.quantity) desc limit 0 , 100";
	        $query = $this->db->query($sql);
// 	        print_r($query->rows);die();
            return $query->rows;
	   }
	   
	   //商品没有分类->查询是否存在一条数据
	public function getone($product_id,$category_id){
        $sql = "select A.product_id,A.category_id from sl_product_to_category A 
                LEFT JOIN sl_product B ON A.product_id = B.product_id 
			    WHERE B.product_id = $product_id AND A.category_id = $category_id";
	    $query = $this->db->query($sql);
	    return $query->rows;
	}
	//添加一条数据
	public function addfirstclass($product_id,$category_id){
	    $sql = "INSERT INTO sl_product_to_category (`product_id`,`category_id`) VALUES ('$product_id','$category_id');";
	    $query = $this->db->query($sql);
	    return $query->rows; 
	}
	
	/**
	 * 查询市名
	 */
	public function getCityname($city_id){
	    $sql = "SELECT * FROM sl_zone WHERE zone_id ='{$city_id}'";
	    return $this->db->query($sql)->row;
	}

	public function getOrderInfoByOutTradeNo($out_trade_no){
	    $query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order where out_trade_no='".$out_trade_no."'");
	    return $query->row;
	}
	
	public function getOrderInfo($order_id){
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order where order_id='".$order_id."'");
	    return $query->row;
	}
	
	public function getOrderProductInfo($o_product_id){
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product where order_product_id='".$o_product_id."'");
	    return $query->row;
	}
	
	/**
	 * 获取订单退款金额
	 * 部分退货-部分未退货：商品金额+退货关税
	 * 都已退货：商品金额+退货关税+运费
	 * @param unknown $order_id
	 */
	public function returnGoodsPrice($order_id , $o_product_id){
	    $orderInfo = $this->getOrderInfo($order_id);
	    $oProductInfo = $this->getOrderProductInfo($o_product_id);
	    $query1 = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."'");
	    $nums = $query1->row['cnts'];
	    $query2 = $this->db->query("select count(*) as cnts from `" . DB_PREFIX . "order_product` where order_id='".$order_id."' and outofstock='1' AND refund='1'");
	    $fundNums = $query2->row['cnts'];
	    if($fundNums == $nums-1){
	        $shippQuery = $this->db->query("select value from `" . DB_PREFIX . "order_total` where order_id='".$order_id."' and code='shipping'");
	        $shippingPrice = $shippQuery->row['value'];
	        $price = $oProductInfo['total']+$oProductInfo['tariff_price']+$shippingPrice;
	    }else{
	        $price = $oProductInfo['total']+$oProductInfo['tariff_price'];
	    }
	    return $price;
	}
	
	/**
	 * 获取订单状态历史记录
	 */
	public function getHistoryInfo($order_id , $status_id){
	    $sql = "select * from sl_order_history where order_id='".$order_id."' AND order_status_id='".$status_id."' order by date_added asc";
	    $query = $this->db->query($sql);
	    return $query->row;
	}
	
	//订单收发货信息列表导出
    public function getorderdate(){
        $sql = "SELECT A.order_id,A.city_id,A.date_added,A.shipping_fullname,A.shipping_telephone,A.shipping_country,A.shipping_zone,
                A.shipping_city,A.shipping_address,A.shipping_postcode,B.cardid,C.name,C.model,C.quantity,C.price,C.party_price,
			    C.tariff_price,C.party_assbillno,D.hscode,E.name as productdetail,F.`name` as stausname FROM sl_order A 
                INNER JOIN sl_customer B ON A.customer_id = B.customer_id
                INNER JOIN sl_order_product C ON A.order_id = C.order_id
                INNER JOIN sl_product D ON C.product_id = D.product_id
                INNER JOIN sl_product_description E ON C.product_id = E.product_id
				INNER JOIN sl_order_status F ON F.order_status_id=A.order_status_id WHERE A.order_status_id = 25";
        $query = $this->db->query($sql);
//         print_r($sql);die();
        return $query->rows;
    }
    
    /**
     * 变更订单状态
     * @param unknown $order_id
     * @param unknown $order_status_id
     * @param string $comment
     * @param string $notify
     */
    public function addOrderHistoryStatus($order_id , $order_status_id, $comment = '', $notify = false){
        $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
    }
    
    //更新订单号，圆通单号
   public function updateorderno($data){
//       var_dump($data);die();
//     $sql = ("UPDATE `" . DB_PREFIX . "order` SET order_id = '" . (int)$data[0] . "',expressno = '" .$data[1]. "' WHERE order_id = '" . (int)$data[0] . "'");
//     $query = $this->db->query($sql);
//     return $query->row;
    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_id = '" . (int)$data[0] . "',expressno = '" .$data[1]. "' WHERE order_id = '" . (int)$data[0] . "'");
   } 
   
   /**
    * 查询order_product表
    */
   public function getOrderProduct($order_id){
       $sql = "select * from sl_order_product where order_id='{$order_id}'";
       $query = $this->db->query($sql);
       return $query->rows;
   }
   
   /**
    * 设置国内物流单号
    */
   public function setLogistics($order_id,$shipping_agents,$logistics){
       $sql = "update sl_order set shipping_agents='".$shipping_agents."',logistics='".$logistics."' where order_id='".$order_id."'";
       return $this->db->query($sql);
   }
   
   /**
    * 
    * 获取物流状态名
    */
   public function getTackingStatus($tacking_status){
       $sql = "select * from sl_tracking_status where status_code = {$tacking_status}";
       return $this->db->query($sql)->row;
   }
   
   /**
    * 查询来源国
    */
   public function getSourceName($count_id){
       $sql = "select * from sl_merchant_country where country_id =".(int) $count_id;
       return $this->db->query($sql)->row;
   }
   
   /**
    * 查询仓库（线路）
    */
   public function getLineName($line_id){
       $sql = "select title from sl_lines where line_id=". (int) $line_id ;
       return $this->db->query($sql)->row;
   }
   
   /***
    * 查询商户名
    */
   public function getMerchantName($merchant_id){
       $sql = "select merchant_name from sl_merchant where merchant_id=" .(int) $merchant_id;
       return $this->db->query($sql)->row;
   }
   
   /**
    * 查询当前用户所有线路
    * user_id
    * @return array line_id,title
    */
   public function getLines($user_id){
       //查询商户id
       $merchant_id = $this->db->query('select merchant_id from sl_user where user_id = '.(int)$user_id)->row;
       if($merchant_id['merchant_id']){
           $lines = $this->db->query('select `lines` from sl_merchant_lines where merchant_id='. (int) $merchant_id['merchant_id'])->row;
           $lines = unserialize($lines['lines']);
       }else {
           $lines = $this->db->query('select line_id,title from sl_lines')->rows;
       }
       return $lines;
   }
   
   /**
    * 根据订单号，查询线路
    */
   public function OrderLine($order_id){
       $sql = 'select line_id from sl_order where order_id = '.(int) $order_id;
       return $this->db->query($sql)->row;
   }
   
   /**
    * 商户发货
    */
   public function merchantSendGoods($order_id,$type,$expressno = '',$shipping_agents =''){
       if($type==1){
           $sql = "update sl_order set order_status_id=29,expressno='".$expressno."',shipping_agents = '".$shipping_agents."' where order_id = ".(int) $order_id;
           $row = $this->db->query($sql);
       }else{
           $sql = "update sl_order set order_status_id = 30 where order_id = ".(int) $order_id;
           $row = $this->db->query($sql);
       }
       return $row;
   }
}