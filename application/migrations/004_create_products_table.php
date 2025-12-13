<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_products_table extends CI_Migration {

    public function up()
    {
        // Create tbl_products table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'product_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ],
            'weight' => [
                'type'       => 'FLOAT',
                'null'       => TRUE,
            ],
            'available_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES tbl_categories(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->create_table('tbl_products');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_products');
    }
}
