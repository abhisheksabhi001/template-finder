<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Status - AA DIGITS</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 50px auto; padding: 20px; background: #f8fafc; }
        .header { background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; padding: 2rem; border-radius: 12px; text-align: center; margin-bottom: 2rem; }
        .header h1 { font-size: 2rem; margin-bottom: 0.5rem; }
        .status-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .status-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #10b981; }
        .status-card.working { border-left-color: #10b981; }
        .status-card.protected { border-left-color: #f59e0b; }
        .status-card h3 { margin-bottom: 0.5rem; color: #1f2937; }
        .status-card p { color: #6b7280; margin-bottom: 1rem; }
        .btn { display: inline-block; padding: 8px 16px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 0.9rem; }
        .btn:hover { background: #2563eb; }
        .btn-success { background: #10b981; }
        .btn-success:hover { background: #059669; }
        .btn-warning { background: #f59e0b; }
        .btn-warning:hover { background: #d97706; }
        .feature-list { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .feature-list h2 { margin-bottom: 1rem; color: #1f2937; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
        .feature { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; }
        .feature i { color: #10b981; }
        .admin-info { background: #fef3c7; border: 1px solid #fbbf24; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; }
        .admin-info h3 { color: #92400e; margin-bottom: 1rem; }
        .credentials { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .credential { background: white; padding: 1rem; border-radius: 8px; }
        .credential strong { color: #1f2937; }
        .credential code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-size: 0.9rem; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-check-circle"></i> AA DIGITS - All Pages Working!</h1>
        <p>Complete website status and functionality overview</p>
    </div>
    
    <div class="admin-info">
        <h3><i class="fas fa-key"></i> Admin Login Credentials</h3>
        <div class="credentials">
            <div class="credential">
                <strong>Main Admin</strong><br>
                <code>admin@aadigits.com</code><br>
                <code>admin123</code>
            </div>
            <div class="credential">
                <strong>Super Admin</strong><br>
                <code>superadmin@aadigits.com</code><br>
                <code>admin123</code>
            </div>
            <div class="credential">
                <strong>Manager</strong><br>
                <code>manager@aadigits.com</code><br>
                <code>manager123</code>
            </div>
            <div class="credential">
                <strong>Dashboard Admin</strong><br>
                <code>dashboard@aadigits.com</code><br>
                <code>dashboard123</code>
            </div>
        </div>
    </div>
    
    <div class="status-grid">
        <div class="status-card working">
            <h3><i class="fas fa-home"></i> Homepage</h3>
            <p>Main landing page with hero section, products, and features</p>
            <a href="index.php" class="btn btn-success">Visit Homepage</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-box"></i> Products</h3>
            <p>Browse all digital products with filters and search</p>
            <a href="products.php" class="btn btn-success">View Products</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-tags"></i> Categories</h3>
            <p>Explore products organized by categories</p>
            <a href="categories.php" class="btn btn-success">View Categories</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-info-circle"></i> About Us</h3>
            <p>Learn about AA DIGITS and our mission</p>
            <a href="about.php" class="btn btn-success">About Page</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-envelope"></i> Contact</h3>
            <p>Get in touch with our support team</p>
            <a href="contact.php" class="btn btn-success">Contact Us</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-shopping-cart"></i> Shopping Cart</h3>
            <p>Review selected items and proceed to checkout</p>
            <a href="cart.php" class="btn btn-success">View Cart</a>
        </div>
        
        <div class="status-card protected">
            <h3><i class="fas fa-user"></i> User Profile</h3>
            <p>Manage account, orders, and downloads (Login Required)</p>
            <a href="profile.php" class="btn btn-warning">View Profile</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-sign-in-alt"></i> Login</h3>
            <p>User authentication and account access</p>
            <a href="login.php" class="btn btn-success">Login Page</a>
        </div>
        
        <div class="status-card working">
            <h3><i class="fas fa-user-plus"></i> Register</h3>
            <p>Create new user account with validation</p>
            <a href="register.php" class="btn btn-success">Register Page</a>
        </div>
        
        <div class="status-card protected">
            <h3><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h3>
            <p>Complete admin panel for managing the website (Admin Only)</p>
            <a href="admin/" class="btn btn-warning">Admin Dashboard</a>
        </div>
    </div>
    
    <div class="feature-list">
        <h2><i class="fas fa-star"></i> Website Features</h2>
        <div class="features">
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Responsive Design</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>User Authentication</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Admin Dashboard</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Product Management</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Shopping Cart</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>User Profiles</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Contact Forms</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Search & Filters</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Category System</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Mobile Navigation</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Dark/Light Mode</span>
            </div>
            <div class="feature">
                <i class="fas fa-check"></i>
                <span>Security Features</span>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 2rem; padding: 2rem; background: white; border-radius: 12px;">
        <h2>🎉 All Systems Operational!</h2>
        <p>Your AA DIGITS website is fully functional and ready for use.</p>
        <a href="index.php" class="btn btn-success" style="font-size: 1.1rem; padding: 12px 24px;">
            <i class="fas fa-rocket"></i> Launch Website
        </a>
    </div>
</body>
</html>
