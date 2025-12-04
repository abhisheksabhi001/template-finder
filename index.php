Parse error: syntax error, unexpected token "endforeach" in C:\xampp\htdocs\AA DIGITS\index.php on line 277
<?php
$page_title = 'AA DIGITS - Premium Digital Products Marketplace';
$page_description = 'Discover and download premium digital products, templates, and resources for your next project. High-quality assets for designers, developers, and creators.';
?>
<style>
:root {
    --primary-color: #7c3aed !important;
    --primary-dark: #6d28d9 !important;
    --secondary-color: #14b8a6 !important;
    --accent-color: #f97316 !important;
    --success-color: #22c55e !important;
    --error-color: #ef4444 !important;
    --warning-color: #f59e0b !important;
    --bg-primary: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
    --bg-secondary: #f3e8ff !important;
    --bg-tertiary: #6c0ad5ff !important;
    --bg-card: #ffffff !important;
    --text-primary: #1f2937 !important;
    --text-secondary: #6b7280 !important;
    --text-muted: #9ca3af !important;
    --text-inverse: #faf5ff !important;
    --border-color: #e9d5ff !important;
    --border-light: #f3e8ff !important;
}

/* Body background with blue-purple gradient */
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #7c3aed 75%, #6d28d9 100%) !important;
    min-height: 100vh;
}

/* Hero section with enhanced gradient */
.hero-section {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 25%, rgba(240, 147, 251, 0.9) 50%, rgba(124, 58, 237, 0.9) 75%, rgba(109, 40, 217, 0.9) 100%) !important;
}

/* Dark Mode Styles */
.dark-mode {
    --primary-color: #a78bfa !important;
    --primary-dark: #8b5cf6 !important;
    --secondary-color: #22d3ee !important;
    --accent-color: #fb923c !important;
    --success-color: #34d399 !important;
    --error-color: #f87171 !important;
    --warning-color: #fbbf24 !important;
    --bg-primary: #1f2937 !important;
    --bg-secondary: #111827 !important;
    --bg-tertiary: #374151 !important;
    --bg-card: #1f2937 !important;
    --text-primary: #f9fafb !important;
    --text-secondary: #d1d5db !important;
    --text-muted: #9ca3af !important;
    --text-inverse: #1f2937 !important;
    --border-color: #374151 !important;
    --border-light: #4b5563 !important;
}

.dark-mode body {
    background: linear-gradient(135deg, #1f2937 0%, #111827 25%, #374151 50%, #1f2937 75%, #111827 100%) !important;
}

.dark-mode .hero-section {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(17, 24, 39, 0.95) 25%, rgba(55, 65, 81, 0.95) 50%, rgba(31, 41, 55, 0.95) 75%, rgba(17, 24, 39, 0.95) 100%) !important;
}

.dark-mode .card {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%) !important;
    border: 1px solid #4b5563 !important;
}

.dark-mode .product-card {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%) !important;
    border: 1px solid #4b5563 !important;
}

.dark-mode .filter-btn {
    background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important;
    border: 2px solid #6b7280 !important;
    color: #d1d5db !important;
}

.dark-mode .filter-btn:hover {
    border-color: #a78bfa !important;
    color: #a78bfa !important;
}

.dark-mode .filter-btn.active {
    background: #8b5cf6 !important;
    border-color: #8b5cf6 !important;
    color: #ffffff !important;
}

.dark-mode .template-card {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%) !important;
    border: 1px solid #4b5563 !important;
}

.dark-mode .bg-gradient-light {
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.1) 0%, rgba(17, 24, 39, 0.1) 25%, rgba(55, 65, 81, 0.1) 50%, rgba(31, 41, 55, 0.1) 75%, rgba(17, 24, 39, 0.1) 100%) !important;
}
</style>
<?php
require_once 'config/config.php';
require_once 'classes/Product.php';
require_once 'classes/Category.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes with database connection
$product = new Product($db);
$category = new Category($db);

