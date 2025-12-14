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
		header('Content-Type: application/json');
       
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
                'image' => $product->image,
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
		header('Content-Type: application/json');
       
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
		header('Content-Type: application/json');
       
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
		header('Content-Type: application/json');
       
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
		header('Content-Type: application/json');
       
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
		header('Content-Type: application/json');
       
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
		header('Content-Type: application/json');
       
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
		header('Content-Type: application/json');
       
        $this->load->model('Image_model');
        $images = $this->Image_model->get_by_product($product_id);
        
        if (empty($images)) {
            return [$this->get_product_image($product_id)];
        }

        return array_map(function($img) {
            return base_url($img->image_path);
        }, $images);
    }

	/**
	 * Get Orders Page - Display user's orders
	 */
	public function get_my_orders()
	{
		header('Content-Type: application/json');
       
		$user = $this->jwt_auth->validate_request();

        if (!$user) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

		// Load models
		$this->load->model('Transaction_model');
		$this->load->model('Detail_transaction_model');

		
		// Get customer's orders
		$orders = $this->Transaction_model->get_by_customer($user->user_id);

		// Get order details for each order
		foreach ($orders as &$order) {
			$order->items = $this->Detail_transaction_model->get_by_order_number($order->order_number);
			$order->item_count = count($order->items);
		}

		echo json_encode([
            'success' => true,
            'data' => $orders,
        ]);
	}

	/**
	 * Download My Receipt (PDF)
	 */
	public function get_my_receipt()
	{
		print_r('test');
		exit;
		
		$user = $this->jwt_auth->validate_request();

		if (!$user) {
			http_response_code(401);
			echo json_encode(['success' => false, 'message' => 'Unauthorized']);
			return;
		}

		$raw = json_decode(file_get_contents("php://input"), true);

		$order_number    = $raw['order_number'] ?? null;
		if (!$order_number) {
			show_error('Order number is required', 400);
			return;
		}

		// Load models
		$this->load->model([
			'Transaction_model',
			'Detail_transaction_model',
			'Customer_model'
		]);

		$transaction = $this->Transaction_model->get_by_order_number($order_number);
		var_dump($transaction);
		if (!$transaction) {
			show_error('Order not found', 404);
			return;
		}

		$customer = $this->Customer_model->get_by_id($transaction->customer_id);
		$details  = $this->Detail_transaction_model->get_by_order_number($order_number);

		$items = [];
		$subtotal = 0;

		foreach ($details as $detail) {
			$total = $detail->price * $detail->qty;
			$items[] = [
				'id'    => $detail->product_id,
				'name'  => $detail->product_name,
				'price' => $detail->price,
				'qty'   => $detail->qty,
				'total' => $total
			];
			$subtotal += $total;
		}

		$order = $this->normalize_order_data([
			'order_number' => $transaction->order_number,
			'order_date'   => date('F j, Y - H:i', strtotime($transaction->created_at)),
			'customer' => [
				'name'    => $transaction->receiver_name ?? ($customer->customer_name ?? 'Customer'),
				'email'   => $customer->email ?? '',
				'phone'   => $transaction->phone ?? '',
				'address' => $transaction->address ?? '',
				'city'    => $transaction->city ?? '',
				'zip'     => $transaction->postal_code ?? ''
			],
			'items'        => $items,
			'item_count'   => count($items),
			'subtotal'     => $subtotal,
			'shipping'     => 0,
			'total'        => $transaction->grand_total,
			'payment_method' => 'Credit Card'
		]);

		// 🔥 HARD RESET OUTPUT (CRITICAL)
		while (ob_get_level()) {
			ob_end_clean();
		}

		header_remove();
		$this->output->enable_profiler(false);

		// 🔥 FORCE PDF HEADERS
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Expose-Headers: Content-Disposition');
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="receipt-'.$order_number.'.pdf"');
		header('Cache-Control: private, max-age=0, must-revalidate');
		header('Pragma: public');

		// 🔥 OUTPUT RAW PDF
		$this->load->library('pdf_invoice');
		// Download PDF
        $this->pdf_invoice->download($order);

		exit;
	}


	/**
     * Normalize order data to ensure all fields exist
     * 
     * @param array $order
     * @return array
     */
    protected function normalize_order_data($order)
    {
        // Set defaults for missing fields
        $defaults = [
            'order_number' => 'N/A',
            'order_date' => date('F j, Y - H:i'),
            'customer' => [
                'name' => 'Customer',
                'email' => '',
                'phone' => '',
                'address' => '',
                'city' => '',
                'zip' => ''
            ],
            'items' => [],
            'item_count' => 0,
            'subtotal' => 0,
            'shipping' => 0,
            'total' => 0,
            'payment_method' => 'Credit Card'
        ];

        // Merge with defaults
        $order = array_merge($defaults, $order);

        // Ensure customer array has all fields
        if (isset($order['customer']) && is_array($order['customer'])) {
            $order['customer'] = array_merge($defaults['customer'], $order['customer']);
        }

        return $order;
    }
}
