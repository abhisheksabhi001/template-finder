<?php
$page_title = 'Premium Digital Products';
$page_description = 'Discover and shop our exclusive collection of premium digital products, templates, and software solutions.';
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap');

:root {
    --primary-color: #3b82f6 !important;
    --primary-dark: #2563eb !important;
    --secondary-color: #06b6d4 !important;
    --accent-color: #0ea5e9 !important;
    --success-color: #10b981 !important;
    --error-color: #ef4444 !important;
    --warning-color: #f59e0b !important;
    --bg-secondary: #eff6ff !important;
    --bg-tertiary: #dbeafe !important;
    
    /* Font Families */
    --font-primary: 'Inter', sans-serif !important;
    --font-heading: 'Poppins', sans-serif !important;
    --font-mono: 'Fira Code', 'Courier New', monospace !important;
}

/* Global Typography */
body {
    font-family: var(--font-primary) !important;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 25%, #1e40af 50%, #1d4ed8 75%, #1e3a8a 100%) !important;
    min-height: 100vh;
    font-weight: 400 !important;
    line-height: 1.6 !important;
}

/* Headings */
h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-heading) !important;
    font-weight: 600 !important;
    letter-spacing: -0.025em !important;
}

.display-4 {
    font-family: var(--font-heading) !important;
    font-weight: 700 !important;
    letter-spacing: -0.05em !important;
}

.lead {
    font-family: var(--font-primary) !important;
    font-weight: 400 !important;
    opacity: 0.9 !important;
}

/* Card Typography */
.card {
    font-family: var(--font-primary) !important;
    background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%) !important;
    border: 1px solid #93c5fd !important;
}

.card-title {
    font-family: var(--font-heading) !important;
    font-weight: 600 !important;
    font-size: 1.125rem !important;
    line-height: 1.4 !important;
}

.card-text {
    font-family: var(--font-primary) !important;
    font-weight: 400 !important;
    font-size: 0.875rem !important;
    line-height: 1.5 !important;
}

/* Button Typography */
.btn {
    font-family: var(--font-primary) !important;
    font-weight: 500 !important;
    letter-spacing: 0.025em !important;
    text-transform: none !important;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    border-color: #3b82f6 !important;
    font-weight: 600 !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    border-color: #2563eb !important;
}

.btn-outline-primary {
    border-color: #3b82f6 !important;
    color: #3b82f6 !important;
    font-weight: 500 !important;
}

.btn-outline-primary:hover {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}

.btn-outline-primary.active {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}

/* Form Typography */
.form-control, .form-select {
    font-family: var(--font-primary) !important;
    font-weight: 400 !important;
    font-size: 0.95rem !important;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25) !important;
}

/* Price Typography */
.price {
    font-family: var(--font-heading) !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
}

.h5 {
    font-family: var(--font-heading) !important;
    font-weight: 600 !important;
}

/* Badge Typography */
.badge {
    font-family: var(--font-primary) !important;
    font-weight: 500 !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.025em !important;
}

/* Pagination Typography */
.pagination .page-link {
    font-family: var(--font-primary) !important;
    font-weight: 500 !important;
    color: #3b82f6 !important;
    border: 1px solid #93c5fd !important;
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    font-weight: 600 !important;
}

/* Other Updates */
.bg-white {
    background-color: #eff6ff !important;
}

.bg-light {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
}

.text-dark {
    color: #1f2937 !important;
}

.product-card {
    background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%) !important;
    border: 1px solid #93c5fd !important;
    transition: all 0.3s ease !important;
}

.product-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3) !important;
}

.search-section {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
}

.filter-section {
    background: #eff6ff !important;
    border: 1px solid #93c5fd !important;
}

.hero-section {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(37, 99, 235, 0.9) 25%, rgba(30, 64, 175, 0.9) 50%, rgba(29, 78, 216, 0.9) 75%, rgba(30, 58, 138, 0.9) 100%) !important;
}

