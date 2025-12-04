<?php
$page_title = 'My Profile';
$page_description = 'Manage your AA DIGITS account, view your orders, and update your profile information.';

require_once 'config/config.php';
require_once 'classes/User.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
}

$user = new User();
$message = '';
$success = '';

// Get user data
try {
    $user_data = $user->getUserById($_SESSION['user_id']);
    if (!$user_data) {
        handle_error('User not found.', 'login.php');
    }
} catch (Exception $e) {
    handle_error('Error loading profile.', 'index.php');
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    
    if (empty($name) || empty($email)) {
        $message = 'Name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        try {
            if ($user->updateProfile($_SESSION['user_id'], $name, $email, $phone)) {
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $success = 'Profile updated successfully!';
                $user_data['name'] = $name;
                $user_data['email'] = $email;
                $user_data['phone'] = $phone;
            } else {
                $message = 'Failed to update profile.';
            }
        } catch (Exception $e) {
            $message = 'Error updating profile: ' . $e->getMessage();
        }
    }
}

// Get user orders (mock data for now)
$recent_orders = [
    [
        'id' => 1,
        'order_number' => 'ORD-001',
        'date' => '2025-11-15',
        'total' => 49.99,
        'status' => 'completed',
        'items' => 'Modern Website Template'
    ],
    [
        'id' => 2,
        'order_number' => 'ORD-002',
        'date' => '2025-11-10',
        'total' => 79.99,
        'status' => 'completed',
        'items' => 'Mobile App UI Kit'
    ]
];

include 'includes/header.php';
?>

<div class="profile-header">
    <div class="container">
        <div class="profile-header-content">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1>Welcome back, <?php echo htmlspecialchars($user_data['name']); ?>!</h1>
                <p>Manage your account and view your digital products</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="profile-section">
        <div class="profile-sidebar">
            <nav class="profile-nav">
                <a href="#profile" class="nav-item active" onclick="showTab('profile')">
                    <i class="fas fa-user"></i>
                    Profile Information
                </a>
                <a href="#orders" class="nav-item" onclick="showTab('orders')">
                    <i class="fas fa-shopping-bag"></i>
                    My Orders
                </a>
                <a href="#downloads" class="nav-item" onclick="showTab('downloads')">
                    <i class="fas fa-download"></i>
                    Downloads
                </a>
                <a href="#settings" class="nav-item" onclick="showTab('settings')">
                    <i class="fas fa-cog"></i>
                    Account Settings
                </a>
                <?php if (is_admin()): ?>
                <a href="admin/" class="nav-item admin-link">
                    <i class="fas fa-tachometer-alt"></i>
                    Admin Dashboard
                </a>
                <?php endif; ?>
                <a href="logout.php" class="nav-item logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </div>
        
        <div class="profile-content">
            <!-- Profile Information Tab -->
            <div id="profile-tab" class="tab-content active">
                <div class="content-header">
                    <h2>Profile Information</h2>
                    <p>Update your personal information and contact details</p>
                </div>
                
                <?php if ($message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="profile-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo htmlspecialchars($user_data['name']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo htmlspecialchars($user_data['email']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>"
                               placeholder="Enter your phone number">
                    </div>
                    
                    <div class="form-group">
                        <label>Account Type</label>
                        <div class="account-type">
                            <span class="role-badge role-<?php echo $_SESSION['user_role']; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $_SESSION['user_role'])); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Member Since</label>
                        <div class="member-since">
                            <?php echo date('F j, Y', strtotime($user_data['created_at'])); ?>
                        </div>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Profile
                    </button>
                </form>
            </div>
            
            <!-- Orders Tab -->
            <div id="orders-tab" class="tab-content">
                <div class="content-header">
                    <h2>My Orders</h2>
                    <p>View your order history and download purchased products</p>
                </div>
                
                <?php if (!empty($recent_orders)): ?>
                    <div class="orders-list">
                        <?php foreach ($recent_orders as $order): ?>
                            <div class="order-item">
                                <div class="order-header">
                                    <div class="order-number">
                                        <strong><?php echo $order['order_number']; ?></strong>
                                        <span class="order-date"><?php echo date('M j, Y', strtotime($order['date'])); ?></span>
                                    </div>
                                    <div class="order-status">
                                        <span class="status-badge status-<?php echo $order['status']; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="order-details">
                                    <div class="order-items">
                                        <strong><?php echo htmlspecialchars($order['items']); ?></strong>
                                    </div>
                                    <div class="order-total">
                                        $<?php echo number_format($order['total'], 2); ?>
                                    </div>
                                </div>
                                <div class="order-actions">
                                    <button class="btn btn-outline btn-sm" onclick="alert('View order details coming soon!')">
                                        View Details
                                    </button>
                                    <?php if ($order['status'] === 'completed'): ?>
                                        <button class="btn btn-primary btn-sm" onclick="alert('Download feature coming soon!')">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-orders">
                        <i class="fas fa-shopping-bag fa-3x"></i>
                        <h3>No orders yet</h3>
                        <p>You haven't made any purchases yet. Start shopping to see your orders here.</p>
                        <a href="products.php" class="btn btn-primary">Browse Products</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Downloads Tab -->
            <div id="downloads-tab" class="tab-content">
                <div class="content-header">
                    <h2>My Downloads</h2>
                    <p>Access all your purchased digital products</p>
                </div>
                
                <div class="downloads-list">
                    <div class="download-item">
                        <div class="download-icon">
                            <i class="fas fa-file-code"></i>
                        </div>
                        <div class="download-info">
                            <h3>Modern Website Template</h3>
                            <p>Purchased on Nov 15, 2025</p>
                            <span class="download-size">15.2 MB</span>
                        </div>
                        <div class="download-actions">
                            <button class="btn btn-primary btn-sm" onclick="alert('Download feature coming soon!')">
                                <i class="fas fa-download"></i>
                                Download
                            </button>
                        </div>
                    </div>
                    
                    <div class="download-item">
                        <div class="download-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="download-info">
                            <h3>Mobile App UI Kit</h3>
                            <p>Purchased on Nov 10, 2025</p>
                            <span class="download-size">28.7 MB</span>
                        </div>
                        <div class="download-actions">
                            <button class="btn btn-primary btn-sm" onclick="alert('Download feature coming soon!')">
                                <i class="fas fa-download"></i>
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Settings Tab -->
            <div id="settings-tab" class="tab-content">
                <div class="content-header">
                    <h2>Account Settings</h2>
                    <p>Manage your account preferences and security settings</p>
                </div>
                
                <div class="settings-sections">
                    <div class="settings-section">
                        <h3>Change Password</h3>
                        <p>Update your password to keep your account secure</p>
                        <button class="btn btn-outline" onclick="alert('Change password feature coming soon!')">
                            Change Password
                        </button>
                    </div>
                    
                    <div class="settings-section">
                        <h3>Email Notifications</h3>
                        <p>Choose what email notifications you'd like to receive</p>
                        <div class="notification-options">
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                Order confirmations
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                Product updates
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox">
                                Marketing emails
                            </label>
                        </div>
                    </div>
                    
                    <div class="settings-section danger-zone">
                        <h3>Danger Zone</h3>
                        <p>Permanently delete your account and all associated data</p>
                        <button class="btn btn-danger" onclick="alert('Delete account feature coming soon!')">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 3rem 0;
}

