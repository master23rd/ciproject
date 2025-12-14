<style>
    .orders-container {
        padding: 60px 0;
        min-height: 70vh;
    }

    .page-header {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8b35 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(255, 107, 53, 0.3);
    }

    .page-header h1 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .order-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .order-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px 25px;
        border-bottom: 2px solid #dee2e6;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .order-header:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    }

    .order-header .toggle-icon {
        transition: transform 0.3s ease;
    }

    .order-header[aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
    }

    .order-number {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 5px;
    }

    .order-date {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .order-body {
        padding: 25px;
    }

    .order-items {
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .order-item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }

    .order-item-info {
        flex-grow: 1;
    }

    .order-item-name {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 5px;
    }

    .order-item-qty {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .order-item-price {
        font-weight: 600;
        color: #ff6b35;
        font-size: 1.1rem;
    }

    .order-summary {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .summary-row.total {
        border-top: 2px solid #dee2e6;
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-status {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }

    .badge-info {
        background-color: #17a2b8;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }

    .badge-pending {
        background-color: #ffc107;
        color: #000;
    }

    .badge-processing {
        background-color: #17a2b8;
        color: white;
    }

    .badge-shipped {
        background-color: #007bff;
        color: white;
    }

    .badge-completed {
        background-color: #28a745;
        color: white;
    }

    .badge-cancelled {
        background-color: #dc3545;
        color: white;
    }

    .order-actions {
        display: flex;
        gap: 10px;
    }

    .btn-download {
        background: linear-gradient(135deg, #ff6b35, #ff8b35);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-download:hover {
        background: linear-gradient(135deg, #ff5722, #ff6b35);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }

    .btn-view {
        background: white;
        color: #ff6b35;
        border: 2px solid #ff6b35;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view:hover {
        background: #ff6b35;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .empty-state i {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #6c757d;
        margin-bottom: 15px;
    }

    .empty-state p {
        color: #adb5bd;
        margin-bottom: 25px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #ff6b35, #ff8b35);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #ff5722, #ff6b35);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }

    @media (max-width: 768px) {
        .order-header {
            padding: 15px;
        }

        .order-body {
            padding: 15px;
        }

        .order-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .order-actions {
            width: 100%;
        }

        .btn-download,
        .btn-view {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="orders-container">
    <div class="container">
        <div class="page-header">
            <div class="text-center">
                <h1><i class="fas fa-box me-2"></i>My Orders</h1>
                <p class="mb-0">Track and manage your orders</p>
            </div>
        </div>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $index => $order): ?>
                <div class="order-card">
                    <div class="order-header" 
                         data-bs-toggle="collapse" 
                         data-bs-target="#order-<?= $index ?>" 
                         aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
                         aria-controls="order-<?= $index ?>">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="order-number">
                                    <i class="fas fa-receipt me-2"></i>Order #<?= $order->order_number ?>
                                </div>
                                <div class="order-date">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= date('F d, Y \a\t H:i', strtotime($order->created_at)) ?>
                                </div>
                            </div>
                            <div class="col-md-5 text-md-center mt-3 mt-md-0">
                                <div class="order-status">
                                    <span class="badge badge-<?= $order->payment_status ?>">
                                        <i class="fas fa-credit-card me-1"></i>
                                        Payment: <?= ucfirst($order->payment_status) ?>
                                    </span>
                                    <span class="badge badge-<?= $order->order_status ?>">
                                        <i class="fas fa-shipping-fast me-1"></i>
                                        <?= ucfirst(str_replace('_', ' ', $order->order_status)) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 text-md-end mt-3 mt-md-0">
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div id="order-<?= $index ?>" class="collapse <?= $index === 0 ? 'show' : '' ?>">
                        <div class="order-body">
                        <!-- Order Items -->
                        <div class="order-items">
                            <h6 class="mb-3">
                                <i class="fas fa-shopping-bag me-2"></i>
                                Order Items (<?= $order->item_count ?> item<?= $order->item_count > 1 ? 's' : '' ?>)
                            </h6>
                            <?php if (!empty($order->items)): ?>
                                <?php foreach ($order->items as $item): ?>
                                    <div class="order-item">
                                        <?php if ($item->image): ?>
                                            <img src="<?= base_url('uploads/products/' . $item->image) ?>" 
                                                 alt="<?= htmlspecialchars($item->product_name) ?>" 
                                                 class="order-item-image">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/60" 
                                                 alt="No Image" 
                                                 class="order-item-image">
                                        <?php endif; ?>
                                        
                                        <div class="order-item-info">
                                            <div class="order-item-name"><?= htmlspecialchars($item->product_name) ?></div>
                                            <div class="order-item-qty">
                                                Quantity: <?= $item->qty ?> × $<?= number_format($item->price, 2) ?>
                                            </div>
                                        </div>
                                        
                                        <div class="order-item-price">
                                            $<?= number_format($item->qty * $item->price, 2) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span>$<?= number_format($order->grand_total, 2) ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping:</span>
                                <span class="text-success">FREE</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total:</span>
                                <span class="text-primary">$<?= number_format($order->grand_total, 2) ?></span>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="order-footer">
                            <div class="order-actions">
                                <a href="<?= base_url('invoice/view/' . $order->order_number) ?>" 
                                   class="btn-view"
                                   target="_blank">
                                    <i class="fas fa-eye"></i> View Invoice
                                </a>
                                <a href="<?= base_url('invoice/download/' . $order->order_number) ?>" 
                                   class="btn-download">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet. Start shopping now!</p>
                <a href="<?= base_url() ?>" class="btn-primary-custom">
                    <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                </a>
            </div>    </div>
                    
        <?php endif; ?>
    </div>
</div>

<script>
    // You can add any JavaScript functionality here if needed
    document.addEventListener('DOMContentLoaded', function() {
        console.log('My Orders page loaded');
    });
</script>