.py-4[style*="background"] {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
}
</style>
<?php
require_once 'config/config.php';
require_once 'classes/Product.php';
require_once 'classes/Database.php';

// Initialize product class
$product = new Product();

// Get filter parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 12;
$offset = ($page - 1) * $per_page;
$sort = $_GET['sort'] ?? 'newest';

// Get products with filters
$products = $product->getAllProducts($per_page, $offset, $category_id, $search, $sort);
$total_products = $product->getProductsCount($category_id, $search);
$total_pages = ceil($total_products / $per_page);

// Get featured products
$featured_products = $product->getFeaturedProducts(4);

// Get categories
$database = new Database();
$conn = $database->getConnection();
$categories_stmt = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get popular products (most downloaded)
$popular_products = $product->getPopularProducts(4);

include 'includes/header.php';
?>

<!-- Hero Section with Background -->
<section class="hero-section bg-dark text-white py-6 position-relative" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/hero-bg.jpg') center/cover no-repeat;">
    <div class="container py-5">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 mx-auto text-center">
                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-25 text-white px-3 py-2 mb-3">Premium Digital Assets</span>
                    <h1 class="display-4 fw-bold mb-3">Discover Amazing Digital Products</h1>
                    <p class="lead mb-4">High-quality templates, themes, and digital assets for your next project</p>
                    <form class="d-flex justify-content-center w-100" method="GET" action="products.php">
                            <?php if ($category_id): ?>
                                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                            <?php endif; ?>
                            <?php if ($sort && $sort !== 'newest'): ?>
                                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                            <?php endif; ?>
                            <div class="input-group" style="max-width: 600px;">
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       name="search" 
                                       value="<?php echo htmlspecialchars($search); ?>" 
                                       placeholder="Search products..."
                                       aria-label="Search products">
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="fas fa-search me-2"></i> Search
                                </button>
                                <?php if ($search): ?>
                                    <a href="products.php<?php echo $category_id ? '?category=' . $category_id : ''; ?>" class="btn btn-outline-light ms-2">
                                        <i class="fas fa-times me-1"></i> Clear
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    <div class="mt-3">
                        <span class="text-white-50 me-2">Popular Searches:</span>
                        <a href="products.php?search=wordpress" class="badge bg-white bg-opacity-10 text-white text-decoration-none me-2">WordPress</a>
                        <a href="products.php?search=template" class="badge bg-white bg-opacity-10 text-white text-decoration-none me-2">Templates</a>
                        <a href="products.php?search=ui+kit" class="badge bg-white bg-opacity-10 text-white text-decoration-none me-2">UI Kits</a>
                        <a href="products.php?search=plugins" class="badge bg-white bg-opacity-10 text-white text-decoration-none">Plugins</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 end-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" fill="#fff" preserveAspectRatio="none">
            <path d="M0,64L48,69.3C96,75,192,85,288,90.7C384,96,480,96,576,85.3C672,75,768,53,864,48C960,43,1056,53,1152,69.3C1248,85,1344,107,1392,117.3L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>
    </div>
</section>

