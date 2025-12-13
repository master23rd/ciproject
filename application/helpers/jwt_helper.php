<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JWT Authentication Helper Functions
 */

if (!function_exists('jwt_check_auth')) {
    /**
     * Check if user is authenticated via JWT
     * 
     * @return bool
     */
    function jwt_check_auth()
    {
        $CI =& get_instance();
        $CI->load->library('jwt_auth');
        
        return $CI->jwt_auth->is_logged_in();
    }
}

if (!function_exists('jwt_get_user')) {
    /**
     * Get current authenticated user data from JWT
     * 
     * @return object|null
     */
    function jwt_get_user()
    {
        $CI =& get_instance();
        $CI->load->library('jwt_auth');
        
        return $CI->jwt_auth->get_user_data();
    }
}

if (!function_exists('jwt_get_user_id')) {
    /**
     * Get current authenticated user ID from JWT
     * 
     * @return int|null
     */
    function jwt_get_user_id()
    {
        $user = jwt_get_user();
        
        if ($user && isset($user->user_id)) {
            return $user->user_id;
        }
        
        return null;
    }
}

if (!function_exists('jwt_require_auth')) {
    /**
     * Require authentication - redirect to login if not authenticated
     * 
     * @param string $redirect_url URL to redirect to if not authenticated
     * @return void
     */
    function jwt_require_auth($redirect_url = null)
    {
        if (!jwt_check_auth()) {
            $CI =& get_instance();
            
            if ($redirect_url === null) {
                $redirect_url = base_url('login');
            }
            
            // For AJAX requests, return JSON response
            if ($CI->input->is_ajax_request()) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Authentication required'
                ]);
                exit;
            }
            
            // Store current URL for redirect after login
            $CI->load->library('session');
            $CI->session->set_userdata('redirect_after_login', current_url());
            
            redirect($redirect_url);
        }
    }
}

if (!function_exists('jwt_api_require_auth')) {
    /**
     * Require authentication for API - returns JSON error if not authenticated
     * 
     * @return object|void Returns user data or exits with error
     */
    function jwt_api_require_auth()
    {
        $user = jwt_get_user();
        
        if (!$user) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid or expired token',
                'error_code' => 'UNAUTHORIZED'
            ]);
            exit;
        }
        
        return $user;
    }
}

if (!function_exists('jwt_get_token')) {
    /**
     * Get current JWT token from request
     * 
     * @return string|null
     */
    function jwt_get_token()
    {
        $CI =& get_instance();
        $CI->load->library('jwt_auth');
        
        return $CI->jwt_auth->get_token_from_request();
    }
}
