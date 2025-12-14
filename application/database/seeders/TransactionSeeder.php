<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionSeeder {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run()
    {
        $data = [
            [
                'customer_id'    => 1,
                'order_number'   => 'ORD-' . date('Ymd') . '-001',
                'created_at'     => date('Y-m-d H:i:s', strtotime('-5 days')),
                'receiver_name'  => 'John Doe',
                'address'        => '123 Main Street, Apt 4B',
                'city'           => 'New York',
                'postal_code'    => '10001',
                'phone'          => '+1 555 123 4567',
                'grand_total'    => 1349.98,
                'payment_status' => 'paid',
                'order_status'   => 'completed',
            ],
            [
                'customer_id'    => 2,
                'order_number'   => 'ORD-' . date('Ymd') . '-002',
                'created_at'     => date('Y-m-d H:i:s', strtotime('-3 days')),
                'receiver_name'  => 'Jane Smith',
                'address'        => '456 Oak Avenue, Suite 200',
                'city'           => 'Los Angeles',
                'postal_code'    => '90001',
                'phone'          => '+1 555 234 5678',
                'grand_total'    => 2199.98,
                'payment_status' => 'paid',
                'order_status'   => 'shipped',
            ],
            
        ];

        $this->CI->db->insert_batch('tbl_transactions', $data);
        echo "TransactionSeeder: " . count($data) . " records inserted.\n";
    }
}
