<?php
// Simple redirect to working dashboard
header('Location: dashboard.php');
exit();

// Initialize classes
$product = new Product();
$user = new User();

// Get dashboard statistics
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Get total counts
    $total_products = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $total_users = $conn->query("SELECT COUNT(*) FROM users WHERE is_admin = 0")->fetchColumn();
    $total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    $total_revenue = $conn->query("SELECT COALESCE(SUM(final_amount), 0) FROM orders WHERE payment_status = 'completed'")->fetchColumn();
    
    // Get recent products
    $recent_products = $product->getAllProducts(5, 0);
    
    // Get recent orders
    $recent_orders_stmt = $conn->query("
        SELECT o.*, u.name as user_name, u.email as user_email 
        FROM orders o 
        LEFT JOIN users u ON o.user_id = u.id 
        ORDER BY o.created_at DESC 
        LIMIT 5
    ");
    $recent_orders = $recent_orders_stmt->fetchAll();
    
} catch (Exception $e) {
    $total_products = $total_users = $total_orders = $total_revenue = 0;
    $recent_products = $recent_orders = [];
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
            <a href="index.php" class="admin-nav-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="products.php" class="admin-nav-item">
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
            <a href="coupons.php" class="admin-nav-item">
                <i class="fas fa-ticket-alt"></i>
                <span>Coupons</span>
            </a>
            <a href="support.php" class="admin-nav-item">
                <i class="fas fa-life-ring"></i>
                <span>Support</span>
            </a>
            <a href="settings.php" class="admin-nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
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
            <h1>Dashboard</h1>
            <div class="admin-header-actions">
                <button class="btn btn-primary" onclick="location.href='products.php?action=add'">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($total_products); ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($total_users); ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo number_format($total_orders); ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <h3>$<?php echo number_format($total_revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="admin-grid">
            <!-- Recent Products -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Recent Products</h3>
                    <a href="products.php" class="btn btn-sm btn-outline">View All</a>
                </div>
                <div class="admin-card-content">
                    <?php if (!empty($recent_products)): ?>
                        <div class="admin-table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_products as $product_item): ?>
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <strong><?php echo htmlspecialchars($product_item['title']); ?></strong>
                                                <small><?php echo htmlspecialchars($product_item['category_name'] ?? 'No Category'); ?></small>
                                            </div>
                                        </td>
                                        <td>$<?php echo number_format($product_item['price'], 2); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $product_item['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $product_item['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo time_ago($product_item['created_at']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="no-data">No products found. <a href="products.php?action=add">Add your first product</a></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Recent Orders</h3>
                    <a href="orders.php" class="btn btn-sm btn-outline">View All</a>
                </div>
                <div class="admin-card-content">
                    <?php if (!empty($recent_orders)): ?>
                        <div class="admin-table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo htmlspecialchars($order['order_number']); ?></td>
                                        <td>
                                            <div class="customer-info">
                                                <strong><?php echo htmlspecialchars($order['user_name'] ?? 'Guest'); ?></strong>
                                                <small><?php echo htmlspecialchars($order['user_email'] ?? ''); ?></small>
                                            </div>
                                        </td>
                                        <td>$<?php echo number_format($order['final_amount'], 2); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $order['payment_status']; ?>">
                                                <?php echo ucfirst($order['payment_status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="no-data">No orders yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Admin Dashboard Styles */
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

.admin-header h1 {
    color: var(--text-primary);
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.stat-content p {
    color: var(--text-secondary);
    margin: 0;
}

.admin-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.admin-card {
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.admin-card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-card-header h3 {
    margin: 0;
    color: var(--text-primary);
}

.admin-card-content {
    padding: 1.5rem;
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

.product-info strong,
.customer-info strong {
    display: block;
    color: var(--text-primary);
}

.product-info small,
.customer-info small {
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

.status-completed {
    background: #dcfce7;
    color: #166534;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-failed {
    background: #fee2e2;
    color: #991b1b;
}

.no-data {
    text-align: center;
    color: var(--text-secondary);
    padding: 2rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    
    .admin-main {
        margin-left: 0;
        padding: 1rem;
    }
    
    .admin-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
}
</style>

<?php include '../includes/footer.php'; ?>
