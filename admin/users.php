<?php
$page_title = 'Manage Users';
$page_description = 'AA DIGITS Admin - Manage Users';

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

// Get users
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $search = $_GET['search'] ?? '';
    $role_filter = $_GET['role'] ?? '';
    $page = max(1, (int)($_GET['page'] ?? 1));
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    
    $query = "
        SELECT u.*, 
               COUNT(DISTINCT o.id) as order_count,
               COALESCE(SUM(o.final_amount), 0) as total_spent
        FROM users u 
        LEFT JOIN orders o ON u.id = o.user_id AND o.payment_status = 'completed'
        WHERE 1=1
    ";
    
    $params = [];
    
    if ($search) {
        $query .= " AND (u.name LIKE ? OR u.email LIKE ?)";
        $search_term = "%$search%";
        $params[] = $search_term;
        $params[] = $search_term;
    }
    
    if ($role_filter) {
        $query .= " AND u.role = ?";
        $params[] = $role_filter;
    }
    
    $query .= " GROUP BY u.id ORDER BY u.created_at DESC LIMIT ? OFFSET ?";
    $params[] = (int)$per_page;
    $params[] = (int)$offset;
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll();
    
} catch (Exception $e) {
    $users = [];
    $message = 'Error loading users: ' . $e->getMessage();
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
            <a href="orders.php" class="admin-nav-item">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
            </a>
            <a href="users.php" class="admin-nav-item active">
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
            <h1>Manage Users</h1>
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
                            <input type="text" name="search" placeholder="Search users..." 
                                   value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="role" class="form-control">
                                <option value="">All Roles</option>
                                <option value="user" <?php echo $role_filter === 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="super_admin" <?php echo $role_filter === 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
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

        <!-- Users Table -->
        <div class="admin-card">
            <div class="admin-card-content">
                <?php if (!empty($users)): ?>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Orders</th>
                                    <th>Total Spent</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user_item): ?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong><?php echo htmlspecialchars($user_item['name']); ?></strong>
                                                <small><?php echo htmlspecialchars($user_item['email']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role-badge role-<?php echo $user_item['role']; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $user_item['role'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $user_item['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $user_item['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                        <?php if ($user_item['email_verified']): ?>
                                            <br><span class="status-badge status-verified">Verified</span>
                                        <?php else: ?>
                                            <br><span class="status-badge status-unverified">Unverified</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo number_format($user_item['order_count']); ?></td>
                                    <td>$<?php echo number_format($user_item['total_spent'], 2); ?></td>
                                    <td><?php echo time_ago($user_item['created_at']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline" onclick="viewUser(<?php echo $user_item['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if ($user_item['id'] != $_SESSION['user_id']): ?>
                                                <button class="btn btn-sm btn-secondary" onclick="toggleUserStatus(<?php echo $user_item['id']; ?>, <?php echo $user_item['is_active'] ? 'false' : 'true'; ?>)">
                                                    <i class="fas fa-<?php echo $user_item['is_active'] ? 'ban' : 'check'; ?>"></i>
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
                        <i class="fas fa-users fa-3x" style="color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <h3>No Users Found</h3>
                        <p>No users match your current filters.</p>
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

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.user-info strong {
    display: block;
    color: var(--text-primary);
}

.user-info small {
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

.status-verified {
    background: #dbeafe;
    color: #1e40af;
}

.status-unverified {
    background: #fef3c7;
    color: #92400e;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.role-user {
    background: #f3f4f6;
    color: #374151;
}

.role-admin {
    background: #fbbf24;
    color: #92400e;
}

.role-super_admin {
    background: #dc2626;
    color: white;
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
function viewUser(userId) {
    alert('User details view coming soon! User ID: ' + userId);
}

function toggleUserStatus(userId, newStatus) {
    if (confirm('Are you sure you want to ' + (newStatus === 'true' ? 'activate' : 'deactivate') + ' this user?')) {
        alert('User status toggle coming soon! User ID: ' + userId + ', New Status: ' + newStatus);
    }
}
</script>

<?php include '../includes/footer.php'; ?>
