<?php
$page_title = 'Product Details';
$page_description = 'View details about this premium digital product';

require_once 'config/config.php';
require_once 'classes/Product.php';
require_once 'classes/Database.php';

// Initialize product class
$product = new Product();

// Get product by slug
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Get product details from database
$product_data = $product->getProductBySlug($slug);

if (!$product_data) {
    header('HTTP/1.0 404 Not Found');
    include('404.php');
    exit();
}

// Sample data (replace with actual data from database)
$product_data['category_name'] = 'Mobile App Template';
$product_data['tags'] = ['iOS', 'SwiftUI', 'Social Media', 'App Template'];
$product_data['preview_url'] = 'https://example.com/preview';
$product_data['last_update'] = '2023-11-20';
$product_data['compatibility'] = 'iOS 15.0+, Xcode 14.0+';
$product_data['framework'] = 'SwiftUI';
$product_data['version'] = '2.1.0';
$product_data['file_size'] = '45.7 MB';
$product_data['demo_url'] = 'https://example.com/demo';
$product_data['documentation'] = 'https://example.com/docs';
$product_data['support'] = '6 months included';
$product_data['browser_compatibility'] = 'Chrome, Firefox, Safari, Edge';

// Features array
$features = [
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
];

// Requirements array
$requirements = [
    'Xcode 14.0+',
    'iOS 15.0+',
    'CocoaPods',
    'Firebase Account',
    'Apple Developer Account'
];

// Sample images (replace with actual product images)
$product_images = [
    'assets/images/products/ios-social-1.jpg',
    'assets/images/products/ios-social-2.jpg',
    'assets/images/products/ios-social-3.jpg',
    'assets/images/products/ios-social-4.jpg'
];

// Related products
$related_products = [
    [
        'id' => 2,
        'title' => 'Android Social App Template',
        'slug' => 'android-social-app-template',
        'price' => 89.99,
        'sale_price' => 69.99,
        'image' => 'assets/images/products/android-social-thumb.jpg',
        'rating' => 4.5,
        'review_count' => 28
    ],
    [
        'id' => 3,
        'title' => 'Flutter Dating App UI Kit',
        'slug' => 'flutter-dating-app-ui-kit',
        'price' => 79.99,
        'image' => 'assets/images/products/flutter-dating-thumb.jpg',
        'rating' => 4.7,
        'review_count' => 36
    ],
    [
        'id' => 4,
        'title' => 'React Native E-commerce App',
        'slug' => 'react-native-ecommerce-app',
        'price' => 109.99,
        'sale_price' => 89.99,
        'image' => 'assets/images/products/rn-ecommerce-thumb.jpg',
        'rating' => 4.9,
        'review_count' => 54
    ]
];

include 'includes/header.php';
?>

