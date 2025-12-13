<style>
    .checkout-container {
        padding: 40px 0;
    }

    .payment-method-card {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .payment-method-card.active {
        border-color: #ff6b35;
        background-color: #fff8f5;
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.2);
    }

    .payment-method-card input[type="radio"] {
        width: 20px;
        height: 20px;
        accent-color: #ff6b35;
        cursor: pointer;
    }

    .payment-method-info {
        flex: 1;
    }

    .payment-method-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #1a1a2e;
        margin-bottom: 5px;
    }

    .payment-method-desc {
        font-size: 0.85rem;
        color: #666;
    }

    .payment-method-icons {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .payment-icon {
        font-size: 2rem;
    }

    .payment-icon.visa {
        color: #1A1F71;
    }

    .payment-icon.mastercard {
        color: #EB001B;
    }

    .payment-icon.paypal {
        color: #00457C;
    }

    .payment-icon.gpay {
        color: #4285F4;
    }

    .payment-details {
        display: none;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-top: 15px;
    }

    .payment-details.show {
        display: block;
    }

    .card-input-wrapper {
        position: relative;
    }

    .card-input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 1.3rem;
    }

    .form-control:focus {
        border-color: #ff6b35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.15);
    }

    .btn-place-order {
        background: linear-gradient(135deg, #ff6b35, #ff8b35);
        border: none;
        color: #fff;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 10px;
        width: 100%;
    }

    .secure-payment-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 15px;
        color: #28a745;
        font-size: 0.9rem;
    }

    .paypal-button-container,
    .gpay-button-container {
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-alert {
        background: #e3f2fd;
        border: 1px solid #90caf9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .payment-alert i {
        color: #1976d2;
        margin-right: 8px;
    }
</style>

<div class="container checkout-container">
    <h2 class="mb-4"><i class="fas fa-shopping-bag me-2"></i>Checkout</h2>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-user me-2 text-primary"></i>Personal Information
                    </h5>
                    <form id="checkoutForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" placeholder="John" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Doe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" placeholder="john.doe@example.com" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" placeholder="+62 812 3456 7890" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address *</label>
                                <textarea class="form-control" id="address" rows="2" placeholder="Jl. Sudirman No. 123" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" placeholder="Jakarta" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip" class="form-label">ZIP Code *</label>
                                <input type="text" class="form-control" id="zip" placeholder="12345" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-credit-card me-2 text-primary"></i>Payment Method
                    </h5>

                    <!-- Visa/Mastercard Payment -->
                    <div class="payment-method-card active" data-method="card">
                        <input type="radio" name="paymentMethod" value="card" checked>
                        <div class="payment-method-info">
                            <div class="payment-method-name">Credit / Debit Card</div>
                            <div class="payment-method-desc">Pay securely with your card</div>
                        </div>
                        <div class="payment-method-icons">
                            <i class="fab fa-cc-visa payment-icon visa"></i>
                            <i class="fab fa-cc-mastercard payment-icon mastercard"></i>
                        </div>
                    </div>

                    <div class="payment-details show" id="cardDetails">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="card-element" class="form-label">Card Details *</label>
                                <div id="card-element" class="form-control" style="height: auto; padding: 12px;">
                                    <!-- Stripe Card Element akan dimuat disini -->
                                </div>
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="cardName" class="form-label">Cardholder Name *</label>
                                <input type="text" class="form-control" id="cardName" placeholder="JOHN DOE" required>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="saveCard">
                            <label class="form-check-label" for="saveCard">
                                Save this card for future purchases
                            </label>
                        </div>
                    </div>

                    <!-- PayPal Payment -->
                    <div class="payment-method-card" data-method="paypal">
                        <input type="radio" name="paymentMethod" value="paypal">
                        <div class="payment-method-info">
                            <div class="payment-method-name">PayPal</div>
                            <div class="payment-method-desc">Fast and secure payment with PayPal</div>
                        </div>
                        <div class="payment-method-icons">
                            <i class="fab fa-cc-paypal payment-icon paypal"></i>
                        </div>
                    </div>

                    <div class="payment-details" id="paypalDetails">
                        <div class="payment-alert">
                            <i class="fas fa-info-circle"></i>
                            You will be redirected to PayPal to complete your purchase securely.
                        </div>
                        <div id="paypal-button-container" class="paypal-button-container"></div>
                    </div>

                    <!-- Google Pay Payment -->
                    <div class="payment-method-card" data-method="gpay">
                        <input type="radio" name="paymentMethod" value="gpay">
                        <div class="payment-method-info">
                            <div class="payment-method-name">Google Pay</div>
                            <div class="payment-method-desc">Quick checkout with Google Pay</div>
                        </div>
                        <div class="payment-method-icons">
                            <i class="fab fa-google-pay payment-icon gpay"></i>
                        </div>
                    </div>

                    <div class="payment-details" id="gpayDetails">
                        <div class="payment-alert">
                            <i class="fas fa-info-circle"></i>
                            Click the button below to pay with Google Pay.
                        </div>
                        <div id="google-pay-button-container" class="gpay-button-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-receipt me-2 text-primary"></i>Order Summary
                    </h5>

                    <!-- Cart Items -->
                    <?php if (isset($cart_items) && !empty($cart_items)): ?>
                    <div class="order-items mb-3">
                        <?php foreach ($cart_items as $item): ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="<?= $item['image'] ? base_url('uploads/products/' . $item['image']) : 'https://via.placeholder.com/60' ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><?= htmlspecialchars($item['name']) ?></h6>
                                <small class="text-muted">Qty: <?= $item['qty'] ?></small>
                            </div>
                            <strong>$ <?= number_format($item['total'], 2) ?></strong>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (<?= isset($item_count) ? $item_count : 0 ?> items)</span>
                            <strong>$ <?= isset($subtotal) ? number_format($subtotal, 2) : '0.00' ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <strong class="text-success">FREE</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="h5 mb-0">Total</span>
                            <strong class="h5 mb-0 text-primary">$ <?= isset($total) ? number_format($total, 2) : '0.00' ?></strong>
                        </div>
                    </div>

                    <button type="button" class="btn btn-place-order" onclick="handlePlaceOrder()">
                        <i class="fas fa-lock me-2"></i>Place Order Securely
                    </button>

                    <div class="secure-payment-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure SSL Encrypted Payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=USD"></script>

<!-- Google Pay SDK -->
<script async src="https://pay.google.com/gp/p/js/pay.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    const paymentCards = document.querySelectorAll('.payment-method-card');
    
    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            paymentCards.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked card
            this.classList.add('active');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Hide all payment details
            document.querySelectorAll('.payment-details').forEach(detail => {
                detail.classList.remove('show');
            });
            
            // Show relevant payment details
            const method = this.dataset.method;
            if (method === 'card') {
                document.getElementById('cardDetails').classList.add('show');
            } else if (method === 'paypal') {
                document.getElementById('paypalDetails').classList.add('show');
                initPayPal();
            } else if (method === 'gpay') {
                document.getElementById('gpayDetails').classList.add('show');
                initGooglePay();
            }
        });
    });

    // Card number formatting
    const cardNumberInput = document.getElementById('cardNumber');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }

    // Expiry date formatting
    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });
    }

    // CVV input - numbers only
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
        cvvInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }
});

