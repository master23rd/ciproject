        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0"><?= $mode === 'add' ? 'Add New Product' : 'Edit Product' ?></h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/products') ?>">Products</a></li>
                                <li class="breadcrumb-item active"><?= $mode === 'add' ? 'Add' : 'Edit' ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-box-seam me-2"></i>
                                        Product Information
                                    </h3>
                                </div>
                                <form action="<?= $mode === 'add' ? base_url('admin/products_add') : base_url('admin/products_edit/' . $product->id) ?>" 
                                      method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" 
                                                   value="<?= isset($product) ? $product->product_name : set_value('product_name') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">-- Select Category --</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= $category->id ?>" 
                                                            <?= (isset($product) && $product->category_id == $category->id) || set_value('category_id') == $category->id ? 'selected' : '' ?>>
                                                        <?= $category->name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                                           value="<?= isset($product) ? $product->price : set_value('price') ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="qty" name="qty" 
                                                           value="<?= isset($product) ? $product->qty : set_value('qty') ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="5"><?= isset($product) ? $product->description : set_value('description') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Product Image</label>
                                            <?php if (isset($product) && $product->image): ?>
                                                <div class="mb-2">
                                                    <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                                                         alt="<?= $product->product_name ?>" 
                                                         class="img-thumbnail" style="max-width: 200px;">
                                                    <p class="text-muted small mt-1">Current image (upload new to replace)</p>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <small class="text-muted">Allowed: JPG, JPEG, PNG, GIF, WEBP (Max: 2MB)</small>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="available_status" name="available_status" value="1" 
                                                   <?= (isset($product) && $product->available_status) || (!isset($product)) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="available_status">
                                                Available for sale
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i> 
                                            <?= $mode === 'add' ? 'Add Product' : 'Update Product' ?>
                                        </button>
                                        <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">
                                            <i class="bi bi-x-lg me-1"></i> Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Help
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Product Name:</strong> Enter a descriptive name for your product
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Category:</strong> Select the appropriate category
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Price:</strong> Enter price in USD (use decimal point for cents)
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Quantity:</strong> Current stock quantity
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Image:</strong> Upload a clear product image (recommended: 800x800px)
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <strong>Available Status:</strong> Uncheck to hide from customers
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
