<?php
class ModelAccountOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");
		if ($order_query->num_rows) {
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
			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'fullname'               => $order_query->row['fullname'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
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
			    'payment_code'            => $order_query->row['payment_code'],
				'payment_method'          => $order_query->row['payment_method'],
				'shipping_fullname'      => $order_query->row['shipping_fullname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address'      => $order_query->row['shipping_address'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_telephone'       => $order_query->row['shipping_telephone'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
			    'city_id'                 => $order_query->row['city_id'],
			    'area_id'                 => $order_query->row['area_id'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_method'         => $order_query->row['shipping_method'],
			    'shipping_agents'         => $order_query->row['shipping_agents'],
			    'assbillno'               => $order_query->row['assbillno'],
			    'ship_price'              => $order_query->row['ship_price'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
			    'has_tariff'              => $order_query->row['has_tariff'],
			    'tariff_price'            => $order_query->row['tariff_price'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'language_id'             => $order_query->row['language_id'],
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip'],
			    'trackingno'              => $order_query->row['trackingno']
			);
		} else {
			return false;
		}
	}

	public function getOrders($start = 0, $limit = 20 , $status = '') {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 1;
		}
        
		$whereSql = '';
		if($status){
		    $whereSql.= " AND o.order_status_id in({$status})";
		}
		$query = $this->db->query("SELECT o.order_id, o.expressno, o.fullname,o.shipping_agents,o.logistics,os.order_status_id,os.name as status, o.date_added, o.total, o.currency_code, o.currency_value FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id) WHERE o.customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id >= '0' AND o.store_id = '" . (int)$this->config->get('config_store_id') . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' " . $whereSql . " ORDER BY o.order_id DESC LIMIT " . (int)$start . "," . (int)$limit);
		return $query->rows;
	}

	public function getOrderProduct($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");
		return $query->row;
	}

	//2016-10-8 : 支持商户系统+
	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT T1.*,T2.product_id,T2.parent_id,T2.location as source,T2.bonded,T2.hscode,T2.line_id,merchant_id FROM " . DB_PREFIX . "order_product T1," . DB_PREFIX . "product T2 WHERE T1.product_id=T2.product_id and T1.order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}
	
	/**
	 * 查询仓库详情
	 * @param unknown $line_id
	 */
	public function getLine($line_id){
	    $query = $this->db->query("select * from sl_lines where line_id=".$line_id);
	    return $query->row;
	}
	
	public function getOrderProductsList($order_id) {
	    $query = $this->db->query("SELECT op.*,p.image FROM " . DB_PREFIX . "order_product op," . DB_PREFIX . "product p WHERE op.product_id=p.product_id and order_id = '" . (int)$order_id . "'");
	
	    return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getOrderHistories($order_id) {
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added");

		return $query->rows;
	}

	public function getTotalOrders($status = '') {
	    $whereSql = '';
	    if($status){
	        $whereSql.= " AND o.order_status_id in ({$status})";
	    }
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id > '0' AND o.store_id = '" . (int)$this->config->get('config_store_id') . "'" . $whereSql);
		return $query->row['total'];
	}

	public function getTotalOrderProductsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderVouchersByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getStatus($status_id){
		$query = $this->db->query("SELECT * FROM `". DB_PREFIX . "order_status` where order_status_id = ".$status_id);
		return $query->row['name'];
	}
	
	public function setOutTradeNoByOrderNo($order_id  , $out_trade_no){
	    if(!$order_id || !$out_trade_no) return false;
	    $this->db->query("UPDATE " . DB_PREFIX . "order SET out_trade_no ='".$out_trade_no."' where order_id='".$order_id."'");
	}
	
	public function getOrderInfoByOutTradeNo($out_trade_no){
	    $query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order where out_trade_no='".$out_trade_no."'");
		return $query->row;
	}
	
	public function getOrderInfo($order_id){
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order where order_id='".$order_id."'");
	    return $query->row;
	}
	
	/**
	 * 确认收货
	 */
	public function confirmOrder($order_id,$customer_id){
	    $row = false;
	    if($order_id && $customer_id){
	      $row = $this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id ='5' where order_id='".$order_id."' and customer_id='".$customer_id."'");
	    }
	    return $row;
	}
	/**
	 * 查询订单用户id
	 */
	public function getOrderCustomer_id($order_id){
	    $query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "order where order_id='".$order_id."'");
	    return $query->row;
	}
	
	//获取所有已发货未发送订单中心的订单
	public function getOrdercenters(){
	    $query = $this->db->query("select * from `" . DB_PREFIX . "order` where send_ordercenter ='0' and order_status_id in (1,3,24,25) and is_split='1'");
	    return $query->rows;
	}
	
	//查询城市
	public function getCity($city_id){
	    $query = $this->db->query("select * from `" . DB_PREFIX . "zone` where zone_id = '{$city_id}'");
	    return $query->row['name'];
	}
	//更改已发送订单中心并写入快递单号
	public function saveTraking($order_id,$TrackingNo,$ExpressNo , $source='amazon' , $order_status_id=24){
	    if(in_array($source, array('germany','canada','japan','korea'))){
	        $order_status_id = '17';
	    }else{
	        $order_status_id= '24'; 
	    }
	    if($ExpressNo){
	        $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='".$order_status_id."',send_ordercenter='1',trackingno = '{$TrackingNo}',expressno='{$ExpressNo}' where order_id='".$order_id."'");
	    }else{
	        $this->db->query("update `" . DB_PREFIX . "order` set order_status_id='".$order_status_id."',send_ordercenter='1',trackingno = '{$TrackingNo}' where order_id='".$order_id."'");
	    }
	}
	
	//获取用户信息
	public function getCustomerMsg($customer_id){
	    $query = $this->db->query("select cardname,cardid from `" . DB_PREFIX . "customer` where customer_id = '{$customer_id}'");
	    return $query->row;
	}
	
	//查询订单的国际单号
	public function getParty_assbillno($order_id){
	    $query = $this->db->query("select party_assbillno from `" . DB_PREFIX . "order_product` where order_id = '{$order_id}'");
	    return $query->row;
	}
	
	//查询所有无申报类型订单
	public function getDeclarType(){
	    /* $sql="SELECT
            	t2.order_id,
            	t3.hscode,
              t2.product_id
            FROM
            	sl_order t1,
            	sl_order_product t2,
            	sl_product t3
            WHERE
            	t1.order_id = t2.order_id
            AND t2.product_id = t3.product_id
            AND t1.declartype='0' AND t1.order_status_id in(3,2,5,1,15,17,18)"; */
	    
	    $sql = "select total,order_id from sl_order where declartype='0' AND order_status_id >= 1 and is_split = 1";
	    $query = $this->db->query($sql);
	    return $query->rows;
	}
	
	//查询负面清单商品
	public function getNegative($goodno){
	    $sql = "select * from sl_product_negative where goodno='{$goodno}'";
	    $query = $this->db->query($sql);
	    return $query->rows;
	}
	
	//根据商品查询是否走跨境电商
	public function getIscross($product_id){
	    $sql = "SELECT t2.iscross,t1.product_id from sl_product t1,sl_generhscode t2 WHERE t1.hscode=t2.generhscode AND t1.product_id='{$product_id}'";
	    $query = $this->db->query($sql);
	    return $query->row;
	}
	//设置order表declarttype状态
	public function setDeclartype($order_id,$declartype){
	    $sql = "UPDATE sl_order SET declartype = '{$declartype}' WHERE order_id = '{$order_id}'";
	    $this->db->query($sql);
	}
	
	/**
	 * 获取订单状态历史记录
	 */
	public function getHistoryInfo($order_id , $status_id){
	    $sql = "select * from sl_order_history where order_id='".$order_id."' AND order_status_id='".$status_id."' order by date_added asc";
	    $query = $this->db->query($sql);
	    return $query->row;
	}
	
	public function getOrderProductList($order_id){
	    $sql = "select party_assbillno from sl_order_product where order_id='".$order_id."' group by party_assbillno";
	    $query = $this->db->query($sql);
	    return $query->rows;
	}
	
	public function getOneOrder($order_id){
	    $sql = "select order_id from sl_order where order_id = '".$order_id."'";
	    $query = $this->db->query($sql);
	    return $query->row;
	}
	
	/**
	 * 写入tackingHistory记录
	 */
	
	public function insertTackingHistory($data){
	    return $this->db->query($this->db->insertStr('sl_tracking_history',$data));
	}
	
	/**
	 * 更新物流状态码
	 */
	public function updateOrderTacking($order_id,$status_id){
	    $time = date('Y-m-d H:i:s');
	    $sql = "update sl_order set tacking_status = {$status_id},tacking_time = '{$time}' where order_id = {$order_id}";
	    return $this->db->query($sql);
	}
	
	//更改订单状态
	public function editOrderStatus($order_id,$order_status,$desc){
	    $sql = "update sl_order set order_status_id='{$order_status}' where order_id=".$order_id;
	    $this->db->query($sql);
	    //写入记录表
	    $data['order_id'] = $order_id;
	    $data['order_status_id'] = $order_status;
	    $data['comment'] = $desc;
	    $data['date_added'] = date('Y-m-d H:i:s');
	    $this->db->query($this->db->insertStr('sl_order_history',$data));
	}
	
	
	/**
	 * 查询amazon商品
	 */
    public function getAmazons(){
        $sql = "select product_id from sl_product where source='amazon' and status =1 and iscross_status=0 limit 100";
        return $this->db->query($sql)->rows;
    }
    
    /**
     * 关闭商品
     */
    public function setStatus($product_id,$status){
        $sql = "update sl_product set status = '{$status}' where product_id='".$product_id."'";
        $this->db->query($sql);
    }
    
    /**
     * 设置已查询正面清单
     */
    public function setiscross($product_id){
        $sql = "update sl_product set iscross_status = 1 where product_id='".$product_id."'";
        $this->db->query($sql);
    }
}