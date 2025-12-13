<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seeder Controller
 * 
 * Controller untuk menjalankan database seeders
 * 
 * Cara penggunaan:
 * - Jalankan semua seeder: http://localhost/ciproject/seeder
 * - Jalankan seeder tertentu: http://localhost/ciproject/seeder/run/NamaSeeder
 * 
 * Contoh:
 * - http://localhost/ciproject/seeder/run/AdminSeeder
 * - http://localhost/ciproject/seeder/run/ProductSeeder
 */
class Seeder extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Default method - run all seeders
     */
    public function index()
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Seeder hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        require_once(APPPATH . 'database/seeders/DatabaseSeeder.php');
        
        $seeder = new DatabaseSeeder();
        $seeder->run();

        if (!$this->input->is_cli_request()) {
            echo "<br><br><a href='" . base_url() . "'>Kembali ke Home</a>";
        }
    }

    /**
     * Run a specific seeder
     * 
     * @param string $seeder_name The name of the seeder to run
     */
    public function run($seeder_name = null)
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Seeder hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        if (empty($seeder_name)) {
            echo "Error: Nama seeder harus diisi!\n";
            echo "Contoh: php index.php seeder run AdminSeeder\n";
            return;
        }

        require_once(APPPATH . 'database/seeders/DatabaseSeeder.php');
        
        $seeder = new DatabaseSeeder();
        $seeder->call($seeder_name);

        if (!$this->input->is_cli_request()) {
            echo "<br><br><a href='" . base_url() . "'>Kembali ke Home</a>";
        }
    }

    /**
     * Fresh - Truncate all tables and re-seed
     */
    public function fresh()
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Seeder hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        echo "=== Truncating All Tables ===\n\n";

        // Disable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // Truncate tables in reverse order
        $tables = [
            'tbl_detail_transactions',
            'tbl_transactions',
            'tbl_images',
            'tbl_products',
            'tbl_categories',
            'tbl_customers',
            'tbl_admins',
            'tbl_settings',
            'tbl_customer_account',
        ];

        foreach ($tables as $table) {
            if ($this->db->table_exists($table)) {
                $this->db->truncate($table);
                echo "Truncated: {$table}\n";
            }
        }

        // Enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        echo "\n";

        // Run all seeders
        $this->index();
    }
}