<!-- Product Header -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item"><a href="products.php" class="text-white-50">Products</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?php echo htmlspecialchars($product_data['title']); ?></li>
            </ol>
        </nav>
        <div class="row align-items-center mt-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-primary me-2"><?php echo htmlspecialchars($product_data['category_name']); ?></span>
                    <div class="text-warning small">
                        <?php 
                        $rating = $product_data['rating'] ?? 5;
                        $full_stars = floor($rating);
                        $half_star = $rating - $full_stars >= 0.5 ? 1 : 0;
                        $empty_stars = 5 - $full_stars - $half_star;
                        
                        echo str_repeat('<i class="fas fa-star"></i>', $full_stars);
                        echo $half_star ? '<i class="fas fa-star-half-alt"></i>' : '';
                        echo str_repeat('<i class="far fa-star"></i>', $empty_stars);
                        ?>
                        <span class="text-white-50 ms-1">(<?php echo $product_data['review_count'] ?? 0; ?> reviews)</span>
                    </div>
                </div>
                <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($product_data['title']); ?></h1>
                <p class="lead mb-4"><?php echo htmlspecialchars($product_data['short_description'] ?? $product_data['description']); ?></p>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <?php if (isset($product_data['sale_price'])): ?>
                        <span class="h3 mb-0 text-warning">$<?php echo number_format($product_data['sale_price'], 2); ?></span>
                        <span class="text-muted text-decoration-line-through">$<?php echo number_format($product_data['price'], 2); ?></span>
                        <span class="badge bg-danger">Save <?php echo round((($product_data['price'] - $product_data['sale_price']) / $product_data['price']) * 100); ?>%</span>
                    <?php else: ?>
                        <span class="h3 mb-0 text-warning">$<?php echo number_format($product_data['price'], 2); ?></span>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-2 mb-4">
                    <a href="#demo" class="btn btn-outline-light">
                        <i class="fas fa-eye me-2"></i>Live Demo
                    </a>
                    <a href="#screenshots" class="btn btn-outline-light">
                        <i class="fas fa-images me-2"></i>View Screenshots
                    </a>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#shareModal">
                        <i class="fas fa-share-alt me-2"></i>Share
                    </button>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($product_data['tags'] as $tag): ?>
                        <a href="products.php?search=<?php echo urlencode($tag); ?>" class="badge bg-dark bg-opacity-50 text-white text-decoration-none">
                            <?php echo htmlspecialchars($tag); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="position-relative" style="height: 500px;">
                    <img src="<?php echo $product_images[0]; ?>" 
                         class="position-absolute top-0 start-50 translate-middle-x img-fluid rounded-3 shadow" 
                         style="max-height: 100%; max-width: 100%; object-fit: contain;" 
                         alt="<?php echo htmlspecialchars($product_data['title']); ?>">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Content -->