// Get data with error handling
$featured_products = [];
$latest_products = [];
$categories = [];
$popular_products = [];

try {
    $featured_products = $product->getFeaturedProducts(6);
    $latest_products = $product->getAllProducts(8, 0);
    $categories = $category->getAllCategories();
    $popular_products = $product->getPopularProducts(4);
} catch (Exception $e) {
    error_log('Error loading products: ' . $e->getMessage());
}

// Sample testimonials data (replace with database call if available)
$testimonials = [
    [
        'name' => 'Sarah Johnson',
        'role' => 'UI/UX Designer',
        'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
        'content' => 'The quality of templates here is outstanding. It saved me countless hours of work!',
        'rating' => 5
    ],
    [
        'name' => 'Michael Chen',
        'role' => 'Web Developer',
        'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
        'content' => 'Great selection of digital products with excellent support. Highly recommended!',
        'rating' => 5
    ],
    [
        'name' => 'Emma Davis',
        'role' => 'Marketing Manager',
        'avatar' => 'https://randomuser.me/api/portraits/women/68.jpg',
        'content' => 'Found the perfect template for our campaign. The customization was a breeze!',
        'rating' => 4
    ]
];

include 'includes/header.php';
?>

<!-- Hero Section with Animated Background -->
<section class="hero-section">
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 hero-content" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Create Amazing Designs <span class="text-gradient">Without Limits</span></h1>
                <p class="lead mb-5">Access thousands of premium templates, graphics, and design assets to bring your ideas to life. No design skills needed!</p>
                
                <div class="d-flex flex-wrap gap-3">
                    <a href="products.php" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-rocket me-2"></i> Start Creating Free
                    </a>
                    <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-play-circle me-2"></i> Watch Demo
                    </a>
                </div>
                
                <div class="d-flex align-items-center mt-4">
                    <div class="avatar-group me-3">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="avatar" alt="User">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="avatar" alt="User">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="avatar" alt="User">
                        <div class="avatar-more">+2.5K</div>
                    </div>
                    <div class="text-white-50">Trusted by 50,000+ creators worldwide</div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                <div class="hero-image-wrapper">
                    <img src="https://via.placeholder.com/800x600/6c757d/ffffff?text=Hero+Image" alt="Hero" class="img-fluid rounded-4 shadow-lg">
                    <div class="floating-badge bg-primary">
                        <i class="fas fa-bolt me-1"></i> New Templates Added
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 50L60 41.7C120 33.3 240 16.7 360 25C480 33.3 600 66.7 720 75C840 83.3 960 66.7 1080 58.3C1200 50 1320 50 1380 50H1440V0H1380C1320 0 1200 0 1080 0C960 0 840 0 720 0C600 0 480 0 360 0C240 0 120 0 60 0H0V50Z" fill="#fff"/>
        </svg>
    </div>
</section>