<!-- Categories & Filters -->
<section class="py-4" style="background: linear-gradient(135deg, #faf5ff 0%, #e0e7ff 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex flex-wrap gap-2">
                    <a href="products.php" class="btn btn-outline-primary <?php echo !$category_id ? 'active' : ''; ?>">>
                        All Products
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="products.php?category=<?php echo $cat['id']; ?>" 
                           class="btn btn-outline-primary <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <form method="GET" action="products.php" class="d-flex">
                    <?php if ($search): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <?php endif; ?>
                    <?php if ($category_id): ?>
                        <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                    <?php endif; ?>
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="oldest" <?php echo $sort == 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                        <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="popular" <?php echo $sort == 'popular' ? 'selected' : ''; ?>>Most Popular</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($products)): ?>
            <div class="row g-4">
                <?php foreach ($products as $product_item): 
                    $sale_badge = $product_item['sale_price'] ? 
                        '<span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>' : '';
                    $price = $product_item['sale_price'] ? $product_item['sale_price'] : $product_item['price'];
                    $original_price = $product_item['sale_price'] ? 
                        '<small class="text-muted text-decoration-line-through me-2">$' . number_format($product_item['price'], 2) . '</small>' : '';
                ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 product-card shadow-sm border-0">
                        <div class="position-relative">
                            <img src="https://via.placeholder.com/400x250?text=<?php echo urlencode($product_item['title']); ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($product_item['title']); ?>">
                            <?php echo $sale_badge; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product_item['title']); ?></h5>
                            <p class="card-text text-muted small">
                                <?php echo mb_strimwidth(strip_tags($product_item['description']), 0, 100, '...'); ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">
                                    <?php echo $original_price; ?>
                                    <span class="h5 mb-0 text-dark">$<?php echo number_format($price, 2); ?></span>
                                </div>
                                <a href="product.php?slug=<?php echo $product_item['slug']; ?>" 
                                   class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($total_pages > 1): ?>
                <div class="pagination-wrapper mt-5">
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            

                            <?php 
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);
                            

                            for ($i = $start_page; $i <= $end_page; $i++): 
                            ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No products found</h3>
                <p class="text-muted">Try adjusting your search or filters</p>
                <a href="products.php" class="btn btn-primary">Clear Filters</a>
            </div>
        <?php endif; ?>
    </div>
</section>
<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSgzMCkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSJ0cmFuc3BhcmVudCI+PC9yZWN0PjxjaXJjbGUgY3g9IjIwIiBjeT0iMjAiIHI9IjEiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48L2NpcmNsZT48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiPjwvcmVjdD48L3N2Zz4=');
    opacity: 0.1;
}

/* Product Card */
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.product-card .card-img-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .card-img-overlay {
    opacity: 1;
}

/* Category Buttons */
.btn-outline-primary.active {
    background-color: #4e54c8;
    border-color: #4e54c8;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .search-box {
        margin-bottom: 1.5rem;
    }
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Pagination */
.pagination .page-link {
    color: #4e54c8;
    border: 1px solid #dee2e6;
    margin: 0 2px;
    border-radius: 5px;
}

.pagination .page-item.active .page-link {
    background-color: #4e54c8;
    border-color: #4e54c8;
}

/* Badge */
.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

/* Price styling */
.price {
    font-weight: 600;
    color: #333;
}

/* Star rating */
.text-warning {
    color: #ffc107 !important;
}

/* Button hover effect */
.btn-outline-primary:hover {
    background-color: #4e54c8;
    border-color: #4e54c8;
}

/* Form controls */
.form-control:focus, .form-select:focus {
    border-color: #8f94fb;
    box-shadow: 0 0 0 0.25rem rgba(142, 148, 251, 0.25);
}

/* Responsive images */
.card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}

/* Pagination active state */
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #4e54c8;
    border-color: #4e54c8;
}

/* Responsive adjustments for mobile */
@media (max-width: 576px) {
    .hero-section h1 {
        font-size: 2rem;
    }
    
    .hero-section p {
        font-size: 1rem;
    }
    
    .card-img-top {
        height: 160px;
    }
}
</style>


