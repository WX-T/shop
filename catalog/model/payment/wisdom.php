<?php
class ModelPaymentWisdom extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/wisdom');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pp_standard_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('wisdom_total') > $total) {
			$status = false;
		}elseif (!$this->config->get('pp_pro_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$currencies = array(
			'CNY',
		);

		if (!in_array(strtoupper($this->currency->getCode()), $currencies)) {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'wisdom',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
			    'image'      => 'catalog/view/theme/shopyfashion/image/banks/wisdom.gif',
				'sort_order' => $this->config->get('wisdom_sort_order')
			);
		}

		return $method_data;
	}
}