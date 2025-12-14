<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageSeeder {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run()
    {
        $data = [
            // Samsung Galaxy S24 Ultra
            [
                'image_path'  => 'uploads/products/samsung_s24_ultra_1.jpg',
                'product_id'  => 1,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            [
                'image_path'  => 'uploads/products/samsung_s24_ultra_2.jpg',
                'product_id'  => 2,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // iPhone 15 Pro Max
            [
                'image_path'  => 'uploads/products/iphone_15_pro_max_1.jpg',
                'product_id'  => 3,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            [
                'image_path'  => 'uploads/products/iphone_15_pro_max_2.jpg',
                'product_id'  => 4,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->CI->db->insert_batch('tbl_images', $data);
        echo "ImageSeeder: " . count($data) . " records inserted.\n";
    }
}
