<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JWT Configuration
 */

$config['jwt_secret_key'] = 'jwt-super-key';

$config['jwt_algorithm'] = 'HS256';

$config['jwt_access_token_expiration'] = 86400; // 24 hours

$config['jwt_refresh_token_expiration'] = 604800; // 7 days

$config['jwt_issuer'] = 'ShopHub';

$config['jwt_cookie_name'] = 'auth_token';

$config['jwt_refresh_cookie_name'] = 'refresh_token';
