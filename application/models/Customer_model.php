<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    protected $table = 'tbl_customers';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all customers
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get customer by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get customer by email
     */
    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Create new customer
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update customer
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete customer
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Verify login credentials
     */
    public function verify_login($email, $password)
    {
        $customer = $this->get_by_email($email);
        
        if ($customer && password_verify($password, $customer->password)) {
            return $customer;
        }
        
        return false;
    }

    /**
     * Check if email exists
     */
    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        
        if ($exclude_id) {
            $this->db->where($this->primaryKey . ' !=', $exclude_id);
        }
        
        return $this->db->get($this->table)->num_rows() > 0;
    }
}
