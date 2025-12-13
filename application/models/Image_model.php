<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_model extends CI_Model {

    protected $table = 'tbl_images';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all images
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get image by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get images by product ID
     */
    public function get_by_product($product_id)
    {
        return $this->db->get_where($this->table, ['product_id' => $product_id])->result();
    }

    /**
     * Get first image of a product
     */
    public function get_first_by_product($product_id)
    {
        return $this->db->get_where($this->table, ['product_id' => $product_id])->row();
    }

    /**
     * Get primary/first image of a product (alias for get_first_by_product)
     */
    public function get_primary_image($product_id)
    {
        return $this->get_first_by_product($product_id);
    }

    /**
     * Create new image
     */
    public function create($data)
    {
        $data['uploaded_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Create multiple images
     */
    public function create_batch($data)
    {
        foreach ($data as &$item) {
            $item['uploaded_at'] = date('Y-m-d H:i:s');
        }
        return $this->db->insert_batch($this->table, $data);
    }

    /**
     * Update image
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete image
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Delete images by product ID
     */
    public function delete_by_product($product_id)
    {
        return $this->db->where('product_id', $product_id)->delete($this->table);
    }

    /**
     * Count images by product ID
     */
    public function count_by_product($product_id)
    {
        return $this->db->where('product_id', $product_id)->count_all_results($this->table);
    }
}
