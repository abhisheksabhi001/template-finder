<?php
require_once 'config/config.php';
require_once 'classes/User.php';

// Auto-login as admin for quick access
$email = 'admin@aadigits.com';
$password = 'admin123';

$user = new User();
$login_result = $user->login($email, $password);

if ($login_result) {
    echo "<h2>✅ Auto-Login Successful!</h2>";
    echo "<p>You are now logged in as: <strong>" . $_SESSION['user_name'] . "</strong></p>";
    echo "<p>Role: <strong>" . ucfirst($_SESSION['user_role']) . "</strong></p>";
    
    echo "<h3>🚀 Quick Links:</h3>";
    echo "<p>";
    echo "<a href='admin/' style='background: #059669; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 18px; margin-right: 10px;'>🎯 Admin Dashboard</a>";
    echo "<a href='index.php' style='background: #2563eb; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 18px; margin-right: 10px;'>🏠 Homepage</a>";
    echo "<a href='products.php' style='background: #7c3aed; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 18px;'>📦 Products</a>";
    echo "</p>";
    
    echo "<script>";
    echo "setTimeout(function() { window.location.href = 'admin/'; }, 3000);";
    echo "</script>";
    
    echo "<p><em>Redirecting to admin dashboard in 3 seconds...</em></p>";
} else {
    echo "<h2>❌ Login Failed</h2>";
    echo "<p>Could not auto-login. Please try manual login.</p>";
    echo "<p><a href='login.php'>Go to Login Page</a></p>";
}
?>
