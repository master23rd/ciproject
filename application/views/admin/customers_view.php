<!-- Main Content -->
<main class="app-main">
    <!-- Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Customer Detail</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/customers') ?>">Customers</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Customer Info -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($customer->customer_name) ?>&background=ff6b35&color=fff&size=150" 
                                 class="rounded-circle shadow-sm mb-3" style="width: 150px; height: 150px;">
                            <h4 class="mb-1"><?= htmlspecialchars($customer->customer_name) ?></h4>
                            <p class="text-muted mb-3"><?= htmlspecialchars($customer->email) ?></p>
                            
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <a href="<?= base_url('admin/customers/edit/' . $customer->id) ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('<?= base_url('admin/customers/delete/' . $customer->id) ?>', '<?= addslashes($customer->customer_name) ?>')">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                                <a href="<?= base_url('admin/customers') ?>" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-telephone me-2 text-muted"></i>Phone</span>
                                    <span class="fw-bold"><?= htmlspecialchars($customer->phone ?? '-') ?></span>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-geo-alt me-2 text-muted"></i>
                                        <div>
                                            <small class="text-muted d-block">Address</small>
                                            <?= nl2br(htmlspecialchars($customer->address ?? '-')) ?>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-calendar-event me-2 text-muted"></i>Registered</span>
                                    <span><?= isset($customer->created_at) ? date('M d, Y', strtotime($customer->created_at)) : '-' ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-graph-up me-2"></i>Customer Stats
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-cart-check me-2 text-primary"></i>Total Orders</span>
                                    <span class="badge bg-primary rounded-pill fs-6"><?= $total_orders ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-currency-dollar me-2 text-success"></i>Total Spent</span>
                                    <span class="fw-bold text-success fs-6">$<?= number_format($total_spent, 2) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-receipt me-2 text-info"></i>Avg. Order Value</span>
                                    <span class="fw-bold text-info">$<?= $total_orders > 0 ? number_format($total_spent / $total_orders, 2) : '0.00' ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Orders History -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-clock-history me-2"></i>Order History
                            </h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($orders)): ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><strong>#<?= $order->order_number ?></strong></td>
                                                <td><?= date('M d, Y H:i', strtotime($order->created_at)) ?></td>
                                                <td><strong>$<?= number_format($order->grand_total, 2) ?></strong></td>
                                                <td>
                                                    <?php
                                                    $payment_class = 'secondary';
                                                    if ($order->payment_status === 'paid') $payment_class = 'success';
                                                    elseif ($order->payment_status === 'pending') $payment_class = 'warning';
                                                    elseif ($order->payment_status === 'failed') $payment_class = 'danger';
                                                    ?>
                                                    <span class="badge bg-<?= $payment_class ?>">
                                                        <?= ucfirst($order->payment_status) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_class = 'secondary';
                                                    if ($order->order_status === 'completed') $status_class = 'success';
                                                    elseif ($order->order_status === 'processing') $status_class = 'info';
                                                    elseif ($order->order_status === 'shipped') $status_class = 'primary';
                                                    elseif ($order->order_status === 'pending') $status_class = 'warning';
                                                    elseif ($order->order_status === 'cancelled') $status_class = 'danger';
                                                    ?>
                                                    <span class="badge bg-<?= $status_class ?>">
                                                        <?= ucfirst($order->order_status) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('admin/orders/view/' . $order->order_number) ?>" 
                                                       class="btn btn-sm btn-info" title="View Order">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mb-0 mt-2">No orders found for this customer</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
