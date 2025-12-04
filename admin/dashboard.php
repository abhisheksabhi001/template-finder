<?php
require_once '../config/config.php';
require_once '../config/database.php';

// Check if admin is logged in
if (!is_admin()) {
    header('Location: ../login.php');
    exit;
}

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Fetch real data from database
$stats = [
    'total_products' => 0,
    'total_users' => 0,
    'total_orders' => 0,
    'total_revenue' => 0,
    'pending_orders' => 0,
    'completed_orders' => 0,
    'low_stock_products' => 0
];

try {
    // Get total products
    $stmt = $db->query("SELECT COUNT(*) as count FROM products WHERE is_active = 1");
    $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get total users
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE is_admin = 0");
    $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get total orders
    $stmt = $db->query("SELECT COUNT(*) as count FROM orders");
    $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get total revenue
    $stmt = $db->query("SELECT SUM(final_amount) as total FROM orders WHERE status = 'completed'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['total_revenue'] = $result['total'] ?: 0;
    
    // Get pending orders
    $stmt = $db->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'");
    $stats['pending_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get completed orders
    $stmt = $db->query("SELECT COUNT(*) as count FROM orders WHERE status = 'completed'");
    $stats['completed_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get low stock products (assuming stock field exists)
    try {
        $stmt = $db->query("SELECT COUNT(*) as count FROM products WHERE stock <= 5 AND is_active = 1");
        $stats['low_stock_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    } catch (Exception $e) {
        $stats['low_stock_products'] = 0;
    }
    
    // Get recent orders
    $stmt = $db->query("SELECT o.*, u.name as customer_name, u.email as customer_email 
                       FROM orders o 
                       LEFT JOIN users u ON o.user_id = u.id 
                       ORDER BY o.created_at DESC LIMIT 5");
    $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get top products
    $stmt = $db->query("SELECT p.*, COUNT(oi.product_id) as sales_count 
                       FROM products p 
                       LEFT JOIN order_items oi ON p.id = oi.product_id 
                       LEFT JOIN orders o ON oi.order_id = o.id 
                       WHERE o.status = 'completed' 
                       GROUP BY p.id 
                       ORDER BY sales_count DESC LIMIT 5");
    $top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent users
    $stmt = $db->query("SELECT * FROM users WHERE is_admin = 0 ORDER BY created_at DESC LIMIT 5");
    $recent_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get monthly revenue data
    $stmt = $db->query("SELECT DATE_FORMAT(created_at, '%b') as month, SUM(final_amount) as revenue 
                       FROM orders 
                       WHERE status = 'completed' AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                       GROUP BY DATE_FORMAT(created_at, '%b'), MONTH(created_at) 
                       ORDER BY MONTH(created_at) LIMIT 6");
    $monthly_revenue = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log("Dashboard data fetch error: " . $e->getMessage());
    $recent_orders = [];
    $top_products = [];
    $recent_users = [];
    $monthly_revenue = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AA DIGITS - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #475569;
            --gray-700: #334155;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .admin-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card.primary { border-left-color: var(--primary); }
        .stat-card.success { border-left-color: var(--secondary); }
        .stat-card.warning { border-left-color: var(--warning); }
        .stat-card.danger { border-left-color: var(--danger); }
        
        .stat-card h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stat-card h3 i {
            font-size: 1.5rem;
            opacity: 0.9;
        }
        
        .stat-card p {
            color: var(--gray-600);
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .stat-card .stat-trend {
            margin-top: 0.75rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .trend-up { color: #10b981; }
        .trend-down { color: #ef4444; }
        
        .admin-nav {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        
        .nav-card {
            background: white;
            padding: 1.5rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            text-align: center;
            text-decoration: none;
            color: var(--dark);
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .nav-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }
        
        .nav-card i {
            font-size: 1.75rem;
            color: var(--primary);
            margin-bottom: 1rem;
            background: rgba(79, 70, 229, 0.1);
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .nav-card:hover i {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }
        
        .nav-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .nav-card p {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .card-header .view-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: color 0.2s;
        }
        
        .card-header .view-all:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .table thead {
            background-color: var(--gray-100);
        }
        
        .table th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        
        .table td {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--gray-200);
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: background-color 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: var(--gray-50);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        
        .status-active, .status-completed, .status-success {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-pending, .status-processing {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-cancelled, .status-failed, .status-declined {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-refunded {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .badge-primary {
            background-color: #e0e7ff;
            color: #4f46e5;
        }
        
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.9rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-name {
            font-weight: 500;
            color: var(--dark);
        }
        
        .user-email {
            font-size: 0.85rem;
            color: var(--gray-600);
        }
        
        .action-btn {
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .btn-outline {
            background-color: transparent;
            border-color: var(--gray-300);
            color: var(--gray-700);
        }
        
        .btn-outline:hover {
            background-color: var(--gray-100);
            border-color: var(--gray-400);
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin: 1.5rem 0;
        }
        
        .grid-12 { grid-column: span 12; }
        .grid-8 { grid-column: span 8; }
        .grid-6 { grid-column: span 6; }
        .grid-4 { grid-column: span 4; }
        .grid-3 { grid-column: span 3; }
        
        @media (max-width: 1200px) {
            .grid-8, .grid-6, .grid-4, .grid-3 {
                grid-column: span 12;
            }
        }
        
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        
        .text-muted {
            color: var(--gray-600);
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-5 { margin-bottom: 1.25rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-5 { margin-top: 1.25rem; }
        
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-5 { padding: 1.25rem; }
        
        .rounded { border-radius: 0.375rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-full { border-radius: 9999px; }
        
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .shadow { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        
        .logout-btn {
            background: white;
            color: var(--danger);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: 1px solid var(--gray-200);
        }
        
        .logout-btn:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-container {
                padding: 0 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .admin-nav {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .stats-grid,
            .admin-nav {
                grid-template-columns: 1fr;
            }
            
            .admin-header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
                text-align: center;
            }
            
            .logout-btn {
                position: static;
                margin-top: 0.5rem;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="admin-header">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard Overview</h1>
        <a href="../logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
    
    <div class="admin-container">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-xl mb-6 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Welcome back, Admin!</h2>
                    <p class="opacity-90">Here's what's happening with your store today.</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="text-xs bg-white/20 px-3 py-1 rounded-full">
                            <i class="fas fa-calendar-alt mr-1"></i> <?php echo date('l, F j, Y'); ?>
                        </span>
                        <span class="text-xs bg-white/20 px-3 py-1 rounded-full">
                            <i class="fas fa-clock mr-1"></i> <?php echo date('h:i A'); ?>
                        </span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <button onclick="refreshDashboard()" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i> Refresh
                    </button>
                    <a href="settings.php" class="bg-white text-indigo-600 hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="dashboard-grid">
            <!-- Quick Stats -->
            <div class="grid-12">
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <h3><i class="fas fa-shopping-cart"></i> <?php echo number_format($stats['total_orders']); ?></h3>
                        <p>Total Orders</p>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up trend-up"></i>
                            <span class="text-green-600"><?php echo $stats['pending_orders']; ?> pending</span>
                        </div>
                    </div>
                    <div class="stat-card success">
                        <h3><i class="fas fa-dollar-sign"></i> $<?php echo number_format($stats['total_revenue'], 2); ?></h3>
                        <p>Total Revenue</p>
                        <div class="stat-trend">
                            <i class="fas fa-check-circle trend-up"></i>
                            <span class="text-green-600"><?php echo $stats['completed_orders']; ?> completed</span>
                        </div>
                    </div>
                    <div class="stat-card warning">
                        <h3><i class="fas fa-users"></i> <?php echo number_format($stats['total_users']); ?></h3>
                        <p>Total Customers</p>
                        <div class="stat-trend">
                            <i class="fas fa-user-plus trend-up"></i>
                            <span class="text-green-600">Active users</span>
                        </div>
                    </div>
                    <div class="stat-card danger">
                        <h3><i class="fas fa-box"></i> <?php echo number_format($stats['total_products']); ?></h3>
                        <p>Products</p>
                        <div class="stat-trend">
                            <?php if ($stats['low_stock_products'] > 0): ?>
                                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                <span class="text-yellow-600"><?php echo $stats['low_stock_products']; ?> low stock</span>
                            <?php else: ?>
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span class="text-green-600">All stocked</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="grid-8">
                <!-- Revenue Chart -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-chart-line text-indigo-500"></i> Revenue Overview</h2>
                        <div class="flex gap-2">
                            <button class="btn-outline btn-sm">Week</button>
                            <button class="btn-outline btn-sm active">Month</button>
                            <button class="btn-outline btn-sm">Year</button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    
                    <!-- Additional Chart -->
                    <div class="card mt-6">
                        <div class="card-header">
                            <h2><i class="fas fa-chart-pie text-indigo-500"></i> Order Status Distribution</h2>
                        </div>
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-shopping-bag text-indigo-500"></i> Recent Orders</h2>
                        <a href="orders.php" class="view-all">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recent_orders)): ?>
                                    <tr class="animate-fade-in">
                                        <td colspan="6" class="text-center p-8 text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                            <p>No orders found</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recent_orders as $order): ?>
                                        <tr class="animate-fade-in hover:bg-gray-50">
                                            <td class="font-medium">#<?php echo $order['order_number']; ?></td>
                                            <td>
                                                <div class="user-info">
                                                    <div class="user-avatar"><?php echo strtoupper(substr($order['customer_name'] ?? 'U', 0, 1)); ?></div>
                                                    <div>
                                                        <div class="user-name"><?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?></div>
                                                        <div class="user-email text-xs"><?php echo htmlspecialchars($order['customer_email'] ?? ''); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-sm text-gray-600"><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                            <td class="font-medium">$<?php echo number_format($order['final_amount'], 2); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                                    <?php echo ucfirst($order['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="orders.php?view=<?php echo $order['id']; ?>" class="btn-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($order['status'] === 'pending'): ?>
                                                        <button onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'processing')" class="btn-outline btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="grid-4">
                <!-- Quick Actions -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h2><i class="fas fa-bolt text-indigo-500"></i> Quick Actions</h2>
                    </div>
                    <div class="space-y-3">
                        <a href="products.php?action=add" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Add New Product</h4>
                                <p class="text-sm text-gray-500">Create a new product listing</p>
                            </div>
                        </a>
                        <a href="orders.php?filter=processing" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Process Orders</h4>
                                <p class="text-sm text-gray-500">0 pending orders</p>
                            </div>
                        </a>
                        <a href="products.php?low_stock=1" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Low Stock</h4>
                                <p class="text-sm text-gray-500">0 items need restocking</p>
                            </div>
                        </a>
                        <a href="reports.php" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">View Reports</h4>
                                <p class="text-sm text-gray-500">Sales and analytics</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-history text-indigo-500"></i> Recent Activity</h2>
                    </div>
                    <div class="space-y-4" id="activityFeed">
                        <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 flex-shrink-0 mt-1">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <p class="text-sm"><span class="font-medium">System</span> Dashboard loaded successfully!</p>
                                <p class="text-xs text-gray-500 mt-1">Just now</p>
                            </div>
                        </div>
                        <?php if ($stats['pending_orders'] > 0): ?>
                            <div class="flex items-start gap-3 p-3 bg-yellow-50 rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 flex-shrink-0 mt-1">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <p class="text-sm"><span class="font-medium">Orders</span> <?php echo $stats['pending_orders']; ?> orders pending</p>
                                    <p class="text-xs text-gray-500 mt-1">Action required</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($stats['low_stock_products'] > 0): ?>
                            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-500 flex-shrink-0 mt-1">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <p class="text-sm"><span class="font-medium">Inventory</span> <?php echo $stats['low_stock_products']; ?> products low in stock</p>
                                    <p class="text-xs text-gray-500 mt-1">Restock needed</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Row -->
        <div class="dashboard-grid mt-6">
            <!-- Top Products -->
            <div class="grid-6">
                <div class="card h-full">
                    <div class="card-header">
                        <h2><i class="fas fa-star text-indigo-500"></i> Top Products</h2>
                        <a href="products.php?sort=popular" class="view-all">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <?php if (empty($top_products)): ?>
                        <div class="p-4 text-center text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-2 text-gray-300"></i>
                            <p>No products available</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($top_products as $index => $product): ?>
                                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-sm"><?php echo htmlspecialchars($product['title']); ?></h4>
                                        <p class="text-xs text-gray-500">Sold: <?php echo $product['sales_count']; ?> times</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-sm">$<?php echo number_format($product['price'], 2); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Recent Customers -->
            <div class="grid-6">
                <div class="card h-full">
                    <div class="card-header">
                        <h2><i class="fas fa-users text-indigo-500"></i> Recent Customers</h2>
                        <a href="users.php" class="view-all">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <?php if (empty($recent_users)): ?>
                        <div class="p-4 text-center text-gray-500">
                            <i class="fas fa-user-friends text-4xl mb-2 text-gray-300"></i>
                            <p>No customers found</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($recent_users as $user): ?>
                                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-semibold text-gray-700">
                                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-sm"><?php echo htmlspecialchars($user['name']); ?></h4>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($user['email']); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Joined <?php echo date('M j', strtotime($user['created_at'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart with real data
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueData = <?php echo json_encode($monthly_revenue); ?>;
            
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueData.map(item => item.month || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'][revenueData.indexOf(item)]),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: revenueData.map(item => parseFloat(item.revenue || 0)),
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'white',
                        pointBorderColor: 'rgba(79, 70, 229, 1)',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'white',
                            titleColor: '#1f2937',
                            bodyColor: '#4b5563',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 12,
                            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                            callbacks: {
                                label: function(context) {
                                    return `$${context.parsed.y.toFixed(2)}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Order Status Chart
            const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [
                            <?php echo $stats['pending_orders']; ?>,
                            <?php echo $stats['total_orders'] - $stats['pending_orders'] - $stats['completed_orders']; ?>,
                            <?php echo $stats['completed_orders']; ?>,
                            0
                        ],
                        backgroundColor: [
                            '#f59e0b',
                            '#3b82f6',
                            '#10b981',
                            '#ef4444'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
        
        // Toggle active state for filter buttons
        document.querySelectorAll('.btn-outline').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.btn-outline').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Refresh dashboard function
        function refreshDashboard() {
            location.reload();
        }
        
        // Update order status function
        function updateOrderStatus(orderId, status) {
            if (confirm('Are you sure you want to update this order status?')) {
                fetch('api/update_order_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Order status updated successfully!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showNotification('Error updating order status', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error updating order status', 'error');
                });
            }
        }
        
        // Show notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 animate-fade-in ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="fas ${
                        type === 'success' ? 'fa-check-circle' :
                        type === 'error' ? 'fa-exclamation-circle' :
                        'fa-info-circle'
                    }"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Auto-refresh every 30 seconds
        setInterval(() => {
            refreshDashboard();
        }, 30000);
    </script>
</body>
</html>
