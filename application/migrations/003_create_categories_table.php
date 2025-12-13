<?php
defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Migration to create the admin table
 */
class Migration_Create_Categories_Table extends CI_Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tbl_categories');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_categories');
    }
}
