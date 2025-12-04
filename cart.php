<?php
$page_title = 'Shopping Cart';
$page_description = 'Review your selected digital products and proceed to checkout at AA DIGITS.';

require_once 'config/config.php';
require_once 'classes/Product.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = [];
$total_amount = 0;

// Get cart items from database
if (!empty($_SESSION['cart'])) {
    try {
        $product = new Product();
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $item = $product->getProductById($product_id);
            if ($item) {
                $item['quantity'] = $quantity;
                $item['subtotal'] = $item['price'] * $quantity;
                $cart_items[] = $item;
                $total_amount += $item['subtotal'];
            }
        }
    } catch (Exception $e) {
        // Handle error silently
    }
}

include 'includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Shopping Cart</h1>
        <p>Review your selected items and proceed to checkout</p>
    </div>
</div>

<div class="container">
    <div class="cart-section">
        <?php if (!empty($cart_items)): ?>
            <div class="cart-content">
                <!-- Cart Items -->
                <div class="cart-items">
                    <h2>Your Items (<?php echo count($cart_items); ?>)</h2>
                    
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item" data-product-id="<?php echo $item['id']; ?>">
                            <div class="item-image">
                                <?php if ($item['image_url']): ?>
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['title']); ?>">
                                <?php else: ?>
                                    <div class="image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p class="item-description"><?php echo htmlspecialchars(substr($item['description'], 0, 100)) . '...'; ?></p>
                                <div class="item-meta">
                                    <span class="item-category">
                                        <i class="fas fa-tag"></i>
                                        Category: Digital Product
                                    </span>
                                </div>
                            </div>
                            
                            <div class="item-quantity">
                                <label>Quantity:</label>
                                <div class="quantity-controls">
                                    <button class="qty-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                                    <span class="quantity"><?php echo $item['quantity']; ?></span>
                                    <button class="qty-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                                </div>
                            </div>
                            
                            <div class="item-price">
                                <div class="price">$<?php echo number_format($item['price'], 2); ?></div>
                                <div class="subtotal">$<?php echo number_format($item['subtotal'], 2); ?></div>
                            </div>
                            
                            <div class="item-actions">
                                <button class="remove-btn" onclick="removeFromCart(<?php echo $item['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format($total_amount, 2); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Tax:</span>
                        <span>$0.00</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>$<?php echo number_format($total_amount, 2); ?></span>
                    </div>
                    
                    <div class="checkout-actions">
                        <button class="btn btn-primary btn-large" onclick="proceedToCheckout()">
                            <i class="fas fa-credit-card"></i>
                            Proceed to Checkout
                        </button>
                        
                        <a href="products.php" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i>
                            Continue Shopping
                        </a>
                    </div>
                    
                    <div class="security-badges">
                        <div class="security-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Checkout</span>
                        </div>
                        <div class="security-badge">
                            <i class="fas fa-download"></i>
                            <span>Instant Download</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any products to your cart yet.</p>
                <a href="products.php" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i>
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.page-header h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-header p {
    font-size: 1.2rem;
    opacity: 0.9;
}

.cart-section {
    padding: 4rem 0;
}

.cart-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
}

.cart-items h2 {
    margin-bottom: 2rem;
    color: var(--text-primary);
}

.cart-item {
    display: grid;
    grid-template-columns: 100px 1fr auto auto auto;
    gap: 1.5rem;
    align-items: center;
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    margin-bottom: 1rem;
}

.item-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    width: 100%;
    height: 100%;
    background: var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    font-size: 1.5rem;
}

.item-details h3 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.item-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.item-meta {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

.item-quantity label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.qty-btn {
    width: 30px;
    height: 30px;
    border: 1px solid var(--border-color);
    background: var(--bg-primary);
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
}

.qty-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.quantity {
    font-weight: 600;
    color: var(--text-primary);
}

.item-price {
    text-align: right;
}

.price {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.subtotal {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.remove-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.remove-btn:hover {
    background: #dc2626;
    color: white;
}

.cart-summary {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    height: fit-content;
    position: sticky;
    top: 2rem;
}

.cart-summary h2 {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    color: var(--text-secondary);
}

.summary-row.total {
    border-top: 1px solid var(--border-color);
    padding-top: 1rem;
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
}

.checkout-actions {
    margin: 2rem 0;
}

.btn-large {
    width: 100%;
    padding: 1rem;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.security-badges {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.security-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.security-badge i {
    color: var(--primary-color);
}

.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-cart-icon {
    font-size: 4rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
    opacity: 0.5;
}

.empty-cart h2 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.empty-cart p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 2rem 0;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .cart-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .cart-item {
        grid-template-columns: 1fr;
        gap: 1rem;
        text-align: center;
    }
    
    .item-details {
        order: 1;
    }
    
    .item-quantity {
        order: 2;
    }
    
    .item-price {
        order: 3;
    }
    
    .item-actions {
        order: 4;
    }
    
    .security-badges {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<script>
function updateQuantity(productId, change) {
    // This would typically make an AJAX call to update the cart
    alert('Update quantity feature coming soon!');
}

function removeFromCart(productId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        // This would typically make an AJAX call to remove the item
        alert('Remove from cart feature coming soon!');
    }
}

function proceedToCheckout() {
    <?php if (is_logged_in()): ?>
        alert('Checkout feature coming soon!');
    <?php else: ?>
        if (confirm('You need to login to proceed with checkout. Would you like to login now?')) {
            window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.pathname);
        }
    <?php endif; ?>
}
</script>

<?php include 'includes/footer.php'; ?>
