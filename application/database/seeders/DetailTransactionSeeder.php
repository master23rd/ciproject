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
                'product_id'     => 6,
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
                'product_id'     => 9,
                'qty'            => 1,
                'product_name'   => 'iPhone 15 Pro',
            ],
            // Transaction 3 - Michael Johnson (Nubia Red Magic 9 Pro)
            [
                'order_number' => 'ORD-' . date('Ymd') . '-003',
                'product_id'     => 15,
                'qty'            => 1,
                'product_name'   => 'Nubia Red Magic 9 Pro',
            ],
            // Transaction 4 - Emily Davis (Galaxy Z Fold 5)
            [
                'order_number' => 'ORD-' . date('Ymd') . '-004',
                'product_id'     => 16,
                'qty'            => 1,
                'product_name'   => 'Samsung Galaxy Z Fold 5',
            ],
            // Transaction 5 - Robert Wilson (Galaxy Z Flip 5 + Redmi Note 13 Pro)
            [
                'order_number' => 'ORD-' . date('Ymd') . '-005',
                'product_id'     => 17,
                'qty'            => 1,
                'product_name'   => 'Samsung Galaxy Z Flip 5',
            ],
            [
                'order_number' => 'ORD-' . date('Ymd') . '-005',
                'product_id'     => 12,
                'qty'            => 1,
                'product_name'   => 'Xiaomi Redmi Note 13 Pro',
            ],
        ];

        $this->CI->db->insert_batch('tbl_detail_transactions', $data);
        echo "DetailTransactionSeeder: " . count($data) . " records inserted.\n";
    }
}
