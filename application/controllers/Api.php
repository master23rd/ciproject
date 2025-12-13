<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Controller for Products
 * Provides RESTful API endpoints for product data
 */
class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->library('jwt_auth');
        
        // Set JSON header for all responses
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type');
        
        // Handle preflight requests
        if ($this->input->method() === 'options') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * Get all products
     * GET /api/products
     */
    public function products()
    {
        $category_id = $this->input->get('category_id');
        $search = $this->input->get('search');
        $limit = $this->input->get('limit') ? (int) $this->input->get('limit') : null;
        $offset = $this->input->get('offset') ? (int) $this->input->get('offset') : 0;
        
        // Get products
        if ($category_id) {
            $products = $this->Product_model->get_by_category($category_id);
        } else {
            $products = $this->Product_model->get_all_with_category();
        }
        
        // Search filter
        if ($search) {
            $products = array_filter($products, function($product) use ($search) {
                return stripos($product->product_name, $search) !== false ||
                       stripos($product->description, $search) !== false;
            });
            $products = array_values($products); // Re-index array
        }
        
        $total = count($products);
        
        // Apply limit and offset
        if ($limit) {
            $products = array_slice($products, $offset, $limit);
        }
        
        // Format products data
        $formatted_products = array_map(function($product) {
            return [
                'id' => (int) $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => (float) $product->price,
                'weight' => (float) $product->weight,
                'qty' => (int) $product->qty,
                'available_status' => (bool) $product->available_status,
                'category_id' => (int) $product->category_id,
                'category_name' => $product->category_name ?? null,
                'image' => $this->get_product_image($product->id),
                'created_at' => $product->created_at ?? null,
                'updated_at' => $product->updated_at ?? null
            ];
        }, $products);

        echo json_encode([
            'success' => true,
            'data' => $formatted_products,
            'meta' => [
                'total' => $total,
                'count' => count($formatted_products),
                'offset' => $offset,
                'limit' => $limit
            ]
        ]);
    }

    /**
     * Get single product by ID
     * GET /api/products/:id
     */
    public function product($id = null)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            return;
        }

        $product = $this->Product_model->get_by_id_with_category($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            return;
        }

        $formatted_product = [
            'id' => (int) $product->id,
            'product_name' => $product->product_name,
            'description' => $product->description,
            'price' => (float) $product->price,
            'weight' => (float) $product->weight,
            'qty' => (int) $product->qty,
            'available_status' => (bool) $product->available_status,
            'category_id' => (int) $product->category_id,
            'category_name' => $product->category_name ?? null,
            'image' => $this->get_product_image($product->id),
            'images' => $this->get_product_images($product->id),
            'created_at' => $product->created_at ?? null,
            'updated_at' => $product->updated_at ?? null
        ];

        echo json_encode([
            'success' => true,
            'data' => $formatted_product
        ]);
    }

    /**
     * Get all categories
     * GET /api/categories
     */
    public function categories()
    {
        $categories = $this->Category_model->get_all();

        $formatted_categories = array_map(function($category) {
            return [
                'id' => (int) $category->id,
                'name' => $category->name,
                'description' => $category->description ?? null
            ];
        }, $categories);

        echo json_encode([
            'success' => true,
            'data' => $formatted_categories
        ]);
    }

    /**
     * Get single category by ID
     * GET /api/categories/:id
     */
    public function category($id = null)
    {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Category ID is required']);
            return;
        }

        $category = $this->Category_model->get_by_id($id);

        if (!$category) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Category not found']);
            return;
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => (int) $category->id,
                'name' => $category->name,
                'description' => $category->description ?? null
            ]
        ]);
    }

    /**
     * Get products by category
     * GET /api/categories/:id/products
     */
    public function category_products($category_id = null)
    {
        if (!$category_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Category ID is required']);
            return;
        }

        $products = $this->Product_model->get_by_category($category_id);

        $formatted_products = array_map(function($product) {
            return [
                'id' => (int) $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => (float) $product->price,
                'weight' => (float) $product->weight,
                'qty' => (int) $product->qty,
                'available_status' => (bool) $product->available_status,
                'image' => $this->get_product_image($product->id)
            ];
        }, $products);

        echo json_encode([
            'success' => true,
            'data' => $formatted_products
        ]);
    }

    /**
     * Search products
     * GET /api/products/search?q=keyword
     */
    public function search()
    {
        $query = $this->input->get('q');

        if (empty($query)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Search query is required']);
            return;
        }

        $products = $this->Product_model->get_all_with_category();
        
        $filtered = array_filter($products, function($product) use ($query) {
            return stripos($product->product_name, $query) !== false ||
                   stripos($product->description, $query) !== false;
        });

        $formatted_products = array_map(function($product) {
            return [
                'id' => (int) $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => (float) $product->price,
                'weight' => (float) $product->weight,
                'qty' => (int) $product->qty,
                'category_name' => $product->category_name ?? null,
                'image' => $this->get_product_image($product->id)
            ];
        }, array_values($filtered));

        echo json_encode([
            'success' => true,
            'data' => $formatted_products,
            'meta' => [
                'query' => $query,
                'count' => count($formatted_products)
            ]
        ]);
    }

    /**
     * Protected endpoint example - requires JWT authentication
     * GET /api/user/profile
     */
    public function user_profile()
    {
        $user = $this->jwt_auth->validate_request();

        if (!$user) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'user_id' => $user->user_id,
                'name' => $user->customer_name ?? $user->user_name,
                'email' => $user->customer_email ?? $user->user_email
            ]
        ]);
    }

    /**
     * Get product main image URL
     */
    private function get_product_image($product_id)
    {
        $this->load->model('Image_model');
        $image = $this->Image_model->get_primary_image($product_id);
        
        if ($image && !empty($image->image_path)) {
            return base_url($image->image_path);
        }
        
        // Default placeholder image
        return 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400';
    }

    /**
     * Get all product images
     */
    private function get_product_images($product_id)
    {
        $this->load->model('Image_model');
        $images = $this->Image_model->get_by_product($product_id);
        
        if (empty($images)) {
            return [$this->get_product_image($product_id)];
        }

        return array_map(function($img) {
            return base_url($img->image_path);
        }, $images);
    }
}
