<?php
$page_title = 'App Templates';
$page_description = 'Browse our collection of premium app templates for your next project';

require_once 'config/config.php';
require_once 'classes/Product.php';
require_once 'classes/Category.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes
$product = new Product($db);
$category = new Category($db);

// Get filter parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';
$price_filter = isset($_GET['price']) ? $_GET['price'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';

// Get categories for filter
$categories = $category->getAllCategories();

// Sample app templates data (in a real app, this would come from the database)
$app_templates = [
    [
        'id' => 1,
        'title' => 'Social Network App',
        'slug' => 'social-network-app',
        'description' => 'A complete social media app template with user profiles, news feed, and messaging.',
        'category' => 'social',
        'price' => 129.99,
        'sale_price' => 99.99,
        'rating' => 4.8,
        'review_count' => 124,
        'downloads' => 845,
        'screens' => 24,
        'features' => ['User Profiles', 'News Feed', 'Messaging', 'Notifications', 'Dark Mode'],
        'preview_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'images' => [
            'https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1611605698335-8b1569810432?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        'tags' => ['ios', 'android', 'react native', 'firebase']
    ],
    [
        'id' => 2,
        'title' => 'E-commerce App',
        'slug' => 'ecommerce-app',
        'description' => 'Feature-rich e-commerce app with product catalog, cart, and payment integration.',
        'category' => 'ecommerce',
        'price' => 149.99,
        'sale_price' => 119.99,
        'rating' => 4.9,
        'review_count' => 98,
        'downloads' => 721,
        'screens' => 32,
        'features' => ['Product Catalog', 'Shopping Cart', 'Payment Gateway', 'Order Tracking', 'Wishlist'],
        'preview_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'images' => [
            'https://images.unsplash.com/photo-1601784551446-9e3c36667cfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1555529669-fd14bfb4c8c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        'tags' => ['ios', 'android', 'flutter', 'nodejs']
    ],
    // Add more templates...
    [
        'id' => 3,
        'title' => 'Fitness Tracker',
        'slug' => 'fitness-tracker',
        'description' => 'Comprehensive fitness tracking app with workout plans and progress analytics.',
        'category' => 'health',
        'price' => 109.99,
        'sale_price' => 89.99,
        'rating' => 4.7,
        'review_count' => 156,
        'downloads' => 932,
        'screens' => 28,
        'features' => ['Workout Plans', 'Activity Tracking', 'Progress Analytics', 'Meal Planner', 'Challenges'],
        'preview_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'images' => [
            'https://images.unsplash.com/photo-1571019614242-c5c5dee9f725?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1571019614283-ffc1834a33b1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        'tags' => ['ios', 'android', 'react native', 'firebase']
    ],
    [
        'id' => 4,
        'title' => 'Food Delivery',
        'slug' => 'food-delivery',
        'description' => 'Complete food delivery solution with restaurant listings and real-time tracking.',
        'category' => 'food',
        'price' => 139.99,
        'sale_price' => 109.99,
        'rating' => 4.6,
        'review_count' => 87,
        'downloads' => 654,
        'screens' => 26,
        'features' => ['Restaurant Listings', 'Menu Management', 'Order Tracking', 'Payment Gateway', 'Reviews & Ratings'],
        'preview_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'images' => [
            'https://images.unsplash.com/photo-1504674900247-087703934569?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1504674900248-962ebb870736?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1504674900248-962ebb870736?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        'tags' => ['ios', 'android', 'flutter', 'nodejs']
    ],
    [
        'id' => 5,
        'title' => 'Travel Booking',
        'slug' => 'travel-booking',
        'description' => 'All-in-one travel booking app with hotel, flight, and activity reservations.',
        'category' => 'travel',
        'price' => 159.99,
        'sale_price' => 129.99,
        'rating' => 4.9,
        'review_count' => 203,
        'downloads' => 1124,
        'screens' => 35,
        'features' => ['Hotel Booking', 'Flight Search', 'Itinerary Planner', 'Reviews', 'Offline Access'],
        'preview_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'images' => [
            'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        'tags' => ['ios', 'android', 'react native', 'nodejs']
    ],
    [
        'id' => 6,
        'title' => 'E-learning Platform',
        'slug' => 'elearning-platform',
        'description' => 'Interactive e-learning platform with courses, quizzes, and progress tracking.',
        'category' => 'education',
        'price' => 129.99,
        'sale_price' => 99.99,
        'rating' => 4.7,
        'review_count' => 145,
        'downloads' => 876,
        'screens' => 30,
        'features' => ['Course Catalog', 'Video Lessons', 'Quizzes', 'Progress Tracking', 'Certificates'],
        'preview_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'images' => [
            'https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        'tags' => ['ios', 'android', 'flutter', 'firebase']
    ]
];

// Filter templates based on search and category
$filtered_templates = array_filter($app_templates, function($template) use ($search, $category_filter) {
    $matches_search = empty($search) || 
                     stripos($template['title'], $search) !== false || 
                     stripos($template['description'], $search) !== false;
    
    $matches_category = $category_filter === 'all' || $template['category'] === $category_filter;
    
    return $matches_search && $matches_category;
});

// Sort templates
usort($filtered_templates, function($a, $b) use ($sort) {
    switch ($sort) {
        case 'price_asc':
            return $a['price'] - $b['price'];
        case 'price_desc':
            return $b['price'] - $a['price'];
        case 'newest':
            return $b['id'] - $a['id'];
        case 'rating':
            return $b['rating'] - $a['rating'];
        case 'popular':
        default:
            return $b['downloads'] - $a['downloads'];
    }
});

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-app-templates">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Premium App Templates</h1>
                <p class="lead mb-4">Jumpstart your next mobile app project with our professionally designed, fully customizable app templates. Save hundreds of hours of development time.</p>
                <div class="d-flex gap-3">
                    <a href="#templates" class="btn btn-primary btn-lg">
                        <i class="fas fa-rocket me-2"></i> Browse Templates
                    </a>
                    <a href="#how-it-works" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-play-circle me-2"></i> Watch Demo
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-mockup">
                    <div class="phone-mockup">
                        <div class="screen">
                            <img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="App Preview">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</section>

<!-- Search & Filters -->
<section id="templates" class="section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title">Find Your Perfect App Template</h2>
                <p class="section-subtitle">Choose from our collection of professionally designed templates</p>
                
                <!-- Search Bar -->
                <form class="search-form mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search templates..." 
                               name="search" 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-primary" type="submit">
                            Search
                        </button>
                    </div>
                </form>
                
                <!-- Category Filters -->
                <div class="category-filters mb-4">
                    <div class="btn-group" role="group">
                        <a href="?category=all" class="btn btn-outline-primary <?php echo $category_filter === 'all' ? 'active' : ''; ?>">
                            All Templates
                        </a>
                        <a href="?category=social" class="btn btn-outline-primary <?php echo $category_filter === 'social' ? 'active' : ''; ?>">
                            <i class="fas fa-share-alt me-1"></i> Social
                        </a>
                        <a href="?category=ecommerce" class="btn btn-outline-primary <?php echo $category_filter === 'ecommerce' ? 'active' : ''; ?>">
                            <i class="fas fa-shopping-cart me-1"></i> E-commerce
                        </a>
                        <a href="?category=health" class="btn btn-outline-primary <?php echo $category_filter === 'health' ? 'active' : ''; ?>">
                            <i class="fas fa-heartbeat me-1"></i> Health
                        </a>
                        <a href="?category=food" class="btn btn-outline-primary <?php echo $category_filter === 'food' ? 'active' : ''; ?>">
                            <i class="fas fa-utensils me-1"></i> Food
                        </a>
                    </div>
                </div>
                
                <!-- Sort Options -->
                <div class="sort-options">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-1"></i> Sort: 
                            <span id="sortText">
                                <?php 
                                $sort_texts = [
                                    'popular' => 'Most Popular',
                                    'newest' => 'Newest',
                                    'rating' => 'Top Rated',
                                    'price_asc' => 'Price: Low to High',
                                    'price_desc' => 'Price: High to Low'
                                ];
                                echo $sort_texts[$sort] ?? 'Most Popular';
                                ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item sort-option <?php echo $sort === 'popular' ? 'active' : ''; ?>" href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'popular'])); ?>">Most Popular</a></li>
                            <li><a class="dropdown-item sort-option <?php echo $sort === 'newest' ? 'active' : ''; ?>" href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'newest'])); ?>">Newest</a></li>
                            <li><a class="dropdown-item sort-option <?php echo $sort === 'rating' ? 'active' : ''; ?>" href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'rating'])); ?>">Top Rated</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item sort-option <?php echo $sort === 'price_asc' ? 'active' : ''; ?>" href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'price_asc'])); ?>">Price: Low to High</a></li>
                            <li><a class="dropdown-item sort-option <?php echo $sort === 'price_desc' ? 'active' : ''; ?>" href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'price_desc'])); ?>">Price: High to Low</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Template Grid -->
        <div class="row g-4">
            <?php if (count($filtered_templates) > 0): ?>
                <?php foreach ($filtered_templates as $template): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="template-card h-100">
                            <div class="template-thumbnail">
                                <img src="<?php echo $template['images'][0]; ?>" alt="<?php echo htmlspecialchars($template['title']); ?>" class="img-fluid">
                                <div class="template-overlay">
                                    <div class="template-actions">
                                        <button class="btn btn-primary btn-sm me-2 preview-btn" data-bs-toggle="modal" data-bs-target="#previewModal" data-preview-url="<?php echo $template['preview_url']; ?>">
                                            <i class="fas fa-eye me-1"></i> Preview
                                        </button>
                                        <a href="product.php?slug=<?php echo $template['slug']; ?>" class="btn btn-light btn-sm">
                                            <i class="fas fa-info-circle me-1"></i> Details
                                        </a>
                                    </div>
                                    <?php if (isset($template['sale_price'])): ?>
                                        <div class="template-price">
                                            <span class="text-decoration-line-through text-muted me-2">$<?php echo number_format($template['price'], 2); ?></span>
                                            <span class="sale-price">$<?php echo number_format($template['sale_price'], 2); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="template-price">
                                            $<?php echo number_format($template['price'], 2); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="template-rating">
                                        <i class="fas fa-star text-warning"></i> <?php echo $template['rating']; ?>
                                        <small class="text-muted ms-1">(<?php echo $template['review_count']; ?>)</small>
                                    </div>
                                </div>
                                <div class="template-badges">
                                    <?php if (isset($template['sale_price'])): ?>
                                        <span class="badge bg-danger">Sale</span>
                                    <?php endif; ?>
                                    <span class="badge bg-primary"><?php echo ucfirst($template['category']); ?></span>
                                </div>
                            </div>
                            <div class="template-info p-3">
                                <h5 class="template-title mb-2">
                                    <a href="product.php?slug=<?php echo $template['slug']; ?>"><?php echo htmlspecialchars($template['title']); ?></a>
                                </h5>
                                <p class="template-description text-muted small mb-3"><?php echo htmlspecialchars($template['description']); ?></p>
                                
                                <div class="template-meta d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="me-3" data-bs-toggle="tooltip" title="Screens">
                                            <i class="fas fa-mobile-alt me-1 text-muted"></i> <?php echo $template['screens']; ?>
                                        </span>
                                        <span data-bs-toggle="tooltip" title="Downloads">
                                            <i class="fas fa-download me-1 text-muted"></i> <?php echo $template['downloads']; ?>
                                        </span>
                                    </div>
                                    <div class="template-tags">
                                        <?php foreach (array_slice($template['tags'], 0, 2) as $tag): ?>
                                            <span class="badge bg-light text-dark me-1"><?php echo $tag; ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($template['tags']) > 2): ?>
                                            <span class="badge bg-light text-dark">+<?php echo count($template['tags']) - 2; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>No templates found</h4>
                        <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
                        <a href="?" class="btn btn-primary">Clear all filters</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Why Choose Our App Templates?</h2>
            <p class="section-subtitle">Professional quality, fully customizable, and ready to launch</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-mobile-alt fa-2x text-primary"></i>
                    </div>
                    <h4>Fully Responsive</h4>
                    <p class="text-muted mb-0">Works perfectly on all devices and screen sizes, from mobile to tablet to desktop.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-code fa-2x text-primary"></i>
                    </div>
                    <h4>Clean Code</h4>
                    <p class="text-muted mb-0">Well-documented, modular code that's easy to understand and customize.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-headset fa-2x text-primary"></i>
                    </div>
                    <h4>Premium Support</h4>
                    <p class="text-muted mb-0">Dedicated support team to help you with any questions or issues.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section bg-primary text-white">
    <div class="container text-center">
        <h2 class="mb-4">Ready to Build Your App?</h2>
        <p class="lead mb-5">Join thousands of developers who have launched their apps with our templates</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#templates" class="btn btn-light btn-lg">
                <i class="fas fa-rocket me-2"></i> Browse Templates
            </a>
            <a href="#" class="btn btn-outline-light btn-lg">
                <i class="fas fa-question-circle me-2"></i> Need Help?
            </a>
        </div>
    </div>
