<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    protected $table = 'tbl_admins';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all admins
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get admin by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get admin by username
     */
    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }

    /**
     * Create new admin
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update admin
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete admin
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Verify login credentials
     */
    public function verify_login($username, $password)
    {
        $admin = $this->get_by_username($username);
        
        if ($admin && password_verify($password, $admin->password)) {
            return $admin;
        }
        
        return false;
    }
}
