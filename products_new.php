<?php
$page_title = 'Premium Digital Products';
$page_description = 'Discover and shop our exclusive collection of premium digital products, templates, and software solutions.';

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

// Get products
$products = $product->getAllProducts($per_page, $offset, $category_id, $search, $sort);
$total_products = $product->getProductsCount($category_id, $search);
$total_pages = ceil($total_products / $per_page);

// Get featured products
$featured_products = $product->getAllProducts(4, 0, null, null, true);

// Get categories
$database = new Database();
$conn = $database->getConnection();
$categories_stmt = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get popular products (most downloaded)
$popular_products = $product->getPopularProducts(4);

// Build query parameters for pagination
$query_params = [];
if ($search) $query_params['search'] = $search;
if ($category_id) $query_params['category'] = $category_id;
if ($sort != 'newest') $query_params['sort'] = $sort;

include 'includes/header.php';
?>

<!-- Hero Section -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">Discover our premium digital products collection</p>
            <div class="mt-4">
                <form class="d-flex justify-content-center" method="GET" action="products.php">
                    <div class="input-group" style="max-width: 500px;">
                        <input type="text" name="search" class="form-control form-control-lg" 
                               placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Categories -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mb-3 mb-md-0">
                <div class="d-flex flex-wrap gap-2">
                    <a href="products.php" class="btn btn-sm btn-outline-dark rounded-pill px-3 <?php echo !$category_id ? 'active bg-dark text-white' : ''; ?>">
                        <i class="fas fa-th-large me-1"></i> All Products
                    </a>
                    <?php foreach ($categories as $cat): 
                        $count = $product->getProductsCount($cat['id']);
                    ?>
                        <a href="products.php?category=<?php echo $cat['id']; ?>" 
                           class="btn btn-sm btn-outline-dark rounded-pill px-3 <?php echo $category_id == $cat['id'] ? 'active bg-dark text-white' : ''; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                            <span class="badge bg-secondary ms-1 rounded-pill"><?php echo $count; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-md-end">
                    <span class="text-muted small me-2 d-none d-md-block">Sort by:</span>
                    <select class="form-select form-select-sm" style="max-width: 200px;" onchange="window.location.href=this.value">
                        <option value="?sort=newest<?php echo $category_id ? '&category='.$category_id : ''; ?>" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest</option>
                        <option value="?sort=price_asc<?php echo $category_id ? '&category='.$category_id : ''; ?>" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="?sort=price_desc<?php echo $category_id ? '&category='.$category_id : ''; ?>" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="?sort=popular<?php echo $category_id ? '&category='.$category_id : ''; ?>" <?php echo $sort === 'popular' ? 'selected' : ''; ?>>Most Popular</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<?php if (!empty($featured_products) && $page == 1 && !$search && !$category_id): ?>
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5">
        <h2 class="fw-bolder mb-4">Featured Products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4">
            <?php foreach ($featured_products as $item): 
                $sale_badge = $item['sale_price'] ? 
                    '<div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>' : '';
                $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                $original_price = $item['sale_price'] ? 
                    '<span class="text-muted text-decoration-line-through">$' . number_format($item['price'], 2) . '</span> ' : '';
            ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Sale badge-->
                    <?php echo $sale_badge; ?>
                    <!-- Product image-->
                    <img class="card-img-top" src="https://via.placeholder.com/450x300?text=<?php echo urlencode($item['title']); ?>" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <!-- Product price-->
                            <?php echo $original_price; ?>
                            $<?php echo number_format($price, 2); ?>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-outline-dark mt-auto" href="product.php?slug=<?php echo $item['slug']; ?>">
                                <i class="bi-cart-fill me-1"></i> Add to cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Products Grid -->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <?php if (!empty($products)): ?>
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4">
                <?php foreach ($products as $item): 
                    $sale_badge = $item['sale_price'] ? 
                        '<div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>' : '';
                    $new_badge = (strtotime($item['created_at']) > strtotime('-7 days')) ? 
                        '<div class="badge bg-success text-white position-absolute" style="top: 0.5rem; left: 0.5rem">New</div>' : '';
                    $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                    $original_price = $item['sale_price'] ? 
                        '<span class="text-muted text-decoration-line-through">$' . number_format($item['price'], 2) . '</span> ' : '';
                ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product badges -->
                        <?php echo $sale_badge . $new_badge; ?>
                        
                        <!-- Product image -->
                        <div class="position-relative" style="height: 200px; overflow: hidden;">
                            <img class="card-img-top h-100 w-100" 
                                 src="https://via.placeholder.com/450x300?text=<?php echo urlencode($item['title']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>"
                                 style="object-fit: cover;">
                            <!-- Quick view overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                 style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s;">
                                <a href="product.php?slug=<?php echo $item['slug']; ?>" 
                                   class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-eye me-1"></i> Quick View
                                </a>
                            </div>
                        </div>
                        
                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Category -->
                                <div class="small text-muted mb-2">
                                    <?php echo htmlspecialchars($item['category_name'] ?? 'Digital Product'); ?>
                                </div>
                                
                                <!-- Product name -->
                                <h5 class="fw-bolder">
                                    <a href="product.php?slug=<?php echo $item['slug']; ?>" 
                                       class="text-dark text-decoration-none">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </a>
                                </h5>
                                
                                <!-- Product reviews -->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <?php 
                                    $rating = $item['rating'] ?? rand(30, 50) / 10; // Random rating between 3.0 and 5.0
                                    $full_stars = floor($rating);
                                    $half_star = $rating - $full_stars >= 0.5 ? 1 : 0;
                                    $empty_stars = 5 - $full_stars - $half_star;
                                    
                                    echo str_repeat('<i class="fas fa-star"></i>', $full_stars);
                                    echo $half_star ? '<i class="fas fa-star-half-alt"></i>' : '';
                                    echo str_repeat('<i class="far fa-star"></i>', $empty_stars);
                                    ?>
                                    <span class="text-muted ms-1">(<?php echo $item['review_count'] ?? rand(5, 150); ?>)</span>
                                </div>
                                
                                <!-- Product price -->
                                <div class="h5 mb-0">
                                    <?php echo $original_price; ?>
                                    <span class="text-primary">$<?php echo number_format($price, 2); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product actions -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="d-grid gap-2">
                                <a class="btn btn-outline-dark mt-auto" href="#" onclick="addToCart(<?php echo $item['id']; ?>); return false;">
                                    <i class="fas fa-shopping-cart me-1"></i> Add to cart
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="addToWishlist(<?php echo $item['id']; ?>); return false;">
                                    <i class="far fa-heart"></i> Add to wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): 
                            $prev_params = $query_params;
                            $prev_params['page'] = $page - 1;
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?php echo http_build_query($prev_params); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
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
                            if ($start_page > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
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
                            if ($end_page < $total_pages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
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
                                <a class="page-link" href="?<?php echo http_build_query($next_params); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- No Products Found -->
            <div class="text-center py-5 my-5">
                <div class="py-5 my-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3>No products found</h3>
                    <p class="text-muted">We couldn't find any products matching your criteria.</p>
                    <a href="products.php" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-2"></i> Back to Shop
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
            <h2 class="fw-bolder mb-4">Subscribe to our newsletter</h2>
            <p class="lead mb-4">Get the latest updates on new products and upcoming sales</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email" aria-describedby="button-subscribe">
                        <button class="btn btn-primary" type="button" id="button-subscribe">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5
            <div class="col-md-4 mb-5">
                <div class="card h-100 border-0">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-gradient text-white rounded-circle p-3 d-inline-block mb-3">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                        <h5 class="card-title">Fast & Free Delivery</h5>
                        <p class="card-text text-muted">Free delivery on all orders over $50</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card h-100 border-0">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-gradient text-white rounded-circle p-3 d-inline-block mb-3">
                            <i class="fas fa-undo-alt fa-2x"></i>
                        </div>
                        <h5 class="card-title">Easy Returns</h5>
                        <p class="card-text text-muted">30-day return policy on all products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card h-100 border-0">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-gradient text-white rounded-circle p-3 d-inline-block mb-3">
                            <i class="fas fa-headset fa-2x"></i>
                        </div>
                        <h5 class="card-title">24/7 Support</h5>
                        <p class="card-text text-muted">Dedicated support for all customers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Product Card Hover Effects */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 0.5rem;
    overflow: hidden;
    height: 100%;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-img-top {
    transition: transform 0.5s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

/* Hover effect for quick view */
.position-relative:hover .position-absolute {
    opacity: 1 !important;
}

/* Button hover effects */
.btn-outline-dark:hover {
    background-color: #212529;
    color: #fff;
}

/* Custom checkbox for wishlist */
.wishlist-checkbox {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.wishlist-label {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.3s;
    z-index: 1;
}

.wishlist-checkbox:checked + .wishlist-label {
    color: #dc3545;
}

/* Price styling */
.text-primary {
    color: #0d6efd !important;
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .card-body {
        padding: 1rem !important;
    }
    
    .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
}

/* Animation for add to cart */
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
    40% {transform: translateY(-10px);}
    60% {transform: translateY(-5px);}
}

.add-to-cart-animation {
    animation: bounce 1s;
}
</style>

<script>
// Add to cart function
function addToCart(productId) {
    // Here you would typically make an AJAX call to add the product to cart
    console.log('Added to cart:', productId);
    
    // Show success message
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-success text-white rounded-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = 'Product added to cart!';
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
    
    // Add animation to the button
    const button = event.target.closest('.btn');
    if (button) {
        button.classList.add('add-to-cart-animation');
        setTimeout(() => {
            button.classList.remove('add-to-cart-animation');
        }, 1000);
    }
}

// Add to wishlist function
function addToWishlist(productId) {
    // Here you would typically make an AJAX call to add the product to wishlist
    console.log('Added to wishlist:', productId);
    
    // Toggle heart icon
    const button = event.target.closest('button');
    if (button) {
        const icon = button.querySelector('i');
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas', 'text-danger');
            
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-success text-white rounded-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = 'Added to wishlist!';
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        } else {
            icon.classList.remove('fas', 'text-danger');
            icon.classList.add('far');
        }
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include 'includes/footer.php'; ?>
