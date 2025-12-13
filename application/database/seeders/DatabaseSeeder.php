<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Database Seeder
 * 
 * This class is used to run all seeders at once.
 * Usage: Load this class and call the run() method to seed all tables.
 */
class DatabaseSeeder {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    /**
     * Run all seeders in the correct order
     */
    public function run()
    {
        echo "=== Starting Database Seeding ===\n\n";

        // Load and run each seeder in order (respecting foreign key constraints)
        $seeders = [
            'AdminSeeder',
            'CustomerSeeder',
            'CategorySeeder',
            'ProductSeeder',
            'ImageSeeder',
            'TransactionSeeder',
            'DetailTransactionSeeder',
            'SettingsSeeder',
            'CustomerAccountSeeder',
        ];

        foreach ($seeders as $seeder) {
            $seeder_file = APPPATH . 'database/seeders/' . $seeder . '.php';
            
            if (file_exists($seeder_file)) {
                require_once($seeder_file);
                $seeder_instance = new $seeder();
                $seeder_instance->run();
            } else {
                echo "Warning: Seeder file not found - {$seeder}.php\n";
            }
        }

        echo "\n=== Database Seeding Completed ===\n";
    }

    /**
     * Run a specific seeder
     * 
     * @param string $seeder_name The name of the seeder class to run
     */
    public function call($seeder_name)
    {
        $seeder_file = APPPATH . 'database/seeders/' . $seeder_name . '.php';
        
        if (file_exists($seeder_file)) {
            require_once($seeder_file);
            $seeder_instance = new $seeder_name();
            $seeder_instance->run();
        } else {
            echo "Error: Seeder file not found - {$seeder_name}.php\n";
        }
    }
}
