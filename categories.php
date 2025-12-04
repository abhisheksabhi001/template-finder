<?php
$page_title = 'Categories';
$page_description = 'Browse all product categories at AA DIGITS - Find the perfect digital products for your needs.';

require_once 'config/config.php';

// Get categories from database
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->query("
        SELECT c.*, COUNT(p.id) as product_count 
        FROM categories c 
        LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
        WHERE c.is_active = 1 
        GROUP BY c.id 
        ORDER BY c.name ASC
    ");
    $categories = $stmt->fetchAll();
} catch (Exception $e) {
    $categories = [];
}

include 'includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Product Categories</h1>
        <p>Explore our diverse range of digital products organized by category</p>
    </div>
</div>

<div class="container">
    <div class="categories-section">
        <?php if (!empty($categories)): ?>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-<?php echo $category['icon'] ?? 'folder'; ?>"></i>
                        </div>
                        <div class="category-content">
                            <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                            <p><?php echo htmlspecialchars($category['description']); ?></p>
                            <div class="category-stats">
                                <span class="product-count"><?php echo $category['product_count']; ?> Products</span>
                            </div>
                            <a href="products.php?category=<?php echo $category['slug'] ?? $category['id']; ?>" class="category-link">
                                Browse Products <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-categories">
                <i class="fas fa-tags fa-3x"></i>
                <h3>No Categories Available</h3>
                <p>Categories will appear here once they are added.</p>
                <a href="products.php" class="btn btn-primary">Browse All Products</a>
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

.categories-section {
    padding: 4rem 0;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.category-card {
    background: var(--bg-secondary);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-color);
}

.category-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.category-content h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.category-content p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.category-stats {
    margin-bottom: 1.5rem;
}

.product-count {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.category-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.category-link:hover {
    color: var(--secondary-color);
    transform: translateX(5px);
}

.no-categories {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.no-categories i {
    margin-bottom: 2rem;
    opacity: 0.5;
}

.no-categories h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 2rem 0;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .category-card {
        padding: 1.5rem;
    }
    
    .category-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
