<?php
$page_title = 'Product Details';
$page_description = 'View details about this premium digital product';

require_once 'config/config.php';
require_once 'classes/Product.php';

// Initialize product class
$product = new Product();

// Get product by slug
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Sample product data (replace with database query)
$product_data = [
    'id' => 1,
    'title' => 'iOS Social Media App Template',
    'slug' => 'ios-social-media-app-template',
    'description' => 'A fully functional iOS social media app template built with SwiftUI. This template includes modern UI/UX, real-time updates, user authentication, and seamless integration with Firebase backend services. Perfect for launching your next social media platform with a professional look and feel.',
    'price' => 99.99,
    'sale_price' => 79.99,
    'category_id' => 2, // Mobile Apps
    'rating' => 4.8,
    'review_count' => 42,
    'version' => '2.1.0',
    'updated_at' => '2023-11-20',
    'compatibility' => 'iOS 15.0+, Xcode 14.0+',
    'framework' => 'SwiftUI',
    'features' => [
        'User Authentication (Email & Social Login)',
        'Real-time Feed & Notifications',
        'Image/Video Uploads',
        'Direct Messaging',
        'Dark/Light Mode',
        'Profile Customization',
        'Hashtag & Search Functionality',
        'Push Notifications',
        'Analytics Dashboard',
        'REST API Integration'
    ],
    'requirements' => [
        'Xcode 14.0+',
        'iOS 15.0+',
        'CocoaPods',
        'Firebase Account',
        'Apple Developer Account'
    ],
    'sku' => 'IOS-' . rand(1000, 9999)
];

// Sample related products - iOS App Templates
$related_products = [
    [
        'id' => 8,
        'title' => 'Fitness Tracker App',
        'slug' => 'fitness-tracker-app',
        'price' => 89.99,
        'rating' => 4.9,
        'review_count' => 28,
        'image' => 'https://via.placeholder.com/300x200/00C853/FFFFFF?text=Fitness+App',
        'category' => 'iOS Apps',
        'framework' => 'SwiftUI',
        'features' => ['Workout Tracking', 'HealthKit', 'Progress Analytics']
    ],
    [
        'id' => 9,
        'title' => 'Food Delivery App',
        'slug' => 'food-delivery-app',
        'price' => 109.99,
        'rating' => 4.7,
        'review_count' => 35,
        'image' => 'https://via.placeholder.com/300x200/FF7043/FFFFFF?text=Food+Delivery',
        'category' => 'iOS Apps',
        'framework' => 'SwiftUI',
        'features' => ['Real-time Tracking', 'Menu Management', 'Payment Gateway']
    ],
    [
        'id' => 10,
        'title' => 'E-learning App',
        'slug' => 'elearning-app',
        'price' => 99.99,
        'rating' => 4.8,
        'review_count' => 22,
        'image' => 'https://via.placeholder.com/300x200/5E35B1/FFFFFF?text=E-learning',
        'category' => 'iOS Apps',
        'framework' => 'UIKit',
        'features' => ['Video Lessons', 'Quizzes', 'Progress Tracking']
    ],
    [
        'id' => 11,
        'title' => 'Travel Booking App',
        'slug' => 'travel-booking-app',
        'price' => 119.99,
        'rating' => 4.9,
        'review_count' => 41,
        'image' => 'https://via.placeholder.com/300x200/039BE5/FFFFFF?text=Travel+App',
        'category' => 'iOS Apps',
        'framework' => 'SwiftUI',
        'features' => ['Hotel Booking', 'Flight Search', 'Itinerary Planner']
    ],
    [
        'id' => 12,
        'title' => 'Fashion Marketplace',
        'slug' => 'fashion-marketplace-app',
        'price' => 129.99,
        'rating' => 4.8,
        'review_count' => 37,
        'image' => 'https://via.placeholder.com/300x200/E91E63/FFFFFF?text=Fashion+App',
        'category' => 'iOS Apps',
        'framework' => 'SwiftUI',
        'features' => ['Product Catalog', 'Shopping Cart', 'AR Try-On']
    ],
    [
        'id' => 13,
        'title' => 'Meditation & Sleep',
        'slug' => 'meditation-app',
        'price' => 79.99,
        'rating' => 4.9,
        'review_count' => 45,
        'image' => 'https://via.placeholder.com/300x200/7B1FA2/FFFFFF?text=Meditation',
        'category' => 'iOS Apps',
        'framework' => 'SwiftUI',
        'features' => ['Guided Meditations', 'Sleep Stories', 'Mood Tracking']
    ]
];

