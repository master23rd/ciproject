<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

/**
 * JWT Authentication Library for CodeIgniter
 * Compatible with PHP 7.3+
 */
class Jwt_auth {

    protected $CI;
    protected $secret_key;
    protected $algorithm;
    protected $access_token_expiration;
    protected $refresh_token_expiration;
    protected $issuer;
    protected $cookie_name;
    protected $refresh_cookie_name;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->config('jwt');

        $this->secret_key = $this->CI->config->item('jwt_secret_key');
        $this->algorithm = $this->CI->config->item('jwt_algorithm');
        $this->access_token_expiration = $this->CI->config->item('jwt_access_token_expiration');
        $this->refresh_token_expiration = $this->CI->config->item('jwt_refresh_token_expiration');
        $this->issuer = $this->CI->config->item('jwt_issuer');
        $this->cookie_name = $this->CI->config->item('jwt_cookie_name');
        $this->refresh_cookie_name = $this->CI->config->item('jwt_refresh_cookie_name');
    }

    /**
     * Generate Access Token
     * 
     * @param array $user_data Data user yang akan dimasukkan ke token
     * @return string JWT token
     */
    public function generate_access_token($user_data)
    {
        $issued_at = time();
        $expiration = $issued_at + $this->access_token_expiration;

        $payload = [
            'iss' => $this->issuer,           // Issuer
            'iat' => $issued_at,               // Issued at
            'exp' => $expiration,              // Expiration time
            'type' => 'access',                // Token type
            'data' => $user_data               // User data
        ];

        return JWT::encode($payload, $this->secret_key, $this->algorithm);
    }

    /**
     * Generate Refresh Token
     * 
     * @param array $user_data Data user minimal (biasanya hanya user_id)
     * @return string JWT refresh token
     */
    public function generate_refresh_token($user_data)
    {
        $issued_at = time();
        $expiration = $issued_at + $this->refresh_token_expiration;

        $payload = [
            'iss' => $this->issuer,
            'iat' => $issued_at,
            'exp' => $expiration,
            'type' => 'refresh',
            'data' => $user_data
        ];

        return JWT::encode($payload, $this->secret_key, $this->algorithm);
    }

    /**
     * Verify and decode token
     * 
     * @param string $token JWT token
     * @return object|false Decoded token atau false jika invalid
     */
    public function verify_token($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret_key, $this->algorithm));
            return $decoded;
        } catch (ExpiredException $e) {
            // Token expired
            return false;
        } catch (\Exception $e) {
            // Token invalid
            return false;
        }
    }

    /**
     * Get token from request (header, cookie, atau parameter)
     * 
     * @return string|null Token atau null
     */
    public function get_token_from_request()
    {
        // 1. Check Authorization header (Bearer token)
        $headers = $this->get_authorization_header();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        // 2. Check cookie
        $token = $this->CI->input->cookie($this->cookie_name);
        if (!empty($token)) {
            return $token;
        }

        // 3. Check POST/GET parameter
        $token = $this->CI->input->post('token');
        if (!empty($token)) {
            return $token;
        }

        $token = $this->CI->input->get('token');
        if (!empty($token)) {
            return $token;
        }

        return null;
    }

    /**
     * Get refresh token from request
     * 
     * @return string|null Token atau null
     */
    public function get_refresh_token()
    {
        // Check cookie
        $token = $this->CI->input->cookie($this->refresh_cookie_name);
        if (!empty($token)) {
            return $token;
        }

        // Check POST parameter
        $token = $this->CI->input->post('refresh_token');
        if (!empty($token)) {
            return $token;
        }

        return null;
    }

    /**
     * Set token ke cookie
     * 
     * @param string $access_token Access token
     * @param string $refresh_token Refresh token
     */
    public function set_token_cookies($access_token, $refresh_token = null)
    {
        // Set access token cookie
        $this->CI->input->set_cookie([
            'name'   => $this->cookie_name,
            'value'  => $access_token,
            'expire' => $this->access_token_expiration,
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        // Set refresh token cookie
        if ($refresh_token) {
            $this->CI->input->set_cookie([
                'name'   => $this->refresh_cookie_name,
                'value'  => $refresh_token,
                'expire' => $this->refresh_token_expiration,
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }
    }

    /**
     * Clear token cookies (logout)
     */
    public function clear_token_cookies()
    {
        $this->CI->input->set_cookie([
            'name'   => $this->cookie_name,
            'value'  => '',
            'expire' => -1
        ]);

        $this->CI->input->set_cookie([
            'name'   => $this->refresh_cookie_name,
            'value'  => '',
            'expire' => -1
        ]);
    }

    /**
     * Validate current request - check if user is authenticated
     * 
     * @return object|false User data atau false
     */
    public function validate_request()
    {
        $token = $this->get_token_from_request();
        
        if (empty($token)) {
            return false;
        }

        $decoded = $this->verify_token($token);
        
        if (!$decoded) {
            return false;
        }

        // Check token type
        if (!isset($decoded->type) || $decoded->type !== 'access') {
            return false;
        }

        return $decoded->data;
    }

    /**
     * Get user data from current token
     * 
     * @return object|null User data atau null
     */
    public function get_user_data()
    {
        return $this->validate_request();
    }

    /**
     * Check if user is logged in
     * 
     * @return bool
     */
    public function is_logged_in()
    {
        return $this->validate_request() !== false;
    }

    /**
     * Get Authorization header
     * 
     * @return string|null
     */
    protected function get_authorization_header()
    {
        $headers = null;
        
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER['Authorization']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
        } elseif (function_exists('apache_request_headers')) {
            $request_headers = apache_request_headers();
            $request_headers = array_combine(
                array_map('ucwords', array_keys($request_headers)),
                array_values($request_headers)
            );
            if (isset($request_headers['Authorization'])) {
                $headers = trim($request_headers['Authorization']);
            }
        }

        return $headers;
    }

    /**
     * Refresh access token using refresh token
     * 
     * @return array|false New tokens atau false
     */
    public function refresh_access_token()
    {
        $refresh_token = $this->get_refresh_token();
        
        if (empty($refresh_token)) {
            return false;
        }

        $decoded = $this->verify_token($refresh_token);
        
        if (!$decoded) {
            return false;
        }

        // Check token type
        if (!isset($decoded->type) || $decoded->type !== 'refresh') {
            return false;
        }

        // Generate new tokens
        $user_data = (array) $decoded->data;
        $new_access_token = $this->generate_access_token($user_data);
        $new_refresh_token = $this->generate_refresh_token(['user_id' => $user_data['user_id']]);

        return [
            'access_token' => $new_access_token,
            'refresh_token' => $new_refresh_token
        ];
    }

    /**
     * Get token expiration info
     * 
     * @param string $token
     * @return array|false
     */
    public function get_token_info($token)
    {
        $decoded = $this->verify_token($token);
        
        if (!$decoded) {
            return false;
        }

        return [
            'issued_at' => date('Y-m-d H:i:s', $decoded->iat),
            'expires_at' => date('Y-m-d H:i:s', $decoded->exp),
            'expires_in' => $decoded->exp - time(),
            'type' => $decoded->type,
            'data' => $decoded->data
        ];
    }
}
