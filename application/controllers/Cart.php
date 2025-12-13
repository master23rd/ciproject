<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('session');
    }

    /**
     * Check if user is logged in
     */
    private function is_logged_in()
    {
        return $this->session->userdata('customer_logged_in') === true;
    }

    /**
     * Get cart from session
     */
    private function get_cart()
    {
        $cart = $this->session->userdata('cart');
        return $cart ? $cart : [];
    }

    /**
     * Save cart to session
     */
    private function save_cart($cart)
    {
        $this->session->set_userdata('cart', $cart);
    }

    /**
     * Add item to cart (AJAX)
     */
    public function add()
    {
        // Set JSON header
        header('Content-Type: application/json');

        // Check if logged in
        if (!$this->is_logged_in()) {
            echo json_encode([
                'success' => false,
                'redirect' => true,
                'message' => 'Please login to add items to cart',
                'redirect_url' => base_url('login')
            ]);
            return;
        }

        // Get product ID and quantity from POST
        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty') ? (int) $this->input->post('qty') : 1;

        if (!$product_id) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid product'
            ]);
            return;
        }

        // Get product info
        $product = $this->Product_model->get_by_id($product_id);

        if (!$product) {
            echo json_encode([
                'success' => false,
                'message' => 'Product not found'
            ]);
            return;
        }

        // Check stock
        if ($product->qty < $qty) {
            echo json_encode([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $product->qty
            ]);
            return;
        }

        // Get current cart
        $cart = $this->get_cart();

        // Check if product already in cart
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $product_id) {
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }

        // If not found, add new item
        if (!$found) {
            $cart[] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'qty' => $qty,
                'image' => $product->image,
                'weight' => $product->weight
            ];
        }

        // Save cart
        $this->save_cart($cart);

        // Return success with cart data
        echo json_encode([
            'success' => true,
            'message' => 'Product added to cart',
            'cart' => $cart,
            'cart_count' => $this->get_cart_count(),
            'cart_total' => $this->get_cart_total(),
            'cart_html' => $this->get_cart_html()
        ]);
    }

    /**
     * Update cart item quantity (AJAX)
     */
    public function update()
    {
        header('Content-Type: application/json');

        if (!$this->is_logged_in()) {
            echo json_encode(['success' => false, 'message' => 'Please login']);
            return;
        }

        $product_id = $this->input->post('product_id');
        $qty = (int) $this->input->post('qty');

        if ($qty < 1) {
            // Remove item if qty is 0
            return $this->remove();
        }

        $cart = $this->get_cart();

        foreach ($cart as &$item) {
            if ($item['id'] == $product_id) {
                $item['qty'] = $qty;
                break;
            }
        }

        $this->save_cart($cart);

        echo json_encode([
            'success' => true,
            'cart_count' => $this->get_cart_count(),
            'cart_total' => $this->get_cart_total(),
            'cart_html' => $this->get_cart_html()
        ]);
    }

    /**
     * Remove item from cart (AJAX)
     */
    public function remove()
    {
        header('Content-Type: application/json');

        if (!$this->is_logged_in()) {
            echo json_encode(['success' => false, 'message' => 'Please login']);
            return;
        }

        $product_id = $this->input->post('product_id');
        $cart = $this->get_cart();

        $cart = array_filter($cart, function($item) use ($product_id) {
            return $item['id'] != $product_id;
        });

        $this->save_cart(array_values($cart));

        echo json_encode([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $this->get_cart_count(),
            'cart_total' => $this->get_cart_total(),
            'cart_html' => $this->get_cart_html()
        ]);
    }

    /**
     * Clear cart (AJAX)
     */
    public function clear()
    {
        header('Content-Type: application/json');

        $this->save_cart([]);

        echo json_encode([
            'success' => true,
            'message' => 'Cart cleared',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }

    /**
     * Get cart count
     */
    public function get_cart_count()
    {
        $cart = $this->get_cart();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['qty'];
        }
        return $count;
    }

    /**
     * Get cart total
     */
    public function get_cart_total()
    {
        $cart = $this->get_cart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    /**
     * Get cart HTML for offcanvas
     */
    private function get_cart_html()
    {
        $cart = $this->get_cart();
        
        if (empty($cart)) {
            return '<div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-muted">Your cart is empty</p>
                <a href="' . base_url() . '" class="btn btn-primary">Continue Shopping</a>
            </div>';
        }

        $html = '<div class="cart-items">';
        foreach ($cart as $item) {
            $image_url = $item['image'] ? base_url('uploads/products/' . $item['image']) : 'https://via.placeholder.com/100';
            $html .= '
            <div class="cart-item" data-id="' . $item['id'] . '">
                <img src="' . $image_url . '" alt="' . htmlspecialchars($item['name']) . '">
                <div class="cart-item-details">
                    <h6 class="cart-item-name">' . htmlspecialchars($item['name']) . '</h6>
                    <div class="cart-item-price">$ ' . number_format($item['price'], 2) . '</div>
                </div>
                <div class="cart-item-actions">
                    <div class="quantity-control">
                        <button class="qty-btn minus" onclick="updateCartQty(' . $item['id'] . ', -1)"><i class="fas fa-minus"></i></button>
                        <input type="number" class="qty-input" value="' . $item['qty'] . '" min="1" max="10" readonly>
                        <button class="qty-btn plus" onclick="updateCartQty(' . $item['id'] . ', 1)"><i class="fas fa-plus"></i></button>
                    </div>
                    <button class="btn-remove" onclick="removeFromCart(' . $item['id'] . ')" title="Remove">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Get cart data (AJAX) - for checking login status
     */
    public function get_data()
    {
        header('Content-Type: application/json');

        echo json_encode([
            'logged_in' => $this->is_logged_in(),
            'cart' => $this->get_cart(),
            'cart_count' => $this->get_cart_count(),
            'cart_total' => $this->get_cart_total()
        ]);
    }

    /**
     * View cart page
     */
    public function index()
    {
        $data['cart'] = $this->get_cart();
        $data['cart_count'] = $this->get_cart_count();
        $data['cart_total'] = $this->get_cart_total();
        
        $this->load->view('templates/public-layout/header', $data);
        $this->load->view('pages/cart', $data);
        $this->load->view('templates/public-layout/footer');
    }
}
