        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Settings</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- General Settings -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-gear me-2"></i>
                                        General Settings (coming soon)
                                    </h3>
                                </div>
                                <form action="<?= base_url('admin/settings/save') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Site Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="site_name" 
                                                       value="<?= $settings->site_name ?? 'CI Phone Store' ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Site Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="site_email" 
                                                       value="<?= $settings->site_email ?? 'admin@example.com' ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Site Phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="site_phone" 
                                                       value="<?= $settings->site_phone ?? '' ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Site Address</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="site_address" rows="3"><?= $settings->site_address ?? '' ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Site Logo</label>
                                            <div class="col-sm-9">
                                                <?php if (!empty($settings->site_logo)): ?>
                                                    <img src="<?= base_url('uploads/' . $settings->site_logo) ?>" class="img-thumbnail mb-2" style="max-height: 60px;">
                                                <?php endif; ?>
                                                <input type="file" class="form-control" name="site_logo" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Currency</label>
                                            <div class="col-sm-9">
                                                <select class="form-select" name="currency">
                                                    <option value="USD" <?= ($settings->currency ?? 'USD') == 'USD' ? 'selected' : '' ?>>USD ($)</option>
                                                    <option value="EUR" <?= ($settings->currency ?? '') == 'EUR' ? 'selected' : '' ?>>EUR (€)</option>
                                                    <option value="GBP" <?= ($settings->currency ?? '') == 'GBP' ? 'selected' : '' ?>>GBP (£)</option>
                                                    <option value="IDR" <?= ($settings->currency ?? '') == 'IDR' ? 'selected' : '' ?>>IDR (Rp)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-1"></i> Save Settings
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Payment Settings -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-credit-card me-2"></i>
                                        Payment Settings (coming soon)
                                    </h3>
                                </div>
                                <form action="<?= base_url('admin/settings/save_payment') ?>" method="POST">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Stripe Mode</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="stripe_mode" id="stripe_test" value="test" 
                                                           <?= ($settings->stripe_mode ?? 'test') == 'test' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="stripe_test">Test Mode</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="stripe_mode" id="stripe_live" value="live"
                                                           <?= ($settings->stripe_mode ?? '') == 'live' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="stripe_live">Live Mode</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Stripe Publishable Key</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="stripe_public_key" 
                                                       value="<?= $settings->stripe_public_key ?? '' ?>" placeholder="pk_test_...">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Stripe Secret Key</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="stripe_secret_key" 
                                                       value="<?= $settings->stripe_secret_key ?? '' ?>" placeholder="sk_test_...">
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="mb-3">Payment Methods</h5>
                                        <div class="row mb-3">
                                            <div class="col-sm-9 offset-sm-3">
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" name="enable_stripe" id="enable_stripe" value="1"
                                                           <?= ($settings->enable_stripe ?? 1) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="enable_stripe">Enable Stripe</label>
                                                </div>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" name="enable_paypal" id="enable_paypal" value="1"
                                                           <?= ($settings->enable_paypal ?? 0) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="enable_paypal">Enable PayPal</label>
                                                </div>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" name="enable_bank_transfer" id="enable_bank" value="1"
                                                           <?= ($settings->enable_bank_transfer ?? 0) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="enable_bank">Enable Bank Transfer</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_cod" id="enable_cod" value="1"
                                                           <?= ($settings->enable_cod ?? 0) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="enable_cod">Enable Cash on Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-1"></i> Save Payment Settings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Quick Info -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-info-circle me-2"></i>
                                        System Information
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>PHP Version</strong></td>
                                            <td><?= phpversion() ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>CodeIgniter Version</strong></td>
                                            <td><?= CI_VERSION ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Server</strong></td>
                                            <td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Database</strong></td>
                                            <td>MySQL</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Admin Profile -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-person me-2"></i>
                                        Admin Profile (coming soon)
                                    </h3>
                                </div>
                                <form action="<?= base_url('admin/settings/save_profile') ?>" method="POST">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="admin_username" 
                                                   value="<?= $this->session->userdata('admin_username') ?? '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="admin_email" 
                                                   value="<?= $this->session->userdata('admin_email') ?? '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control" name="admin_password" placeholder="Leave blank to keep current">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="admin_password_confirm" placeholder="Confirm new password">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block w-100">
                                            <i class="bi bi-check-lg me-1"></i> Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
