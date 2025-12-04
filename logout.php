<?php
require_once 'config/config.php';
require_once 'classes/User.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('login.php');
}

// Logout user
$user = new User();
$user->logout();

// Clear remember me cookie
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

// Redirect to home page with success message
handle_success('You have been successfully logged out.', 'index.php');
?>
