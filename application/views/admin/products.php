        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Products Management</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Products</li>
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
                                <i class="bi bi-box-seam me-2"></i>
                                All Products
                            </h3>
                            <div class="card-tools">
                                <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i> Add Product
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Image</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php $no = 1; foreach ($products as $product): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <img src="<?= $product->image ? base_url('uploads/products/' . $product->image) : 'https://via.placeholder.com/50' ?>" 
                                                     alt="<?= $product->product_name ?>" 
                                                     class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <strong><?= $product->product_name ?></strong>
                                                <br><small class="text-muted"><?= substr($product->description ?? '', 0, 50) ?>...</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?= $product->category_name ?? 'Uncategorized' ?></span>
                                            </td>
                                            <td><strong>$<?= number_format($product->price, 2) ?></strong></td>
                                            <td>
                                                <?php if ($product->qty <= 0): ?>
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                <?php elseif ($product->qty <= 10): ?>
                                                    <span class="badge bg-warning"><?= $product->qty ?> left</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success"><?= $product->qty ?> in stock</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($product->available_status): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/products/edit/' . $product->id) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('admin/products/view/' . $product->id) ?>" class="btn btn-sm btn-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="confirmDelete('<?= base_url('admin/products/delete/' . $product->id) ?>', '<?= addslashes($product->product_name) ?>')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                                <p class="text-muted mb-0">No products found</p>
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