<div class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Product Gallery -->
                <div class="card border-0 shadow-sm mb-4" id="screenshots">
                    <div class="card-body p-0">
                        <div class="gallery">
                            <div class="main-image p-3 text-center" style="background-color: #f8f9fa; min-height: 400px;">
                                <img src="<?php echo $product_images[0]; ?>" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px; width: auto;" 
                                     alt="<?php echo htmlspecialchars($product_data['title']); ?> Screenshot 1"
                                     id="mainImage">
                            </div>
                            <div class="gallery-thumbnails p-3 border-top d-flex overflow-auto">
                                <?php foreach ($product_images as $index => $image): ?>
                                    <img src="<?php echo $image; ?>" 
                                         class="img-thumbnail me-2" 
                                         style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;"
                                         onclick="document.getElementById('mainImage').src = this.src"
                                         alt="<?php echo htmlspecialchars($product_data['title']); ?> Thumbnail <?php echo $index + 1; ?>">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Tabs -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                    <i class="fas fa-file-alt me-2"></i>Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">
                                    <i class="fas fa-list-ul me-2"></i>Features
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                                    <i class="fas fa-info-circle me-2"></i>Specifications
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                                    <i class="fas fa-star me-2"></i>Reviews (<?php echo $product_data['review_count'] ?? 0; ?>)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates" type="button" role="tab">
                                    <i class="fas fa-sync-alt me-2"></i>Updates
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content p-4" id="productTabsContent">
                            <!-- Description Tab -->
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <h4 class="mb-4">About This Item</h4>
                                <div class="mb-4">
                                    <?php echo nl2br(htmlspecialchars($product_data['description'])); ?>
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="text-primary me-3">
                                                <i class="fas fa-mobile-alt fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="h6 mb-1">Fully Responsive</h5>
                                                <p class="small text-muted mb-0">Works perfectly on all devices and screen sizes</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="text-primary me-3">
                                                <i class="fas fa-code fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="h6 mb-1">Clean Code</h5>
                                                <p class="small text-muted mb-0">Well-documented and easy to customize</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="text-primary me-3">
                                                <i class="fas fa-headset fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="h6 mb-1">Premium Support</h5>
                                                <p class="small text-muted mb-0">Dedicated support to help you with any issues</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="text-primary me-3">
                                                <i class="fas fa-sync-alt fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="h6 mb-1">Free Updates</h5>
                                                <p class="small text-muted mb-0">Regular updates with new features and improvements</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Features Tab -->
                            <div class="tab-pane fade" id="features" role="tabpanel">
                                <h4 class="mb-4">Key Features</h4>
                                <div class="row">
                                    <?php foreach ($features as $feature): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex">
                                                <div class="text-success me-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <span><?php echo htmlspecialchars($feature); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="mt-4">
                                    <h5 class="mb-3">What's Included</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-file-code text-primary me-2"></i> Source Code (Swift/SwiftUI)</li>
                                        <li class="mb-2"><i class="fas fa-book text-primary me-2"></i> Documentation</li>
                                        <li class="mb-2"><i class="fas fa-palette text-primary me-2"></i> Customizable UI Components</li>
                                        <li class="mb-2"><i class="fas fa-server text-primary me-2"></i> Backend Integration Guide</li>
                                        <li class="mb-2"><i class="fas fa-video text-primary me-2"></i> Video Tutorials</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Specifications Tab -->
                            <div class="tab-pane fade" id="specs" role="tabpanel">
                                <h4 class="mb-4">Technical Specifications</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="w-25 bg-light">Version</th>
                                                <td><?php echo htmlspecialchars($product_data['version']); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Last Updated</th>
                                                <td><?php echo date('F j, Y', strtotime($product_data['last_update'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Compatibility</th>
                                                <td><?php echo htmlspecialchars($product_data['compatibility']); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Framework</th>
                                                <td><?php echo htmlspecialchars($product_data['framework']); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">File Size</th>
                                                <td><?php echo htmlspecialchars($product_data['file_size']); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Requirements</th>
                                                <td>
                                                    <ul class="mb-0">
                                                        <?php foreach ($requirements as $requirement): ?>
                                                            <li><?php echo htmlspecialchars($requirement); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Browser Compatibility</th>
                                                <td><?php echo htmlspecialchars($product_data['browser_compatibility']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="alert alert-info mt-4">
                                    <h5><i class="fas fa-info-circle me-2"></i>Note</h5>
                                    <p class="mb-0">This product comes with 6 months of free updates and support. Extended support is available for an additional fee.</p>
                                </div>
                            </div>
                            
                            <!-- Reviews Tab -->
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                        <div class="display-4 fw-bold text-primary"><?php echo number_format($product_data['rating'], 1); ?></div>
                                        <div class="text-warning mb-2">
                                            <?php 
                                            $rating = $product_data['rating'] ?? 5;
                                            $full_stars = floor($rating);
                                            $half_star = $rating - $full_stars >= 0.5 ? 1 : 0;
                                            $empty_stars = 5 - $full_stars - $half_star;
                                            
                                            echo str_repeat('<i class="fas fa-star"></i>', $full_stars);
                                            echo $half_star ? '<i class="fas fa-star-half-alt"></i>' : '';
                                            echo str_repeat('<i class="far fa-star"></i>', $empty_stars);
                                            ?>
                                        </div>
                                        <p class="text-muted small">Based on <?php echo $product_data['review_count'] ?? 0; ?> reviews</p>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                            <i class="far fa-edit me-1"></i>Write a Review
                                        </button>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Review Item 1 -->
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">John D.</h6>
                                                <div class="text-warning small">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                </div>
                                            </div>
                                            <p class="small text-muted mb-1">Posted on January 15, 2023</p>
                                            <h6>Amazing Template!</h6>
                                            <p class="mb-2">This template saved me so much development time. The code is clean and well-documented. Highly recommended!</p>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-secondary"><i class="far fa-thumbs-up"></i> Helpful (12)</button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="far fa-comment"></i> Comment</button>
                                            </div>
                                        </div>
                                        
                                        <!-- Review Item 2 -->
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Sarah M.</h6>
                                                <div class="text-warning small">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="small text-muted mb-1">Posted on December 5, 2022</p>
                                            <h6>Great UI/UX</h6>
                                            <p class="mb-2">The user interface is modern and intuitive. The documentation is thorough and the support team is responsive.</p>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-secondary"><i class="far fa-thumbs-up"></i> Helpful (8)</button>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="far fa-comment"></i> Comment</button>
                                            </div>
                                        </div>
                                        
                                        <!-- Load More Reviews Button -->
                                        <div class="text-center mt-4">
                                            <button class="btn btn-outline-primary">
                                                <i class="fas fa-sync-alt me-2"></i>Load More Reviews
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Updates Tab -->
                            <div class="tab-pane fade" id="updates" role="tabpanel">
                                <h4 class="mb-4">Version History</h4>
                                
                                <!-- Update Item -->
                                <div class="border-bottom pb-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Version 2.1.0</h5>
                                        <span class="badge bg-success">Latest</span>
                                    </div>
                                    <p class="text-muted small mb-2">Released on November 20, 2023</p>
                                    <h6>New Features:</h6>
                                    <ul class="mb-2">
                                        <li>Added dark mode support</li>
                                        <li>Implemented push notifications</li>
                                        <li>Added new profile customization options</li>
                                    </ul>
                                    <h6>Improvements:</h6>
                                    <ul class="mb-2">
                                        <li>Optimized image loading performance</li>
                                        <li>Improved app startup time</li>
                                        <li>Enhanced error handling</li>
                                    </ul>
                                    <h6>Bug Fixes:</h6>
                                    <ul>
                                        <li>Fixed crash on iOS 16.4</li>
                                        <li>Resolved issue with image uploads</li>
                                        <li>Fixed navigation issues in dark mode</li>
                                    </ul>
                                </div>
                                
                                <!-- Update Item -->
                                <div class="border-bottom pb-3 mb-4">
                                    <h5>Version 2.0.0</h5>
                                    <p class="text-muted small mb-2">Released on September 5, 2023</p>
                                    <h6>New Features:</h6>
                                    <ul class="mb-2">
                                        <li>Complete UI redesign with SwiftUI</li>
                                        <li>Added real-time chat functionality</li>
                                        <li>Integrated Firebase Authentication</li>
                                    </ul>
                                </div>
                                
                                <!-- Update Item -->
                                <div class="pb-3">
                                    <h5>Version 1.0.0</h5>
                                    <p class="text-muted small mb-2">Initial Release - June 15, 2023</p>
                                    <p>Initial release of the iOS Social Media App Template with basic social features and UI components.</p>
                                </div>
                                
                                <div class="alert alert-info mt-4">
                                    <h5><i class="fas fa-bell me-2"></i>Update Notifications</h5>
                                    <p class="mb-0">Subscribe to our newsletter to receive notifications about new updates and features.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Related Articles -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="mb-4">Related Articles</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <img src="https://via.placeholder.com/300x200?text=Blog+1" class="img-fluid rounded-start" alt="Blog Post">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-3">
                                                <h6 class="card-title mb-1">How to Customize the iOS Social App Template</h6>
                                                <p class="card-text small text-muted">Learn how to customize the template to match your brand identity.</p>
                                                <a href="#" class="btn btn-link p-0 text-primary small">Read More <i class="fas fa-arrow-right ms-1 small"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <img src="https://via.placeholder.com/300x200?text=Blog+2" class="img-fluid rounded-start" alt="Blog Post">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body p-3">
                                                <h6 class="card-title mb-1">Best Practices for Social Media App Development</h6>
                                                <p class="card-text small text-muted">Essential tips for building a successful social media app.</p>
                                                <a href="#" class="btn btn-link p-0 text-primary small">Read More <i class="fas fa-arrow-right ms-1 small"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Purchase Card -->
                <div class="card border-0 shadow-sm sticky-top mb-4" style="top: 20px;">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <?php if (isset($product_data['sale_price'])): ?>
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <span class="h3 mb-0 text-primary">$<?php echo number_format($product_data['sale_price'], 2); ?></span>
                                    <span class="text-muted text-decoration-line-through ms-2">$<?php echo number_format($product_data['price'], 2); ?></span>
                                    <span class="badge bg-danger ms-2">Save <?php echo round((($product_data['price'] - $product_data['sale_price']) / $product_data['price']) * 100); ?>%</span>
                                </div>
                                <p class="text-success small mb-0">Limited time offer</p>
                            <?php else: ?>
                                <div class="h3 mb-0 text-primary">$<?php echo number_format($product_data['price'], 2); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" id="addToCartBtn">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                            <button class="btn btn-outline-secondary" id="addToWishlistBtn">
                                <i class="far fa-heart me-2"></i>Add to Wishlist
                            </button>
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Version</span>
                                <span class="fw-medium"><?php echo htmlspecialchars($product_data['version']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Last Update</span>
                                <span class="fw-medium"><?php echo date('F j, Y', strtotime($product_data['last_update'])); ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Compatibility</span>
                                <span class="fw-medium"><?php echo htmlspecialchars($product_data['compatibility']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Framework</span>
                                <span class="fw-medium"><?php echo htmlspecialchars($product_data['framework']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">File Size</span>
                                <span class="fw-medium"><?php echo htmlspecialchars($product_data['file_size']); ?></span>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h6 class="mb-3">Share This Product</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-circle" data-bs-toggle="tooltip" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-info rounded-circle" data-bs-toggle="tooltip" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger rounded-circle" data-bs-toggle="tooltip" title="Share on Pinterest">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" data-bs-toggle="tooltip" title="Copy Link">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="fas fa-shield-alt me-2"></i>
                                <span>Secure Payment</span>
                            </div>
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="fas fa-sync-alt me-2"></i>
                                <span>30-Day Money Back Guarantee</span>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-headset me-2"></i>
                                <span>24/7 Customer Support</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Demo Preview -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Live Demo</h5>
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe src="<?php echo $product_data['demo_url']; ?>" allowfullscreen></iframe>
                        </div>
                        <a href="<?php echo $product_data['demo_url']; ?>" target="_blank" class="btn btn-outline-primary w-100">
                            <i class="fas fa-external-link-alt me-2"></i>View Demo
                        </a>
                    </div>
                </div>
                
                <!-- Documentation & Support -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Documentation & Support</h5>
                        <div class="list-group list-group-flush">
                            <a href="<?php echo $product_data['documentation']; ?>" target="_blank" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded me-3">
                                        <i class="fas fa-book text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Documentation</h6>
                                        <small class="text-muted">Detailed documentation and guides</small>
                                    </div>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0" data-bs-toggle="modal" data-bs-target="#supportModal">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded me-3">
                                        <i class="fas fa-headset text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Get Support</h6>
                                        <small class="text-muted">Contact our support team</small>
                                    </div>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded me-3">
                                        <i class="fas fa-question-circle text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">FAQs</h6>
                                        <small class="text-muted">Frequently asked questions</small>
                                    </div>
                                    <i class="fas fa-chevron-right ms-auto text-muted"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Tags -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tags</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($product_data['tags'] as $tag): ?>
                                <a href="products.php?search=<?php echo urlencode($tag); ?>" class="badge bg-light text-dark text-decoration-none border">
                                    <?php echo htmlspecialchars($tag); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">You May Also Like</h3>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <?php foreach ($related_products as $related): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    <img src="<?php echo $related['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related['title']); ?>">
                                    <?php if (isset($related['sale_price'])): ?>
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                    <?php endif; ?>
                                    <div class="card-img-overlay d-flex align-items-end p-0">
                                        <div class="w-100 bg-dark bg-opacity-75 text-white p-3">
                                            <h5 class="card-title mb-1"><?php echo htmlspecialchars($related['title']); ?></h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-warning">
                                                    <?php 
                                                    $rating = $related['rating'];
                                                    $full_stars = floor($rating);
                                                    $half_star = $rating - $full_stars >= 0.5 ? 1 : 0;
                                                    $empty_stars = 5 - $full_stars - $half_star;
                                                    
                                                    echo str_repeat('<i class="fas fa-star"></i>', $full_stars);
                                                    echo $half_star ? '<i class="fas fa-star-half-alt"></i>' : '';
                                                    echo str_repeat('<i class="far fa-star"></i>', $empty_stars);
                                                    ?>
                                                    <small class="ms-1">(<?php echo $related['review_count']; ?>)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price">
                                            <?php if (isset($related['sale_price'])): ?>
                                                <span class="text-muted text-decoration-line-through me-2">$<?php echo number_format($related['price'], 2); ?></span>
                                                <span class="h5 mb-0 text-primary">$<?php echo number_format($related['sale_price'], 2); ?></span>
                                            <?php else: ?>
                                                <span class="h5 mb-0 text-primary">$<?php echo number_format($related['price'], 2); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="product.php?slug=<?php echo $related['slug']; ?>" class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating-input mb-3">
                            <input type="radio" id="star5" name="rating" value="5" class="d-none">
                            <label for="star5" class="star"><i class="far fa-star"></i></label>
                            
                            <input type="radio" id="star4" name="rating" value="4" class="d-none">
                            <label for="star4" class="star"><i class="far fa-star"></i></label>
                            
                            <input type="radio" id="star3" name="rating" value="3" class="d-none" checked>
                            <label for="star3" class="star"><i class="far fa-star"></i></label>
                            
                            <input type="radio" id="star2" name="rating" value="2" class="d-none">
                            <label for="star2" class="star"><i class="far fa-star"></i></label>
                            
                            <input type="radio" id="star1" name="rating" value="1" class="d-none">
                            <label for="star1" class="star"><i class="far fa-star"></i></label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reviewTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="reviewTitle" placeholder="Summarize your opinion" required>
                    </div>
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Your Review</label>
                        <textarea class="form-control" id="reviewText" rows="5" placeholder="Share your experience with this product" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="recommendProduct" checked>
                        <label class="form-check-label" for="recommendProduct">
                            I recommend this product
                        </label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Support Modal -->
<div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportModalLabel">Get Support</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supportForm">
                    <div class="mb-3">
                        <label for="supportSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="supportSubject" placeholder="How can we help you?" required>
                    </div>
                    <div class="mb-3">
                        <label for="supportMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="supportMessage" rows="5" placeholder="Please describe your issue in detail" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="supportEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="supportEmail" placeholder="your@email.com" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share This Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="<?php echo $product_images[0]; ?>" class="img-thumbnail mb-3" style="max-height: 100px;" alt="<?php echo htmlspecialchars($product_data['title']); ?>">
                    <h6 class="mb-0"><?php echo htmlspecialchars($product_data['title']); ?></h6>
                </div>
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="#" class="btn btn-primary rounded-circle" style="width: 50px; height: 50px; line-height: 50px;" data-bs-toggle="tooltip" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-info text-white rounded-circle" style="width: 50px; height: 50px; line-height: 50px;" data-bs-toggle="tooltip" title="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-danger rounded-circle" style="width: 50px; height: 50px; line-height: 50px;" data-bs-toggle="tooltip" title="Share on Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <a href="#" class="btn btn-success rounded-circle" style="width: 50px; height: 50px; line-height: 50px;" data-bs-toggle="tooltip" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="btn btn-secondary rounded-circle" style="width: 50px; height: 50px; line-height: 50px;" data-bs-toggle="tooltip" title="Copy Link" id="copyLinkBtn">
                        <i class="fas fa-link"></i>
                    </a>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="shareableLink" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="copyLinkBtn2">
                        <i class="far fa-copy"></i>
                    </button>
                </div>
                <div class="text-center mt-2">
                    <small class="text-muted">Or share via email</small>
                </div>
                <form class="mt-3">
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Enter email addresses (comma separated)">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" placeholder="Add a message (optional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styles for the product page */
.star {
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.star:hover,
.star:hover ~ .star,
.rating-input input:checked ~ .star {
    color: #ffc107;
}

.rating-input input:checked ~ .star {
    color: #ffc107;
}

.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-input input {
    display: none;
}

.rating-input label {
    cursor: pointer;
    padding: 0 2px;
}

.rating-input label:hover,
.rating-input label:hover ~ label,
.rating-input input:checked ~ label {
    color: #ffc107;
}

/* Gallery image hover effect */
.gallery-thumbnails img {
    transition: all 0.3s ease;
    opacity: 0.7;
}

.gallery-thumbnails img:hover,
.gallery-thumbnails img.active {
    opacity: 1;
    border-color: #0d6efd !important;
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Animation for price */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.price-animation {
    animation: pulse 1s infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .gallery-thumbnails {
        justify-content: center;
    }
    
    .gallery-thumbnails img {
        width: 60px;
        height: 45px;
    }
    
    .main-image {
        min-height: 300px !important;
    }
    
    .main-image img {
        max-height: 280px !important;
    }
}

/* Print styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        padding: 20px;
        font-size: 12px;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Copy link functionality
document.getElementById('copyLinkBtn').addEventListener('click', function(e) {
    e.preventDefault();
    copyToClipboard(document.getElementById('shareableLink').value);
    showToast('Link copied to clipboard!');
});

document.getElementById('copyLinkBtn2').addEventListener('click', function() {
    copyToClipboard(document.getElementById('shareableLink').value);
    showToast('Link copied to clipboard!');
});

function copyToClipboard(text) {
    var textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
}

function showToast(message) {
    // Create toast element
    var toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-success text-white rounded-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = message;
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(function() {
        toast.remove();
    }, 3000);
}

// Add to cart functionality
document.getElementById('addToCartBtn').addEventListener('click', function() {
    // Here you would typically make an AJAX call to add the product to cart
    var productId = <?php echo $product_data['id']; ?>;
    var quantity = 1; // Default quantity
    
    // Show success message
    showToast('Product added to cart!');
    
    // Update cart count in the header (if you have one)
    updateCartCount(1);
    
    // Add animation to the button
    this.classList.add('add-to-cart-animation');
    setTimeout(() => {
        this.classList.remove('add-to-cart-animation');
    }, 1000);
});

// Add to wishlist functionality
document.getElementById('addToWishlistBtn').addEventListener('click', function() {
    // Here you would typically make an AJAX call to add the product to wishlist
    var productId = <?php echo $product_data['id']; ?>;
    
    // Toggle button state
    var icon = this.querySelector('i');
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas', 'text-danger');
        showToast('Added to wishlist!');
    } else {
        icon.classList.remove('fas', 'text-danger');
        icon.classList.add('far');
        showToast('Removed from wishlist');
    }
});

// Function to update cart count (if you have a cart count element)
function updateCartCount(change) {
    var cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        var currentCount = parseInt(cartCount.textContent) || 0;
        cartCount.textContent = currentCount + change;
        cartCount.classList.add('cart-count-updated');
        setTimeout(function() {
            cartCount.classList.remove('cart-count-updated');
        }, 1000);
    }
}

// Image gallery functionality
document.querySelectorAll('.gallery-thumbnails img').forEach(thumb => {
    thumb.addEventListener('click', function() {
        // Update main image
        document.getElementById('mainImage').src = this.src;
        
        // Update active thumbnail
        document.querySelectorAll('.gallery-thumbnails img').forEach(img => {
            img.classList.remove('active', 'border-primary');
        });
        this.classList.add('active', 'border-primary');
    });
});

// Review form submission
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Here you would typically submit the review via AJAX
    var rating = document.querySelector('input[name="rating"]:checked').value;
    var title = document.getElementById('reviewTitle').value;
    var review = document.getElementById('reviewText').value;
    
    // Show success message
    showToast('Thank you for your review!');
    
    // Close the modal
    var modal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
    modal.hide();
    
    // Reset the form
    this.reset();
});

// Support form submission
document.getElementById('supportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Here you would typically submit the support request via AJAX
    var subject = document.getElementById('supportSubject').value;
    var message = document.getElementById('supportMessage').value;
    var email = document.getElementById('supportEmail').value;
    
    // Show success message
    showToast('Your support request has been submitted!');
    
    // Close the modal
    var modal = bootstrap.Modal.getInstance(document.getElementById('supportModal'));
    modal.hide();
    
    // Reset the form
    this.reset();
});

// Animation for price when page loads
window.addEventListener('load', function() {
    var priceElement = document.querySelector('.price');
    if (priceElement) {
        priceElement.classList.add('price-animation');
        setTimeout(function() {
            priceElement.classList.remove('price-animation');
        }, 2000);
    }
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
