<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_transaction_model extends CI_Model {

    protected $table = 'tbl_detail_transactions';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all detail transactions
     */
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Get detail transaction by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get details by order number
     */
    public function get_by_order_number($order_number)
    {
        $this->db->select('tbl_detail_transactions.*, tbl_products.price, tbl_products.image');
        $this->db->from($this->table);
        $this->db->join('tbl_products', 'tbl_products.id = tbl_detail_transactions.product_id', 'left');
        $this->db->where('tbl_detail_transactions.order_number', $order_number);
        return $this->db->get()->result();
    }

    /**
     * Get details by product ID
     */
    public function get_by_product($product_id)
    {
        return $this->db->get_where($this->table, ['product_id' => $product_id])->result();
    }

    /**
     * Create new detail transaction
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Create multiple detail transactions
     */
    public function create_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    /**
     * Update detail transaction
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Delete detail transaction
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Delete by order number
     */
    public function delete_by_order_number($order_number)
    {
        return $this->db->where('order_number', $order_number)->delete($this->table);
    }

    /**
     * Calculate subtotal for an order
     */
    public function get_order_subtotal($order_number)
    {
        $this->db->select('SUM(tbl_detail_transactions.qty * tbl_products.price) as subtotal');
        $this->db->from($this->table);
        $this->db->join('tbl_products', 'tbl_products.id = tbl_detail_transactions.product_id');
        $this->db->where('order_number', $order_number);
        $result = $this->db->get()->row();
        return $result->subtotal ?? 0;
    }

    /**
     * Get total quantity sold for a product
     */
    public function get_total_sold($product_id)
    {
        $this->db->select_sum('qty');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get($this->table)->row();
        return $result->qty ?? 0;
    }

    /**
     * Get best selling products
     */
    public function get_best_sellers($limit = 10)
    {
        $this->db->select('product_id, product_name, SUM(qty) as total_sold');
        $this->db->from($this->table);
        $this->db->group_by('product_id, product_name');
        $this->db->order_by('total_sold', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
