<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Invoice Controller
 * Handle invoice generation and download
 */
class Invoice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Transaction_model');
        $this->load->model('Detail_transaction_model');
        $this->load->model('Customer_model');
    }

    /**
     * Download Invoice PDF
     * 
     * @param string $order_number Order number
     */
    public function download($order_number = null)
    {
        if (!$order_number) {
            show_error('Order number is required', 400);
            return;
        }

        // Get order data
        $order = $this->get_order_data($order_number);

        if (!$order) {
            show_error('Order not found', 404);
            return;
        }

        // Load PDF library
        $this->load->library('pdf_invoice');

        // Download PDF
        $this->pdf_invoice->download($order);
    }

    /**
     * View Invoice PDF (inline)
     * 
     * @param string $order_number Order number
     */
    public function view($order_number = null)
    {
        if (!$order_number) {
            show_error('Order number is required', 400);
            return;
        }

        // Get order data
        $order = $this->get_order_data($order_number);

        if (!$order) {
            show_error('Order not found', 404);
            return;
        }

        // Load PDF library
        $this->load->library('pdf_invoice');

        // View PDF inline
        $this->pdf_invoice->view($order);
    }

    /**
     * Download invoice from session (for success page)
     */
    public function download_from_session()
    {
        // Get completed order from session
        $order = $this->session->userdata('last_completed_order');

        if (!$order) {
            // Try to get from completed_order session
            $order = $this->session->userdata('completed_order');
        }

        if (!$order) {
            show_error('No order data found. Please complete a checkout first.', 400);
            return;
        }

        // Ensure all required fields exist
        $order = $this->normalize_order_data($order);

        // Load PDF library
        $this->load->library('pdf_invoice');

        // Download PDF
        $this->pdf_invoice->download($order);
    }

    /**
     * Get order data from database
     * 
     * @param string $order_number
     * @return array|null
     */
    protected function get_order_data($order_number)
    {
        // Get transaction
        $transaction = $this->Transaction_model->get_by_order_number($order_number);

        if (!$transaction) {
            return null;
        }

        // Get customer
        $customer = $this->Customer_model->get_by_id($transaction->customer_id);

        // Get order details
        $details = $this->Detail_transaction_model->get_by_order_number($order_number);

        // Build order items array
        $items = [];
        $subtotal = 0;

        foreach ($details as $detail) {
            $item_total = $detail->price * $detail->qty;
            $items[] = [
                'id' => $detail->product_id,
                'name' => $detail->product_name,
                'price' => $detail->price,
                'qty' => $detail->qty,
                'total' => $item_total
            ];
            $subtotal += $item_total;
        }

        // Build order array
        $order = [
            'order_number' => $transaction->order_number,
            'order_date' => date('F j, Y - H:i', strtotime($transaction->created_at)),
            'customer' => [
                'name' => $transaction->receiver_name ?? ($customer ? $customer->customer_name : 'Customer'),
                'email' => $customer ? $customer->email : '',
                'phone' => $transaction->phone ?? '',
                'address' => $transaction->address ?? '',
                'city' => $transaction->city ?? '',
                'zip' => $transaction->postal_code ?? ''
            ],
            'items' => $items,
            'item_count' => count($items),
            'subtotal' => $subtotal,
            'shipping' => 0,
            'total' => $transaction->grand_total,
            'payment_status' => $transaction->payment_status,
            'order_status' => $transaction->order_status,
            'payment_method' => 'Credit Card'
        ];

        return $order;
    }

    /**
     * Normalize order data to ensure all fields exist
     * 
     * @param array $order
     * @return array
     */
    protected function normalize_order_data($order)
    {
        // Set defaults for missing fields
        $defaults = [
            'order_number' => 'N/A',
            'order_date' => date('F j, Y - H:i'),
            'customer' => [
                'name' => 'Customer',
                'email' => '',
                'phone' => '',
                'address' => '',
                'city' => '',
                'zip' => ''
            ],
            'items' => [],
            'item_count' => 0,
            'subtotal' => 0,
            'shipping' => 0,
            'total' => 0,
            'payment_method' => 'Credit Card'
        ];

        // Merge with defaults
        $order = array_merge($defaults, $order);

        // Ensure customer array has all fields
        if (isset($order['customer']) && is_array($order['customer'])) {
            $order['customer'] = array_merge($defaults['customer'], $order['customer']);
        }

        return $order;
    }
}
