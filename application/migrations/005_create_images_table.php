<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Migration to create the images table
 */
class Migration_Create_Images_Table extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (product_id) REFERENCES tbl_products(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->create_table('tbl_images', TRUE);
    }

    public function down() {
        $this->dbforge->drop_table('tbl_images', TRUE);
    }
}