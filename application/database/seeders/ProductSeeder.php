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
            [
                'category_id'      => 1,
                'product_name'     => 'Xiaomi 14 Pro',
                'price'            => 899.99,
                'description'      => 'Xiaomi 14 Pro with Snapdragon 8 Gen 3, 6.73" LTPO AMOLED display, Leica optics, 12GB RAM, and 256GB storage.',
                'image'            => 'xiaomi_14_pro.jpg',
                'weight'           => 0.22,
                'available_status' => 1,
                'qty'              => 38,
            ],
            // Phone Accessories (category_id: 2)
            [
                'category_id'      => 2,
                'product_name'     => 'Samsung 45W Super Fast Charger',
                'price'            => 49.99,
                'description'      => 'Official Samsung 45W Super Fast Charger 2.0 with USB-C cable, compatible with Galaxy S24 series.',
                'image'            => 'samsung_charger_45w.jpg',
                'weight'           => 0.15,
                'available_status' => 1,
                'qty'              => 150,
            ],
            [
                'category_id'      => 2,
                'product_name'     => 'Apple MagSafe Charger',
                'price'            => 39.99,
                'description'      => 'Apple MagSafe Charger for iPhone 15/14/13/12 series with 15W wireless charging capability.',
                'image'            => 'apple_magsafe.jpg',
                'weight'           => 0.05,
                'available_status' => 1,
                'qty'              => 120,
            ],
            [
                'category_id'      => 2,
                'product_name'     => 'Spigen Ultra Hybrid Case for iPhone 15 Pro',
                'price'            => 29.99,
                'description'      => 'Crystal clear Spigen Ultra Hybrid case with military-grade drop protection for iPhone 15 Pro.',
                'image'            => 'spigen_case_iphone.jpg',
                'weight'           => 0.03,
                'available_status' => 1,
                'qty'              => 200,
            ],
            // Flagship Phones (category_id: 3)
            [
                'category_id'      => 3,
                'product_name'     => 'iPhone 15 Pro',
                'price'            => 999.99,
                'description'      => 'Apple iPhone 15 Pro with A17 Pro chip, 6.1" Super Retina XDR display, 128GB storage, titanium design.',
                'image'            => 'iphone_15_pro.jpg',
                'weight'           => 0.19,
                'available_status' => 1,
                'qty'              => 55,
            ],
            [
                'category_id'      => 3,
                'product_name'     => 'Samsung Galaxy S24+',
                'price'            => 999.99,
                'description'      => 'Samsung Galaxy S24+ with 6.7" Dynamic AMOLED 2X, Snapdragon 8 Gen 3, 12GB RAM, 256GB storage.',
                'image'            => 'samsung_s24_plus.jpg',
                'weight'           => 0.20,
                'available_status' => 1,
                'qty'              => 42,
            ],
            // Budget Phones (category_id: 4)
            [
                'category_id'      => 4,
                'product_name'     => 'Samsung Galaxy A35 5G',
                'price'            => 399.99,
                'description'      => 'Samsung Galaxy A35 5G with 6.6" Super AMOLED display, Exynos 1380, 6GB RAM, 128GB storage, 50MP camera.',
                'image'            => 'samsung_a35.jpg',
                'weight'           => 0.21,
                'available_status' => 1,
                'qty'              => 80,
            ],
            [
                'category_id'      => 4,
                'product_name'     => 'Xiaomi Redmi Note 13 Pro',
                'price'            => 299.99,
                'description'      => 'Xiaomi Redmi Note 13 Pro with 6.67" AMOLED display, Snapdragon 7s Gen 2, 8GB RAM, 256GB storage, 200MP camera.',
                'image'            => 'redmi_note_13_pro.jpg',
                'weight'           => 0.19,
                'available_status' => 1,
                'qty'              => 100,
            ],
            [
                'category_id'      => 4,
                'product_name'     => 'Google Pixel 8a',
                'price'            => 499.99,
                'description'      => 'Google Pixel 8a with Tensor G3, 6.1" OLED display, 8GB RAM, 128GB storage, 7 years of OS updates.',
                'image'            => 'pixel_8a.jpg',
                'weight'           => 0.19,
                'available_status' => 1,
                'qty'              => 60,
            ],
            // Gaming Phones (category_id: 5)
            [
                'category_id'      => 5,
                'product_name'     => 'ASUS ROG Phone 8 Pro',
                'price'            => 1199.99,
                'description'      => 'ASUS ROG Phone 8 Pro with Snapdragon 8 Gen 3, 6.78" 165Hz AMOLED, 24GB RAM, 1TB storage, AeroActive Cooler.',
                'image'            => 'rog_phone_8_pro.jpg',
                'weight'           => 0.23,
                'available_status' => 1,
                'qty'              => 25,
            ],
            [
                'category_id'      => 5,
                'product_name'     => 'Nubia Red Magic 9 Pro',
                'price'            => 899.99,
                'description'      => 'Nubia Red Magic 9 Pro with Snapdragon 8 Gen 3, 6.8" 120Hz AMOLED, 16GB RAM, 512GB storage, built-in cooling fan.',
                'image'            => 'redmagic_9_pro.jpg',
                'weight'           => 0.23,
                'available_status' => 1,
                'qty'              => 30,
            ],
            // Foldable Phones (category_id: 6)
            [
                'category_id'      => 6,
                'product_name'     => 'Samsung Galaxy Z Fold 5',
                'price'            => 1799.99,
                'description'      => 'Samsung Galaxy Z Fold 5 with 7.6" foldable Dynamic AMOLED 2X, Snapdragon 8 Gen 2, 12GB RAM, 256GB storage.',
                'image'            => 'galaxy_z_fold_5.jpg',
                'weight'           => 0.25,
                'available_status' => 1,
                'qty'              => 20,
            ],
            [
                'category_id'      => 6,
                'product_name'     => 'Samsung Galaxy Z Flip 5',
                'price'            => 999.99,
                'description'      => 'Samsung Galaxy Z Flip 5 with 6.7" foldable Dynamic AMOLED 2X, 3.4" Flex Window, Snapdragon 8 Gen 2, 8GB RAM.',
                'image'            => 'galaxy_z_flip_5.jpg',
                'weight'           => 0.19,
                'available_status' => 1,
                'qty'              => 35,
            ],
            [
                'category_id'      => 6,
                'product_name'     => 'Google Pixel Fold',
                'price'            => 1799.99,
                'description'      => 'Google Pixel Fold with 7.6" foldable OLED display, Tensor G2 chip, 12GB RAM, 256GB storage, Pixel camera system.',
                'image'            => 'pixel_fold.jpg',
                'weight'           => 0.28,
                'available_status' => 1,
                'qty'              => 15,
            ],
        ];

        $this->CI->db->insert_batch('tbl_products', $data);
        echo "ProductSeeder: " . count($data) . " records inserted.\n";
    }
}
