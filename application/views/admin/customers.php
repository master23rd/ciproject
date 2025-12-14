        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Customers Management</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Customers</li>
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
                                <i class="bi bi-people me-2"></i>
                                All Customers
                            </h3>
                            <div class="card-tools">
                                <a href="<?= base_url('admin/customers/add') ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-person-plus me-1"></i> Add Customer
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Registered</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($customers)): ?>
                                        <?php $no = 1; foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($customer->customer_name) ?>&background=ff6b35&color=fff" 
                                                         class="rounded-circle me-2" style="width: 35px; height: 35px;">
                                                    <strong><?= $customer->customer_name ?></strong>
                                                </div>
                                            </td>
                                            <td><?= $customer->email ?></td>
                                            <td><?= $customer->phone ?? '-' ?></td>
                                            <td><?= $customer->address ?? '-' ?></td>
                                            <td><?= isset($customer->created_at) ? date('M d, Y', strtotime($customer->created_at)) : '-' ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/customers/view/' . $customer->id) ?>" class="btn btn-sm btn-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/customers/edit/' . $customer->id) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="confirmDelete('<?= base_url('admin/customers/delete/' . $customer->id) ?>', '<?= addslashes($customer->customer_name) ?>')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                                <p class="text-muted mb-0">No customers found</p>
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
