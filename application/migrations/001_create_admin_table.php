<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Create_Admin_Table extends CI_Migration
{
    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tbl_admins', TRUE);
    }

    public function down() {
        $this->dbforge->drop_table('tbl_admins', TRUE);
    }
}