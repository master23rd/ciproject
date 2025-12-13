<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    protected $table = 'tbl_transactions';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all transactions
     */
    public function get_all()
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get all transactions with customer info
     */
    public function get_all_with_customer()
    {
        $this->db->select('tbl_transactions.*, tbl_customers.customer_name, tbl_customers.email');
        $this->db->from($this->table);
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_transactions.customer_id', 'left');
        $this->db->order_by('tbl_transactions.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get transaction by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }

    /**
     * Get transaction by order number
     */
    public function get_by_order_number($order_number)
    {
        return $this->db->get_where($this->table, ['order_number' => $order_number])->row();
    }

    /**
     * Get transactions by customer ID
     */
    public function get_by_customer($customer_id)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get_where($this->table, ['customer_id' => $customer_id])->result();
    }

    /**
     * Get transactions by payment status
     */
    public function get_by_payment_status($status)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get_where($this->table, ['payment_status' => $status])->result();
    }

    /**
     * Get transactions by order status
     */
    public function get_by_order_status($status)
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get_where($this->table, ['order_status' => $status])->result();
    }

    /**
     * Create new transaction
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['order_number'] = $this->generate_order_number();
        $this->db->insert($this->table, $data);
        return $data['order_number'];
    }

    /**
     * Update transaction
     */
    public function update($id, $data)
    {
        return $this->db->where($this->primaryKey, $id)->update($this->table, $data);
    }

    /**
     * Update by order number
     */
    public function update_by_order_number($order_number, $data)
    {
        return $this->db->where('order_number', $order_number)->update($this->table, $data);
    }

    /**
     * Update payment status
     */
    public function update_payment_status($order_number, $status)
    {
        return $this->update_by_order_number($order_number, ['payment_status' => $status]);
    }

    /**
     * Update order status
     */
    public function update_order_status($order_number, $status)
    {
        return $this->update_by_order_number($order_number, ['order_status' => $status]);
    }

    /**
     * Delete transaction
     */
    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }

    /**
     * Generate unique order number
     */
    public function generate_order_number()
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        
        // Get the last order number for today
        $this->db->select('order_number');
        $this->db->like('order_number', $prefix, 'after');
        $this->db->order_by('order_number', 'DESC');
        $this->db->limit(1);
        $last_order = $this->db->get($this->table)->row();

        if ($last_order) {
            $last_number = (int) substr($last_order->order_number, -3);
            $new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $new_number = '001';
        }

        return $prefix . $new_number;
    }

    /**
     * Get transactions with pagination
     */
    public function get_paginated($limit, $offset, $filters = [])
    {
        $this->db->select('tbl_transactions.*, tbl_customers.customer_name, tbl_customers.email');
        $this->db->from($this->table);
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_transactions.customer_id', 'left');
        
        if (!empty($filters['payment_status'])) {
            $this->db->where('payment_status', $filters['payment_status']);
        }
        
        if (!empty($filters['order_status'])) {
            $this->db->where('order_status', $filters['order_status']);
        }
        
        if (!empty($filters['customer_id'])) {
            $this->db->where('customer_id', $filters['customer_id']);
        }
        
        $this->db->order_by('tbl_transactions.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count all transactions
     */
    public function count_all($filters = [])
    {
        if (!empty($filters['payment_status'])) {
            $this->db->where('payment_status', $filters['payment_status']);
        }
        
        if (!empty($filters['order_status'])) {
            $this->db->where('order_status', $filters['order_status']);
        }
        
        if (!empty($filters['customer_id'])) {
            $this->db->where('customer_id', $filters['customer_id']);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get total revenue
     */
    public function get_total_revenue()
    {
        $this->db->select_sum('grand_total');
        $this->db->where('payment_status', 'paid');
        $result = $this->db->get($this->table)->row();
        return $result->grand_total ?? 0;
    }
}
