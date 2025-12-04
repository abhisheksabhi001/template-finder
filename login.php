<?php
$page_title = 'Login';
$page_description = 'Login to your AA DIGITS account to access your purchases and downloads.';

require_once 'config/config.php';
require_once 'classes/User.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $user = new User();
        $login_result = $user->login($email, $password);
        
        if ($login_result) {
            // Set remember me cookie if checked
            if ($remember) {
                setcookie('remember_token', generate_token(), time() + (30 * 24 * 60 * 60), '/'); // 30 days
            }
            
            // Redirect to intended page or dashboard
            $redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
            redirect($redirect_url);
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-container">
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Welcome Back</h1>
                    <p>Sign in to your account to continue</p>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="auth-form" data-validate>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               placeholder="Enter your email address">
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" class="form-control" required 
                                   placeholder="Enter your password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>
                        
                        <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-full btn-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>
                </form>
                
                <div class="auth-divider">
                    <span>or</span>
                </div>
                
                <div class="social-login">
                    <button class="btn btn-outline btn-full social-btn google-btn">
                        <i class="fab fa-google"></i>
                        Continue with Google
                    </button>
                    
                    <button class="btn btn-outline btn-full social-btn facebook-btn">
                        <i class="fab fa-facebook-f"></i>
                        Continue with Facebook
                    </button>
                </div>
                
                <div class="auth-footer">
                    <p>Don't have an account? <a href="register.php">Create one here</a></p>
                </div>
            </div>
            
            <div class="auth-image">
                <div class="auth-image-content">
                    <h2>Join thousands of creators</h2>
                    <p>Access premium digital products, templates, and resources to accelerate your projects.</p>
                    
                    <div class="auth-features">
                        <div class="auth-feature">
                            <i class="fas fa-download"></i>
                            <span>Instant Downloads</span>
                        </div>
                        <div class="auth-feature">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Payments</span>
                        </div>
                        <div class="auth-feature">
                            <i class="fas fa-headset"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Authentication Styles */
.auth-container {
    min-height: calc(100vh - 128px);
    display: flex;
    align-items: center;
    padding: var(--spacing-xl) 0;
    background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
}

.auth-wrapper {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--spacing-xl);
    max-width: 1000px;
    margin: 0 auto;
}

.auth-card {
    background: var(--bg-card);
    padding: var(--spacing-2xl);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border-color);
}

.auth-header {
    text-align: center;
    margin-bottom: var(--spacing-xl);
}

.auth-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: var(--spacing-sm);
    color: var(--text-primary);
}

.auth-header p {
    color: var(--text-secondary);
    font-size: 1.125rem;
    margin: 0;
}

.auth-form {
    margin-bottom: var(--spacing-xl);
}

.password-input {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: var(--spacing-md);
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 1rem;
    padding: var(--spacing-xs);
}

.password-toggle:hover {
    color: var(--primary-color);
}

.form-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-xl);
    flex-wrap: wrap;
    gap: var(--spacing-md);
}

.form-check {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.form-check-input {
    width: 18px;
    height: 18px;
    accent-color: var(--primary-color);
}

.form-check-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

.forgot-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.forgot-link:hover {
    text-decoration: underline;
}

.auth-divider {
    text-align: center;
    margin: var(--spacing-xl) 0;
    position: relative;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--border-color);
}

.auth-divider span {
    background: var(--bg-card);
    padding: 0 var(--spacing-md);
    color: var(--text-muted);
    font-size: 0.875rem;
}

.social-login {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-xl);
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-md);
    font-weight: 500;
}

.google-btn:hover {
    border-color: #db4437;
    color: #db4437;
}

.facebook-btn:hover {
    border-color: #4267B2;
    color: #4267B2;
}

.auth-footer {
    text-align: center;
}

.auth-footer p {
    color: var(--text-secondary);
    margin: 0;
}

.auth-footer a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.auth-image {
    display: none;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-xl);
    padding: var(--spacing-2xl);
    color: white;
    position: relative;
    overflow: hidden;
}

.auth-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.1;
}

.auth-image-content {
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-image h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: var(--spacing-md);
    line-height: 1.2;
}

.auth-image p {
    font-size: 1.125rem;
    opacity: 0.9;
    margin-bottom: var(--spacing-xl);
    line-height: 1.6;
}

.auth-features {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.auth-feature {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.auth-feature i {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
}

.auth-feature span {
    font-size: 1.125rem;
    font-weight: 500;
}

/* Desktop Layout */
@media (min-width: 768px) {
    .auth-container {
        min-height: calc(100vh - 80px);
    }
    
    .auth-wrapper {
        grid-template-columns: 1fr 1fr;
        align-items: center;
    }
    
    .auth-image {
        display: block;
    }
}

@media (max-width: 767px) {
    .auth-card {
        padding: var(--spacing-xl);
    }
    
    .form-row {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .social-login {
        gap: var(--spacing-sm);
    }
}
</style>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        toggle.className = 'fas fa-eye';
    }
}
</script>

<?php include 'includes/footer.php'; ?>
