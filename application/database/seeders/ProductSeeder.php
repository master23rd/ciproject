<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductSeeder {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run()
    {
        $data = [
            // Smartphones (category_id: 1)
            [
                'category_id'      => 1,
                'product_name'     => 'Samsung Galaxy S24 Ultra',
                'price'            => 1299.99,
                'description'      => 'Samsung Galaxy S24 Ultra with 6.8" Dynamic AMOLED 2X display, Snapdragon 8 Gen 3, 12GB RAM, 256GB storage, 200MP camera with AI features.',
                'image'            => 'samsung_s24_ultra.jpg',
                'weight'           => 0.23,
                'available_status' => 1,
                'qty'              => 50,
            ],
            [
                'category_id'      => 1,
                'product_name'     => 'iPhone 15 Pro Max',
                'price'            => 1199.99,
                'description'      => 'Apple iPhone 15 Pro Max with A17 Pro chip, 6.7" Super Retina XDR display, 256GB storage, titanium design, and 48MP camera system.',
                'image'            => 'iphone_15_pro_max.jpg',
                'weight'           => 0.22,
                'available_status' => 1,
                'qty'              => 45,
            ],
            [
                'category_id'      => 1,
                'product_name'     => 'Google Pixel 8 Pro',
                'price'            => 999.99,
                'description'      => 'Google Pixel 8 Pro with Tensor G3 chip, 6.7" LTPO OLED display, 12GB RAM, 128GB storage, and advanced AI photography features.',
                'image'            => 'pixel_8_pro.jpg',
                'weight'           => 0.21,
                'available_status' => 1,
                'qty'              => 35,
            ],
            [
                'category_id'      => 1,
                'product_name'     => 'OnePlus 12',
                'price'            => 799.99,
                'description'      => 'OnePlus 12 with Snapdragon 8 Gen 3, 6.82" LTPO AMOLED display, 16GB RAM, 256GB storage, Hasselblad camera system.',
                'image'            => 'oneplus_12.jpg',
                'weight'           => 0.22,
                'available_status' => 1,
                'qty'              => 40,
            ],
            
        ];

        $this->CI->db->insert_batch('tbl_products', $data);
        echo "ProductSeeder: " . count($data) . " records inserted.\n";
    }
}
