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
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}

	public function getOrders($data = array()) {
		$sql = "SELECT o.order_id, o.fullname AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.shipping_code, o.declartype , o.total, o.currency_code,o.currency_value,o.telephone,o.shipping_agents,o.assbillno,o.ship_price, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			} else {

			}
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		
		if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
		    $sql .= " AND o.declartype = '" . $data['filter_order_declartype'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND o.fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
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
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

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
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

		if (!empty($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND fullname LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}
		
	    if ($data['filter_order_declartype'] == '0' || !empty($data['filter_order_declartype'])) {
		    $sql .= " AND o.declartype = '" . $data['filter_order_declartype'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND total = '" . (float)$data['filter_total'] . "'";
		}

		$query = $this->db->query($sql);

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
	
	public function confirmBuy($o_product_id , $party_order_no , $party_price){
	    if(!$o_product_id || !$party_order_no || !$party_price) return false;
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set confirm_buy='1',party_order_no='".$party_order_no."',party_price='".$party_price."' where order_product_id='".$o_product_id."'");
// 	    party_assbillno='".$assbillno."'
	    return true;
	}
	
// 	public function confirmreserve($o_product_id,$assbillno){
// 	    if(!$o_product_id || !$assbillno) return false;
// 	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` set confirm_buy='1',party_assbillno='".$assbillno."' where order_product_id='".$o_product_id."'");
// 	    // 	    party_assbillno='".$assbillno."'
// 	    return true;
// 	}
	
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
	        $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='2' where order_id='".$order_id."'");
	        $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','2','".date("Y-m-d H:i:s")."')");
	        return '处理中';
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
	    if($fundNums == $nums){
	        $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='11' where order_id='".$order_id."'");
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
	            $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='17' where order_id='".$order_id."'");
	            $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','17','".date("Y-m-d H:i:s")."')");
	            return '已备货';
	        }else{
	            return '处理中';
	        }
	    }
	}
	//1id，2物流公司，3运单号，4运费
	public function shipment($order_id , $shipping_agents , $assbillno , $ship_price , $party_assbillno){
	    $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` set shipping_agents='{$shipping_agents}',assbillno='{$assbillno}',ship_price='{$ship_price}',order_status_id='3' where order_id='".$order_id."'");
	   if($this->db->query("UPDATE `" . DB_PREFIX . "order_product` set party_assbillno='".$party_assbillno."' where order_id='".$order_id."'")){
	       $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('{$order_id}','3','".date("Y-m-d H:i:s")."')");
	   } 
	}
	//获取需要导出的订单信息
	public function getexportdata($start_time,$end_time){
	    $query = $this->db->query("
	       SELECT
	A.fullname,
	A.telephone,
	A.total,
	A.date_added,
	A.date_modified,
	A.declartype,
	B.order_id,
	B.model,
	B.name,
	B.quantity,
	B.price,
	B.tariff_price,
	B.party_assbillno,
	B.party_order_no,
	C.out_url,
	D. NAME AS orderstaus
FROM
	sl_order A
LEFT JOIN sl_order_product B ON A.order_id = B.order_id
LEFT JOIN sl_product C ON B.product_id = C.product_id
LEFT JOIN sl_order_status D ON A.order_status_id = D.order_status_id
WHERE
	D.order_status_id = 1 AND A.date_added >'$start_time' AND  A.date_added < '$end_time'
	        ");
	    return $query->rows;
	}
}