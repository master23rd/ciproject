<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['checkout'] = 'welcome/checkout';
$route['checkout/success'] = 'welcome/success';
$route['success'] = 'welcome/success';
$route['process_checkout'] = 'welcome/process_checkout';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['register'] = 'auth/register';

// Cart routes
$route['cart'] = 'cart/index';
$route['cart/add'] = 'cart/add';
$route['cart/update'] = 'cart/update';
$route['cart/remove'] = 'cart/remove';
$route['cart/clear'] = 'cart/clear';
$route['cart/data'] = 'cart/get_data';

// Payment routes
$route['payment/create_payment_intent'] = 'payment/create_payment_intent';
$route['payment/confirm_payment'] = 'payment/confirm_payment';
$route['payment/get_public_key'] = 'payment/get_public_key';
$route['payment/get_secret_key'] = 'payment/get_secret_key';
$route['payment/webhook'] = 'payment/webhook';

// Invoice routes
$route['invoice/download/(:any)'] = 'invoice/download/$1';
$route['invoice/view/(:any)'] = 'invoice/view/$1';
$route['invoice/download-session'] = 'invoice/download_from_session';

// User Orders routes
$route['orders'] = 'welcome/my_orders';
$route['my-orders'] = 'welcome/my_orders';

// Admin routes
$route['admin'] = 'admin/index';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/test_routing'] = 'admin/test_routing';  // For debugging

// Products routes (specific routes must come first)
$route['admin/products/add'] = 'admin/products_add';
$route['admin/products/edit/(:num)'] = 'admin/products_edit/$1';
$route['admin/products/view/(:num)'] = 'admin/products_view/$1';
$route['admin/products/delete/(:num)'] = 'admin/products_delete/$1';
$route['admin/products'] = 'admin/products';

$route['admin/orders'] = 'admin/orders';
$route['admin/orders/(:any)'] = 'admin/orders/$1';
$route['admin/orders/(:any)/(:num)'] = 'admin/orders/$1/$2';
$route['admin/categories'] = 'admin/categories';
$route['admin/categories/(:any)'] = 'admin/categories/$1';
$route['admin/categories/(:any)/(:num)'] = 'admin/categories/$1/$2';
$route['admin/customers'] = 'admin/customers';
$route['admin/customers/add'] = 'admin/customers_add';
$route['admin/customers/edit/(:num)'] = 'admin/customers_edit/$1';
$route['admin/customers/view/(:num)'] = 'admin/customers_view/$1';
$route['admin/customers/delete/(:num)'] = 'admin/customers_delete/$1';
$route['admin/transactions'] = 'admin/transactions';
$route['admin/transactions/(:any)'] = 'admin/transactions/$1';
$route['admin/transactions/(:any)/(:num)'] = 'admin/transactions/$1/$2';
$route['admin/settings'] = 'admin/settings';
$route['admin/settings/(:any)'] = 'admin/settings/$1';
$route['admin/login'] = 'admin/login';
$route['admin/do_login'] = 'admin/do_login';
$route['admin/logout'] = 'admin/logout';

// JWT Auth API routes
$route['api/auth/login'] = 'auth/api_login';
$route['api/auth/logout'] = 'auth/api_logout';
$route['api/auth/refresh'] = 'auth/refresh_token';
$route['api/auth/verify'] = 'auth/verify';
$route['api/auth/check'] = 'auth/check';

// Product API routes
$route['api/products'] = 'api/products';
$route['api/products/search'] = 'api/search';
$route['api/products/(:num)'] = 'api/product/$1';
$route['api/categories'] = 'api/categories';
$route['api/categories/(:num)'] = 'api/category/$1';
$route['api/categories/(:num)/products'] = 'api/category_products/$1';

// User API routes (protected)
$route['api/user/profile'] = 'api/user_profile';
$route['api/user/orders'] = 'api/get_my_orders';
$route['api/user/reciept/(:any)'] = 'api/get_my_receipt';


// Migration and seeder routes
$route['migrate'] = 'migrate/index';
$route['migrate/(:any)'] = 'migrate/$1';
$route['seed'] = 'seeder/index';
$route['seed/(:any)'] = 'seeder/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
