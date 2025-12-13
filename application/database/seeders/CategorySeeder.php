<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategorySeeder {

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
                'name'        => 'Smartphones',
                'description' => 'Latest smartphones from various brands including Samsung, Apple, Xiaomi, and more.',
            ],
            [
                'name'        => 'Phone Accessories',
                'description' => 'Phone cases, chargers, screen protectors, and other smartphone accessories.',
            ],
            [
                'name'        => 'Flagship Phones',
                'description' => 'Premium flagship smartphones with cutting-edge technology and features.',
            ],
            [
                'name'        => 'Budget Phones',
                'description' => 'Affordable smartphones with great value for money.',
            ],
            [
                'name'        => 'Gaming Phones',
                'description' => 'High-performance gaming smartphones with advanced cooling and displays.',
            ],
            [
                'name'        => 'Foldable Phones',
                'description' => 'Innovative foldable smartphones with flexible displays.',
            ],
        ];

        $this->CI->db->insert_batch('tbl_categories', $data);
        echo "CategorySeeder: " . count($data) . " records inserted.\n";
    }
}
