<?php
$page_title = 'Manage Categories';
$page_description = 'AA DIGITS Admin - Manage Categories';

require_once '../config/config.php';
require_once '../classes/User.php';

// Check if user is logged in and is admin
if (!is_logged_in()) {
    redirect('../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
}

if (!is_admin()) {
    handle_error('Access denied. Admin privileges required.', '../login.php');
}

$message = '';

// Get categories
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->query("
        SELECT c.*, 
               COUNT(p.id) as product_count 
        FROM categories c 
        LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
        GROUP BY c.id 
        ORDER BY c.sort_order, c.name
    ");
    $categories = $stmt->fetchAll();
    
} catch (Exception $e) {
    $categories = [];
    $message = 'Error loading categories: ' . $e->getMessage();
}

include '../includes/header.php';
?>

<div class="admin-container">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <i class="fas fa-cog"></i>
            <span>Admin Panel</span>
        </div>
        
        <nav class="admin-nav">
            <a href="index.php" class="admin-nav-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="products.php" class="admin-nav-item">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>
            <a href="categories.php" class="admin-nav-item active">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </a>
            <a href="orders.php" class="admin-nav-item">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
            </a>
            <a href="users.php" class="admin-nav-item">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
            <hr>
            <a href="../index.php" class="admin-nav-item">
                <i class="fas fa-home"></i>
                <span>View Site</span>
            </a>
            <a href="../logout.php" class="admin-nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Categories</h1>
            <div class="admin-header-actions">
                <button class="btn btn-primary" onclick="alert('Add Category feature coming soon!')">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Categories Grid -->
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="category-status">
                            <span class="status-badge <?php echo $category['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="category-content">
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description'] ?? 'No description'); ?></p>
                        
                        <div class="category-stats">
                            <div class="stat">
                                <i class="fas fa-box"></i>
                                <span><?php echo $category['product_count']; ?> Products</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-sort"></i>
                                <span>Order: <?php echo $category['sort_order']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="category-actions">
                        <button class="btn btn-sm btn-outline" onclick="alert('Edit feature coming soon!')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="viewProducts('<?php echo $category['slug']; ?>')">
                            <i class="fas fa-eye"></i> View Products
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($categories)): ?>
                <div class="no-data" style="grid-column: 1 / -1;">
                    <i class="fas fa-tags fa-3x" style="color: var(--text-secondary); margin-bottom: 1rem;"></i>
                    <h3>No Categories Found</h3>
                    <p>Create your first category to organize your products.</p>
                    <button class="btn btn-primary" onclick="alert('Add Category feature coming soon!')">
                        <i class="fas fa-plus"></i> Add Your First Category
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<style>
/* Include admin styles */
.admin-container {
    display: flex;
    min-height: 100vh;
    background: var(--bg-primary);
}

.admin-sidebar {
    width: 260px;
    background: var(--bg-secondary);
    border-right: 1px solid var(--border-color);
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
}

.admin-logo {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--primary-color);
}

.admin-nav {
    padding: 1rem 0;
}

.admin-nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.2s;
}

.admin-nav-item:hover,
.admin-nav-item.active {
    background: var(--primary-color);
    color: white;
}

.admin-main {
    flex: 1;
    margin-left: 260px;
    padding: 2rem;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.category-card {
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.category-header {
    padding: 1.5rem 1.5rem 0 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.category-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.category-content {
    padding: 1rem 1.5rem;
}

.category-content h3 {
    margin: 0 0 0.5rem 0;
    color: var(--text-primary);
    font-size: 1.25rem;
}

.category-content p {
    color: var(--text-secondary);
    margin: 0 0 1rem 0;
    font-size: 0.875rem;
    line-height: 1.5;
}

.category-stats {
    display: flex;
    gap: 1rem;
}

.stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.stat i {
    color: var(--primary-color);
}

.category-actions {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 0.75rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.no-data {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-info {
    background: #dbeafe;
    color: #1e40af;
    border: 1px solid #93c5fd;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
    }
    
    .admin-main {
        margin-left: 0;
        padding: 1rem;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
}
</style>

<script>
function viewProducts(categorySlug) {
    window.location.href = 'products.php?category=' + categorySlug;
}
</script>

<?php include '../includes/footer.php'; ?>
