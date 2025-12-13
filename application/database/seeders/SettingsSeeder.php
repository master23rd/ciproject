<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsSeeder {

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
                'business_name'  => 'Mobile Phone Store',
                'locations'      => 'New York, Los Angeles, Chicago',
                'address'        => '123 Tech Avenue, Suite 500, New York, NY 10001',
                'contact_number' => '+1 555 123 4567',
            ],
        ];

        $this->CI->db->insert_batch('tbl_settings', $data);
        echo "SettingsSeeder: " . count($data) . " records inserted.\n";
    }
}
