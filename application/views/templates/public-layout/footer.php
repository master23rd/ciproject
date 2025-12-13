    </main>
    <!-- End Main Content -->

    <!-- Footer -->
    <footer class="footer">
        <!-- Main Footer -->
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <!-- About Column -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-brand">
                            <a href="<?php echo base_url(); ?>">
                                <i class="fas fa-store me-2"></i>Shop<span>Hub</span>
                            </a>
                        </div>
                        <p class="footer-about">
                            ShopHub is your one-stop destination for all your shopping needs. We offer a wide range of quality products at competitive prices with excellent customer service.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop" title="Back to Top">
        <i class="fas fa-chevron-up"></i>
    </a>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">
                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <!-- Cart Items -->
            <div class="cart-items">
    
            </div>

   
        </div>
    </div>

    <!-- Footer Styles -->
    <style>
        /* Footer Base */
        .footer {
            background-color: var(--dark-color);
            color: #fff;
            margin-top: auto;
        }

        /* Newsletter Section */
        .footer-newsletter {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            padding: 40px 0;
        }

        .footer-newsletter h4 {
            color: #fff;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .footer-newsletter p {
            color: rgba(255, 255, 255, 0.9);
        }

        .newsletter-form .form-control {
            border-radius: 25px 0 0 25px;
            padding: 12px 20px;
            border: none;
        }

        .newsletter-form .btn {
            border-radius: 0 25px 25px 0;
            padding: 12px 30px;
            background-color: var(--dark-color);
            border-color: var(--dark-color);
            font-weight: 500;
        }

        .newsletter-form .btn:hover {
            background-color: #000;
            border-color: #000;
        }

        /* Main Footer */
        .footer-main {
            padding: 60px 0 40px;
        }

        .footer-brand a {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .footer-brand a span {
            color: #fff;
        }

        .footer-about {
            color: rgba(255, 255, 255, 0.7);
            margin: 20px 0;
            line-height: 1.8;
        }

        .footer-social {
            display: flex;
            gap: 10px;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .footer-social a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        .footer-title {
            color: #fff;
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 1.1rem;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-contact li {
            display: flex;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-contact li i {
            color: var(--primary-color);
            margin-right: 15px;
            margin-top: 4px;
            width: 16px;
        }

        /* App Download Buttons */
        .app-download {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .app-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .app-btn:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .app-btn i {
            font-size: 1.2rem;
        }

        /* Payment Section */
        .footer-payment {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 20px 0;
        }

        .payment-title {
            color: rgba(255, 255, 255, 0.7);
            margin-right: 15px;
        }

        .payment-icons {
            display: inline-flex;
            gap: 15px;
            font-size: 1.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .payment-icons i:hover {
            color: #fff;
        }

        .security-badges {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .security-badges i {
            color: var(--accent-color);
        }

        /* Bottom Footer */
        .footer-bottom {
            background-color: rgba(0, 0, 0, 0.3);
            padding: 20px 0;
        }

        .copyright {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-legal {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            justify-content: flex-end;
        }

        .footer-legal a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .footer-legal a:hover {
            color: var(--primary-color);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 999;
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
        }

        .back-to-top:hover {
            background-color: var(--secondary-color);
            color: #fff;
            transform: translateY(-5px);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        /* Cart Offcanvas Styles */
        .offcanvas {
            width: 420px !important;
        }

        .cart-items {
            max-height: calc(100vh - 350px);
            overflow-y: auto;
            padding: 0;
        }

        .cart-item {
            display: flex;
            gap: 15px;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.3s;
        }

        .cart-item:hover {
            background-color: #f8f9fa;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            background: #f8f9fa;
            padding: 8px;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .cart-item-specs {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 8px;
        }

        .cart-item-price {
            font-size: 1rem;
            font-weight: 700;
            color: #ff6b35;
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 5px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border: none;
            background: #f8f9fa;
            color: #333;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .qty-btn:hover {
            background: #ff6b35;
            color: #fff;
        }

        .qty-input {
            width: 40px;
            height: 28px;
            border: none;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0;
        }

        .qty-input:focus {
            outline: none;
        }

        /* Remove spinner arrows from number input */
        .qty-input::-webkit-inner-spin-button,
        .qty-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-input {
            -moz-appearance: textfield;
        }

        .btn-remove {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1rem;
            padding: 5px;
            transition: all 0.3s;
        }

        .btn-remove:hover {
            color: #c82333;
            transform: scale(1.1);
        }

        .cart-summary {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 20px;
            border-top: 2px solid #e0e0e0;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95rem;
            color: #333;
        }

        .summary-row.total {
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .cart-summary hr {
            margin: 15px 0;
            opacity: 0.2;
        }

        .cart-actions {
            margin-top: 20px;
        }

        .cart-actions .btn {
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .cart-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 767px) {
            .footer-newsletter h4 {
                font-size: 1.1rem;
            }

            .footer-main {
                padding: 40px 0 20px;
            }

            .payment-icons {
                display: flex;
                flex-wrap: wrap;
                margin-top: 10px;
            }

            .footer-legal {
                justify-content: center;
            }

            .security-badges {
                display: block;
                margin-top: 10px;
            }

            .offcanvas {
                width: 100% !important;
            }

            .cart-item {
                flex-direction: row;
                padding: 15px;
            }

            .cart-item img {
                width: 70px;
                height: 70px;
            }

            .cart-item-name {
                font-size: 0.9rem;
            }

            .cart-summary {
                padding: 15px;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Back to Top Script -->
    <script>
        // Back to Top Button
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        function showCartOffcanvas() {
            const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasMenu'));
            offcanvas.show();
        }
    </script>
    </body>

    </html>