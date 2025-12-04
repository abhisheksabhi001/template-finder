<?php
require_once 'config/config.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->query("SELECT id, name, email, role, is_admin, is_active, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
    
    echo "<h2>Existing User Accounts</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f5f5f5;'>";
    echo "<th style='padding: 10px;'>ID</th>";
    echo "<th style='padding: 10px;'>Name</th>";
    echo "<th style='padding: 10px;'>Email</th>";
    echo "<th style='padding: 10px;'>Role</th>";
    echo "<th style='padding: 10px;'>Status</th>";
    echo "<th style='padding: 10px;'>Created</th>";
    echo "</tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td style='padding: 10px;'>" . $user['id'] . "</td>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($user['name']) . "</td>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td style='padding: 10px;'>" . ucfirst($user['role']) . "</td>";
        echo "<td style='padding: 10px;'>" . ($user['is_active'] ? 'Active' : 'Inactive') . "</td>";
        echo "<td style='padding: 10px;'>" . $user['created_at'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<br><h3>Default Admin Login:</h3>";
    echo "<p><strong>Email:</strong> admin@aadigits.com</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    
    echo "<br><p><a href='login.php'>Go to Login</a> | <a href='register.php'>Register New Account</a> | <a href='index.php'>Homepage</a></p>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
