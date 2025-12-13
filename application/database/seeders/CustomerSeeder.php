<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerSeeder {

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
                'id'            => 1,
                'customer_name' => 'John Doe',
                'email'         => 'john.doe@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'id'            => 2,
                'customer_name' => 'Jane Smith',
                'email'         => 'jane.smith@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'id'            => 3,
                'customer_name' => 'Michael Johnson',
                'email'         => 'michael.johnson@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'id'            => 4,
                'customer_name' => 'Emily Davis',
                'email'         => 'emily.davis@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
            ],
            [
                'id'            => 5,
                'customer_name' => 'Robert Wilson',
                'email'         => 'robert.wilson@example.com',
                'password'      => password_hash('password123', PASSWORD_DEFAULT),
            ],
        ];

        $this->CI->db->insert_batch('tbl_customers', $data);
        echo "CustomerSeeder: " . count($data) . " records inserted.\n";
    }
}
