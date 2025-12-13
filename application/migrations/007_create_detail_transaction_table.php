<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_detail_transaction_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (order_number) REFERENCES tbl_transactions(order_number) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (product_id) REFERENCES tbl_products(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->create_table('tbl_detail_transactions');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_detail_transactions');
    }
}