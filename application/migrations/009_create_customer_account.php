<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_customer_account extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'merchant_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'account_number' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'account_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tbl_customer_account');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_customer_account');
    }
}