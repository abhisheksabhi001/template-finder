<?php
$page_title = 'Create Admin User';
require_once '../config/config.php';
require_once '../classes/User.php';

// Check if user is logged in and is super admin
if (!is_logged_in()) {
    redirect('../login.php');
}

if (!is_admin()) {
    handle_error('Access denied. Super admin privileges required.', '../login.php');
}

$message = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    if (empty($name) || empty($email) || empty($password)) {
        $message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters long.';
    } else {
        try {
            $database = new Database();
            $conn = $database->getConnection();
            
            // Check if email exists
            $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $check_stmt->execute([$email]);
            
            if ($check_stmt->fetch()) {
                $message = 'An account with this email already exists.';
            } else {
                // Create admin user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $is_admin = ($role === 'admin' || $role === 'super_admin') ? 1 : 0;
                
                $stmt = $conn->prepare("
                    INSERT INTO users (name, email, password, is_admin, role, is_active, email_verified) 
                    VALUES (?, ?, ?, ?, ?, 1, 1)
                ");
                
                if ($stmt->execute([$name, $email, $hashed_password, $is_admin, $role])) {
                    $success = "Admin user created successfully! Email: $email, Password: $password";
                } else {
                    $message = 'Failed to create admin user.';
                }
            }
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<div class="admin-container">
    <!-- Simple form for creating admin users -->
    <div style="max-width: 500px; margin: 50px auto; padding: 20px; background: var(--bg-secondary); border-radius: 12px;">
        <h2>Create Admin User</h2>
        <p>Create a new admin or super admin account for AA DIGITS.</p>
        
        <?php if ($message): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin: 10px 0;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div style="background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; margin: 10px 0;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" style="margin-top: 20px;">
            <div style="margin-bottom: 15px;">
                <label>Full Name:</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" 
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Email:</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Password:</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Role:</label>
                <select name="role" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="user">Regular User</option>
                </select>
            </div>
            
            <button type="submit" style="background: var(--primary-color); color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer;">
                Create User
            </button>
            
            <a href="index.php" style="margin-left: 10px; padding: 12px 24px; background: #6b7280; color: white; text-decoration: none; border-radius: 5px;">
                Back to Dashboard
            </a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
