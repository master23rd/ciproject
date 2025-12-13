        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Product Detail</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/products') ?>">Products</a></li>
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <?php if ($product->image): ?>
                                        <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                                             alt="<?= $product->product_name ?>" 
                                             class="img-fluid rounded shadow-sm mb-3">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/400x400?text=No+Image" 
                                             alt="No Image" 
                                             class="img-fluid rounded shadow-sm mb-3">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-box-seam me-2"></i>
                                        <?= $product->product_name ?>
                                    </h3>
                                    <div class="card-tools">
                                        <a href="<?= base_url('admin/products/edit/' . $product->id) ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('<?= base_url('admin/products/delete/' . $product->id) ?>', '<?= addslashes($product->product_name) ?>')">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                        <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-arrow-left me-1"></i> Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-tag me-2"></i>Product ID:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="badge bg-secondary">#<?= $product->id ?></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-grid me-2"></i>Category:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="badge bg-info"><?= $product->category_name ?? 'Uncategorized' ?></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-currency-dollar me-2"></i>Price:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <h4 class="text-success mb-0">$<?= number_format($product->price, 2) ?></h4>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-box me-2"></i>Stock Quantity:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php if ($product->qty <= 0): ?>
                                                <span class="badge bg-danger fs-6">Out of Stock (<?= $product->qty ?>)</span>
                                            <?php elseif ($product->qty <= 10): ?>
                                                <span class="badge bg-warning fs-6">Low Stock (<?= $product->qty ?> left)</span>
                                            <?php else: ?>
                                                <span class="badge bg-success fs-6"><?= $product->qty ?> in stock</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-eye me-2"></i>Status:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php if ($product->available_status): ?>
                                                <span class="badge bg-success fs-6">
                                                    <i class="bi bi-check-circle me-1"></i>Active
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary fs-6">
                                                    <i class="bi bi-x-circle me-1"></i>Inactive
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-file-text me-2"></i>Description:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php if ($product->description): ?>
                                                <p><?= nl2br(htmlspecialchars($product->description)) ?></p>
                                            <?php else: ?>
                                                <p class="text-muted fst-italic">No description available</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-calendar-plus me-2"></i>Created At:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="text-muted">
                                                <?= isset($product->created_at) ? date('d M Y, H:i', strtotime($product->created_at)) : 'N/A' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-calendar-check me-2"></i>Last Updated:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="text-muted">
                                                <?= isset($product->updated_at) ? date('d M Y, H:i', strtotime($product->updated_at)) : 'N/A' ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
