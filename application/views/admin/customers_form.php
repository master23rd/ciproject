<!-- Main Content -->
<main class="app-main">
    <!-- Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= $action === 'edit' ? 'Edit Customer' : 'Add New Customer' ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/customers') ?>">Customers</a></li>
                        <li class="breadcrumb-item active"><?= $action === 'edit' ? 'Edit' : 'Add' ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-person-<?= $action === 'edit' ? 'gear' : 'plus' ?> me-2"></i>
                                <?= $action === 'edit' ? 'Edit Customer Information' : 'Customer Information' ?>
                            </h3>
                        </div>
                        <form action="<?= $action === 'edit' ? base_url('admin/customers/edit/' . $customer->id) : base_url('admin/customers/add') ?>" method="POST">
                            <div class="card-body">
                                <!-- Customer Name -->
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">
                                        <i class="bi bi-person me-1"></i>Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                           value="<?= isset($customer) ? htmlspecialchars($customer->customer_name) : '' ?>" 
                                           placeholder="Enter customer name" required>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= isset($customer) ? htmlspecialchars($customer->email) : '' ?>" 
                                           placeholder="Enter email address" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Password 
                                        <?php if ($action === 'add'): ?>
                                            <span class="text-danger">*</span>
                                        <?php else: ?>
                                            <small class="text-muted">(Leave empty to keep current password)</small>
                                        <?php endif; ?>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="<?= $action === 'edit' ? 'Enter new password' : 'Enter password' ?>"
                                               <?= $action === 'add' ? 'required' : '' ?>>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-<?= $action === 'edit' ? 'check-lg' : 'plus-lg' ?> me-1"></i>
                                    <?= $action === 'edit' ? 'Update Customer' : 'Add Customer' ?>
                                </button>
                                <a href="<?= base_url('admin/customers') ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-lg me-1"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-info-circle me-2"></i>Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">
                                <i class="bi bi-asterisk text-danger me-1"></i>Fields marked with asterisk are required.
                            </p>
                            <p class="text-muted mb-2">
                                <i class="bi bi-shield-check me-1"></i>Password will be securely hashed before storing.
                            </p>
                            <?php if ($action === 'edit'): ?>
                                <hr>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    <strong>Registered:</strong><br>
                                    <?= isset($customer->created_at) ? date('M d, Y \a\t H:i', strtotime($customer->created_at)) : 'N/A' ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}
</script>
