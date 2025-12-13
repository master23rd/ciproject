<?php
defined('BASEPATH') || exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

/**
 * Payment Controller untuk Stripe Integration
 * 
 * @property CI_Config $config
 */
class Payment extends CI_Controller
{
    /**
     * @var string
     */
    private $stripeSecret;
    
    /**
     * @var string
     */
    private $stripePublic;

    public function __construct()
    {
        parent::__construct();
        $this->config->load('stripe', true);
        
        $stripe_config = $this->config->item('stripe');
        
        $this->stripeSecret = $stripe_config['stripe_secret'];
        $this->stripePublic = $stripe_config['stripe_public'];
        
        Stripe::setApiKey($this->stripeSecret);
    }

    /**
     * Create Payment Intent
     */
    public function create_payment_intent()
    {
        // Set header untuk JSON response
        header('Content-Type: application/json');
        
        try {
            // Get data dari request
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['amount']) || !isset($input['currency'])) {
                echo json_encode([
                    'error' => 'Amount and currency are required'
                ]);
                return;
            }

            // Create Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $input['amount'], // Amount in cents (e.g., 1000 = $10.00)
                'currency' => $input['currency'], // e.g., 'idr' for Indonesian Rupiah
                'payment_method_types' => ['card'],
                'description' => isset($input['description']) ? $input['description'] : 'Phone Shop Purchase',
                'metadata' => [
                    'order_id' => isset($input['order_id']) ? $input['order_id'] : 'ORD-' . time(),
                    'customer_name' => isset($input['customer_name']) ? $input['customer_name'] : '',
                    'customer_email' => isset($input['customer_email']) ? $input['customer_email'] : '',
                ]
            ]);

            

            echo json_encode([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id
            ]);

        } catch (ApiErrorException $e) {
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'error' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Confirm Payment
     */
    public function confirm_payment()
    {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['payment_intent_id'])) {
                echo json_encode([
                    'error' => 'Payment Intent ID is required'
                ]);
                return;
            }

            // Retrieve Payment Intent
            $paymentIntent = PaymentIntent::retrieve($input['payment_intent_id']);

            if ($paymentIntent->status === 'succeeded') {
                // Payment berhasil
                echo json_encode([
                    'success' => true,
                    'status' => 'succeeded',
                    'payment_intent' => $paymentIntent->id,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency
                ]);
            } else {
                // Payment belum selesai atau gagal
                echo json_encode([
                    'success' => false,
                    'status' => $paymentIntent->status,
                    'message' => 'Payment not completed'
                ]);
            }

        } catch (ApiErrorException $e) {
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'error' => 'An unexpected error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Webhook untuk handle payment events dari Stripe
     */
    public function webhook()
    {
        // Endpoint untuk menerima webhook dari Stripe
        // Untuk production, perlu set webhook secret di Stripe Dashboard
        
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $endpoint_secret = ''; // Set ini dari Stripe Dashboard jika menggunakan webhook

        try {
            if ($endpoint_secret) {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } else {
                $event = json_decode($payload, true);
            }

            // Handle event
            switch ($event['type']) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event['data']['object'];
                    // Handle successful payment
                    // Save to database, send email, etc.
                    log_message('info', 'Payment succeeded: ' . $paymentIntent['id']);
                    break;
                    
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event['data']['object'];
                    // Handle failed payment
                    log_message('error', 'Payment failed: ' . $paymentIntent['id']);
                    break;
                    
                default:
                    log_message('info', 'Received unknown event type: ' . $event['type']);
            }

            http_response_code(200);
            echo json_encode(['status' => 'success']);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get Stripe Public Key
     */
    public function get_public_key()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'publicKey' => $this->stripePublic
        ]);
    }
}
