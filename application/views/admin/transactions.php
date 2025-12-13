        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Transactions</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Transactions</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-success shadow-sm">
                                    <i class="bi bi-check-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Completed</span>
                                    <span class="info-box-number"><?= $completed ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-warning shadow-sm">
                                    <i class="bi bi-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending</span>
                                    <span class="info-box-number"><?= $pending ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-info shadow-sm">
                                    <i class="bi bi-truck"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Processing</span>
                                    <span class="info-box-number"><?= $processing ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-danger shadow-sm">
                                    <i class="bi bi-x-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cancelled</span>
                                    <span class="info-box-number"><?= $cancelled ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-receipt me-2"></i>
                                Transaction History
                            </h3>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-filter me-1"></i> Filter
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="?status=all">All</a></li>
                                        <li><a class="dropdown-item" href="?status=pending">Pending</a></li>
                                        <li><a class="dropdown-item" href="?status=processing">Processing</a></li>
                                        <li><a class="dropdown-item" href="?status=completed">Completed</a></li>
                                        <li><a class="dropdown-item" href="?status=cancelled">Cancelled</a></li>
                                    </ul>
                                </div>
                                <a href="<?= base_url('admin/transactions/export') ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Export
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Order Number</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transactions)): ?>
                                        <?php $no = 1; foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <code><?= $transaction->order_number ?></code>
                                            </td>
                                            <td>
                                                <strong><?= $transaction->customer_name ?></strong>
                                                <br><small class="text-muted"><?= $transaction->customer_email ?? '' ?></small>
                                            </td>
                                            <td>
                                                <span class="badge text-bg-secondary"><?= $transaction->total_items ?? 1 ?> items</span>
                                            </td>
                                            <td>
                                                <strong class="text-success">$<?= number_format($transaction->total_amount, 2) ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                $payment_icon = 'bi-credit-card';
                                                $payment_class = 'secondary';
                                                if (isset($transaction->payment_method)) {
                                                    switch (strtolower($transaction->payment_method)) {
                                                        case 'credit_card':
                                                        case 'stripe':
                                                            $payment_icon = 'bi-credit-card';
                                                            $payment_class = 'primary';
                                                            break;
                                                        case 'paypal':
                                                            $payment_icon = 'bi-paypal';
                                                            $payment_class = 'info';
                                                            break;
                                                        case 'bank_transfer':
                                                            $payment_icon = 'bi-bank';
                                                            $payment_class = 'success';
                                                            break;
                                                        case 'cod':
                                                            $payment_icon = 'bi-cash';
                                                            $payment_class = 'warning';
                                                            break;
                                                    }
                                                }
                                                ?>
                                                <span class="badge text-bg-<?= $payment_class ?>">
                                                    <i class="bi <?= $payment_icon ?> me-1"></i>
                                                    <?= ucfirst(str_replace('_', ' ', $transaction->payment_method ?? 'N/A')) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $status = $transaction->status ?? 'pending';
                                                $status_class = 'secondary';
                                                switch (strtolower($status)) {
                                                    case 'completed':
                                                    case 'paid':
                                                        $status_class = 'success';
                                                        break;
                                                    case 'pending':
                                                        $status_class = 'warning';
                                                        break;
                                                    case 'processing':
                                                    case 'shipped':
                                                        $status_class = 'info';
                                                        break;
                                                    case 'cancelled':
                                                    case 'failed':
                                                        $status_class = 'danger';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge text-bg-<?= $status_class ?>"><?= ucfirst($status) ?></span>
                                            </td>
                                            <td><?= date('M d, Y H:i', strtotime($transaction->created_at)) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/transactions/view/' . $transaction->id) ?>" class="btn btn-sm btn-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('invoice/download/' . $transaction->order_number) ?>" class="btn btn-sm btn-secondary" title="Invoice">
                                                    <i class="bi bi-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                                <p class="text-muted mb-0">No transactions found</p>
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
