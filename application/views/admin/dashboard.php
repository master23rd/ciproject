        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Statistics Cards -->
                    <div class="row">
						<!-- Total Revenue -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3>$<?= number_format($total_revenue ?? 0, 2) ?></h3>
                                    <p>Total Revenue</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.128 3.128 0 00-1.89.666.75.75 0 10.92 1.182 1.62 1.62 0 01.97-.324h.01c.54 0 1.017.267 1.305.686.288.42.389.936.276 1.424a1.7 1.7 0 01-.975 1.133l-.603.261a3.2 3.2 0 00-1.758 1.817A3.23 3.23 0 009.75 15v.75a.75.75 0 001.5 0V15c0-.642.37-1.225.947-1.475l.604-.261a3.2 3.2 0 001.837-2.134c.212-.918.074-1.887-.389-2.57A3.122 3.122 0 0012.75 6.816V6z"></path>
                                </svg>
                                <!-- <a href="<?= base_url('admin/reports/sales') ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    View Report <i class="bi bi-arrow-right"></i>
                                </a> -->
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3><?= number_format($total_orders ?? 0) ?></h3>
                                    <p>Total Orders</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                                </svg>
                                <a href="<?= base_url('admin/orders') ?>" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    View Orders <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        
                        <!-- Total Products -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3><?= number_format($total_products ?? 0) ?></h3>
                                    <p>Total Products</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z"></path>
                                    <path fill-rule="evenodd" d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.163 3.75A.75.75 0 0110 12h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="<?= base_url('admin/products') ?>" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    View Products <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Total Customers -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-info">
                                <div class="inner">
                                    <h3><?= number_format($total_customers ?? 0) ?></h3>
                                    <p>Total Customers</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd"></path>
                                    <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z"></path>
                                </svg>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-clock-history me-2"></i>
                                        Recent Orders
                                    </h3>
                                    <div class="card-tools">
                                        <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-primary">
                                            View All
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recent_orders)): ?>
                                                <?php foreach ($recent_orders as $order): ?>
                                                <tr>
                                                    <td><strong>#<?= $order->order_number ?></strong></td>
                                                    <td><?= $order->customer_name ?? 'Guest' ?></td>
                                                    <td><?= date('M d, Y', strtotime($order->created_at)) ?></td>
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
                                                        <a href="<?= base_url('admin/orders/view/' . $order->order_number) ?>" class="btn btn-sm btn-info">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-4">
                                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                                        <p class="text-muted mb-0">No orders yet</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
