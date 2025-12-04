<?php
$page_title = 'Home';
$page_description = 'AA DIGITS - Premium digital products, templates, and software solutions for modern businesses and developers.';

require_once 'config/config.php';
require_once 'classes/Product.php';
require_once 'classes/Category.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes
$product = new Product($db);
$category = new Category($db);

// Get featured products
try {
    $featured_products = $product->getFeaturedProducts(8);
    $latest_products = $product->getAllProducts(8, 0);
    $categories = $category->getAllCategories();
    
    // Template categories for the showcase
    $template_categories = [
        ['id' => 'social-media', 'name' => 'Social Media', 'icon' => 'share-alt'],
        ['id' => 'presentation', 'name' => 'Presentations', 'icon' => 'file-powerpoint'],
        ['id' => 'marketing', 'name' => 'Marketing', 'icon' => 'bullhorn'],
        ['id' => 'business', 'name' => 'Business', 'icon' => 'briefcase'],
        ['id' => 'education', 'name' => 'Education', 'icon' => 'graduation-cap'],
        ['id' => 'all', 'name' => 'View All', 'icon' => 'th-large']
    ];
    
    // Sample templates data with placeholder images from Unsplash
    $templates = [
        [
            'id' => 1,
            'title' => 'Modern Business Presentation',
            'category' => 'presentation',
            'image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 245,
            'price' => 19.99,
            'rating' => 4.8
        ],
        [
            'id' => 2,
            'title' => 'Instagram Story Pack',
            'category' => 'social-media',
            'image' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => false,
            'likes' => 189,
            'price' => 0.00,
            'rating' => 4.5
        ],
        [
            'id' => 3,
            'title' => 'Marketing Brochure',
            'category' => 'marketing',
            'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 312,
            'price' => 24.99,
            'rating' => 4.9
        ],
        [
            'id' => 4,
            'title' => 'Professional Resume',
            'category' => 'business',
            'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => false,
            'likes' => 421,
            'price' => 0.00,
            'rating' => 4.7
        ],
        [
            'id' => 5,
            'title' => 'E-book Cover Design',
            'category' => 'education',
            'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 178,
            'price' => 14.99,
            'rating' => 4.6
        ],
        [
            'id' => 6,
            'title' => 'Facebook Ad Template',
            'category' => 'social-media',
            'image' => 'https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => false,
            'likes' => 267,
            'price' => 0.00,
            'rating' => 4.4
        ],
        [
            'id' => 7,
            'title' => 'Business Card Design',
            'category' => 'business',
            'image' => 'https://images.unsplash.com/photo-1601784551446-9e3c36667cfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 198,
            'price' => 9.99,
            'rating' => 4.8
        ],
        [
            'id' => 8,
            'title' => 'Certificate Template',
            'category' => 'education',
            'image' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => false,
            'likes' => 156,
            'price' => 0.00,
            'rating' => 4.3
        ],
        [
            'id' => 9,
            'title' => 'Social Media Banner',
            'category' => 'social-media',
            'image' => 'https://images.unsplash.com/photo-1611605698335-8b1569810432?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 289,
            'price' => 12.99,
            'rating' => 4.7
        ],
        [
            'id' => 10,
            'title' => 'Startup Pitch Deck',
            'category' => 'presentation',
            'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 321,
            'price' => 29.99,
            'rating' => 4.9
        ],
        [
            'id' => 11,
            'title' => 'Product Catalog',
            'category' => 'marketing',
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => true,
            'likes' => 198,
            'price' => 19.99,
            'rating' => 4.6
        ],
        [
            'id' => 12,
            'title' => 'Infographic Template',
            'category' => 'education',
            'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'premium' => false,
            'likes' => 234,
            'price' => 0.00,
            'rating' => 4.5
        ]
    ];
    
} catch (Exception $e) {
    $featured_products = [];
    $latest_products = [];
    $categories = [];
    $templates = [];
    $template_categories = [];
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content fade-in">
            <h1>Create Stunning Designs in Minutes</h1>
            <p>Choose from thousands of professional templates for all your design needs. No design skills needed!</p>
            <div class="hero-actions">
                <a href="#templates" class="btn btn-primary btn-lg">
                    <i class="fas fa-magic"></i>
                    Start Designing
                </a>
                <a href="#how-it-works" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-play-circle"></i>
                    Watch Demo
                </a>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</section>

<!-- Template Showcase Section -->
<section id="templates" class="section bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Amazing Templates for Everything</h2>
            <p class="section-subtitle">Professionally designed, fully customizable templates for every need</p>
        </div>
        
        <!-- Template Categories -->
        <div class="template-categories mb-5">
            <div class="row g-3 justify-content-center">
                <?php foreach ($template_categories as $cat): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="#" class="template-category-item" data-category="<?php echo $cat['id']; ?>">
                            <div class="icon-wrapper">
                                <i class="fas fa-<?php echo $cat['icon']; ?>"></i>
                            </div>
                            <span><?php echo $cat['name']; ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Template Grid -->
        <div class="template-grid">
            <div class="row g-4">
                <?php foreach ($templates as $template): ?>
                    <div class="col-6 col-md-4 col-lg-3 template-item" data-category="<?php echo $template['category']; ?>">
                        <div class="template-card">
                            <div class="template-thumbnail">
                                <img src="<?php echo $template['image']; ?>" alt="<?php echo htmlspecialchars($template['title']); ?>" class="img-fluid">
                                <div class="template-overlay">
                                    <div class="template-actions">
                                        <button class="btn btn-primary btn-sm me-2">
                                            <i class="fas fa-eye me-1"></i> Preview
                                        </button>
                                        <button class="btn btn-light btn-sm">
                                            <i class="far fa-heart"></i> <?php echo $template['likes']; ?>
                                        </button>
                                    </div>
                                    <div class="template-price">
                                        <?php if ($template['premium']): ?>
                                            $<?php echo number_format($template['price'], 2); ?>
                                        <?php else: ?>
                                            <span class="text-success">Free</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="template-rating">
                                        <i class="fas fa-star text-warning"></i> <?php echo $template['rating']; ?>
                                    </div>
                                </div>
                                <?php if ($template['premium']): ?>
                                    <span class="template-badge premium">Premium</span>
                                <?php else: ?>
                                    <span class="template-badge free">Free</span>
                                <?php endif; ?>
                            </div>
                            <div class="template-info p-3">
                                <h5 class="template-title mb-1"><?php echo htmlspecialchars($template['title']); ?></h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="template-category"><?php echo ucfirst(str_replace('-', ' ', $template['category'])); ?></span>
                                    <div class="template-stats">
                                        <i class="fas fa-thumbs-up text-muted"></i> <?php echo $template['likes']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="templates.php" class="btn btn-primary btn-lg">
                <i class="fas fa-th-large me-2"></i> Browse All Templates
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Create stunning designs in just a few clicks</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="how-it-works-item text-center p-4">
                    <div class="step-number">1</div>
                    <div class="step-icon mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Choose a Template</h4>
                    <p class="text-muted">Browse our collection of professionally designed templates for any purpose.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="how-it-works-item text-center p-4">
                    <div class="step-number">2</div>
                    <div class="step-icon mb-3">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h4>Customize It</h4>
                    <p class="text-muted">Easily customize the template with our drag-and-drop editor. No design skills needed!</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="how-it-works-item text-center p-4">
                    <div class="step-number">3</div>
                    <div class="step-icon mb-3">
                        <i class="fas fa-download"></i>
                    </div>
                    <h4>Download & Share</h4>
                    <p class="text-muted">Download your design in high resolution or share it directly on social media.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Templates Section -->
<section class="section bg-light">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Popular Templates</h2>
                <p class="section-subtitle mb-0">Most downloaded and highly rated by our community</p>
            </div>
            <a href="templates.php" class="btn btn-outline-primary">View All</a>
        </div>
        
        <div class="popular-templates-slider">
            <div class="row g-4">
                <?php 
                // Display first 4 popular templates
                $popular_templates = array_slice($templates, 0, 4);
                foreach ($popular_templates as $template): 
                ?>
                    <div class="col-md-3">
                        <div class="template-card">
                            <div class="template-thumbnail">
                                <img src="<?php echo $template['image']; ?>" alt="<?php echo htmlspecialchars($template['title']); ?>" class="img-fluid">
                                <div class="template-overlay">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i> Customize
                                    </button>
                                </div>
                            </div>
                            <div class="template-info p-3">
                                <h5 class="template-title mb-1"><?php echo htmlspecialchars($template['title']); ?></h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-<?php echo $template['premium'] ? 'crown text-warning' : 'check-circle text-success'; ?> me-1"></i>
                                        <?php echo $template['premium'] ? 'Premium' : 'Free'; ?>
                                    </span>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i> 4.8
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Template Categories Section -->
<section class="section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-subtitle">Find the perfect template for your next project</p>
        </div>
        
        <div class="row g-4">
            <?php 
            $category_icons = [
                'Social Media' => 'share-alt',
                'Presentations' => 'file-powerpoint',
                'Marketing' => 'bullhorn',
                'Business' => 'briefcase',
                'Education' => 'graduation-cap',
                'Resume' => 'file-alt',
                'Invitation' => 'envelope',
                'Brochure' => 'newspaper'
            ];
            
            $category_count = 0;
            foreach ($category_icons as $name => $icon): 
                if ($category_count >= 8) break;
                $category_count++;
            ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="templates.php?category=<?php echo strtolower($name); ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-<?php echo $icon; ?>"></i>
                        </div>
                        <h5><?php echo $name; ?></h5>
                        <span class="text-muted small"><?php echo rand(50, 500); ?>+ Templates</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section bg-primary text-white">
    <div class="container text-center">
        <h2 class="mb-4">Ready to Create Something Amazing?</h2>
        <p class="lead mb-5">Join thousands of creators who trust our templates for their design needs</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="register.php" class="btn btn-light btn-lg">
                <i class="fas fa-user-plus me-2"></i> Sign Up Free
            </a>
            <a href="templates.php" class="btn btn-outline-light btn-lg">
                <i class="fas fa-play-circle me-2"></i> Watch Demo
            </a>
        </div>
    </div>
</section>

<style>
/* Template Showcase Styles */
.template-categories {
    margin-bottom: 2rem;
    padding: 0 10px;
}

/* Adjust template grid spacing */
.template-grid .row {
    margin: 0 -8px;
}

.template-grid .col-6, 
.template-grid .col-md-4, 
.template-grid .col-lg-3 {
    padding: 0 8px;
    margin-bottom: 20px;
}

/* Make template cards more compact */
.template-info {
    padding: 12px 15px !important;
}

.template-title {
    font-size: 0.9rem !important;
    margin-bottom: 6px !important;
    line-height: 1.3;
    height: 2.2em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.template-badge {
    font-size: 0.7rem !important;
    padding: 0.2rem 0.6rem !important;
    top: 0.75rem !important;
    right: 0.75rem !important;
}

.template-overlay .btn {
    font-size: 0.75rem !important;
    padding: 0.25rem 0.5rem !important;
}

.template-price {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
}

.template-rating {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.template-rating i {
    margin-right: 3px;
}

/* Hover effects */
.template-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
}

.template-thumbnail img {
    transition: transform 0.5s ease;
}

.template-card:hover .template-thumbnail img {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .template-grid .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .template-title {
        font-size: 0.8rem !important;
    }
}

.template-category-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    color: var(--text-color);
    text-decoration: none;
    padding: 1.5rem 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    background: white;
    border: 1px solid var(--border-color);
    height: 100%;
}

.template-category-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.template-category-item .icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(var(--primary-rgb), 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.template-category-item:hover .icon-wrapper {
    background: var(--primary-color);
    color: white;
}

.template-grid {
    margin: 2rem 0;
}

.template-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #f0f0f0;
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.template-thumbnail {
    position: relative;
    overflow: hidden;
    padding-top: 75%; /* 4:3 aspect ratio */
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.template-card:hover .template-overlay {
    opacity: 1;
}

.template-actions {
    display: flex;
    gap: 0.5rem;
}

.template-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.template-badge.premium {
    background: var(--primary-color);
    color: white;
}

.template-badge.free {
    background: #28a745;
    color: white;
}

.template-info {
    padding: 1.25rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.template-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark);
}

.template-category {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.template-stats {
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* How It Works */
.how-it-works-item {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.how-it-works-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.step-number {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 30px;
    height: 30px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.step-icon {
    width: 70px;
    height: 70px;
    background: rgba(var(--primary-rgb), 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: var(--primary-color);
    margin: 0 auto 1.5rem;
}

/* Category Cards */
.category-card {
    display: block;
    background: white;
    border-radius: 0.5rem;
    padding: 2rem 1rem;
    text-align: center;
    color: var(--text-color);
    text-decoration: none;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    height: 100%;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.category-icon {
    width: 60px;
    height: 60px;
    background: rgba(var(--primary-rgb), 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    background: var(--primary-color);
    color: white;
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .template-category-item {
        padding: 1rem 0.5rem;
    }
    
    .template-category-item .icon-wrapper {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .template-title {
        font-size: 0.9rem;
    }
    
    .template-badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
    }
}

/* Animation */
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

.template-item {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

/* Add delay for each item */
.template-item:nth-child(1) { animation-delay: 0.1s; }
.template-item:nth-child(2) { animation-delay: 0.2s; }
.template-item:nth-child(3) { animation-delay: 0.3s; }
.template-item:nth-child(4) { animation-delay: 0.4s; }
.template-item:nth-child(5) { animation-delay: 0.5s; }
.template-item:nth-child(6) { animation-delay: 0.6s; }
.template-item:nth-child(7) { animation-delay: 0.7s; }
.template-item:nth-child(8) { animation-delay: 0.8s; }
</style>

<script>
// Template filtering
$(document).ready(function() {
    // Filter templates by category
    $('.template-category-item').on('click', function(e) {
        e.preventDefault();
        const category = $(this).data('category');
        
        // Update active state
        $('.template-category-item').removeClass('active');
        $(this).addClass('active');
        
        // Show/hide templates
        if (category === 'all') {
            $('.template-item').show();
        } else {
            $('.template-item').hide();
            $(`.template-item[data-category="${category}"]`).show();
        }
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add to favorites
    $('.btn-favorite').on('click', function() {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).html('<i class="fas fa-heart"></i>');
            showToast('Added to favorites');
        } else {
            $(this).html('<i class="far fa-heart"></i>');
            showToast('Removed from favorites');
        }
    });
});

// Show toast notification
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-success text-white rounded-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = message;
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

<?php include 'includes/footer.php'; ?>