<!-- Search Section -->
<section class="search-section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-body p-4">
                        <h2 class="h4 text-center mb-4">Find the perfect template for your next project</h2>
                        
                        <form id="main-search-form" action="products.php" method="GET" class="position-relative">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-0" 
                                       name="search" 
                                       id="main-search" 
                                       placeholder="Search for templates, graphics, themes..." 
                                       autocomplete="off"
                                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="fas fa-arrow-right me-1"></i> Search
                                </button>
                            </div>
                            <div id="search-suggestions" class="search-suggestions dropdown-menu w-100"></div>
                        </form>
                        
                        <div class="popular-searches mt-3 text-center">
                            <span class="text-muted me-2">Trending:</span>
                            <a href="products.php?search=website+template" class="badge bg-light text-dark text-decoration-none me-2 mb-2">
                                <i class="fas fa-laptop-code me-1"></i> Website Templates
                            </a>
                            <a href="products.php?search=social+media" class="badge bg-light text-dark text-decoration-none me-2 mb-2">
                                <i class="fas fa-hashtag me-1"></i> Social Media
                            </a>
                            <a href="products.php?search=presentation" class="badge bg-light text-dark text-decoration-none me-2 mb-2">
                                <i class="fas fa-presentation me-1"></i> Presentations
                            </a>
                            <a href="products.php?search=logo" class="badge bg-light text-dark text-decoration-none me-2 mb-2">
                                <i class="fas fa-palette me-1"></i> Logo Design
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Template Showcase - Canva Style -->
<section id="template-showcase" class="py-5 bg-gradient-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-3">Template Gallery</span>
            <h1 class="display-5 fw-bold mb-3">Professional Website Templates</h1>
            <p class="lead text-muted">Choose from thousands of stunning templates designed by professionals</p>
        </div>
        
        <!-- Template Categories Filter -->
        <div class="template-filters mb-5" data-aos="fade-up">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-th me-2"></i>All Templates
                </button>
                <button class="filter-btn" data-filter="business">
                    <i class="fas fa-briefcase me-2"></i>Business
                </button>
                <button class="filter-btn" data-filter="portfolio">
                    <i class="fas fa-user me-2"></i>Portfolio
                </button>
                <button class="filter-btn" data-filter="blog">
                    <i class="fas fa-blog me-2"></i>Blog
                </button>
                <button class="filter-btn" data-filter="ecommerce">
                    <i class="fas fa-shopping-cart me-2"></i>E-commerce
                </button>
                <button class="filter-btn" data-filter="restaurant">
                    <i class="fas fa-utensils me-2"></i>Restaurant
                </button>
                <button class="filter-btn" data-filter="creative">
                    <i class="fas fa-palette me-2"></i>Creative
                </button>
            </div>
        </div>
        
        <!-- Template Grid -->
        <div class="template-grid" data-aos="fade-up">
            <?php 
            // Sample template data - replace with database query
            $templates = [
                [
                    'id' => 1,
                    'title' => 'Modern Business',
                    'category' => 'business',
                    'image' => 'https://picsum.photos/seed/business1/400/300',
                    'price' => 29.99,
                    'rating' => 4.8,
                    'downloads' => 1234,
                    'description' => 'Professional business website template with modern design'
                ],
                [
                    'id' => 2,
                    'title' => 'Creative Portfolio',
                    'category' => 'portfolio',
                    'image' => 'https://picsum.photos/seed/portfolio1/400/300',
                    'price' => 24.99,
                    'rating' => 4.9,
                    'downloads' => 987,
                    'description' => 'Stunning portfolio template for creative professionals'
                ],
                [
                    'id' => 3,
                    'title' => 'E-commerce Pro',
                    'category' => 'ecommerce',
                    'image' => 'https://picsum.photos/seed/ecommerce1/400/300',
                    'price' => 39.99,
                    'rating' => 4.7,
                    'downloads' => 2341,
                    'description' => 'Complete e-commerce solution with shopping cart'
                ],
                [
                    'id' => 4,
                    'title' => 'Restaurant Menu',
                    'category' => 'restaurant',
                    'image' => 'https://picsum.photos/seed/restaurant1/400/300',
                    'price' => 19.99,
                    'rating' => 4.6,
                    'downloads' => 654,
                    'description' => 'Elegant restaurant website with online ordering'
                ],
                [
                    'id' => 5,
                    'title' => 'Personal Blog',
                    'category' => 'blog',
                    'image' => 'https://picsum.photos/seed/blog1/400/300',
                    'price' => 14.99,
                    'rating' => 4.8,
                    'downloads' => 1876,
                    'description' => 'Clean and modern blog template for writers'
                ],
                [
                    'id' => 6,
                    'title' => 'Creative Agency',
                    'category' => 'creative',
                    'image' => 'https://picsum.photos/seed/creative1/400/300',
                    'price' => 34.99,
                    'rating' => 4.9,
                    'downloads' => 1543,
                    'description' => 'Bold and creative agency website template'
                ]
            ];
            
            foreach ($templates as $template):
            ?>
            <div class="template-item" data-category="<?php echo $template['category']; ?>">
                <div class="template-card">
                    <div class="template-preview">
                        <img src="<?php echo $template['image']; ?>" alt="<?php echo $template['title']; ?>" loading="lazy">
                        <div class="template-overlay">
                            <div class="template-actions">
                                <button class="btn btn-primary preview-btn" data-id="<?php echo $template['id']; ?>">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button class="btn btn-outline-light use-template-btn" data-id="<?php echo $template['id']; ?>">
                                    <i class="fas fa-edit me-2"></i>Use Template
                                </button>
                            </div>
                        </div>
                        <?php if ($template['category'] === 'business' || $template['category'] === 'ecommerce'): ?>
                            <span class="template-badge popular">
                                <i class="fas fa-fire me-1"></i>Popular
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="template-info">
                        <h4 class="template-title"><?php echo $template['title']; ?></h4>
                        <p class="template-description"><?php echo $template['description']; ?></p>
                        <div class="template-meta">
                            <div class="template-rating">
                                <i class="fas fa-star text-warning"></i>
                                <span><?php echo $template['rating']; ?></span>
                                <small>(<?php echo $template['downloads']; ?> uses)</small>
                            </div>
                            <div class="template-price">
                                ₹<?php echo number_format($template['price'], 2); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-primary btn-lg load-more-btn">
                <i class="fas fa-plus-circle me-2"></i>Load More Templates
            </button>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="section-header slide-up">
            <h2 class="section-title">Browse Categories</h2>
            <p class="section-subtitle">Find exactly what you need in our organized categories</p>
        </div>
        
        <div class="grid grid-cols-2 grid-md-3 grid-lg-6 slide-up">
            <a href="products.php?category=web-templates" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h4>Web Templates</h4>
                <p>Professional website templates</p>
            </a>
            
            <a href="products.php?category=mobile-apps" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Mobile Apps</h4>
                <p>iOS & Android app templates</p>
            </a>
            
            <a href="products.php?category=graphics-design" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h4>Graphics & Design</h4>
                <p>Logos, icons, and graphics</p>
            </a>
            
            <a href="products.php?category=software-tools" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h4>Software Tools</h4>
                <p>Utility and development tools</p>
            </a>
            
            <a href="products.php?category=ebooks" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h4>E-books</h4>
                <p>Digital books and guides</p>
            </a>
            
            <a href="products.php?category=audio-music" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-music"></i>
                </div>
                <h4>Audio & Music</h4>
                <p>Sound effects and music</p>
            </a>
        </div>
    </div>