</section>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Template Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="previewFrame" src="" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Section */
.hero-app-templates {
    background: linear-gradient(135deg, #6e8efb 0%, #a777e3 100%);
    color: white;
    padding: 80px 0 120px;
    position: relative;
    overflow: hidden;
}

.hero-app-templates h1 {
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.hero-mockup {
    position: relative;
    z-index: 1;
}

.phone-mockup {
    width: 300px;
    height: 600px;
    background: #111;
    border-radius: 40px;
    padding: 15px;
    margin: 0 auto;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.phone-mockup .screen {
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    border-radius: 25px;
    overflow: hidden;
}

.phone-mockup .screen img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100px;
    background: white;
}

.hero-wave svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.hero-wave path {
    fill: #6e8efb;
}

/* Template Cards */
.template-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #eee;
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.template-thumbnail {
    position: relative;
    padding-top: 60%;
    overflow: hidden;
    background: #f8f9fa;
}

.template-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.template-card:hover .template-thumbnail img {
    transform: scale(1.05);
}

.template-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 20px;
}

.template-card:hover .template-overlay {
    opacity: 1;
}

.template-actions {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    text-align: center;
    z-index: 2;
}

.template-price {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.sale-price {
    color: #ffc107;
    font-weight: 700;
}

.template-rating {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
}

.template-badges {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.template-badges .badge {
    font-size: 0.7rem;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 4px;
}

.template-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.template-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.template-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.2s;
}

.template-title a:hover {
    color: #6e8efb;
}

.template-description {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
    flex-grow: 1;
}

.template-meta {
    font-size: 0.85rem;
    color: #777;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

.template-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.template-tags .badge {
    font-size: 0.7rem;
    font-weight: 400;
    padding: 3px 8px;
    background: #f5f5f5;
    color: #555;
}

/* Search & Filters */
.search-form .input-group {
    max-width: 600px;
    margin: 0 auto;
}

.search-form .form-control {
    height: 50px;
    font-size: 1.1rem;
    border-radius: 0 8px 8px 0 !important;
}

.search-form .input-group-text {
    height: 50px;
    border-radius: 8px 0 0 8px !important;
    font-size: 1.2rem;
}

.search-form .btn {
    border-radius: 0 8px 8px 0;
    padding: 0 25px;
    font-weight: 500;
}

.category-filters {
    overflow-x: auto;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.category-filters .btn-group {
    flex-wrap: nowrap;
}

.category-filters .btn {
    white-space: nowrap;
    border-radius: 20px !important;
    margin: 0 5px;
    padding: 8px 20px;
    font-weight: 500;
}

.category-filters .btn.active {
    background: #6e8efb;
    border-color: #6e8efb;
    color: white;
}

.sort-options .btn {
    border-radius: 20px;
    padding: 8px 20px;
}

.sort-options .dropdown-menu {
    border-radius: 12px;
    border: 1px solid #eee;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 10px 0;
    margin-top: 10px;
}

.sort-option {
    padding: 8px 20px;
    font-size: 0.9rem;
    color: #333;
    text-decoration: none;
    display: block;
    transition: all 0.2s;
}

.sort-option:hover, .sort-option.active {
    background: #f8f9fa;
    color: #6e8efb;
}

/* Features */
.feature-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid #eee;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    width: 70px;
    height: 70px;
    background: rgba(110, 142, 251, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

/* Preview Modal */
#previewModal .modal-content {
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

#previewModal .modal-header {
    border-bottom: 1px solid #eee;
    padding: 15px 20px;
}

#previewModal .modal-body {
    padding: 0;
}

#previewFrame {
    border: none;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .hero-app-templates {
        padding: 60px 0 100px;
    }
    
    .hero-app-templates h1 {
        font-size: 2.5rem;
    }
    
    .phone-mockup {
        width: 250px;
        height: 500px;
        margin-top: 30px;
    }
}

@media (max-width: 768px) {
    .hero-app-templates {
        text-align: center;
        padding: 50px 0 80px;
    }
    
    .hero-app-templates .btn {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .hero-app-templates .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .category-filters .btn-group {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .category-filters .btn {
        margin: 5px;
    }
}

@media (max-width: 576px) {
    .hero-app-templates h1 {
        font-size: 2rem;
    }
    
    .phone-mockup {
        width: 200px;
        height: 400px;
    }
    
    .template-card {
        margin-bottom: 20px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Handle preview modal
    var previewModal = document.getElementById('previewModal');
    if (previewModal) {
        previewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var previewUrl = button.getAttribute('data-preview-url');
            var modalIframe = previewModal.querySelector('#previewFrame');
            modalIframe.src = previewUrl;
        });
        
        previewModal.addEventListener('hidden.bs.modal', function () {
            var modalIframe = previewModal.querySelector('#previewFrame');
            modalIframe.src = '';
        });
    }
    
    // Update sort text when a sort option is selected
    var sortOptions = document.querySelectorAll('.sort-option');
    var sortText = document.getElementById('sortText');
    
    sortOptions.forEach(function(option) {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            sortText.textContent = this.textContent.trim();
            window.location.href = this.getAttribute('href');
        });
    });
    
    // Add animation to template cards on scroll
    var animateOnScroll = function() {
        var elements = document.querySelectorAll('.template-card');
        
        elements.forEach(function(element) {
            var elementPosition = element.getBoundingClientRect().top;
            var screenPosition = window.innerHeight / 1.3;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Set initial styles for animation
    document.querySelectorAll('.template-card').forEach(function(card, index) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        card.style.transitionDelay = (index * 0.1) + 's';
    });
    
    // Run animation on load and scroll
    window.addEventListener('load', animateOnScroll);
    window.addEventListener('scroll', animateOnScroll);
});
</script>

<?php include 'includes/footer.php'; ?>