<!-- Categories & Filters -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex flex-wrap gap-2">
                    <a href="products.php" class="btn btn-outline-primary <?php echo !$category_id ? 'active' : ''; ?>">
                        All Products
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="products.php?category=<?php echo $cat['id']; ?>" 
                           class="btn btn-outline-primary <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <form method="GET" action="products.php" class="d-flex">
                    <?php if ($search): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <?php endif; ?>
                    <?php if ($category_id): ?>
                        <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                    <?php endif; ?>
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="oldest" <?php echo $sort == 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                        <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="popular" <?php echo $sort == 'popular' ? 'selected' : ''; ?>>Most Popular</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</section>
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Results Info -->
        <div class="results-info">
            <div class="results-count">
                Showing <?php echo count($products); ?> of <?php echo $total_products; ?> products
                <?php if ($search): ?>
                    for "<strong><?php echo htmlspecialchars($search); ?></strong>"
                <?php endif; ?>
            </div>
            
            <div class="view-toggle">
                <button class="view-btn active" data-view="grid" title="Grid View">
                    <i class="fas fa-th"></i>
                </button>
                <button class="view-btn" data-view="list" title="List View">
                    <i class="fas fa-list"></i>
                    List
                </button>
            </div>
        </div>
    </div>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <?php if (!empty($products)): ?>
                    <div class="row">
                        <?php foreach ($products as $product_item): 
                            $sale_badge = $product_item['sale_price'] ? 
                                '<span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>' : '';
                            $price = $product_item['sale_price'] ? 
                                '<span class="text-muted text-decoration-line-through me-2">$' . number_format($product_item['price'], 2) . '</span> $' . number_format($product_item['sale_price'], 2) : 
                                '$' . number_format($product_item['price'], 2);
                        ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 product-card">
                                    <div class="position-relative">
                                        <img src="<?php echo htmlspecialchars($product_item['image_url'] ?? 'assets/images/placeholder.png'); ?>" 
                                             class="card-img-top" alt="<?php echo htmlspecialchars($product_item['title']); ?>">
                                        <?php echo $sale_badge; ?>
                                        <div class="product-overlay">
                                            <a href="product.php?slug=<?php echo $product_item['slug']; ?>" class="btn btn-primary btn-sm">View Details</a>
                                            <span class="price-current"><?php echo format_price($product_item['price']); ?></span>
                                        </div>
                                    
                                    <div class="product-rating">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count">(<?php echo rand(15, 150); ?>)</span>
                                    </div>
                                </div>
                                
                                <div class="product-card-actions">
                                    <button class="btn btn-primary btn-full add-to-cart" data-product-id="<?php echo $product_item['id']; ?>">
                                        <i class="fas fa-cart-plus"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            
            <?php if ($total_pages > 1): ?>
                <div class="pagination-wrapper mt-5">
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination">
                            <?php if ($page > 1): 
                                $prev_params = $query_params;
                                $prev_params['page'] = $page - 1;
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?php echo http_build_query($prev_params); ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php 
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);
                            
                            if ($start_page > 1) {
                                $first_params = $query_params;
                                $first_params['page'] = 1;
                                echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($first_params) . '">1</a></li>';
                                if ($start_page > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            
                            for ($i = $start_page; $i <= $end_page; $i++): 
                                $page_params = $query_params;
                                $page_params['page'] = $i;
                            ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?<?php echo http_build_query($page_params); ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; 
                            
                            if ($end_page < $total_pages) {
                                if ($end_page < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                $last_params = $query_params;
                                $last_params['page'] = $total_pages;
                                echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($last_params) . '">' . $total_pages . '</a></li>';
                            }
                            ?>
                            
                            <?php if ($page < $total_pages): 
                                $next_params = $query_params;
                                $next_params['page'] = $page + 1;
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?php echo http_build_query($next_params); ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- No Products Found -->
            <div class="text-center py-5 my-5">
                <div class="py-5 my-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3>No products found</h3>
                    <p class="text-muted">We couldn't find any products matching your criteria.</p>
                    <a href="products.php" class="btn btn-primary mt-3">Clear Filters</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSgzMCkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSJ0cmFuc3BhcmVudCI+PC9yZWN0PjxjaXJjbGUgY3g9IjIwIiBjeT0iMjAiIHI9IjEiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48L2NpcmNsZT48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiPjwvcmVjdD48L3N2Zz4=');
    opacity: 0.1;
}

/* Product Card */
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.product-card .card-img-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .card-img-overlay {
    opacity: 1;
}

/* Category Buttons */
.btn-outline-primary.active {
    background-color: #4e54c8;
    border-color: #4e54c8;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .search-box {
        margin-bottom: 1.5rem;
    }
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Pagination */
.pagination .page-link {
    color: #4e54c8;
    border: 1px solid #dee2e6;
    margin: 0 2px;
    border-radius: 5px;
}

.pagination .page-item.active .page-link {
    background-color: #4e54c8;
    border-color: #4e54c8;
}

/* Badge */
.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

/* Price styling */
.price {
    font-weight: 600;
    color: #333;
}

/* Star rating */
.text-warning {
    color: #ffc107 !important;
}

/* Button hover effect */
.btn-outline-primary:hover {
    background-color: #4e54c8;
    border-color: #4e54c8;
}

/* Form controls */
.form-control:focus, .form-select:focus {
    border-color: #8f94fb;
    box-shadow: 0 0 0 0.25rem rgba(142, 148, 251, 0.25);
}

/* Responsive images */
.card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: var(--spacing-2xl) 0;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.1;
}

.page-header-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.page-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: var(--spacing-sm);
}

