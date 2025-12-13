<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PDF Invoice Library
 * Generate professional PDF invoices using TCPDF
 */
class Pdf_invoice {

    protected $CI;
    protected $pdf;

    public function __construct()
    {
        $this->CI =& get_instance();
        
        require_once FCPATH . 'vendor/tecnickcom/tcpdf/tcpdf.php';
    }

    /**
     * Generate Invoice PDF
     * 
     * @param array $order Order data
     * @return string PDF content
     */
    public function generate($order)
    {
        // Create new PDF document
        $this->pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $this->pdf->SetCreator('ShopHub');
        $this->pdf->SetAuthor('ShopHub');
        $this->pdf->SetTitle('Invoice #' . $order['order_number']);
        $this->pdf->SetSubject('Payment Invoice');

        // Remove default header/footer
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        // Set margins
        $this->pdf->SetMargins(15, 15, 15);
        $this->pdf->SetAutoPageBreak(TRUE, 15);

        // Add a page
        $this->pdf->AddPage();

        // Generate invoice content
        $this->generateHeader($order);
        $this->generateCustomerInfo($order);
        $this->generateItemsTable($order);
        $this->generateSummary($order);
        $this->generateFooter($order);

        // Return PDF as string
        return $this->pdf->Output('', 'S');
    }

    /**
     * Generate Invoice Header
     */
    protected function generateHeader($order)
    {
        // Logo/Company Name
        $this->pdf->SetFont('helvetica', 'B', 24);
        $this->pdf->SetTextColor(255, 107, 53); // Orange color
        $this->pdf->Cell(0, 15, 'ShopHub', 0, 1, 'L');
        
        // Invoice Title
        $this->pdf->SetFont('helvetica', 'B', 18);
        $this->pdf->SetTextColor(51, 51, 51);
        $this->pdf->Cell(0, 10, 'INVOICE', 0, 1, 'R');
        
        // Invoice Number and Date
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetTextColor(102, 102, 102);
        $this->pdf->Cell(0, 6, 'Invoice Number: #' . $order['order_number'], 0, 1, 'R');
        $this->pdf->Cell(0, 6, 'Date: ' . $order['order_date'], 0, 1, 'R');
        $this->pdf->Cell(0, 6, 'Payment Status: PAID', 0, 1, 'R');
        
        // Line separator
        $this->pdf->Ln(5);
        $this->pdf->SetDrawColor(200, 200, 200);
        $this->pdf->Line(15, $this->pdf->GetY(), 195, $this->pdf->GetY());
        $this->pdf->Ln(8);
    }

    /**
     * Generate Customer Information
     */
    protected function generateCustomerInfo($order)
    {
        $customer = $order['customer'];
        
        // Two columns layout
        $this->pdf->SetFont('helvetica', 'B', 11);
        $this->pdf->SetTextColor(51, 51, 51);
        
        // Bill To section
        $startY = $this->pdf->GetY();
        $this->pdf->Cell(90, 7, 'BILL TO:', 0, 1, 'L');
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetTextColor(80, 80, 80);
        $this->pdf->Cell(90, 6, $customer['name'], 0, 1, 'L');
        $this->pdf->Cell(90, 6, $customer['email'], 0, 1, 'L');
        $this->pdf->Cell(90, 6, $customer['phone'], 0, 1, 'L');
        
        // Ship To section
        $this->pdf->SetXY(110, $startY);
        $this->pdf->SetFont('helvetica', 'B', 11);
        $this->pdf->SetTextColor(51, 51, 51);
        $this->pdf->Cell(85, 7, 'SHIP TO:', 0, 1, 'L');
        $this->pdf->SetX(110);
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetTextColor(80, 80, 80);
        $this->pdf->Cell(85, 6, $customer['name'], 0, 1, 'L');
        $this->pdf->SetX(110);
        $this->pdf->Cell(85, 6, $customer['address'], 0, 1, 'L');
        $this->pdf->SetX(110);
        $this->pdf->Cell(85, 6, $customer['city'] . ', ' . $customer['zip'], 0, 1, 'L');
        
        // Payment Method
        $this->pdf->Ln(5);
        $this->pdf->SetFont('helvetica', 'B', 11);
        $this->pdf->SetTextColor(51, 51, 51);
        $this->pdf->Cell(90, 7, 'PAYMENT METHOD:', 0, 0, 'L');
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetTextColor(80, 80, 80);
        $paymentMethod = isset($order['payment_method']) ? $order['payment_method'] : 'Credit Card';
        $this->pdf->Cell(0, 7, $paymentMethod, 0, 1, 'L');
        
        $this->pdf->Ln(10);
    }

