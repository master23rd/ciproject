<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->library('session');
        $this->load->library('jwt_auth');
    }

    /**
     * Login page
     */
    public function login()
    {
        // If already logged in via JWT, redirect to home
        if ($this->jwt_auth->is_logged_in()) {
            redirect(base_url());
        }

        // Handle POST login
        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Try to find customer by email
            $customer = $this->Customer_model->verify_login($username, $password);

            if ($customer) {
                // Create JWT token payload
                $user_data = [
                    'user_id' => $customer->id,
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->customer_name,
                    'customer_email' => $customer->email,
                    'user_name' => $customer->customer_name,
                    'user_email' => $customer->email
                ];

                // Generate JWT tokens
                $access_token = $this->jwt_auth->generate_access_token($user_data);
                $refresh_token = $this->jwt_auth->generate_refresh_token(['user_id' => $customer->id]);

                // Set tokens in cookies
                $this->jwt_auth->set_token_cookies($access_token, $refresh_token);

                // Also set session for backward compatibility
                $this->session->set_userdata([
                    'customer_logged_in' => true,
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->customer_name,
                    'customer_email' => $customer->email,
                    'user_logged_in' => true,
                    'user_name' => $customer->customer_name,
                    'user_email' => $customer->email,
                    'jwt_token' => $access_token
                ]);

                // Redirect to intended page or home
                $redirect_url = $this->session->userdata('redirect_after_login');
                if ($redirect_url) {
                    $this->session->unset_userdata('redirect_after_login');
                    redirect($redirect_url);
                } else {
                    redirect(base_url());
                }
            } else {
                // Login failed
                $this->session->set_flashdata('error', 'Invalid email or password');
                redirect(base_url('login'));
            }
        }

        // Show login page
        $this->load->view('pages/login');
    }

    /**
     * API Login - Returns JWT token as JSON response
     */
    public function api_login()
    {
        header('Content-Type: application/json');

        if ($this->input->method() !== 'post') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

		$raw = json_decode(file_get_contents("php://input"), true);

		$username    = $raw['email'] ?? null;
    	$password = $raw['password'] ?? null;

        // $username = $this->input->post('email');
        // $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Username and password are required']);
            return;
        }

        $customer = $this->Customer_model->verify_login($username, $password);

        if ($customer) {
            $user_data = [
                'user_id' => $customer->id,
                'customer_id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'customer_email' => $customer->email
            ];

            $access_token = $this->jwt_auth->generate_access_token($user_data);
            $refresh_token = $this->jwt_auth->generate_refresh_token(['user_id' => $customer->id]);

            // Set cookies
            $this->jwt_auth->set_token_cookies($access_token, $refresh_token);

            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token,
                    'token_type' => 'Bearer',
                    'expires_in' => $this->config->item('jwt_access_token_expiration'),
                    'user' => $user_data
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    }

    /**
     * Refresh Token API
     */
    public function refresh_token()
    {
        header('Content-Type: application/json');

        $new_tokens = $this->jwt_auth->refresh_access_token();

        if ($new_tokens) {
            $this->jwt_auth->set_token_cookies($new_tokens['access_token'], $new_tokens['refresh_token']);

            echo json_encode([
                'success' => true,
                'message' => 'Token refreshed successfully',
                'data' => [
                    'access_token' => $new_tokens['access_token'],
                    'refresh_token' => $new_tokens['refresh_token'],
                    'token_type' => 'Bearer',
                    'expires_in' => $this->config->item('jwt_access_token_expiration')
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid or expired refresh token']);
        }
    }

    /**
     * Verify Token API
     */
    public function verify()
    {
        header('Content-Type: application/json');

        $user_data = $this->jwt_auth->validate_request();

        if ($user_data) {
            echo json_encode([
                'success' => true,
                'message' => 'Token is valid',
                'data' => [
                    'user' => $user_data
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Clear JWT cookies
        $this->jwt_auth->clear_token_cookies();

        // Clear all session data
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

    /**
     * API Logout
     */
    public function api_logout()
    {
        header('Content-Type: application/json');

        $this->jwt_auth->clear_token_cookies();
        $this->session->sess_destroy();

        echo json_encode([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }

    /**
     * Register page
     */
    public function register()
    {
        // If already logged in, redirect to home
        if ($this->session->userdata('customer_logged_in')) {
            redirect(base_url());
        }

        // Handle POST register
        if ($this->input->method() === 'post') {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');

            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                $this->session->set_flashdata('error', 'All fields are required');
                redirect(base_url('register'));
            }

            if ($password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Passwords do not match');
                redirect(base_url('register'));
            }

            if ($this->Customer_model->email_exists($email)) {
                $this->session->set_flashdata('error', 'Email already registered');
                redirect(base_url('register'));
            }

            // Create customer
            $customer_id = $this->Customer_model->create([
                'customer_name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            if ($customer_id) {
                $this->session->set_flashdata('success', 'Registration successful! Please login.');
                redirect(base_url('login'));
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect(base_url('register'));
            }
        }

        // Show register page
        $this->load->view('pages/register');
    }

    /**
     * Check login status (AJAX) - supports both session and JWT
     */
    public function check()
    {
        header('Content-Type: application/json');
        
        // First check JWT token
        $jwt_user = $this->jwt_auth->get_user_data();
        
        if ($jwt_user) {
            echo json_encode([
                'logged_in' => true,
                'auth_method' => 'jwt',
                'customer_id' => $jwt_user->customer_id ?? $jwt_user->user_id,
                'customer_name' => $jwt_user->customer_name ?? $jwt_user->user_name
            ]);
            return;
        }
        
        // Fallback to session
        echo json_encode([
            'logged_in' => $this->session->userdata('customer_logged_in') === true,
            'auth_method' => 'session',
            'customer_id' => $this->session->userdata('customer_id'),
            'customer_name' => $this->session->userdata('customer_name')
        ]);
    }
}