// Sample product images
$product_images = [
    'https://via.placeholder.com/800x600/1D1D1F/FFFFFF?text=iOS+Social+Feed',
    'https://via.placeholder.com/800x600/2C2C2E/FFFFFF?text=User+Profile',
    'https://via.placeholder.com/800x600/3A3A3C/FFFFFF?text=Direct+Messages',
    'https://via.placeholder.com/800x600/48484A/FFFFFF?text=Dark+Mode',
    'https://via.placeholder.com/800x600/636366/FFFFFF?text=Post+Creation'
];

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Product Gallery -->
        <div class="col-lg-6">
            <div class="main-image mb-3">
                <img src="<?php echo $product_images[0]; ?>" 
                     alt="<?php echo htmlspecialchars($product_data['title']); ?>" 
                     class="img-fluid rounded"
                     id="main-product-image">
            </div>
            
            <div class="thumbnail-gallery d-flex gap-2">
                <?php foreach ($product_images as $index => $image): ?>
                    <div class="thumbnail-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                         style="width: 80px; height: 80px; cursor: pointer; border: 2px solid #ddd; border-radius: 5px; overflow: hidden;"
                         data-image="<?php echo $image; ?>">
                        <img src="<?php echo $image; ?>" 
                             alt="Screenshot <?php echo $index + 1; ?>"
                             class="img-fluid"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-lg-6">
            <h1 class="mb-3"><?php echo htmlspecialchars($product_data['title']); ?></h1>
            
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning me-2">
                    <?php
                    $rating = $product_data['rating'];
                    $full_stars = floor($rating);
                    $has_half_star = $rating - $full_stars >= 0.5;
                    
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $full_stars) {
                            echo '<i class="fas fa-star"></i>';
                        } elseif ($i == $full_stars + 1 && $has_half_star) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    ?>
                </div>
                <span class="text-muted">(<?php echo $product_data['review_count']; ?> reviews)</span>
            </div>
            
            <div class="mb-4">
                <?php if (isset($product_data['sale_price']) && $product_data['sale_price'] < $product_data['price']): ?>
                    <h2 class="text-danger">$<?php echo number_format($product_data['sale_price'], 2); ?></h2>
                    <del class="text-muted">$<?php echo number_format($product_data['price'], 2); ?></del>
                    <span class="badge bg-danger ms-2">
                        Save <?php echo number_format((($product_data['price'] - $product_data['sale_price']) / $product_data['price']) * 100, 0); ?>%
                    </span>
                <?php else: ?>
                    <h2>$<?php echo number_format($product_data['price'], 2); ?></h2>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <p class="lead"><?php echo htmlspecialchars($product_data['description']); ?></p>
            </div>
            
            <div class="mb-4">
                <h5>Key Features:</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i> Fully Responsive Design</li>
                    <li><i class="fas fa-check text-success me-2"></i> Built with Bootstrap 5</li>
                    <li><i class="fas fa-check text-success me-2"></i> Multiple Homepage Layouts</li>
                    <li><i class="fas fa-check text-success me-2"></i> Shopping Cart & Checkout</li>
                    <li><i class="fas fa-check text-success me-2"></i> User Dashboard</li>
                </ul>
            </div>
            
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="input-group" style="width: 140px;">
                    <button class="btn btn-outline-secondary" type="button" id="decrease-qty">-</button>
                    <input type="number" class="form-control text-center" value="1" min="1" id="quantity">
                    <button class="btn btn-outline-secondary" type="button" id="increase-qty">+</button>
                </div>
                
                <button class="btn btn-primary btn-lg flex-grow-1" id="add-to-cart">
                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                </button>
                
                <button class="btn btn-outline-secondary" title="Add to Wishlist">
                    <i class="far fa-heart"></i>
                </button>
            </div>
            
            <div class="border-top pt-3">
                <p class="mb-2"><strong>SKU:</strong> <?php echo $product_data['sku']; ?></p>
                <p class="mb-2"><strong>Category:</strong> Website Templates</p>
                <p class="mb-0"><strong>Tags:</strong> ecommerce, shop, store, online, responsive</p>
            </div>
        </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                        Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        Reviews (<?php echo $product_data['review_count']; ?>)
                    </button>
                </li>
            </ul>
            
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <h4>Product Description</h4>
                    <p><?php echo nl2br(htmlspecialchars($product_data['description'])); ?></p>
                    
                    <h5 class="mt-4">Key Features</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>Fully Responsive Design</li>
                                <li>Built with Bootstrap 5</li>
                                <li>Multiple Homepage Layouts</li>
                                <li>Product Quick View</li>
                                <li>Shopping Cart Functionality</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Checkout Process</li>
                                <li>User Dashboard</li>
                                <li>Clean & Modern Design</li>
                                <li>Well Documented</li>
                                <li>Free Lifetime Updates</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <img src="https://via.placeholder.com/1200x600/F5F7FA/4A90E2?text=Ecommerce+Template+Showcase" 
                             alt="Template Showcase" 
                             class="img-fluid rounded">
                    </div>
                </div>
                
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <h4>Technical Specifications</h4>
                    
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 200px;">Version</th>
                            <td><?php echo $product_data['version']; ?></td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td><?php echo date('F j, Y', strtotime($product_data['updated_at'])); ?></td>
                        </tr>
                        <tr>
                            <th>Framework</th>
                            <td>Bootstrap 5.x</td>
                        </tr>
                        <tr>
                            <th>Responsive</th>
                            <td>Yes</td>
                        </tr>
                        <tr>
                            <th>Documentation</th>
                            <td>Included</td>
                        </tr>
                        <tr>
                            <th>Browser Support</th>
                            <td>Chrome, Firefox, Safari, Edge, Opera</td>
                        </tr>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <h2 class="display-4">4.8</h2>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="text-muted">Based on <?php echo $product_data['review_count']; ?> reviews</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    Write a Review
                                </button>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="me-2">5 Stars</span>
                                    <div class="progress flex-grow-1" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 85%"></div>
                                    </div>
                                    <span class="ms-2">85%</span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="me-2">4 Stars</span>
                                    <div class="progress flex-grow-1" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 10%"></div>
                                    </div>
                                    <span class="ms-2">10%</span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="me-2">3 Stars</span>
                                    <div class="progress flex-grow-1" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 3%"></div>
                                    </div>
                                    <span class="ms-2">3%</span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="me-2">2 Stars</span>
                                    <div class="progress flex-grow-1" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 1%"></div>
                                    </div>
                                    <span class="ms-2">1%</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">1 Star</span>
                                    <div class="progress flex-grow-1" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 1%"></div>
                                    </div>
                                    <span class="ms-2">1%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="review-item border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="mb-0">Amazing eCommerce Template!</h5>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-muted small">By John Doe on June 10, 2023</p>
                                <p>This template exceeded all my expectations. The design is modern and clean, and the code is well-organized and easy to customize. The documentation is thorough and the support team is very responsive. Highly recommended!</p>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="far fa-thumbs-up"></i> Helpful (12)
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="far fa-flag"></i> Report
                                    </button>
                                </div>
                            </div>
                            
                            <div class="review-item">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="mb-0">Great template with minor issues</h5>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-muted small">By Alice Smith on May 25, 2023</p>
                                <p>Overall, this is a great template with a lot of features. The design is modern and responsive. I had a few issues with the checkout process, but the support team helped me resolve them quickly. Would recommend with a few customizations.</p>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="far fa-thumbs-up"></i> Helpful (5)
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="far fa-flag"></i> Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if (!empty($related_products)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">You May Also Like</h3>
        </div>
        
        <?php foreach ($related_products as $related): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/400x300/F5F7FA/4A90E2?text=<?php echo urlencode($related['title']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($related['title']); ?>">
                    <div class="position-absolute top-0 end-0 m-2">
                        <button class="btn btn-sm btn-light rounded-circle" title="Add to Wishlist">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="product.php?slug=<?php echo $related['slug']; ?>" class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($related['title']); ?>
                        </a>
                    </h5>
                    <div class="text-warning mb-2">
                        <?php
                        $rating = $related['rating'];
                        $full_stars = floor($rating);
                        $has_half_star = $rating - $full_stars >= 0.5;
                        
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $full_stars) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($i == $full_stars + 1 && $has_half_star) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                        <span class="text-muted small">(<?php echo $related['review_count']; ?>)</span>
                    </div>
                    <h5 class="text-primary mb-0">$<?php echo number_format($related['price'], 2); ?></h5>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <button class="btn btn-outline-primary w-100 add-to-cart" 
                            data-product-id="<?php echo $related['id']; ?>">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <div class="mb-3">
                        <label class="form-label">Your Rating</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reviewTitle" class="form-label">Review Title</label>
                        <input type="text" class="form-control" id="reviewTitle" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reviewContent" class="form-label">Your Review</label>
                        <textarea class="form-control" id="reviewContent" name="content" rows="5" required></textarea>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="recommendProduct" name="recommend" checked>
                        <label class="form-check-label" for="recommendProduct">
                            I recommend this product
                        </label>
                    </div>
                    
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Thumbnail Gallery
const thumbnailItems = document.querySelectorAll('.thumbnail-item');
const mainImage = document.getElementById('main-product-image');

thumbnailItems.forEach(item => {
    item.addEventListener('click', function() {
        // Remove active class from all thumbnails
        thumbnailItems.forEach(thumb => thumb.classList.remove('active'));
        
        // Add active class to clicked thumbnail
        this.classList.add('active');
        
        // Update main image
        const newImageSrc = this.getAttribute('data-image');
        mainImage.src = newImageSrc;
    });
});

// Quantity Selector
const quantityInput = document.getElementById('quantity');
const decreaseBtn = document.getElementById('decrease-qty');
const increaseBtn = document.getElementById('increase-qty');

if (decreaseBtn && increaseBtn) {
    decreaseBtn.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
        }
    });

    increaseBtn.addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value < 10) {
            quantityInput.value = value + 1;
        }
    });
}

