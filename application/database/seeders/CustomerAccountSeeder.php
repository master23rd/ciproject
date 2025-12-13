<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerAccountSeeder {

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
                'merchant_name'  => 'Bank of America',
                'account_number' => '1234567890',
                'account_name'   => 'Mobile Phone Store LLC',
            ],
            [
                'merchant_name'  => 'Chase Bank',
                'account_number' => '0987654321',
                'account_name'   => 'Mobile Phone Store LLC',
            ],
            [
                'merchant_name'  => 'Wells Fargo',
                'account_number' => '1122334455',
                'account_name'   => 'Mobile Phone Store LLC',
            ],
            [
                'merchant_name'  => 'PayPal',
                'account_number' => 'payments@mobilephonestore.com',
                'account_name'   => 'Mobile Phone Store',
            ],
            [
                'merchant_name'  => 'Stripe',
                'account_number' => 'acct_mobilephonestore',
                'account_name'   => 'Mobile Phone Store',
            ],
        ];

        $this->CI->db->insert_batch('tbl_customer_account', $data);
        echo "CustomerAccountSeeder: " . count($data) . " records inserted.\n";
    }
}
