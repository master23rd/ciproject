<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migrate Controller
 */
class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
        $this->load->database();
    }

    /**
     * Run all migrations
     */
    public function index()
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Migration hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        echo "=== Running Migrations ===\n\n";

        if ($this->migration->latest() === FALSE) {
            echo "Migration Error: " . $this->migration->error_string() . "\n";
        } else {
            echo "Migrations completed successfully!\n";
        }

        if (!$this->input->is_cli_request()) {
            echo "<br><br><a href='" . base_url('seeder') . "'>Run Seeder</a> | ";
            echo "<a href='" . base_url() . "'>Home</a>";
        }
    }

    /**
     * Migrate to a specific version
     * 
     * @param int $version The version to migrate to
     */
    public function version($version = 0)
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Migration hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        echo "=== Migrating to version {$version} ===\n\n";

        if ($this->migration->version($version) === FALSE) {
            echo "Migration Error: " . $this->migration->error_string() . "\n";
        } else {
            echo "Migration to version {$version} completed!\n";
        }
    }

    /**
     * Rollback all migrations (reset database)
     */
    public function rollback()
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Migration hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        echo "=== Rolling back all migrations ===\n\n";

        if ($this->migration->version(0) === FALSE) {
            echo "Rollback Error: " . $this->migration->error_string() . "\n";
        } else {
            echo "All migrations have been rolled back!\n";
        }
    }

    /**
     * Fresh - Rollback all and re-run migrations + seeder
     */
    public function fresh()
    {
        // Pastikan hanya bisa dijalankan dari CLI atau localhost
        if (!$this->input->is_cli_request() && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            show_error('Migration hanya bisa dijalankan dari localhost atau CLI!', 403);
            return;
        }

        echo "=== Fresh Migration (Reset & Re-run) ===\n\n";

        // Rollback
        echo "Step 1: Rolling back all migrations...\n";
        $this->migration->version(0);
        echo "Done!\n\n";

        // Migrate
        echo "Step 2: Running all migrations...\n";
        if ($this->migration->latest() === FALSE) {
            echo "Migration Error: " . $this->migration->error_string() . "\n";
            return;
        }
        echo "Done!\n\n";

        // Seed
        echo "Step 3: Running seeders...\n";
        require_once(APPPATH . 'database/seeders/DatabaseSeeder.php');
        $seeder = new DatabaseSeeder();
        $seeder->run();

        if (!$this->input->is_cli_request()) {
            echo "<br><br><a href='" . base_url() . "'>Home</a>";
        }
    }
}
