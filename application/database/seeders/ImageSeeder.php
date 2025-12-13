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
                'product_id'  => 1,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // iPhone 15 Pro Max
            [
                'image_path'  => 'uploads/products/iphone_15_pro_max_1.jpg',
                'product_id'  => 2,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            [
                'image_path'  => 'uploads/products/iphone_15_pro_max_2.jpg',
                'product_id'  => 2,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Google Pixel 8 Pro
            [
                'image_path'  => 'uploads/products/pixel_8_pro_1.jpg',
                'product_id'  => 3,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // OnePlus 12
            [
                'image_path'  => 'uploads/products/oneplus_12_1.jpg',
                'product_id'  => 4,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Xiaomi 14 Pro
            [
                'image_path'  => 'uploads/products/xiaomi_14_pro_1.jpg',
                'product_id'  => 5,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Samsung 45W Charger
            [
                'image_path'  => 'uploads/products/samsung_charger_45w_1.jpg',
                'product_id'  => 6,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Apple MagSafe
            [
                'image_path'  => 'uploads/products/apple_magsafe_1.jpg',
                'product_id'  => 7,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Spigen Case
            [
                'image_path'  => 'uploads/products/spigen_case_1.jpg',
                'product_id'  => 8,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // iPhone 15 Pro
            [
                'image_path'  => 'uploads/products/iphone_15_pro_1.jpg',
                'product_id'  => 9,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Samsung S24+
            [
                'image_path'  => 'uploads/products/samsung_s24_plus_1.jpg',
                'product_id'  => 10,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Samsung A35
            [
                'image_path'  => 'uploads/products/samsung_a35_1.jpg',
                'product_id'  => 11,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Redmi Note 13 Pro
            [
                'image_path'  => 'uploads/products/redmi_note_13_pro_1.jpg',
                'product_id'  => 12,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Pixel 8a
            [
                'image_path'  => 'uploads/products/pixel_8a_1.jpg',
                'product_id'  => 13,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // ROG Phone 8 Pro
            [
                'image_path'  => 'uploads/products/rog_phone_8_pro_1.jpg',
                'product_id'  => 14,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Red Magic 9 Pro
            [
                'image_path'  => 'uploads/products/redmagic_9_pro_1.jpg',
                'product_id'  => 15,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Galaxy Z Fold 5
            [
                'image_path'  => 'uploads/products/galaxy_z_fold_5_1.jpg',
                'product_id'  => 16,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Galaxy Z Flip 5
            [
                'image_path'  => 'uploads/products/galaxy_z_flip_5_1.jpg',
                'product_id'  => 17,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
            // Pixel Fold
            [
                'image_path'  => 'uploads/products/pixel_fold_1.jpg',
                'product_id'  => 18,
                'uploaded_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->CI->db->insert_batch('tbl_images', $data);
        echo "ImageSeeder: " . count($data) . " records inserted.\n";
    }
}
