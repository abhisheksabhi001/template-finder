<?php
require_once 'config/config.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Additional admin accounts to create
    $admin_accounts = [
        [
            'name' => 'Super Admin',
            'email' => 'superadmin@aadigits.com',
            'password' => 'admin123',
            'role' => 'super_admin'
        ],
        [
            'name' => 'Admin Manager',
            'email' => 'manager@aadigits.com',
            'password' => 'manager123',
            'role' => 'admin'
        ],
        [
            'name' => 'Site Admin',
            'email' => 'siteadmin@aadigits.com',
            'password' => 'site123',
            'role' => 'admin'
        ],
        [
            'name' => 'Dashboard Admin',
            'email' => 'dashboard@aadigits.com',
            'password' => 'dashboard123',
            'role' => 'admin'
        ],
        [
            'name' => 'Main Admin',
            'email' => 'mainadmin@aadigits.com',
            'password' => 'main123',
            'role' => 'super_admin'
        ]
    ];
    
    echo "<h2>Creating Additional Admin Accounts</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 20px 0;'>";
    echo "<tr style='background: #f5f5f5;'>";
    echo "<th style='padding: 10px;'>Name</th>";
    echo "<th style='padding: 10px;'>Email</th>";
    echo "<th style='padding: 10px;'>Password</th>";
    echo "<th style='padding: 10px;'>Role</th>";
    echo "<th style='padding: 10px;'>Status</th>";
    echo "</tr>";
    
    foreach ($admin_accounts as $account) {
        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->execute([$account['email']]);
        
        if ($check_stmt->fetch()) {
            echo "<tr>";
            echo "<td style='padding: 10px;'>" . htmlspecialchars($account['name']) . "</td>";
            echo "<td style='padding: 10px;'>" . htmlspecialchars($account['email']) . "</td>";
            echo "<td style='padding: 10px;'>" . htmlspecialchars($account['password']) . "</td>";
            echo "<td style='padding: 10px;'>" . ucfirst($account['role']) . "</td>";
            echo "<td style='padding: 10px; color: orange;'>Already Exists</td>";
            echo "</tr>";
        } else {
            // Create the admin account
            $hashed_password = password_hash($account['password'], PASSWORD_DEFAULT);
            $is_admin = ($account['role'] === 'admin' || $account['role'] === 'super_admin') ? 1 : 0;
            
            $stmt = $conn->prepare("
                INSERT INTO users (name, email, password, is_admin, role, is_active, email_verified) 
                VALUES (?, ?, ?, ?, ?, 1, 1)
            ");
            
            if ($stmt->execute([$account['name'], $account['email'], $hashed_password, $is_admin, $account['role']])) {
                echo "<tr>";
                echo "<td style='padding: 10px;'>" . htmlspecialchars($account['name']) . "</td>";
                echo "<td style='padding: 10px;'>" . htmlspecialchars($account['email']) . "</td>";
                echo "<td style='padding: 10px;'>" . htmlspecialchars($account['password']) . "</td>";
                echo "<td style='padding: 10px;'>" . ucfirst($account['role']) . "</td>";
                echo "<td style='padding: 10px; color: green;'>✓ Created</td>";
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td style='padding: 10px;'>" . htmlspecialchars($account['name']) . "</td>";
                echo "<td style='padding: 10px;'>" . htmlspecialchars($account['email']) . "</td>";
                echo "<td style='padding: 10px;'>" . htmlspecialchars($account['password']) . "</td>";
                echo "<td style='padding: 10px;'>" . ucfirst($account['role']) . "</td>";
                echo "<td style='padding: 10px; color: red;'>✗ Failed</td>";
                echo "</tr>";
            }
        }
    }
    
    echo "</table>";
    
    echo "<h3>🎯 Admin Login Options:</h3>";
    echo "<div style='background: #f0f9ff; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h4>Choose any of these admin accounts to login:</h4>";
    echo "<ul style='list-style: none; padding: 0;'>";
    echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'><strong>Email:</strong> admin@aadigits.com <strong>Password:</strong> admin123</li>";
    echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'><strong>Email:</strong> superadmin@aadigits.com <strong>Password:</strong> admin123</li>";
    echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'><strong>Email:</strong> manager@aadigits.com <strong>Password:</strong> manager123</li>";
    echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'><strong>Email:</strong> siteadmin@aadigits.com <strong>Password:</strong> site123</li>";
    echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'><strong>Email:</strong> dashboard@aadigits.com <strong>Password:</strong> dashboard123</li>";
    echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'><strong>Email:</strong> mainadmin@aadigits.com <strong>Password:</strong> main123</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h3>🚀 Quick Links:</h3>";
    echo "<p>";
    echo "<a href='login.php' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Login Page</a>";
    echo "<a href='admin/' style='background: #059669; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Admin Dashboard</a>";
    echo "<a href='check-users.php' style='background: #7c3aed; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View All Users</a>";
    echo "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
