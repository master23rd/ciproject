<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_account_model extends CI_Model {

    protected $table = 'tbl_customer_account';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all payment accounts
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get payment account by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get payment accounts by merchant name
     */
    public function get_by_merchant($merchant_name)
    {
        return $this->db->get_where($this->table, ['merchant_name' => $merchant_name])->result();
    }

    /**
     * Create new payment account
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update payment account
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete payment account
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Get dropdown list
     */
    public function get_dropdown()
    {
        $accounts = $this->get_all();
        $dropdown = [];
        
        foreach ($accounts as $account) {
            $dropdown[$account->id] = $account->merchant_name . ' - ' . $account->account_number;
        }
        
        return $dropdown;
    }

    /**
     * Get active banks (unique merchant names)
     */
    public function get_merchants()
    {
        $this->db->distinct();
        $this->db->select('merchant_name');
        return $this->db->get($this->table)->result();
    }
}
