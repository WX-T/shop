<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
		$this->event->trigger('pre.customer.add', $data);

		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
		if(isset($data['cardid']) && $data['cardid']){
    		$data['cardtype'] = '1';
    		$data['cardname'] = $data['fullname'];
    		$data['cardid']   = $data['cardid'];
		}else{
		    $data['cardtype'] = '0';
		    $data['cardname'] = '';
		    $data['cardid']   = '';
		}
		$data['loanacctno'] = isset($data['loanacctno']) ? $data['loanacctno'] : '';
		$data['app_customerid'] = isset($data['app_customerid']) ? $data['app_customerid'] : '';
		$data['userstatus'] = isset($data['userstatus']) ? $data['userstatus'] : '1';
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', fullname = '" . $this->db->escape($data['fullname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? serialize($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW() , cardtype='".$data['cardtype']."' , cardname='".$data['cardname']."' , cardid='".$data['cardid']."' , loanacctno='".$data['loanacctno']."' , app_customerid='".$data['app_customerid']."' , userstatus='".$data['userstatus']."'");

		$customer_id = $this->db->getLastId();
		//edit mcc
		if(isset($data['address'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', fullname = '" . $this->db->escape($data['fullname']) . "', company = '" . $this->db->escape($data['company']) . "', shipping_telephone = '" . $this->db->escape($data['telephone']) . "', address = '" . $this->db->escape($data['address']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "' , city_id = '" . (int)$data['city_id'] . "' , area_id = '" . (int)$data['area_id'] . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? serialize($data['custom_field']['address']) : '') . "'");
	
			$address_id = $this->db->getLastId();
	
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
		}
		//end mcc

		//delete temporary mobile number
		$this->db->query("DELETE FROM " . DB_PREFIX . "sms_mobile WHERE sms_mobile = '" . $this->db->escape($data['telephone']) . "'");

		$this->load->language('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}

		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
        
		if ($this->config->get('config_account_mail')) {
    		$mail = new Mail();
    		$mail->protocol = $this->config->get('config_mail_protocol');
    		$mail->parameter = $this->config->get('config_mail_parameter');
    		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
    		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
    		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
    		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
    		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
    			
    		$mail->setTo($data['email']);
    		$mail->setFrom($this->config->get('config_email'));
    		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
    		$mail->setSubject($subject);
    		$mail->setText($message);
    		$mail->send();
		}

		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
			$message .= $this->language->get('text_fullname') . ' ' . $data['fullname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			
			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if (utf8_strlen($email) > 0 && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		$this->event->trigger('post.customer.add', $customer_id);

		return $customer_id;
	}

	public function editCustomer($data) {
		$this->event->trigger('pre.customer.edit', $data);

		$customer_id = $this->customer->getId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET fullname = '" . $this->db->escape($data['fullname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
		//delete temporary mobile number
		$this->db->query("DELETE FROM " . DB_PREFIX . "sms_mobile WHERE sms_mobile = '" . $this->db->escape($data['telephone']) . "'");

		$this->event->trigger('post.customer.edit', $customer_id);
	}

	public function editPassword($email, $password) {
		$this->event->trigger('pre.customer.edit.password');
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		$this->event->trigger('post.customer.edit.password');
	}
	
	public function modifyUserinfo($cardtype, $cardname , $cardid , $customer_id) {
	    $this->db->query("UPDATE " . DB_PREFIX . "customer SET cardtype = '" . $cardtype . "', cardname = '" . $this->db->escape($cardname) . "',cardid='" . $this->db->escape($cardid) . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
	public function modifyAppUserinfo($cardtype, $cardname , $cardid , $acctNo , $mobileNo ,$customer_id , $userStatus = '1') {
	    $this->db->query("UPDATE " . DB_PREFIX . "customer SET cardtype = '" . $cardtype . "', cardname = '" . $this->db->escape($cardname) . "', fullname = '" . $this->db->escape($cardname) . "',cardid='" . $this->db->escape($cardid) . "',loanacctno='".$this->db->escape($acctNo)."',telephone='".$this->db->escape($mobileNo)."',userstatus='".$userStatus."' WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function modifyUserCart($customer_id){
	    $this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	public function editNewsletter($newsletter) {
		$this->event->trigger('pre.customer.edit.newsletter');

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		$this->event->trigger('post.customer.edit.newsletter');
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' OR fullname='".$this->db->escape(utf8_strtolower($email))."'");

		return $query->row;
	}
	
	public function getCustomerByInfo($customerId) {
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE app_customerid = '" . $this->db->escape($customerId) ."'");
	
	    return $query->row;
	}

	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query->row;
	}

	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}

	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}

	public function isBanIp($ip) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ban_ip` WHERE ip = '" . $this->db->escape($ip) . "'");

		return $query->num_rows;
	}
	
	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
		
		if (!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
		}			
	}	
	
	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}
	
	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
	
	
	public function getTotalCustomersByTelephone($telephone) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE telephone = '" . $this->db->escape($telephone) . "'");

		return $query->row['total'];
	}
	public function getFullnames($fullname){
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE fullname = '".$this->db->escape($fullname)."'");
	    return $query->row;
	}
	public function addHeadphoto($customer_id,$headimg){
	    $query = $this->db->query("UPDATE " . DB_PREFIX . "customer SET headphoto = '" . $this->db->escape($headimg) . "'WHERE customer_id = '" . (int)$customer_id . "'");
	     
	    return $query;
	}
	/*
	 * 查询省ID
	 */
	public function getZone_id($zone){
	    $query = $this->db->query("SELECT * FROM sl_zone WHERE LEVEL='2' AND name like '%".$zone."%'");
	    return $query->row;
	}
	/*
	 * 查询市ID
	 */
	public function getCity_id($city){
	    $query = $this->db->query("SELECT * FROM sl_zone WHERE LEVEL='3' AND name like '%".$city."%'");
	    return $query->row;
	}
	/*
	 * 查询区ID
	 */
	public function getArea_id($area){
	    $query = $this->db->query("SELECT * FROM sl_zone WHERE LEVEL='4' AND name like '%".$area."%'");
	    return $query->row;
	}
	/**
	 * 查询市名
	 */
	public function getCityname($city_id){
	    $sql = "SELECT * FROM sl_zone WHERE zone_id ='{$city_id}'";
	    return $this->db->query($sql)->row;
	}
}