.page-header p {
    font-size: 1.125rem;
    opacity: 0.9;
    margin-bottom: var(--spacing-lg);
}

.breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    font-size: 0.875rem;
}

.breadcrumb a {
    color: white;
    text-decoration: none;
    opacity: 0.8;
}

.breadcrumb a:hover {
    opacity: 1;
}

.breadcrumb i {
    opacity: 0.6;
    font-size: 0.75rem;
}

/* Results Info */
.results-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: var(--spacing-xl) 0;
    flex-wrap: wrap;
    gap: var(--spacing-md);
}

.results-count {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.view-toggle {
    display: flex;
    gap: var(--spacing-xs);
}

.view-btn {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    padding: var(--spacing-sm);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition-fast);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Product Overlay */
.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--transition-normal);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

/* Product Category */
.product-category {
    font-size: 0.75rem;
    color: var(--primary-color);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: var(--spacing-xs);
}

/* Badge Variations */
.product-card-badge.sale {
    background: var(--error-color);
}

/* No Products */
.no-products {
    text-align: center;
    padding: var(--spacing-2xl) 0;
}

.no-products-content i {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: var(--spacing-lg);
}

.no-products-content h3 {
    font-size: 1.5rem;
    margin-bottom: var(--spacing-md);
    color: var(--text-primary);
}

.no-products-content p {
    color: var(--text-secondary);
    margin-bottom: var(--spacing-xl);
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* Pagination */
.pagination-wrapper {
    margin-top: var(--spacing-2xl);
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    flex-wrap: wrap;
}

.pagination-btn,
.pagination-number {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-sm) var(--spacing-md);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    text-decoration: none;
    transition: all var(--transition-fast);
    min-width: 44px;
    height: 44px;
    gap: var(--spacing-xs);
}

.pagination-btn:hover,
.pagination-number:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.pagination-number.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination-numbers {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
}

.pagination-dots {
    color: var(--text-muted);
    padding: 0 var(--spacing-xs);
}

/* Mobile Responsive */
@media (max-width: 767px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .filter-row {
        flex-direction: column;
    }
    
    .filter-group,
    .search-bar {
        width: 100%;
    }
    
    .results-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .pagination {
        justify-content: center;
    }
    
    .pagination-numbers {
        order: -1;
        margin-bottom: var(--spacing-sm);
    }
}
</style>

<script>
// View toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const productsGrid = document.querySelector('.products-grid');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            
            // Update active button
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update grid layout
            if (view === 'list') {
                productsGrid.classList.remove('grid-md-2', 'grid-lg-3');
                productsGrid.classList.add('grid-cols-1');
            } else {
                productsGrid.classList.remove('grid-cols-1');
                productsGrid.classList.add('grid-md-2', 'grid-lg-3');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
