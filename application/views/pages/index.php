<style>
    /* Hot Sale Section */
    .hot-sale-section {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8b35 100%);
        border-radius: 20px;
        padding: 40px 20px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
    }

    .hot-sale-title {
        color: #fff;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 30px;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .hot-sale-title i {
        color: #ffc857;
    }

    /* Product Card */
    .product-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        background: #f8f9fa;
        padding: 20px;
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ff6b35;
        color: #fff;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
    }

    .product-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #1a1a2e;
        margin-bottom: 10px;
        min-height: 50px;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ff6b35;
        margin-bottom: 10px;
    }

    .product-price-old {
        font-size: 1rem;
        color: #999;
        text-decoration: line-through;
        margin-left: 10px;
    }

    .product-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .product-specs {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 15px;
    }

    .product-specs i {
        color: #ff6b35;
        margin-right: 5px;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, #ff6b35, #ff8b35);
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #004e89, #006bb3);
        transform: scale(1.05);
        color: #fff;
    }

    /* Section Title */
    .section-title {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1a1a2e;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #ff6b35, #ffc857);
        border-radius: 2px;
    }

    /* Carousel Custom Styles */
    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        background: #fff;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1);
    }

    /* Hot Sale Product Card */
    .hot-sale-card {
        background: #fff;
        border-radius: 15px;
        padding: 15px;
        margin: 0 10px;
    }

    .hot-sale-card .product-image {
        height: 200px;
    }

    /* Rating Stars */
    .product-rating {
        color: #ffc857;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .product-rating .rating-count {
        color: #999;
        font-size: 0.85rem;
        margin-left: 5px;
    }
</style>

<div class="container">
    <!-- Hot Sale / Featured Products Section -->
    <div class="hot-sale-section">
        <h2 class="hot-sale-title">
            <i class="fas fa-fire"></i> Hot Sale - Limited Time Offer!
        </h2>

        <div id="hotSaleCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#hotSaleCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#hotSaleCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#hotSaleCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-4">
						<?php if (!empty($products)): ?>
							<?php foreach (array_slice($products, 0, 3) as $product): ?>
								<div class="col-md-4">
									<div class="hot-sale-card">
										<div class="position-relative">
											<img src="https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400"
												class="product-image" alt="iPhone 15 Pro Max">
											<span class="product-badge">-25%</span>
										</div>
										<div class="product-body">
											<h5 class="product-name"><?= $product->product_name; ?></h5>
											<div class="product-rating">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<span class="rating-count">(156)</span>
											</div>
											<div class="product-price">
												$ <?= $product->price; ?>
												<span class="product-price-old">$ <?= $product->price; ?></span>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							 <tr>
								<td colspan="8" class="text-center py-4">
									<i class="bi bi-inbox fs-1 text-muted"></i>
									<p class="text-muted mb-0">No products found</p>
								</td>
							</tr>
						<?php endif; ?>
                    </div>
                </div>

                <!-- Slide 2 -->
                <!-- <div class="carousel-item">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="hot-sale-card">
                                <div class="position-relative">
                                    <img src="https://images.unsplash.com/photo-1567581935884-3349723552ca?w=400"
                                        class="product-image" alt="OPPO Find X7 Pro">
                                    <span class="product-badge">-15%</span>
                                </div>
                                <div class="product-body">
                                    <h5 class="product-name">OPPO Find X7 Pro</h5>
                                    <div class="product-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <span class="rating-count">(67)</span>
                                    </div>
                                    <div class="product-price">
                                        Rp 10.199.000
                                        <span class="product-price-old">Rp 11.999.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hot-sale-card">
                                <div class="position-relative">
                                    <img src="https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=400"
                                        class="product-image" alt="Vivo X100 Pro">
                                    <span class="product-badge">-18%</span>
                                </div>
                                <div class="product-body">
                                    <h5 class="product-name">Vivo X100 Pro</h5>
                                    <div class="product-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span class="rating-count">(94)</span>
                                    </div>
                                    <div class="product-price">
                                        Rp 11.479.000
                                        <span class="product-price-old">Rp 13.999.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hot-sale-card">
                                <div class="position-relative">
                                    <img src="https://images.unsplash.com/photo-1592286927505-2fd704821596?w=400"
                                        class="product-image" alt="Google Pixel 8 Pro">
                                    <span class="product-badge">-22%</span>
                                </div>
                                <div class="product-body">
                                    <h5 class="product-name">Google Pixel 8 Pro</h5>
                                    <div class="product-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span class="rating-count">(112)</span>
                                    </div>
                                    <div class="product-price">
                                        Rp 10.919.000
                                        <span class="product-price-old">Rp 13.999.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#hotSaleCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#hotSaleCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- All Products Section -->
    <div class="mb-5">
        <h2 class="section-title">
            <i class="fas fa-mobile-alt me-2"></i> All Products
        </h2>

        <!-- Loading Spinner -->
        <div id="products-loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading products...</p>
        </div>

        <!-- Products Container -->
        <div class="row g-4" id="products-container">
            <!-- Products will be loaded here via API -->
        </div>

        <!-- Error Message -->
        <div id="products-error" class="alert alert-danger d-none" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <span id="error-message">Failed to load products. Please try again.</span>
            <button class="btn btn-sm btn-outline-danger ms-3" onclick="loadProducts()">
                <i class="fas fa-redo me-1"></i> Retry
            </button>
        </div>

        <!-- Empty State -->
        <div id="products-empty" class="text-center py-5 d-none">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No products available</h4>
            <p class="text-muted">Check back later for new products!</p>
        </div>
    </div>