</section>

<!-- Latest Products -->
<?php if (!empty($latest_products)): ?>
<section class="section">
    <div class="container">
        <div class="section-header slide-up">
            <h2 class="section-title">Latest Products</h2>
            <p class="section-subtitle">Fresh additions to our digital marketplace</p>
        </div>
        
        <div class="grid grid-cols-1 grid-md-2 grid-lg-4 slide-up">
            <?php foreach (array_slice($latest_products, 0, 8) as $product_item): ?>
                <div class="product-card">
                    <div class="product-card-image">
                        <?php
                        $screenshots = json_decode($product_item['screenshots'], true);
                        $image_url = !empty($screenshots) ? $screenshots[0] : 'assets/images/placeholder-product.jpg';
                        ?>
                        <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($product_item['title']); ?>" loading="lazy">
                        <div class="product-card-badge new">New</div>
                    </div>
                    
                    <div class="product-card-content">
                        <h3 class="product-card-title">
                            <a href="product.php?slug=<?php echo $product_item['slug']; ?>">
                                <?php echo htmlspecialchars($product_item['title']); ?>
                            </a>
                        </h3>
                        
                        <div class="product-card-price">
                            <div class="price-info">
                                <?php if ($product_item['sale_price'] && $product_item['sale_price'] < $product_item['price']): ?>
                                    <span class="price-current"><?php echo format_price($product_item['sale_price']); ?></span>
                                    <span class="price-original"><?php echo format_price($product_item['price']); ?></span>
                                <?php else: ?>
                                    <span class="price-current"><?php echo format_price($product_item['price']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="product-card-actions">
                            <button class="btn btn-primary btn-sm btn-full add-to-cart" data-product-id="<?php echo $product_item['id']; ?>">
                                <i class="fas fa-cart-plus"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-outline btn-lg">
                View All Products
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Features Section -->
<section class="section" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="section-header slide-up">
            <h2 class="section-title">Why Choose AA DIGITS?</h2>
            <p class="section-subtitle">We provide the best digital products with exceptional service</p>
        </div>
        
        <div class="grid grid-cols-1 grid-md-2 grid-lg-4 slide-up">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Secure Downloads</h4>
                <p>All products are scanned and verified for security before being made available.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-download"></i>
                </div>
                <h4>Instant Access</h4>
                <p>Download your purchases immediately after successful payment completion.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h4>24/7 Support</h4>
                <p>Our dedicated support team is available around the clock to help you.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h4>Money Back Guarantee</h4>
                <p>Not satisfied? Get a full refund within 30 days of your purchase.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section">
    <div class="container">
        <div class="section-header slide-up">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Join thousands of satisfied customers worldwide</p>
        </div>
        
        <div class="grid grid-cols-1 grid-md-2 grid-lg-3 slide-up">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Amazing quality products and excellent customer service. The website templates saved me weeks of development time!"</p>
                </div>
                <div class="testimonial-author">
                    <img src="assets/images/testimonial-1.jpg" alt="Sarah Johnson" loading="lazy">
                    <div>
                        <h5>Sarah Johnson</h5>
                        <span>Web Developer</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"The mobile app templates are top-notch. Clean code, great documentation, and responsive design. Highly recommended!"</p>
                </div>
                <div class="testimonial-author">
                    <img src="assets/images/testimonial-2.jpg" alt="Mike Chen" loading="lazy">
                    <div>
                        <h5>Mike Chen</h5>
                        <span>App Developer</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p>"Fast downloads, secure payments, and great variety of products. AA DIGITS is my go-to marketplace for digital assets."</p>
                </div>
                <div class="testimonial-author">
                    <img src="assets/images/testimonial-3.jpg" alt="Emily Davis" loading="lazy">
                    <div>
                        <h5>Emily Davis</h5>
                        <span>Graphic Designer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Actions */
.hero-actions {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
    flex-wrap: wrap;
    margin-top: var(--spacing-xl);
}

/* Search Section */
.search-section {
    background: var(--bg-card);
    padding: var(--spacing-xl);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border-color);
    margin-bottom: var(--spacing-xl);
}

