<?php
$page_title = 'Manage Products';
$page_description = 'AA DIGITS Admin - Manage Products';

require_once '../config/config.php';
require_once '../classes/User.php';
require_once '../classes/Product.php';

// Check if user is logged in and is admin
if (!is_logged_in()) {
    redirect('../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
}

if (!is_admin()) {
    handle_error('Access denied. Admin privileges required.', '../login.php');
}

// Initialize classes
$product = new Product();

// Handle actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'delete' && isset($_POST['product_id'])) {
        try {
            if ($product->deleteProduct($_POST['product_id'])) {
                $message = 'Product deleted successfully!';
            } else {
                $message = 'Failed to delete product.';
            }
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
}

// Get products
try {
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    $page = max(1, (int)($_GET['page'] ?? 1));
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    $products = $product->getAllProducts($per_page, $offset, $search, $category);
    
    // Get categories for filter
    $database = new Database();
    $conn = $database->getConnection();
    $categories_stmt = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
    $categories = $categories_stmt->fetchAll();
    
} catch (Exception $e) {
    $products = [];
    $categories = [];
    $message = 'Error loading products: ' . $e->getMessage();
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
            <a href="products.php" class="admin-nav-item active">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>
            <a href="categories.php" class="admin-nav-item">
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
            <h1>Manage Products</h1>
            <div class="admin-header-actions">
                <button class="btn btn-primary" onclick="alert('Add Product feature coming soon!')">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="admin-card" style="margin-bottom: 2rem;">
            <div class="admin-card-content">
                <form method="GET" class="filters-form">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="search" placeholder="Search products..." 
                                   value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="category" class="form-control">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" 
                                            <?php echo $category == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Table -->
        <div class="admin-card">
            <div class="admin-card-content">
                <?php if (!empty($products)): ?>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Downloads</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product_item): ?>
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <strong><?php echo htmlspecialchars($product_item['title']); ?></strong>
                                            <small><?php echo htmlspecialchars(substr($product_item['short_description'] ?? '', 0, 60)); ?>...</small>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($product_item['category_name'] ?? 'No Category'); ?></td>
                                    <td>
                                        $<?php echo number_format($product_item['price'], 2); ?>
                                        <?php if ($product_item['sale_price']): ?>
                                            <br><small class="text-success">Sale: $<?php echo number_format($product_item['sale_price'], 2); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo number_format($product_item['downloads_count']); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $product_item['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $product_item['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                        <?php if ($product_item['is_featured']): ?>
                                            <br><span class="status-badge" style="background: #fbbf24; color: #92400e;">Featured</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo time_ago($product_item['created_at']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline" onclick="alert('Edit feature coming soon!')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $product_item['id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-box fa-3x" style="color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <h3>No Products Found</h3>
                        <p>No products match your current filters.</p>
                        <button class="btn btn-primary" onclick="alert('Add Product feature coming soon!')">
                            <i class="fas fa-plus"></i> Add Your First Product
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this product? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="product_id" id="deleteProductId">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<style>
/* Include admin styles from index.php */
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

.admin-card {
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.admin-card-content {
    padding: 1.5rem;
}

.filters-form .form-row {
    display: flex;
    gap: 1rem;
    align-items: end;
}

.form-group {
    flex: 1;
}

.admin-table-container {
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th,
.admin-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.admin-table th {
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.product-info strong {
    display: block;
    color: var(--text-primary);
}

.product-info small {
    color: var(--text-secondary);
    font-size: 0.875rem;
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

.action-buttons {
    display: flex;
    gap: 0.5rem;
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

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.modal-content {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    max-width: 400px;
    width: 90%;
}

.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
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
    
    .filters-form .form-row {
        flex-direction: column;
    }
}
</style>

<script>
function confirmDelete(productId) {
    document.getElementById('deleteProductId').value = productId;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
</script>

<?php include '../includes/footer.php'; ?>