</div>

<script>
    const BASE_URL = '<?= base_url() ?>';

    // Handle Add to Cart
    function handleAddToCart(productId) {
        $.ajax({
            url: BASE_URL + 'cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                qty: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update cart count in header
                    updateCartBadge(response.cart_count);
                    
                    // Update cart content in offcanvas
                    updateCartContent(response.cart_html, response.cart_total, response.cart_count);
                    
                    // Show cart offcanvas
                    showCartOffcanvas();
                    
                    // Show success toast
                    showToast('Success', response.message, 'success');
                } else if (response.redirect) {
                    // Not logged in, redirect to login
                    showToast('Info', response.message, 'warning');
                    setTimeout(function() {
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else {
                    showToast('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                showToast('Error', 'Failed to add item to cart', 'error');
            }
        });
    }

    // Update Cart Quantity
    function updateCartQty(productId, change) {
        const input = document.querySelector(`.cart-item[data-id="${productId}"] .qty-input`);
        let newQty = parseInt(input.value) + change;
        
        if (newQty < 1) {
            removeFromCart(productId);
            return;
        }

        $.ajax({
            url: BASE_URL + 'cart/update',
            type: 'POST',
            data: {
                product_id: productId,
                qty: newQty
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCartBadge(response.cart_count);
                    updateCartContent(response.cart_html, response.cart_total, response.cart_count);
                }
            }
        });
    }

    // Remove from Cart
    function removeFromCart(productId) {
        $.ajax({
            url: BASE_URL + 'cart/remove',
            type: 'POST',
            data: {
                product_id: productId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCartBadge(response.cart_count);
                    updateCartContent(response.cart_html, response.cart_total, response.cart_count);
                    showToast('Success', response.message, 'success');
                }
            }
        });
    }

    // Update cart badge in header
    function updateCartBadge(count) {
        $('.nav-icon .badge').text(count);
    }

    // Update cart content in offcanvas
    function updateCartContent(html, total, count) {
        $('.offcanvas-body .cart-items').parent().html(html + `
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal (${count} items)</span>
                    <span class="fw-bold">$ ${parseFloat(total).toFixed(2)}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="text-success fw-bold">FREE</span>
                </div>
                <hr>
                <div class="summary-row total">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-primary fs-5">$ ${parseFloat(total).toFixed(2)}</span>
                </div>
                
                <div class="cart-actions">
                    <!--<a href="${BASE_URL}cart" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-shopping-cart me-2"></i>View Cart
                    </a>-->
                    <a href="${BASE_URL}checkout" class="btn btn-primary w-100">
                        <i class="fas fa-check-circle me-2"></i>Checkout
                    </a>
                </div>
            </div>
        `);
    }

    // Show cart offcanvas
    function showCartOffcanvas() {
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasMenu'));
        offcanvas.show();
    }

    // Show toast notification
    function showToast(title, message, type) {
        // Remove existing toasts
        $('.toast-container').remove();
        
        let bgClass = 'bg-success';
        let icon = 'fa-check-circle';
        
        if (type === 'error') {
            bgClass = 'bg-danger';
            icon = 'fa-times-circle';
        } else if (type === 'warning') {
            bgClass = 'bg-warning';
            icon = 'fa-exclamation-circle';
        }

        const toastHtml = `
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div class="toast show ${bgClass} text-white" role="alert">
                    <div class="toast-header ${bgClass} text-white">
                        <i class="fas ${icon} me-2"></i>
                        <strong class="me-auto">${title}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(toastHtml);
        
        // Auto hide after 3 seconds
        setTimeout(function() {
            $('.toast-container').fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // ============================================
    // Products API Integration
    // ============================================
    
    // Load products from API
    function loadProducts() {
        const container = $('#products-container');
        const loading = $('#products-loading');
        const error = $('#products-error');
        const empty = $('#products-empty');
        
        // Show loading, hide others
        loading.removeClass('d-none');
        container.empty();
        error.addClass('d-none');
        empty.addClass('d-none');
        
        $.ajax({
            url: BASE_URL + 'api/products',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                loading.addClass('d-none');
                
                if (response.success && response.data && response.data.length > 0) {
                    renderProducts(response.data);
                } else {
                    empty.removeClass('d-none');
                }
            },
            error: function(xhr, status, errorMsg) {
                loading.addClass('d-none');
                error.removeClass('d-none');
                $('#error-message').text('Failed to load products: ' + errorMsg);
                console.error('Failed to load products:', errorMsg);
            }
        });
    }
    
    // Render products to the container
    function renderProducts(products) {
        const container = $('#products-container');
        container.empty();
        
        products.forEach(function(product) {
            const productHtml = createProductCard(product);
            container.append(productHtml);
        });
    }
    
    // Create product card HTML
    function createProductCard(product) {
        const price = parseFloat(product.price).toFixed(2);
        const weight = parseFloat(product.weight).toFixed(2);
        const description = product.description ? 
            (product.description.length > 100 ? product.description.substring(0, 100) + '...' : product.description) 
            : 'No description available';
        
        return `
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="position-relative">
                        <img src="${BASE_URL}uploads/products/${product.image}"
                            class="product-image" 
                            alt="${escapeHtml(product.product_name)}"
							onerror="this.src='https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400'
                            ">
                        ${product.qty <= 5 && product.qty > 0 ? '<span class="product-badge">Low Stock</span>' : ''}
                        ${product.qty <= 0 ? '<span class="product-badge bg-danger">Out of Stock</span>' : ''}
                    </div>
                    <div class="product-body">
                        <h5 class="product-name">${escapeHtml(product.product_name)}</h5>
                        <div class="product-price">$ ${price}</div>
                        <p class="product-description">${escapeHtml(description)}</p>
                        <div class="product-specs">
                            <i class="fas fa-balance-scale"></i> ${weight} Kilograms<br>
                            ${product.category_name ? `<i class="fas fa-tag"></i> ${escapeHtml(product.category_name)}` : ''}
                        </div>
                        <button class="btn btn-add-cart" 
                            onclick="handleAddToCart(${product.id})"
                            ${product.qty <= 0 ? 'disabled' : ''}>
                            <i class="fas fa-shopping-cart me-2"></i> 
                            ${product.qty <= 0 ? 'Out of Stock' : 'Add to Cart'}
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Search products
    function searchProducts(query) {
        if (!query || query.trim() === '') {
            loadProducts();
            return;
        }
        
        const container = $('#products-container');
        const loading = $('#products-loading');
        const error = $('#products-error');
        const empty = $('#products-empty');
        
        loading.removeClass('d-none');
        container.empty();
        error.addClass('d-none');
        empty.addClass('d-none');
        
        $.ajax({
            url: BASE_URL + 'api/products/search',
            type: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(response) {
                loading.addClass('d-none');
                
                if (response.success && response.data && response.data.length > 0) {
                    renderProducts(response.data);
                } else {
                    empty.removeClass('d-none');
                    $('#products-empty h4').text('No products found');
                    $('#products-empty p').text('Try searching with different keywords');
                }
            },
            error: function(xhr, status, errorMsg) {
                loading.addClass('d-none');
                error.removeClass('d-none');
            }
        });
    }
    
    // Load products on page load
    $(document).ready(function() {
        loadProducts();
    });
</script>
