        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Orders Management</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-cart-check me-2"></i>
                                All Orders
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?= $order->order_number ?></strong></td>
                                            <td>
                                                <?= $order->customer_name ?? 'Guest' ?>
                                                <br><small class="text-muted"><?= $order->email ?? '' ?></small>
                                            </td>
                                            <td><?= date('M d, Y H:i', strtotime($order->created_at)) ?></td>
                                            <td><strong>$<?= number_format($order->grand_total, 2) ?></strong></td>
                                            <td>
                                                <span class="badge badge-<?= $order->payment_status ?>">
                                                    <?= ucfirst($order->payment_status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $order->order_status ?>">
                                                    <?= ucfirst($order->order_status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <!--  -->
                                                <a href="<?= base_url('invoice/view/' . $order->order_number) ?>" class="btn btn-sm btn-secondary" title="Invoice" target="_blank">
                                                    <i class="bi bi-file-pdf"></i>
                                                </a>
                                                <!-- <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="bi bi-gear"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="<?= base_url('admin/orders/status/' . $order->order_number . '/processing') ?>">Mark Processing</a></li>
                                                        <li><a class="dropdown-item" href="<?= base_url('admin/orders/status/' . $order->order_number . '/shipped') ?>">Mark Shipped</a></li>
                                                        <li><a class="dropdown-item" href="<?= base_url('admin/orders/status/' . $order->order_number . '/completed') ?>">Mark Completed</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="<?= base_url('admin/orders/status/' . $order->order_number . '/cancelled') ?>">Cancel Order</a></li>
                                                    </ul>
                                                </div> -->
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                                <p class="text-muted mb-0">No orders found</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
