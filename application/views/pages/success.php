<style>
    .success-container {
        padding: 60px 0;
        min-height: 70vh;
    }

    .success-card {
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
    }

    .success-icon i {
        font-size: 2.5rem;
        color: #fff;
    }

    .success-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        text-align: center;
        margin-bottom: 10px;
    }

    .success-message {
        text-align: center;
        color: #666;
        margin-bottom: 35px;
        font-size: 1rem;
    }

    .order-details {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #666;
        font-weight: 500;
    }

    .detail-value {
        color: #1a1a2e;
        font-weight: 600;
        text-align: right;
    }

    .order-items-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e0e0e0;
    }

    .order-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        background: #f8f9fa;
        padding: 8px;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 5px;
    }

    .item-specs {
        font-size: 0.85rem;
        color: #666;
    }

    .item-price {
        font-weight: 700;
        color: #ff6b35;
        white-space: nowrap;
    }

    .summary-section {
        background: #fff;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        margin-top: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 0.95rem;
    }

    .summary-row.total {
        border-top: 2px solid #e0e0e0;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .summary-row.total .amount {
        color: #ff6b35;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-download {
        flex: 1;
        background: #28a745;
        color: #fff;
        border: none;
        padding: 14px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-continue {
        flex: 1;
        background: #ff6b35;
        color: #fff;
        border: none;
        padding: 14px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .info-box {
        background: #e7f3ff;
        border: 1px solid #90caf9;
        border-radius: 10px;
        padding: 15px;
        margin-top: 25px;
    }

    .info-box i {
        color: #1976d2;
        margin-right: 10px;
    }

    .info-box p {
        margin: 0;
        color: #1976d2;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .success-card {
            padding: 25px 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .detail-row {
            flex-direction: column;
            gap: 5px;
        }

        .detail-value {
            text-align: left;
        }
    }
</style>

<div class="container success-container">
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <!-- Success Message -->
        <h1 class="success-title">Order Placed Successfully!</h1>
        <p class="success-message">
            Thank you for your purchase. Your order has been received and is being processed.
        </p>

        <?php if (isset($order)): ?>
        <!-- Order Details -->
        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">Order Number</span>
                <span class="detail-value">#<?= $order['order_number'] ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Order Date</span>
                <span class="detail-value"><?= $order['order_date'] ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">Credit Card</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Status</span>
                <span class="detail-value text-success">Paid</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Delivery Address</span>
                <span class="detail-value">
                    <?= htmlspecialchars($order['customer']['address']) ?><br>
                    <?= htmlspecialchars($order['customer']['city']) ?>, <?= htmlspecialchars($order['customer']['zip']) ?>
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <h3 class="order-items-title">Order Items</h3>
        
        <?php foreach ($order['items'] as $item): ?>
        <div class="order-item">
            <img src="<?= $item['image'] ? base_url('uploads/products/' . $item['image']) : 'https://via.placeholder.com/100' ?>" 
                 alt="<?= htmlspecialchars($item['name']) ?>" class="item-image">
            <div class="item-details">
                <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                <div class="item-specs">Qty: <?= $item['qty'] ?></div>
            </div>
            <div class="item-price">$ <?= number_format($item['total'], 2) ?></div>
        </div>
        <?php endforeach; ?>

        <!-- Summary -->
        <div class="summary-section">
            <div class="summary-row">
                <span>Subtotal (<?= $order['item_count'] ?> items)</span>
                <span>$ <?= number_format($order['subtotal'], 2) ?></span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span class="text-success">FREE</span>
            </div>
            <div class="summary-row total">
                <span>Total Paid</span>
                <span class="amount">$ <?= number_format($order['total'], 2) ?></span>
            </div>
        </div>

        <?php else: ?>
        <!-- Fallback if no order data -->
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Order details are not available. Please check your email for confirmation.
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <?php if (isset($order)): ?>
            <a href="<?= base_url('invoice/download/' . $order['order_number']) ?>" class="btn-download">
                <i class="fas fa-file-pdf me-2"></i>Download Invoice (PDF)
            </a>
            <?php endif; ?>
            <a href="<?php echo base_url(); ?>" class="btn-continue">
                <i class="fas fa-home me-2"></i>Continue Shopping
            </a>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <p><strong>What's next?</strong> You will receive an email confirmation with your order details. We'll notify you when your order is shipped.</p>
        </div>
    </div>
</div>
