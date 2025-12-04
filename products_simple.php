<?php
$page_title = 'Premium Digital Products';
$page_description = 'Discover our hand-picked selection of premium digital products and templates.';
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
    --bg-secondary: #faf5ff !important;
    --bg-tertiary: #f3e8ff !important;
}

/* Override white backgrounds */
.card {
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%) !important;
    border: 1px solid #e9d5ff !important;
}

.bg-white {
    background-color: #faf5ff !important;
}

/* Product cards */
.product-card {
    background: linear-gradient(135deg, #ffffff 0%, #faf5ff 100%) !important;
    border: 1px solid #e9d5ff !important;
    transition: all 0.3s ease !important;
}

.product-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 10px 30px rgba(124, 58, 237, 0.2) !important;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
    border-color: #7c3aed !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #6d28d9, #5b21b6) !important;
    border-color: #6d28d9 !important;
}
</style>
<?php
require_once 'config/config.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section bg-dark text-white py-6 position-relative" style="background: linear-gradient(rgba(124, 58, 237, 0.9), rgba(109, 40, 217, 0.9)), url('assets/images/hero-bg.jpg') center/cover no-repeat;">
    <div class="container py-5">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Premium Digital Products</h1>
                <p class="lead mb-4">Hand-picked selection of the best templates and digital assets</p>
            </div>
        </div>
    </div>
</section>

<!-- Simple Products Grid -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
            <p class="lead text-muted">Choose from our curated collection</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Product 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 product-card shadow-sm border-0">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/7c3aed/ffffff?text=Business+Template" 
                             class="card-img-top" alt="Business Template">
                        <span class="badge bg-primary position-absolute top-0 start-0 m-2">Popular</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Modern Business Template</h5>
                        <p class="card-text text-muted small">Professional business website with modern design</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">$29.99</span>
                            <a href="index.php#template-showcase" class="btn btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 product-card shadow-sm border-0">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/14b8a6/ffffff?text=Portfolio+Template" 
                             class="card-img-top" alt="Portfolio Template">
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">New</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Creative Portfolio</h5>
                        <p class="card-text text-muted small">Stunning portfolio for creative professionals</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">$24.99</span>
                            <a href="index.php#template-showcase" class="btn btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 product-card shadow-sm border-0">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/f97316/ffffff?text=E-commerce+Template" 
                             class="card-img-top" alt="E-commerce Template">
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Featured</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">E-commerce Pro</h5>
                        <p class="card-text text-muted small">Complete online store with shopping cart</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">$39.99</span>
                            <a href="index.php#template-showcase" class="btn btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-muted">Need more options? <a href="index.php#template-showcase" class="text-primary">Browse all templates</a></p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
