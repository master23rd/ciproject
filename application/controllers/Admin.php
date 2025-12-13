<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller
 * Main controller for admin panel
 */
class Admin extends CI_Controller {

    private const HEADER_VIEW = 'templates/admin-layout/header';
    private const SIDEBAR_VIEW = 'templates/admin-layout/sidebar';
    private const FOOTER_VIEW = 'templates/admin-layout/footer';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        
        // Check admin login (except for login-related methods)
        $this->check_admin_login();
    }

    /**
     * Check if admin is logged in
     * Excludes login, do_login, and logout methods
     */
    private function check_admin_login()
    {
        // Get current method
        $excluded_methods = ['login', 'do_login', 'logout', 'test_routing'];
        $current_method = $this->router->fetch_method();
        
        // Skip check for excluded methods
        if (in_array($current_method, $excluded_methods)) {
            return;
        }
        
        // Check if admin is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            // Store intended URL for redirect after login
            $this->session->set_userdata('admin_redirect_url', current_url());
            redirect(base_url('admin/login'));
        }
    }

    /**
     * Get common data for views
     */
    private function get_common_data($page_title = 'Dashboard', $active_menu = 'dashboard')
    {
        return [
            'page_title' => $page_title,
            'active_menu' => $active_menu,
            'admin_name' => $this->session->userdata('admin_name') ?? 'Administrator',
            'admin_email' => $this->session->userdata('admin_email') ?? 'admin@shophub.com'
        ];
    }

    /**
     * Load admin view with layout
     */
    private function load_admin_view($view, $data = [])
    {
        $this->load->view(self::HEADER_VIEW, $data);
        $this->load->view(self::SIDEBAR_VIEW, $data);
        $this->load->view($view, $data);
        $this->load->view(self::FOOTER_VIEW, $data);
    }

    /**
     * Dashboard
     */
    public function index()
    {
        $this->load->model(['Transaction_model', 'Product_model', 'Customer_model']);
        
        $data = $this->get_common_data('Dashboard', 'dashboard');
        
        // Get statistics
        $data['total_orders'] = $this->Transaction_model->count_all();
        $data['total_revenue'] = $this->Transaction_model->get_total_revenue();
        $data['total_products'] = $this->Product_model->count_all();
        $data['total_customers'] = $this->db->count_all('tbl_customers');
        
        // Get recent orders
        $data['recent_orders'] = $this->Transaction_model->get_paginated(5, 0);
        
        $this->load_admin_view('admin/dashboard', $data);
    }

    /**
     * Dashboard alias
     */
    public function dashboard()
    {
        $this->index();
    }

    /**
     * Products Management
     */
    public function products()
    {
        $this->load->model('Product_model');
        
        $data = $this->get_common_data('Products', 'products');
        $data['products'] = $this->Product_model->get_all_with_category();
        
        $this->load_admin_view('admin/products', $data);
    }

    /**
     * Add New Product
     */
    public function products_add()
    {
        $this->load->model(['Product_model', 'Category_model']);
        
        $data = $this->get_common_data('Add Product', 'products');
        $data['categories'] = $this->Category_model->get_all();
        $data['mode'] = 'add';
        
        // If form submitted
        if ($this->input->method() === 'post') {
            // Validation rules
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('qty', 'Quantity', 'required|integer');
            
            if ($this->form_validation->run() === TRUE) {
                // Prepare data
                $product_data = [
                    'product_name' => $this->input->post('product_name'),
                    'category_id' => $this->input->post('category_id'),
                    'price' => $this->input->post('price'),
                    'qty' => $this->input->post('qty'),
                    'description' => $this->input->post('description'),
                    'available_status' => $this->input->post('available_status') ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                // Handle image upload
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path'] = './uploads/products/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['max_size'] = 2048; // 2MB
                    $config['encrypt_name'] = TRUE;
                    
                    // Create directory if not exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                    }
                    
                    $this->load->library('upload', $config);
                    
                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $product_data['image'] = $upload_data['file_name'];
                    } else {
                        $data['error'] = $this->upload->display_errors('', '');
                        $this->load_admin_view('admin/products_form', $data);
                        return;
                    }
                }
                
                // Insert product
                if ($this->Product_model->create($product_data)) {
                    $this->session->set_flashdata('success', 'Product added successfully');
                    redirect(base_url('admin/products'));
                } else {
                    $data['error'] = 'Failed to add product';
                }
            }
        }
        
        $this->load_admin_view('admin/products_form', $data);
    }

    /**
     * Edit Product
     */
    public function products_edit($id = null)
    {
        if (!$id) {
            redirect(base_url('admin/products'));
        }
        
        $this->load->model(['Product_model', 'Category_model']);
        
        $product = $this->Product_model->get_by_id($id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect(base_url('admin/products'));
        }
        
        $data = $this->get_common_data('Edit Product', 'products');
        $data['categories'] = $this->Category_model->get_all();
        $data['product'] = $product;
        $data['mode'] = 'edit';
        
        // If form submitted
        if ($this->input->method() === 'post') {
            // Validation rules
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('qty', 'Quantity', 'required|integer');
            
            if ($this->form_validation->run() === TRUE) {
                // Prepare data
                $product_data = [
                    'product_name' => $this->input->post('product_name'),
                    'category_id' => $this->input->post('category_id'),
                    'price' => $this->input->post('price'),
                    'qty' => $this->input->post('qty'),
                    'description' => $this->input->post('description'),
                    'available_status' => $this->input->post('available_status') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Handle image upload
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path'] = './uploads/products/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['max_size'] = 2048; // 2MB
                    $config['encrypt_name'] = TRUE;
                    
                    // Create directory if not exists
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                    }
                    
                    $this->load->library('upload', $config);
                    
                    if ($this->upload->do_upload('image')) {
                        // Delete old image
                        if ($product->image && file_exists('./uploads/products/' . $product->image)) {
                            unlink('./uploads/products/' . $product->image);
                        }
                        
                        $upload_data = $this->upload->data();
                        $product_data['image'] = $upload_data['file_name'];
                    } else {
                        $data['error'] = $this->upload->display_errors('', '');
                        $this->load_admin_view('admin/products_form', $data);
                        return;
                    }
                }
                
                // Update product
                if ($this->Product_model->update($id, $product_data)) {
                    $this->session->set_flashdata('success', 'Product updated successfully');
                    redirect(base_url('admin/products'));
                } else {
                    $data['error'] = 'Failed to update product';
                }
            }
        }
        
        $this->load_admin_view('admin/products_form', $data);
    }

    /**
     * View Product Detail
     */
    public function products_view($id = null)
    {
        if (!$id) {
            redirect(base_url('admin/products'));
        }
        
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_by_id_with_category($id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect(base_url('admin/products'));
        }
        
        $data = $this->get_common_data('Product Detail', 'products');
        $data['product'] = $product;
        
        $this->load_admin_view('admin/products_view', $data);
    }

    /**
     * Delete Product
     */
    public function products_delete($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid product ID');
            redirect(base_url('admin/products'));
        }
        
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_by_id($id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect(base_url('admin/products'));
        }
        
        // Delete image file
        if ($product->image && file_exists('./uploads/products/' . $product->image)) {
            unlink('./uploads/products/' . $product->image);
        }
        
        // Delete product
        if ($this->Product_model->delete($id)) {
            $this->session->set_flashdata('success', 'Product deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete product');
        }
        
        redirect(base_url('admin/products'));
    }

    /**
     * Categories Management
     */
    public function categories($action = null, $id = null)
    {
        $this->load->model('Category_model');
        
        // Handle different actions
        switch ($action) {
            case 'add':
                $this->categories_add();
                return;
            case 'edit':
                $this->categories_edit();
                return;
            case 'delete':
                $this->categories_delete($id);
                return;
            default:
                // List categories
                $data = $this->get_common_data('Categories', 'categories');
                $data['categories'] = $this->Category_model->get_all();
                
                $this->load_admin_view('admin/categories', $data);
                break;
        }
    }

    /**
     * Add new category
     */
    private function categories_add()
    {
        $this->load->library('form_validation');
        
        // Validation rules
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('admin/categories'));
            return;
        }
        
        // Prepare data
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        ];
        
        // Insert to database
        $result = $this->Category_model->create($data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Category added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add category!');
        }
        
        redirect(base_url('admin/categories'));
    }

    /**
     * Edit category
     */
    private function categories_edit()
    {
        $this->load->library('form_validation');
        
        $id = $this->input->post('id');
        
        // Check if category exists
        $category = $this->Category_model->get_by_id($id);
        if (!$category) {
            $this->session->set_flashdata('error', 'Category not found!');
            redirect(base_url('admin/categories'));
            return;
        }
        
        // Validation rules
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('admin/categories'));
            return;
        }
        
        // Prepare data
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        ];
        
        // Update database
        $result = $this->Category_model->update($id, $data);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Category updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update category!');
        }
        
        redirect(base_url('admin/categories'));
    }

    /**
     * Delete category
     */
    private function categories_delete($id)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid category ID!');
            redirect(base_url('admin/categories'));
            return;
        }
        
        // Check if category exists
        $category = $this->Category_model->get_by_id($id);
        if (!$category) {
            $this->session->set_flashdata('error', 'Category not found!');
            redirect(base_url('admin/categories'));
            return;
        }
        
        // Check if category has products
        $this->load->model('Product_model');
        $products = $this->db->where('category_id', $id)->count_all_results('tbl_products');
        
        if ($products > 0) {
            $this->session->set_flashdata('error', 'Cannot delete category! There are ' . $products . ' products using this category.');
            redirect(base_url('admin/categories'));
            return;
        }
        
        // Delete category
        $result = $this->Category_model->delete($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Category deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category!');
        }
        
        redirect(base_url('admin/categories'));
    }

    /**
     * Orders Management
     */
    public function orders()
    {
        $this->load->model('Transaction_model');
        
        $data = $this->get_common_data('Orders', 'orders');
        $data['orders'] = $this->Transaction_model->get_all_with_customer();
        
        $this->load_admin_view('admin/orders', $data);
    }

    /**
     * Customers Management
     */
    public function customers()
    {
        $this->load->model('Customer_model');
        
        $data = $this->get_common_data('Customers', 'customers');
        $data['customers'] = $this->Customer_model->get_all();
        
        $this->load_admin_view('admin/customers', $data);
    }

    /**
     * Settings
     */
    public function settings()
    {
        $this->load->model('Setting_model');
        
        $data = $this->get_common_data('Settings', 'settings');
        $data['settings'] = $this->Setting_model->get_all();
        
        $this->load_admin_view('admin/settings', $data);
    }

    /**
     * Transactions Management
     */
    public function transactions()
    {
        $this->load->model('Transaction_model');
        
        $data = $this->get_common_data('Transactions', 'transactions');
        $data['transactions'] = $this->Transaction_model->get_all_with_customer();
        
        // Get counts by status
        $data['completed'] = $this->db->where('status', 'completed')->count_all_results('tbl_transactions');
        $data['pending'] = $this->db->where('status', 'pending')->count_all_results('tbl_transactions');
        $data['processing'] = $this->db->where('status', 'processing')->count_all_results('tbl_transactions');
        $data['cancelled'] = $this->db->where('status', 'cancelled')->count_all_results('tbl_transactions');
        
        $this->load_admin_view('admin/transactions', $data);
    }

    /**
     * Admin Login Page
     */
    public function login()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect(base_url('admin'));
        }
        
        $this->load->view('admin/login');
    }

    /**
     * Process Admin Login
     */
    public function do_login()
    {
        $this->load->model('Admin_model');
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $admin = $this->Admin_model->verify_login($username, $password);
        
        if ($admin) {
            $this->session->set_userdata([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
                'admin_role' => $admin->role ?? 'admin'
            ]);
            
            // Redirect to intended URL or admin dashboard
            $redirect_url = $this->session->userdata('admin_redirect_url');
            if ($redirect_url) {
                $this->session->unset_userdata('admin_redirect_url');
                redirect($redirect_url);
            } else {
                redirect(base_url('admin'));
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect(base_url('admin/login'));
        }
    }

    /**
     * Admin Logout
     */
    public function logout()
    {
        $this->session->unset_userdata(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
        $this->session->set_flashdata('success', 'You have been logged out');
        redirect(base_url('admin/login'));
    }

    /**
     * Test Routing (For Debugging)
     * Access: http://localhost/ciproject/admin/test_routing
     */
    public function test_routing()
    {
        $this->load->view('test_products_routing');
    }
}