// PayPal Integration
function initPayPal() {
    const container = document.getElementById('paypal-button-container');
    if (container && container.children.length === 0) {
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'rect',
                label: 'paypal',
                height: 50
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '5330.00', // Approximate USD conversion
                            currency_code: 'USD'
                        },
                        description: 'ShopHub Order - 4 items'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Payment completed successfully by ' + details.payer.name.given_name);
                    // Process checkout to save order
                    processCheckout();
                });
            },
            onError: function(err) {
                console.error('PayPal Error:', err);
                alert('Payment failed. Please try again.');
            }
        }).render('#paypal-button-container');
    }
}

// Google Pay Integration
function initGooglePay() {
    const container = document.getElementById('google-pay-button-container');
    
    if (!container || container.children.length > 0) return;
    
    const paymentsClient = new google.payments.api.PaymentsClient({
        environment: 'TEST' // Change to 'PRODUCTION' for live
    });

    const button = paymentsClient.createButton({
        onClick: onGooglePaymentButtonClicked,
        buttonColor: 'default',
        buttonType: 'buy',
        buttonSizeMode: 'fill'
    });

    container.appendChild(button);
}

function onGooglePaymentButtonClicked() {
    const paymentDataRequest = {
        apiVersion: 2,
        apiVersionMinor: 0,
        allowedPaymentMethods: [{
            type: 'CARD',
            parameters: {
                allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                allowedCardNetworks: ['MASTERCARD', 'VISA']
            },
            tokenizationSpecification: {
                type: 'PAYMENT_GATEWAY',
                parameters: {
                    gateway: 'stripe',
                    'stripe:version': '2018-10-31',
                    'stripe:publishableKey': 'pk_test_YOUR_KEY'
                }
            }
        }],
        merchantInfo: {
            merchantName: 'ShopHub',
            merchantId: '12345678901234567890'
        },
        transactionInfo: {
            totalPriceStatus: 'FINAL',
            totalPrice: '5330.00',
            currencyCode: 'USD',
            countryCode: 'US'
        }
    };

    const paymentsClient = new google.payments.api.PaymentsClient({
        environment: 'TEST'
    });

    paymentsClient.loadPaymentData(paymentDataRequest)
        .then(function(paymentData) {
            console.log('Payment successful:', paymentData);
            alert('Payment successful with Google Pay!');
            // Process checkout to save order
            processCheckout();
        })
        .catch(function(err) {
            console.error('Google Pay Error:', err);
            alert('Payment cancelled or failed.');
        });
}