.search-form {
    margin-bottom: var(--spacing-lg);
}

.search-bar {
    display: flex;
    gap: var(--spacing-md);
    align-items: center;
    flex-wrap: wrap;
}

.search-bar .form-control {
    flex: 1;
    min-width: 250px;
}

.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-top: none;
    border-radius: 0 0 var(--radius-md) var(--radius-md);
    box-shadow: var(--shadow-lg);
    z-index: 100;
    max-height: 300px;
    overflow-y: auto;
}

.suggestion-item {
    display: flex;
    align-items: center;
    padding: var(--spacing-md);
    cursor: pointer;
    transition: background-color var(--transition-fast);
    gap: var(--spacing-sm);
}

.suggestion-item:hover {
    background: var(--bg-tertiary);
}

.popular-searches {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    flex-wrap: wrap;
}

.popular-searches span {
    color: var(--text-secondary);
    font-weight: 500;
}

.search-tag {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    padding: var(--spacing-xs) var(--spacing-md);
    border-radius: var(--radius-md);
    text-decoration: none;
    font-size: 0.875rem;
    transition: all var(--transition-fast);
}

.search-tag:hover {
    background: var(--primary-color);
    color: white;
}

/* Category Cards */
.category-card {
    background: var(--bg-card);
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    text-align: center;
    text-decoration: none;
    color: var(--text-primary);
    transition: all var(--transition-normal);
    border: 1px solid var(--border-color);
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-color);
}

