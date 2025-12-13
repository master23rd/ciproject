<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSeeder {

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
                'full_name' => 'Super Admin',
                'username'  => 'admin',
                'password'  => password_hash('admin123', PASSWORD_DEFAULT),
            ],
            [
                'full_name' => 'John Manager',
                'username'  => 'manager',
                'password'  => password_hash('manager123', PASSWORD_DEFAULT),
            ],
        ];

        $this->CI->db->insert_batch('tbl_admins', $data);
        echo "AdminSeeder: " . count($data) . " records inserted.\n";
    }
}
