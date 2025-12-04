<?php
$page_title = 'Manage Orders';
$page_description = 'AA DIGITS Admin - Manage Orders';

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

// Get orders
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $status_filter = $_GET['status'] ?? '';
    $search = $_GET['search'] ?? '';
    $page = max(1, (int)($_GET['page'] ?? 1));
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    $query = "
        SELECT o.*, u.name as user_name, u.email as user_email,
               COUNT(oi.id) as item_count
        FROM orders o 
        LEFT JOIN users u ON o.user_id = u.id 
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE 1=1
    ";
    
    $params = [];
    
    if ($status_filter) {
        $query .= " AND o.payment_status = ?";
        $params[] = $status_filter;
    }
    
    if ($search) {
        $query .= " AND (o.order_number LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";
        $search_term = "%$search%";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
    }
    
    $query .= " GROUP BY o.id ORDER BY o.created_at DESC LIMIT ? OFFSET ?";
    $params[] = (int)$per_page;
    $params[] = (int)$offset;
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $orders = $stmt->fetchAll();
    
} catch (Exception $e) {
    $orders = [];
    $message = 'Error loading orders: ' . $e->getMessage();
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
            <a href="categories.php" class="admin-nav-item">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </a>
            <a href="orders.php" class="admin-nav-item active">
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
            <h1>Manage Orders</h1>
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
                            <input type="text" name="search" placeholder="Search orders, customers..." 
                                   value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="failed" <?php echo $status_filter === 'failed' ? 'selected' : ''; ?>>Failed</option>
                                <option value="refunded" <?php echo $status_filter === 'refunded' ? 'selected' : ''; ?>>Refunded</option>
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

        <!-- Orders Table -->
        <div class="admin-card">
            <div class="admin-card-content">
                <?php if (!empty($orders)): ?>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <strong>#<?php echo htmlspecialchars($order['order_number']); ?></strong>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <strong><?php echo htmlspecialchars($order['user_name'] ?? 'Guest'); ?></strong>
                                            <small><?php echo htmlspecialchars($order['user_email'] ?? ''); ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo $order['item_count']; ?> items</td>
                                    <td>
                                        <div class="amount-info">
                                            <strong>$<?php echo number_format($order['final_amount'], 2); ?></strong>
                                            <?php if ($order['discount_amount'] > 0): ?>
                                                <small class="text-success">-$<?php echo number_format($order['discount_amount'], 2); ?> discount</small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['payment_status']; ?>">
                                            <?php echo ucfirst($order['payment_status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['status']; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo time_ago($order['created_at']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline" onclick="viewOrder(<?php echo $order['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if ($order['payment_status'] === 'completed'): ?>
                                                <button class="btn btn-sm btn-success" onclick="alert('Download links sent!')">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-shopping-cart fa-3x" style="color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <h3>No Orders Found</h3>
                        <p>No orders match your current filters.</p>
                    </div>
                <?php endif; ?>
            </div>
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

.customer-info strong {
    display: block;
    color: var(--text-primary);
}

.customer-info small {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.amount-info strong {
    display: block;
    color: var(--text-primary);
}

.amount-info small {
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

.status-refunded {
    background: #f3f4f6;
    color: #374151;
}

.status-processing {
    background: #dbeafe;
    color: #1e40af;
}

.status-cancelled {
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

.text-success {
    color: #059669;
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
function viewOrder(orderId) {
    alert('Order details view coming soon! Order ID: ' + orderId);
}
</script>

<?php include '../includes/footer.php'; ?>
