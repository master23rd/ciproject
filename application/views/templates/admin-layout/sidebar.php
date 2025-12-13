        <!-- Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <!-- Start navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="<?= base_url() ?>" class="nav-link" target="_blank">
                            <i class="bi bi-globe me-1"></i> View Store
                        </a>
                    </li>
                </ul>

                <!-- End navbar links -->
                <ul class="navbar-nav ms-auto">
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <span class="dropdown-item dropdown-header">3 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-cart-fill me-2 text-primary"></i> 5 new orders
                                <span class="float-end text-secondary fs-7">2 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-person-fill me-2 text-success"></i> 3 new customers
                                <span class="float-end text-secondary fs-7">1 hour</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin_name ?? 'Admin') ?>&background=ff6b35&color=fff"
                                class="user-image rounded-circle shadow" alt="User Image" style="width: 30px; height: 30px;">
                            <span class="d-none d-md-inline"><?= $admin_name ?? 'Administrator' ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary" style="background: linear-gradient(135deg, #ff6b35 0%, #e55a2b 100%);">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin_name ?? 'Admin') ?>&background=ff6b35&color=fff&size=100"
                                    class="rounded-circle shadow" alt="User Image">
                                <p>
                                    <?= $admin_name ?? 'Administrator' ?>
                                    <small><?= $admin_email ?? 'admin@shophub.com' ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <a href="<?= base_url('admin/settings') ?>" class="btn btn-default btn-flat">Profile</a>
                                <a href="<?= base_url('admin/logout') ?>" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!-- Sidebar Brand -->
            <div class="sidebar-brand">
                <a href="<?= base_url('admin') ?>" class="brand-link">
                    <i class="bi bi-shop brand-image opacity-75 fs-4"></i>
                    <span class="brand-text fw-light ms-2">ShopHub Admin</span>
                </a>
            </div>

            <!-- Sidebar Wrapper -->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin') ?>" class="nav-link <?= ($active_menu ?? '') == 'dashboard' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- E-Commerce Section -->
                        <li class="nav-header">E-COMMERCE</li>

                        <!-- Products -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/products') ?>" class="nav-link <?= ($active_menu ?? '') == 'products' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Products</p>
                            </a>
                        </li>

                        <!-- Categories -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/categories') ?>" class="nav-link <?= ($active_menu ?? '') == 'categories' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-tags"></i>
                                <p>Categories</p>
                            </a>
                        </li>

                        <!-- Orders -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/orders') ?>" class="nav-link <?= ($active_menu ?? '') == 'orders' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-cart-check"></i>
                                <p>Orders</p>
                            </a>
                        </li>

                        <!-- Customers -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/customers') ?>" class="nav-link <?= ($active_menu ?? '') == 'customers' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Customers</p>
                            </a>
                        </li>

                        <!-- Settings Section -->
                        <li class="nav-header">SETTINGS</li>

                        <li class="nav-item">
                            <!-- <a href="<?= base_url('admin/settings') ?>" class="nav-link <?= ($active_menu ?? '') == 'settings' ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-gear"></i>
                                <p>Settings</p>
                            </a> -->
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/logout') ?>" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- /.sidebar -->