.category-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--spacing-md);
    font-size: 1.5rem;
    color: white;
}

.category-card h4 {
    margin-bottom: var(--spacing-sm);
    font-size: 1.125rem;
}

.category-card p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

/* Feature Cards */
.feature-card {
    background: var(--bg-card);
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    text-align: center;
    border: 1px solid var(--border-color);
    transition: all var(--transition-normal);
}

.feature-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--accent-color), #f59e0b);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--spacing-md);
    font-size: 1.5rem;
    color: white;
}

.feature-card h4 {
    margin-bottom: var(--spacing-sm);
    font-size: 1.125rem;
}

.feature-card p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.6;
}

/* Testimonial Cards */
.testimonial-card {
    background: var(--bg-card);
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    transition: all var(--transition-normal);
}

.testimonial-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.testimonial-content {
    margin-bottom: var(--spacing-lg);
}

.testimonial-content .stars {
    color: var(--accent-color);
    margin-bottom: var(--spacing-md);
}

.testimonial-content p {
    font-style: italic;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.testimonial-author img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-author h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.testimonial-author span {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Template Showcase Styles - Canva Inspired */
.bg-gradient-light {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 25%, rgba(240, 147, 251, 0.1) 50%, rgba(124, 58, 237, 0.1) 75%, rgba(109, 40, 217, 0.1) 100%) !important;
    backdrop-filter: blur(10px);
}

.template-filters {
    margin-bottom: 2rem;
}

.filter-btn {
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    border: 2px solid #e9d5ff;
    border-radius: 50px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    color: #6d28d9;
    cursor: pointer;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.filter-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: #fff;
}

.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.template-item {
    animation: fadeInUp 0.5s ease;
}

.template-card {
    background: linear-gradient(135deg, #ffffff 0%, #faf5ff 100%);
    border: 1px solid #e9d5ff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(124, 58, 237, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.template-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

.template-preview {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.template-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.template-card:hover .template-preview img {
    transform: scale(1.05);
}

.template-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 1.5rem;
}

.template-card:hover .template-overlay {
    opacity: 1;
}

.template-actions {
    display: flex;
    gap: 1rem;
    width: 100%;
}

.template-actions .btn {
    flex: 1;
    border-radius: 8px;
    font-weight: 500;
}

.template-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--primary-color);
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.template-badge.popular {
    background: linear-gradient(135deg, #ff6b6b, #ff8e53);
}

.template-info {
    padding: 1.5rem;
}

.template-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.template-description {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.template-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.template-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.template-rating i {
    color: #ffa500;
}

.template-rating small {
    color: #999;
}

.template-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

.load-more-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    border-radius: 50px;
    padding: 1rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.load-more-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile Responsive */
@media (max-width: 767px) {
    .template-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .template-filters {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: 1rem;
    }
    
    .filter-btn {
        white-space: nowrap;
        margin-right: 0.5rem;
    }
    
    .template-actions {
        flex-direction: column;
    }
    
    .template-actions .btn {
        width: 100%;
    }
}

/* Product Rating */
.product-rating {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.stars {
    color: var(--accent-color);
    font-size: 0.875rem;
}

.rating-count {
    color: var(--text-muted);
    font-size: 0.75rem;
}

/* Badge Variations */
.product-card-badge.new {
    background: var(--success-color);
}

/* Mobile Responsive */
@media (max-width: 767px) {
    .hero h1 {
        font-size: 2rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-actions .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .search-bar {
        flex-direction: column;
    }
    
    .search-bar .form-control,
    .search-bar .btn {
        width: 100%;
    }
    
    .popular-searches {
        justify-content: center;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
