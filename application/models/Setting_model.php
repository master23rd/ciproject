<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    protected $table = 'tbl_settings';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get settings (first row)
     */
    public function get()
    {
        return $this->db->get($this->table)->row();
    }

    /**
     * Get setting by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get business name
     */
    public function get_business_name()
    {
        $settings = $this->get();
        return $settings ? $settings->business_name : '';
    }

    /**
     * Get contact number
     */
    public function get_contact_number()
    {
        $settings = $this->get();
        return $settings ? $settings->contact_number : '';
    }

    /**
     * Get address
     */
    public function get_address()
    {
        $settings = $this->get();
        return $settings ? $settings->address : '';
    }

    /**
     * Create settings
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update settings
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Update or create settings
     */
    public function save($data)
    {
        $existing = $this->get();
        
        if ($existing) {
            return $this->update($existing->id, $data);
        } else {
            return $this->create($data);
        }
    }

    /**
     * Get all settings (alias for get)
     */
    public function get_all()
    {
        return $this->get();
    }
}
