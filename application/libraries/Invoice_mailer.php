<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Invoice Mailer Library
 * Sends invoice emails with PDF attachment
 */
class Invoice_mailer {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
        $this->CI->load->library('pdf_invoice');
        $this->CI->load->config('email');
    }

    /**
     * Send invoice email to customer
     * 
     * @param array $order Order data
     * @param string $to_email Recipient email
     * @return bool Success status
     */
    public function send_invoice($order, $to_email)
    {
        // Generate PDF invoice
        $pdf_content = $this->CI->pdf_invoice->generate($order);
        
        // Configure email
        $this->CI->email->initialize([
            'protocol' => $this->CI->config->item('protocol'),
            'smtp_host' => $this->CI->config->item('smtp_host'),
            'smtp_port' => $this->CI->config->item('smtp_port'),
            'smtp_user' => $this->CI->config->item('smtp_user'),
            'smtp_pass' => $this->CI->config->item('smtp_pass'),
            'smtp_crypto' => $this->CI->config->item('smtp_crypto'),
            'smtp_timeout' => $this->CI->config->item('smtp_timeout'),
            'mailtype' => $this->CI->config->item('mailtype'),
            'charset' => $this->CI->config->item('charset'),
            'wordwrap' => $this->CI->config->item('wordwrap'),
            'newline' => $this->CI->config->item('newline')
        ]);

        // Clear previous email data
        $this->CI->email->clear(TRUE);

        // Set email headers
        $from_email = $this->CI->config->item('from_email');
        $from_name = $this->CI->config->item('from_name');
        
        $this->CI->email->from($from_email, $from_name);
        $this->CI->email->to($to_email);
        $this->CI->email->subject('Order Confirmation - Invoice #' . $order['order_number']);
        
        // Generate email body
        $email_body = $this->generate_email_body($order);
        $this->CI->email->message($email_body);

        // Attach PDF invoice
        $filename = 'Invoice_' . $order['order_number'] . '.pdf';
        $this->CI->email->attach($pdf_content, 'attachment', $filename, 'application/pdf');

        // Send email
        $result = $this->CI->email->send();

        // Log email status
        if (!$result) {
            log_message('error', 'Failed to send invoice email to: ' . $to_email);
            log_message('error', $this->CI->email->print_debugger(['headers', 'subject', 'body']));
        } else {
            log_message('info', 'Invoice email sent successfully to: ' . $to_email);
        }

        return $result;
    }

    /**
     * Generate HTML email body
     * 
     * @param array $order Order data
     * @return string HTML email content
     */
    private function generate_email_body($order)
    {
        $customer_name = $order['customer']['name'];
        $order_number = $order['order_number'];
        $order_date = $order['order_date'];
        $total = number_format($order['total'], 2);
        $item_count = $order['item_count'];

        // Generate items HTML
        $items_html = '';
        foreach ($order['items'] as $item) {
            $item_total = number_format($item['total'], 2);
            $items_html .= "
                <tr>
                    <td style='padding: 12px; border-bottom: 1px solid #eee;'>{$item['name']}</td>
                    <td style='padding: 12px; border-bottom: 1px solid #eee; text-align: center;'>{$item['qty']}</td>
                    <td style='padding: 12px; border-bottom: 1px solid #eee; text-align: right;'>\$ {$item_total}</td>
                </tr>
            ";
        }

        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;'>
            <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #f4f4f4; padding: 20px 0;'>
                <tr>
                    <td align='center'>
                        <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
                            <!-- Header -->
                            <tr>
                                <td style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;'>
                                    <h1 style='color: #ffffff; margin: 0; font-size: 28px;'>🛍️ ShopHub</h1>
                                    <p style='color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 14px;'>Thank you for your order!</p>
                                </td>
                            </tr>
                            
                            <!-- Order Confirmation -->
                            <tr>
                                <td style='padding: 40px 30px;'>
                                    <div style='text-align: center; margin-bottom: 30px;'>
                                        <div style='width: 80px; height: 80px; background: #e8f5e9; border-radius: 50%; margin: 0 auto 15px; line-height: 80px; font-size: 40px;'>✓</div>
                                        <h2 style='color: #333; margin: 0 0 10px 0; font-size: 24px;'>Order Confirmed!</h2>
                                        <p style='color: #666; margin: 0;'>Hi {$customer_name}, your order has been received.</p>
                                    </div>
                                    
                                    <!-- Order Info Box -->
                                    <div style='background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 30px;'>
                                        <table width='100%' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td style='padding: 5px 0;'>
                                                    <strong style='color: #333;'>Order Number:</strong>
                                                </td>
                                                <td style='padding: 5px 0; text-align: right;'>
                                                    <span style='color: #667eea; font-weight: bold;'>#{$order_number}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 5px 0;'>
                                                    <strong style='color: #333;'>Order Date:</strong>
                                                </td>
                                                <td style='padding: 5px 0; text-align: right;'>
                                                    <span style='color: #666;'>{$order_date}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 5px 0;'>
                                                    <strong style='color: #333;'>Items:</strong>
                                                </td>
                                                <td style='padding: 5px 0; text-align: right;'>
                                                    <span style='color: #666;'>{$item_count} item(s)</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <!-- Order Items -->
                                    <h3 style='color: #333; margin: 0 0 15px 0; font-size: 18px;'>Order Summary</h3>
                                    <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 20px;'>
                                        <tr style='background: #f8f9fa;'>
                                            <th style='padding: 12px; text-align: left; font-weight: 600; color: #333;'>Product</th>
                                            <th style='padding: 12px; text-align: center; font-weight: 600; color: #333;'>Qty</th>
                                            <th style='padding: 12px; text-align: right; font-weight: 600; color: #333;'>Total</th>
                                        </tr>
                                        {$items_html}
                                    </table>
                                    
                                    <!-- Total -->
                                    <div style='border-top: 2px solid #667eea; padding-top: 15px;'>
                                        <table width='100%' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td style='padding: 5px 0;'>
                                                    <span style='color: #666;'>Subtotal:</span>
                                                </td>
                                                <td style='padding: 5px 0; text-align: right;'>
                                                    <span style='color: #333;'>\$ {$total}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 5px 0;'>
                                                    <span style='color: #666;'>Shipping:</span>
                                                </td>
                                                <td style='padding: 5px 0; text-align: right;'>
                                                    <span style='color: #28a745; font-weight: bold;'>FREE</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 10px 0;'>
                                                    <strong style='color: #333; font-size: 18px;'>Total:</strong>
                                                </td>
                                                <td style='padding: 10px 0; text-align: right;'>
                                                    <strong style='color: #667eea; font-size: 22px;'>\$ {$total}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <!-- Shipping Info -->
                                    <div style='background: #fff8f5; border-left: 4px solid #ff6b35; padding: 15px; margin-top: 25px; border-radius: 0 8px 8px 0;'>
                                        <h4 style='color: #ff6b35; margin: 0 0 10px 0; font-size: 14px;'>📦 Shipping Address</h4>
                                        <p style='color: #666; margin: 0; font-size: 14px; line-height: 1.6;'>
                                            {$order['customer']['name']}<br>
                                            {$order['customer']['address']}<br>
                                            {$order['customer']['city']}, {$order['customer']['zip']}<br>
                                            Phone: {$order['customer']['phone']}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Invoice Notice -->
                            <tr>
                                <td style='padding: 0 30px 30px;'>
                                    <div style='background: #e8f5e9; border-radius: 8px; padding: 20px; text-align: center;'>
                                        <p style='color: #2e7d32; margin: 0; font-size: 14px;'>
                                            📎 <strong>Your invoice is attached to this email as a PDF file.</strong>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Footer -->
                            <tr>
                                <td style='background: #f8f9fa; padding: 25px 30px; text-align: center; border-top: 1px solid #eee;'>
                                    <p style='color: #666; margin: 0 0 10px 0; font-size: 14px;'>
                                        Need help? Contact us at <a href='mailto:support@shophub.com' style='color: #667eea;'>support@shophub.com</a>
                                    </p>
                                    <p style='color: #999; margin: 0; font-size: 12px;'>
                                        © " . date('Y') . " ShopHub. All rights reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";

        return $html;
    }

    /**
     * Send order notification to admin
     * 
     * @param array $order Order data
     * @return bool Success status
     */
    public function notify_admin($order)
    {
        $admin_email = $this->CI->config->item('from_email'); // Or use separate admin email
        
        // Configure email
        $this->CI->email->initialize([
            'protocol' => $this->CI->config->item('protocol'),
            'smtp_host' => $this->CI->config->item('smtp_host'),
            'smtp_port' => $this->CI->config->item('smtp_port'),
            'smtp_user' => $this->CI->config->item('smtp_user'),
            'smtp_pass' => $this->CI->config->item('smtp_pass'),
            'smtp_crypto' => $this->CI->config->item('smtp_crypto'),
            'mailtype' => 'html',
            'charset' => 'utf-8'
        ]);

        $this->CI->email->clear(TRUE);
        
        $this->CI->email->from($this->CI->config->item('from_email'), $this->CI->config->item('from_name'));
        $this->CI->email->to($admin_email);
        $this->CI->email->subject('New Order Received - #' . $order['order_number']);
        
        $total = number_format($order['total'], 2);
        $body = "
        <html>
        <body style='font-family: Arial, sans-serif;'>
            <h2 style='color: #333;'>🛒 New Order Received!</h2>
            <p>A new order has been placed on your store.</p>
            <table style='border-collapse: collapse; width: 100%; max-width: 500px;'>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Order Number:</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>#{$order['order_number']}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Customer:</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$order['customer']['name']}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Email:</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$order['customer']['email']}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Total:</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>\$ {$total}</td>
                </tr>
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'><strong>Items:</strong></td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$order['item_count']} item(s)</td>
                </tr>
            </table>
            <p style='margin-top: 20px;'>
                <a href='" . base_url('admin/orders') . "' style='background: #667eea; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View Order Details</a>
            </p>
        </body>
        </html>
        ";
        
        $this->CI->email->message($body);

        return $this->CI->email->send();
    }
}
