<?php
require_once 'config/config.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<h2>Debug Admin Login</h2>";
    
    // Check if admin user exists
    $email = 'admin@aadigits.com';
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "<h3>✅ Admin User Found:</h3>";
        echo "<p><strong>ID:</strong> " . $user['id'] . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($user['name']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
        echo "<p><strong>Is Admin:</strong> " . ($user['is_admin'] ? 'Yes' : 'No') . "</p>";
        echo "<p><strong>Role:</strong> " . htmlspecialchars($user['role']) . "</p>";
        echo "<p><strong>Active:</strong> " . ($user['is_active'] ? 'Yes' : 'No') . "</p>";
        
        // Test password verification
        $test_password = 'admin123';
        $password_match = password_verify($test_password, $user['password']);
        
        echo "<h3>🔐 Password Test:</h3>";
        echo "<p><strong>Test Password:</strong> admin123</p>";
        echo "<p><strong>Password Match:</strong> " . ($password_match ? '✅ Yes' : '❌ No') . "</p>";
        
        if (!$password_match) {
            // Try to update password
            $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            if ($update_stmt->execute([$new_hash, $email])) {
                echo "<p style='color: green;'>✅ Password updated successfully!</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to update password</p>";
            }
        }
        
    } else {
        echo "<h3>❌ Admin User Not Found</h3>";
        echo "<p>Creating admin user...</p>";
        
        // Create admin user
        $name = 'Admin User';
        $email = 'admin@aadigits.com';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        
        $create_stmt = $conn->prepare("
            INSERT INTO users (name, email, password, is_admin, role, is_active, email_verified) 
            VALUES (?, ?, ?, 1, 'super_admin', 1, 1)
        ");
        
        if ($create_stmt->execute([$name, $email, $password])) {
            echo "<p style='color: green;'>✅ Admin user created successfully!</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to create admin user</p>";
        }
    }
    
    echo "<h3>🚀 Try Login Now:</h3>";
    echo "<p><a href='login.php' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login Page</a></p>";
    echo "<p><strong>Credentials:</strong> admin@aadigits.com / admin123</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