    /**
     * Generate Items Table
     */
    protected function generateItemsTable($order)
    {
        // Table Header
        $this->pdf->SetFillColor(255, 107, 53); // Orange
        $this->pdf->SetTextColor(255, 255, 255);
        $this->pdf->SetFont('helvetica', 'B', 10);
        
        $this->pdf->Cell(10, 10, '#', 1, 0, 'C', true);
        $this->pdf->Cell(80, 10, 'Product', 1, 0, 'L', true);
        $this->pdf->Cell(25, 10, 'Price', 1, 0, 'R', true);
        $this->pdf->Cell(20, 10, 'Qty', 1, 0, 'C', true);
        $this->pdf->Cell(45, 10, 'Subtotal', 1, 1, 'R', true);
        
        // Table Body
        $this->pdf->SetTextColor(51, 51, 51);
        $this->pdf->SetFont('helvetica', '', 10);
        
        $fill = false;
        $num = 1;
        
        foreach ($order['items'] as $item) {
            $this->pdf->SetFillColor(248, 248, 248);
            
            $this->pdf->Cell(10, 10, $num, 1, 0, 'C', $fill);
            $this->pdf->Cell(80, 10, $this->truncateText($item['name'], 40), 1, 0, 'L', $fill);
            $this->pdf->Cell(25, 10, '$ ' . number_format($item['price'], 2), 1, 0, 'R', $fill);
            $this->pdf->Cell(20, 10, $item['qty'], 1, 0, 'C', $fill);
            $this->pdf->Cell(45, 10, '$ ' . number_format($item['total'], 2), 1, 1, 'R', $fill);
            
            $fill = !$fill;
            $num++;
        }
        
        $this->pdf->Ln(5);
    }

    /**
     * Generate Summary Section
     */
    protected function generateSummary($order)
    {
        $summaryX = 115;
        $summaryWidth = 80;
        
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetTextColor(80, 80, 80);
        
        // Subtotal
        $this->pdf->SetX($summaryX);
        $this->pdf->Cell(40, 8, 'Subtotal:', 0, 0, 'L');
        $this->pdf->Cell(40, 8, '$ ' . number_format($order['subtotal'], 2), 0, 1, 'R');
        
        // Shipping
        $this->pdf->SetX($summaryX);
        $this->pdf->Cell(40, 8, 'Shipping:', 0, 0, 'L');
        $shipping = isset($order['shipping']) ? $order['shipping'] : 0;
        $shippingText = $shipping > 0 ? '$ ' . number_format($shipping, 2) : 'FREE';
        $this->pdf->SetTextColor(40, 167, 69); // Green for free shipping
        $this->pdf->Cell(40, 8, $shippingText, 0, 1, 'R');
        
        // Line
        $this->pdf->SetDrawColor(200, 200, 200);
        $this->pdf->Line($summaryX, $this->pdf->GetY(), 195, $this->pdf->GetY());
        $this->pdf->Ln(3);
        
        // Total
        $this->pdf->SetX($summaryX);
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->SetTextColor(255, 107, 53);
        $this->pdf->Cell(40, 10, 'TOTAL:', 0, 0, 'L');
        $this->pdf->Cell(40, 10, '$ ' . number_format($order['total'], 2), 0, 1, 'R');
        
        $this->pdf->Ln(10);
    }

    /**
     * Generate Footer
     */
    protected function generateFooter($order)
    {
        // Thank you message
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->SetTextColor(51, 51, 51);
        $this->pdf->Cell(0, 10, 'Thank you for your purchase!', 0, 1, 'C');
        
        $this->pdf->SetFont('helvetica', '', 9);
        $this->pdf->SetTextColor(128, 128, 128);
        $this->pdf->Cell(0, 6, 'If you have any questions about this invoice, please contact us:', 0, 1, 'C');
        $this->pdf->Cell(0, 6, 'Email: support@shophub.com | Phone: (021) 1234-5678', 0, 1, 'C');
        
        // Footer line
        $this->pdf->Ln(10);
        $this->pdf->SetDrawColor(200, 200, 200);
        $this->pdf->Line(15, $this->pdf->GetY(), 195, $this->pdf->GetY());
        $this->pdf->Ln(5);
        
        // Legal text
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->SetTextColor(150, 150, 150);
        $this->pdf->MultiCell(0, 5, 'This is a computer-generated invoice and does not require a signature. Payment has been received and confirmed.', 0, 'C');
        
        // Generated date
        $this->pdf->Ln(3);
        $this->pdf->Cell(0, 5, 'Generated on: ' . date('F j, Y H:i:s'), 0, 1, 'C');
    }

    /**
     * Truncate text to fit in cell
     */
    protected function truncateText($text, $maxLength)
    {
        if (strlen($text) > $maxLength) {
            return substr($text, 0, $maxLength - 3) . '...';
        }
        return $text;
    }

    /**
     * Output PDF to browser for download
     */
    public function download($order, $filename = null)
    {
        if (!$filename) {
            $filename = 'Invoice_' . $order['order_number'] . '.pdf';
        }
        
        // Generate PDF
        $this->generate($order);
        
        // Output for download
        $this->pdf->Output($filename, 'D');
    }

    /**
     * Output PDF to browser for inline view
     */
    public function view($order, $filename = null)
    {
        if (!$filename) {
            $filename = 'Invoice_' . $order['order_number'] . '.pdf';
        }
        
        // Generate PDF
        $this->generate($order);
        
        // Output inline
        $this->pdf->Output($filename, 'I');
    }
}