// Add to Cart
const addToCartBtn = document.getElementById('add-to-cart');
if (addToCartBtn) {
    addToCartBtn.addEventListener('click', function() {
        const quantity = parseInt(document.getElementById('quantity').value);
        
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'toast show';
        toast.innerHTML = `
            <div class="toast-body bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                ${quantity} x ${'<?php echo addslashes($product_data['title']); ?>'} added to cart
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });
}

// Review Form Submission
document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Close modal
    const reviewModal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
    reviewModal.hide();
    
    // Show success message
    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.innerHTML = `
        <div class="toast-body bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            Thank you for your review! It will be published after moderation.
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
    
    // Reset form
    this.reset();
});

// Add to cart buttons for related products
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'toast show';
        toast.innerHTML = `
            <div class="toast-body bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                Product added to cart
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });
});
</script>

<style>
/* Product Page Styles */
.product-page {
    padding: 40px 0;
    background-color: #f8f9fa;
}

.main-image {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 15px;
    background: #fff;
    padding: 15px;
    text-align: center;
}

.thumbnail-item {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-item:hover, .thumbnail-item.active {
    border-color: #4a90e2;
}

.star-rating {
    direction: rtl;
    display: inline-block;
    unicode-bidi: bidi-override;
}

.star-rating input[type="radio"] {
    display: none;
}

.star-rating label {
    color: #ddd;
    font-size: 24px;
    padding: 0 2px;
    cursor: pointer;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input[type="radio"]:checked ~ label {
    color: #ffc107;
}

.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1100;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.toast.show {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .thumbnail-gallery {
        justify-content: center;
    }
    
    .product-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .input-group {
        width: 100% !important;
    }
    
    #add-to-cart {
        width: 100%;
    }
}
</style>
