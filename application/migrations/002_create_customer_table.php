<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Migration to create the customers table
 */
class Migration_Create_Customer_Table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'unique' => TRUE
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'unique' => TRUE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('id_customer', FALSE, TRUE);
        $this->dbforge->create_table('tbl_customers');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_customers');
    }
}
