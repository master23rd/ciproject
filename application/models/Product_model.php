<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    protected $table = 'tbl_products';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all products
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get all products with category
     */
    public function get_all_with_category()
    {
        $this->db->select('tbl_products.*, tbl_categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('tbl_categories', 'tbl_categories.id = tbl_products.category_id', 'left');
        $this->db->order_by('tbl_products.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get product by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get product by ID with category
     */
    public function get_by_id_with_category($id)
    {
        $this->db->select('tbl_products.*, tbl_categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('tbl_categories', 'tbl_categories.id = tbl_products.category_id', 'left');
        $this->db->where('tbl_products.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get products by category ID
     */
    public function get_by_category($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get available products
     */
    public function get_available()
    {
        return $this->db->get_where($this->table, ['available_status' => 1, 'qty >' => 0])->result();
    }

    /**
     * Create new product
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update product
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete product
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Update stock quantity
     */
    public function update_stock($id, $qty, $operation = 'decrease')
    {
        $product = $this->get_by_id($id);
        
        if (!$product) {
            return false;
        }

        if ($operation === 'decrease') {
            $new_qty = $product->qty - $qty;
        } else {
            $new_qty = $product->qty + $qty;
        }

        return $this->update($id, ['qty' => max(0, $new_qty)]);
    }

    /**
     * Search products
     */
    public function search($keyword)
    {
        $this->db->select('tbl_products.*, tbl_categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('tbl_categories', 'tbl_categories.id = tbl_products.category_id', 'left');
        $this->db->group_start();
        $this->db->like('product_name', $keyword);
        $this->db->or_like('description', $keyword);
        $this->db->group_end();
        return $this->db->get()->result();
    }

    /**
     * Get products with pagination
     */
    public function get_paginated($limit, $offset, $category_id = null)
    {
        $this->db->select('tbl_products.*, tbl_categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('tbl_categories', 'tbl_categories.id = tbl_products.category_id', 'left');
        
        if ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count all products
     */
    public function count_all($category_id = null)
    {
        if ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        return $this->db->count_all_results($this->table);
    }
}
