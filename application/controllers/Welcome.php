<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	private const HEADER_VIEW = 'templates/public-layout/header';
	private const FOOTER_VIEW = 'templates/public-layout/footer';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	/**
	 * Get common data for views
	 */
	private function get_common_data()
	{
		$this->load->model('Product_model');
        
		// Get cart count from session
		$cart = $this->session->userdata('cart');
		$cart_count = 0;
		if ($cart) {
			foreach ($cart as $item) {
				$cart_count += $item['qty'];
			}
		}

		return [
			'user_logged_in' => $this->session->userdata('customer_logged_in'),
			'user_name' => $this->session->userdata('customer_name'),
			'user_email' => $this->session->userdata('customer_email'),
			'cart_count' => $cart_count,
			'products' => $this->Product_model->get_all_with_category()
		];
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		// Products will be loaded via API on client-side
		$data = $this->get_common_data();

		$this->load->view(self::HEADER_VIEW, $data);
		$this->load->view('pages/index', $data);
		$this->load->view(self::FOOTER_VIEW, $data);
	}

	public function checkout()
	{
		// Redirect to login if not logged in
		if (!$this->session->userdata('customer_logged_in')) {
			$this->session->set_userdata('redirect_after_login', base_url('checkout'));
			redirect(base_url('login'));
		}

		$data = $this->get_common_data();
		
		// Get cart from session
		$cart = $this->session->userdata('cart');
		if (empty($cart)) {
			redirect(base_url());
		}

		// Calculate cart items and total
		$cart_items = [];
		$subtotal = 0;
		$item_count = 0;

		foreach ($cart as $item) {
			$item_total = $item['price'] * $item['qty'];
			$cart_items[] = [
				'id' => $item['id'],
				'name' => $item['name'],
				'price' => $item['price'],
				'qty' => $item['qty'],
				'image' => $item['image'],
				'total' => $item_total
			];
			$subtotal += $item_total;
			$item_count += $item['qty'];
		}

		$data['cart_items'] = $cart_items;
		$data['subtotal'] = $subtotal;
		$data['item_count'] = $item_count;
		$data['total'] = $subtotal; // No tax
		
		$this->load->view(self::HEADER_VIEW, $data);
		$this->load->view('pages/checkout', $data);
		$this->load->view(self::FOOTER_VIEW, $data);
	}

	public function success()
	{
		$data = $this->get_common_data();
		
		// Get completed order from session
		$completed_order = $this->session->userdata('completed_order');
		
		if ($completed_order) {
			$data['order'] = $completed_order;
			// Clear the completed order from session after displaying
			$this->session->unset_userdata('completed_order');
		} else {
			// If no order data, redirect to home
			redirect(base_url());
		}
		
		$this->load->view(self::HEADER_VIEW, $data);
		$this->load->view('pages/success', $data);
		$this->load->view(self::FOOTER_VIEW, $data);
	}

	/**
	 * Process checkout (AJAX)
	 */
	public function process_checkout()
	{
		header('Content-Type: application/json');

		// Check if logged in
		if (!$this->session->userdata('customer_logged_in')) {
			echo json_encode(['success' => false, 'message' => 'Please login first']);
			return;
		}

		// Get cart
		$cart = $this->session->userdata('cart');
		if (empty($cart)) {
			echo json_encode(['success' => false, 'message' => 'Cart is empty']);
			return;
		}

		// Load models
		$this->load->model('Transaction_model');
		$this->load->model('Detail_transaction_model');
		$this->load->model('Product_model');

		// Get form data
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$zip = $this->input->post('zip');

		// Calculate totals
		$subtotal = 0;
		$item_count = 0;
		$order_items = [];
		$total_weight = 0;

		foreach ($cart as $item) {
			$item_total = $item['price'] * $item['qty'];
			$order_items[] = [
				'id' => $item['id'],
				'name' => $item['name'],
				'price' => $item['price'],
				'qty' => $item['qty'],
				'image' => $item['image'],
				'total' => $item_total
			];
			$subtotal += $item_total;
			$item_count += $item['qty'];
			$total_weight += isset($item['weight']) ? $item['weight'] * $item['qty'] : 0;
		}

		// Get customer ID from session
		$customer_id = $this->session->userdata('customer_id');

		// Create transaction data (sesuai dengan tbl_transactions)
		$transaction_data = [
			'customer_id' => $customer_id,
			'receiver_name' => $first_name . ' ' . $last_name,
			'address' => $address,
			'city' => $city,
			'postal_code' => $zip,
			'phone' => $phone,
			'grand_total' => $subtotal,
			'payment_status' => 'paid',
			'order_status' => 'processing'
		];

		// Start database transaction
		$this->db->trans_start();

		// Save to tbl_transactions
		$order_number = $this->Transaction_model->create($transaction_data);

		if ($order_number) {
			// Prepare detail transaction data
			$detail_data = [];
			foreach ($order_items as $item) {
				$detail_data[] = [
					'order_number' => $order_number,
					'product_id' => $item['id'],
					'product_name' => $item['name'],
					'qty' => $item['qty']
				];

				// Decrease product stock
				$this->Product_model->update_stock($item['id'], $item['qty'], 'decrease');
			}

			// Save to tbl_detail_transactions
			$this->Detail_transaction_model->create_batch($detail_data);
		}

		// Complete database transaction
		$this->db->trans_complete();

		// Check if transaction was successful
		if ($this->db->trans_status() === FALSE) {
			echo json_encode([
				'success' => false,
				'message' => 'Failed to process order. Please try again.'
			]);
			return;
		}

		// Store completed order in session for success page
		$completed_order = [
			'order_number' => $order_number,
			'order_date' => date('F j, Y - H:i'),
			'customer' => [
				'name' => $first_name . ' ' . $last_name,
				'email' => $email,
				'phone' => $phone,
				'address' => $address,
				'city' => $city,
				'zip' => $zip
			],
			'items' => $order_items,
			'item_count' => $item_count,
			'subtotal' => $subtotal,
			'shipping' => 0, // Free shipping
			'total' => $subtotal,
			'payment_method' => 'Credit Card'
		];

		$this->session->set_userdata('completed_order', $completed_order);
		// Also save as last_completed_order for invoice download
		$this->session->set_userdata('last_completed_order', $completed_order);

		// Send invoice email to customer
		$email_sent = false;
		try {
			$this->load->library('invoice_mailer');
			$email_sent = $this->invoice_mailer->send_invoice($completed_order, $email);
			
			// Also notify admin (optional)
			$this->invoice_mailer->notify_admin($completed_order);
		} catch (Exception $e) {
			log_message('error', 'Failed to send invoice email: ' . $e->getMessage());
		}

		// Clear cart
		$this->session->unset_userdata('cart');

		echo json_encode([
			'success' => true,
			'message' => 'Order placed successfully' . ($email_sent ? '. Invoice sent to your email.' : ''),
			'order_number' => $order_number,
			'email_sent' => $email_sent,
			'redirect_url' => base_url('success')
		]);
	}
}
