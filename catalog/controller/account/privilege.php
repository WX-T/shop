<?php
	class ControllerAccountPrivilege extends Controller {
		public function index() {
			$this->load->model('account/customer');
			$this->document->setTitle('会员特权');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$data['home'] = $this->url->link('common/home');
			$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
			$data['logged'] = $this->customer->isLogged();
			$data['account'] = $this->url->link('account/account', '', 'SSL');
			$data['register'] = $this->url->link('account/register', '', 'SSL');
			$data['login'] = $this->url->link('account/login', '', 'SSL');
			$data['order'] = $this->url->link('account/order', '', 'SSL');
			$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
			$data['download'] = $this->url->link('account/download', '', 'SSL');
			$data['logout'] = $this->url->link('account/logout', '', 'SSL');
			$data['shopping_cart'] = $this->url->link('checkout/cart');
			$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
			$data['contact'] = $this->url->link('information/contact');
			$data['telephone'] = $this->config->get('config_telephone');
			$data['language'] = $this->load->controller('common/language');
			$data['currency'] = $this->load->controller('common/currency');
			$data['search'] = $this->load->controller('common/search');
			$data['cart'] = $this->load->controller('common/cart');
			$data['text_logged'] = $this->customer->getFullName();
			$data['order_url'] = $this->url->link('account/order','','SSL');
			$data['href_center'] = $this->url->link('account/edit', '', 'SSL');
			$data['href_logout'] = $this->url->link('account/logout', '', 'SSL');
			$data['text_wishlist'] = isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
			$this->response->setOutput($this->load->view('shopyfashion/template/account/privilege.tpl', $data));
		}

		public function getList(){
			
		}
	}