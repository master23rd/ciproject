        <!-- Footer -->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">
                Version 1.0.0
            </div>
            <strong>
                Copyright &copy; <?= date('Y') ?> <a href="<?= base_url() ?>" class="text-decoration-none">ShopHub</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- OverlayScrollbars -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.4.5/browser/overlayscrollbars.browser.es6.min.js"></script>
    
    <!-- Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AdminLTE JS - Using CDN -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Initialize AdminLTE components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize sidebar scrollbar
            const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: 'os-theme-light',
                        autoHide: 'leave',
                        clickScroll: true,
                    },
                });
            }
        });
        
        $(document).ready(function() {
            // Initialize DataTables
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [[0, 'asc']]
                });
            }
        });
        
        // Delete confirmation
        function confirmDelete(url, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete "${name}". This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
        
        // Toast notification
        function showToast(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            
            Toast.fire({
                icon: type,
                title: message
            });
        }
        
        // Show flash messages
        <?php if ($this->session->flashdata('success')): ?>
            showToast('success', '<?= $this->session->flashdata('success') ?>');
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            showToast('error', '<?= $this->session->flashdata('error') ?>');
        <?php endif; ?>
    </script>
</body>
</html>
