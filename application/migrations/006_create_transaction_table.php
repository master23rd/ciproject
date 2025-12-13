<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_transaction_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => FALSE,
            ],
            'receiver_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
            ],
            // Transaction details
            'grand_total' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0.00,
            ],
            'payment_status' => [
                'type' => 'ENUM("pending","paid","failed","expired")',
                'default' => 'pending',
            ],
            'order_status' => [
                'type' => 'ENUM("new","processing","shipped","completed","cancelled")',
                'default' => 'new',
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('order_number', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (customer_id) REFERENCES tbl_customers(id)');
        $this->dbforge->create_table('tbl_transactions');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_transactions');
    }
}