.profile-header-content {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.profile-info h1 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.profile-info p {
    opacity: 0.9;
}

.profile-section {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 3rem;
    padding: 3rem 0;
}

.profile-sidebar {
    background: var(--bg-secondary);
    border-radius: 12px;
    padding: 1.5rem;
    height: fit-content;
    position: sticky;
    top: 2rem;
    border: 1px solid var(--border-color);
}

.profile-nav {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-item:hover,
.nav-item.active {
    background: var(--primary-color);
    color: white;
}

.nav-item.admin-link {
    border-top: 1px solid var(--border-color);
    margin-top: 0.5rem;
    padding-top: 1rem;
}

.nav-item.logout-link {
    color: #dc2626;
    border-top: 1px solid var(--border-color);
    margin-top: 0.5rem;
    padding-top: 1rem;
}

.nav-item.logout-link:hover {
    background: #dc2626;
    color: white;
}

.profile-content {
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.tab-content {
    display: none;
    padding: 2rem;
}

.tab-content.active {
    display: block;
}

.content-header {
    margin-bottom: 2rem;
}

.content-header h2 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.content-header p {
    color: var(--text-secondary);
}

.profile-form {
    max-width: 600px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-primary);
    color: var(--text-primary);
}

.account-type,
.member-since {
    padding: 0.75rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-secondary);
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

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.order-item {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.order-date {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-left: 1rem;
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

.order-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.order-total {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary-color);
}

.order-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.downloads-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.download-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
}

.download-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.download-info {
    flex: 1;
}

.download-info h3 {
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.download-info p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.download-size {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

.settings-sections {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.settings-section {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
}

.settings-section h3 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.settings-section p {
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.notification-options {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-primary);
    cursor: pointer;
}

.danger-zone {
    border-color: #fecaca;
    background: #fef2f2;
}

.danger-zone h3 {
    color: #dc2626;
}

.no-orders {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary);
}

.no-orders i {
    margin-bottom: 1rem;
    opacity: 0.5;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .profile-header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .profile-section {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .profile-sidebar {
        position: static;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .order-header,
    .order-details {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .download-item {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
function showTab(tabName) {
    // Hide all tabs
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Remove active class from all nav items
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => item.classList.remove('active'));
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked nav item
    event.target.classList.add('active');
}
</script>

<?php include 'includes/footer.php'; ?>
