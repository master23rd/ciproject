<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetailTransactionSeeder {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run()
    {
        $data = [
            // Transaction 1 - John Doe (Samsung S24 Ultra + Charger)
            [
                'order_number' => 'ORD-' . date('Ymd') . '-001',
                'product_id'     => 1,
                'qty'            => 1,
                'product_name'   => 'Samsung Galaxy S24 Ultra',
            ],
            [
                'order_number' => 'ORD-' . date('Ymd') . '-001',
                'product_id'     => 2,
                'qty'            => 1,
                'product_name'   => 'Samsung 45W Super Fast Charger',
            ],
            // Transaction 2 - Jane Smith (iPhone 15 Pro Max + iPhone 15 Pro)
            [
                'order_number' => 'ORD-' . date('Ymd') . '-002',
                'product_id'     => 2,
                'qty'            => 1,
                'product_name'   => 'iPhone 15 Pro Max',
            ],
            [
                'order_number' => 'ORD-' . date('Ymd') . '-002',
                'product_id'     => 3,
                'qty'            => 1,
                'product_name'   => 'iPhone 15 Pro',
            ],
        ];

        $this->CI->db->insert_batch('tbl_detail_transactions', $data);
        echo "DetailTransactionSeeder: " . count($data) . " records inserted.\n";
    }
}