// Place Order Handler
function handlePlaceOrder() {
    const form = document.getElementById('checkoutForm');
    const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked').value;

    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    if (selectedPayment === 'card') {
        // Validate card details
        const cardName = document.getElementById('cardName').value;

        if (!cardName) {
            alert('Please enter cardholder name');
            return;
        }

        // Process card payment with Stripe then checkout
        processStripePayment();
    } else if (selectedPayment === 'paypal') {
        alert('Please use the PayPal button above to complete payment');
    } else if (selectedPayment === 'gpay') {
        alert('Please use the Google Pay button above to complete payment');
    }
}

// Process checkout after successful payment
async function processCheckout() {
    const formData = new FormData();
    formData.append('first_name', document.getElementById('firstName').value);
    formData.append('last_name', document.getElementById('lastName').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('phone', document.getElementById('phone').value);
    formData.append('address', document.getElementById('address').value);
    formData.append('city', document.getElementById('city').value);
    formData.append('zip', document.getElementById('zip').value);

    try {
        const response = await fetch('<?php echo base_url("welcome/process_checkout"); ?>', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = data.redirect_url;
        } else {
            alert(data.message || 'Checkout failed');
        }
    } catch (error) {
        console.error('Checkout error:', error);
        alert('Checkout failed. Please try again.');
    }
}

// Process Card Payment
function processCardPayment() {
    const btn = document.querySelector('.btn-place-order');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Payment...';
    btn.disabled = true;

    // Simulate payment processing (replace with actual Stripe API call)
    setTimeout(() => {
        alert('Payment successful! Your order has been placed.');
        window.location.href = '<?php echo base_url("checkout/success"); ?>';
    }, 2000);
}

// ==================== STRIPE INTEGRATION ====================
let stripe;
let elements;
let cardElement;

// Initialize Stripe
async function initializeStripe() {
    try {
        const response = await fetch('<?php echo base_url("payment/get_public_key"); ?>');
        const data = await response.json();
        
        stripe = Stripe(data.publicKey);
        
        elements = stripe.elements();
        
        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Poppins", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        
        cardElement = elements.create('card', {
            style: style,
            hidePostalCode: true
        });
        
        // Mount Card Element
        cardElement.mount('#card-element');
        
        // Handle real-time validation errors
        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        
        console.log('Stripe initialized successfully');
    } catch (error) {
        console.error('Error initializing Stripe:', error);
    }
}

// Process Stripe Payment
async function processStripePayment() {
    const btn = document.querySelector('.btn-place-order');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Payment...';
    btn.disabled = true;
    
    try {
        // Get customer details
        const customerName = document.getElementById('cardName').value;
        const firstName = document.getElementById('firstName').value || 'Customer';
        const lastName = document.getElementById('lastName').value || '';
        const fullName = firstName + ' ' + lastName;
        const email = document.getElementById('email').value || 'customer@example.com';
        
        const totalAmount = <?= isset($total) ? (int)$total : 0 ?>;
        
        // Create Payment Intent
        const createIntentResponse = await fetch('<?php echo base_url("payment/create_payment_intent"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                amount: totalAmount,
                currency: 'usd',
                description: 'Phone Shop Purchase - 4 items',
                order_id: 'ORD-' + Date.now(),
                customer_name: fullName,
                customer_email: email
            })
        });
        
        const intentData = await createIntentResponse.json();
        
        if (intentData.error) {
            throw new Error(intentData.error);
        }
        
        // Confirm card payment
        const {error, paymentIntent} = await stripe.confirmCardPayment(
            intentData.clientSecret,
            {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: customerName || fullName
                    }
                }
            }
        );
        
        if (error) {
            // Show error to customer
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            
            btn.innerHTML = originalText;
            btn.disabled = false;
        } else {
            // Payment succeeded
            if (paymentIntent.status === 'succeeded') {
                sessionStorage.setItem('payment_intent_id', paymentIntent.id);
                sessionStorage.setItem('payment_status', 'succeeded');
                
                // Process checkout to save order and clear cart
                await processCheckout();
            }
        }
    } catch (error) {
        console.error('Payment error:', error);
        alert('Payment failed: ' + error.message);
        
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

// Initialize Stripe when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeStripe();
});

</script>