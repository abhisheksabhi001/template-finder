<?php
$page_title = 'Sign Up';
$page_description = 'Create your AA DIGITS account to access premium digital products and templates.';

require_once 'config/config.php';
require_once 'classes/User.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $agree_terms = isset($_POST['agree_terms']);
    
    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (!$agree_terms) {
        $error = 'Please agree to the Terms of Service and Privacy Policy.';
    } else {
        $user = new User();
        
        // Check if email already exists
        if ($user->emailExists($email)) {
            $error = 'An account with this email address already exists. <a href="login.php">Login instead</a> or use a different email.';
        } else {
            // Create user account
            $user_id = $user->register($name, $email, $password);
            
            if ($user_id) {
                // Auto login after registration
                $login_result = $user->login($email, $password);
                
                if ($login_result) {
                    handle_success('Account created successfully! Welcome to AA DIGITS.', 'index.php');
                } else {
                    handle_success('Account created successfully! Please login to continue.', 'login.php');
                }
            } else {
                $error = 'Failed to create account. Please try again.';
            }
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
                    <h1>Create Account</h1>
                    <p>Join thousands of creators and get access to premium digital products</p>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Admin Access:</strong> Use any of these admin accounts:
                    <br><small>
                        • <code>admin@aadigits.com</code> / <code>admin123</code><br>
                        • <code>superadmin@aadigits.com</code> / <code>admin123</code><br>
                        • <code>manager@aadigits.com</code> / <code>manager123</code><br>
                        • <code>dashboard@aadigits.com</code> / <code>dashboard123</code>
                    </small>
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
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                               placeholder="Enter your full name">
                    </div>
                    
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
                                   placeholder="Create a strong password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-meter">
                                <div class="strength-bar"></div>
                            </div>
                            <span class="strength-text">Password strength</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="password-input">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required 
                                   placeholder="Confirm your password">
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="agree_terms" name="agree_terms" class="form-check-input" required>
                            <label for="agree_terms" class="form-check-label">
                                I agree to the <a href="terms-of-service.php" target="_blank">Terms of Service</a> 
                                and <a href="privacy-policy.php" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="newsletter" name="newsletter" class="form-check-input">
                            <label for="newsletter" class="form-check-label">
                                Subscribe to our newsletter for updates and exclusive offers
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-full btn-lg">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </button>
                </form>
                
                <div class="auth-divider">
                    <span>or</span>
                </div>
                
                <div class="social-login">
                    <button class="btn btn-outline btn-full social-btn google-btn">
                        <i class="fab fa-google"></i>
                        Sign up with Google
                    </button>
                    
                    <button class="btn btn-outline btn-full social-btn facebook-btn">
                        <i class="fab fa-facebook-f"></i>
                        Sign up with Facebook
                    </button>
                </div>
                
                <div class="auth-footer">
                    <p>Already have an account? <a href="login.php">Sign in here</a></p>
                </div>
            </div>
            
            <div class="auth-image">
                <div class="auth-image-content">
                    <h2>Start your creative journey</h2>
                    <p>Get instant access to thousands of premium digital products, templates, and resources.</p>
                    
                    <div class="auth-features">
                        <div class="auth-feature">
                            <i class="fas fa-infinity"></i>
                            <span>Unlimited Downloads</span>
                        </div>
                        <div class="auth-feature">
                            <i class="fas fa-crown"></i>
                            <span>Premium Quality</span>
                        </div>
                        <div class="auth-feature">
                            <i class="fas fa-users"></i>
                            <span>Community Support</span>
                        </div>
                    </div>
                    
                    <div class="auth-stats">
                        <div class="stat">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Happy Customers</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Digital Products</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">99%</div>
                            <div class="stat-label">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Password Strength Meter */
.password-strength {
    margin-top: var(--spacing-sm);
}

.strength-meter {
    height: 4px;
    background: var(--border-color);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: var(--spacing-xs);
}

.strength-bar {
    height: 100%;
    width: 0%;
    transition: all var(--transition-normal);
    border-radius: 2px;
}

.strength-text {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Strength levels */
.strength-weak .strength-bar {
    width: 25%;
    background: var(--error-color);
}

.strength-fair .strength-bar {
    width: 50%;
    background: var(--warning-color);
}

.strength-good .strength-bar {
    width: 75%;
    background: #3b82f6;
}

.strength-strong .strength-bar {
    width: 100%;
    background: var(--success-color);
}

.strength-weak .strength-text::after {
    content: ' - Weak';
    color: var(--error-color);
}

.strength-fair .strength-text::after {
    content: ' - Fair';
    color: var(--warning-color);
}

.strength-good .strength-text::after {
    content: ' - Good';
    color: #3b82f6;
}

.strength-strong .strength-text::after {
    content: ' - Strong';
    color: var(--success-color);
}

/* Auth Stats */
.auth-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-lg);
    margin-top: var(--spacing-2xl);
    padding-top: var(--spacing-xl);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.stat {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: var(--spacing-xs);
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.8;
}

/* Form Check Links */
.form-check-label a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.form-check-label a:hover {
    text-decoration: underline;
}

/* Mobile Responsive */
@media (max-width: 767px) {
    .auth-stats {
        grid-template-columns: 1fr;
        gap: var(--spacing-md);
    }
    
    .stat-number {
        font-size: 1.5rem;
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

// Password strength checker
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthMeter = document.querySelector('.password-strength');
    
    if (passwordInput && strengthMeter) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            updateStrengthMeter(strengthMeter, strength);
        });
    }
});

function calculatePasswordStrength(password) {
    let score = 0;
    
    // Length check
    if (password.length >= 8) score += 1;
    if (password.length >= 12) score += 1;
    
    // Character variety checks
    if (/[a-z]/.test(password)) score += 1;
    if (/[A-Z]/.test(password)) score += 1;
    if (/[0-9]/.test(password)) score += 1;
    if (/[^A-Za-z0-9]/.test(password)) score += 1;
    
    // Return strength level
    if (score < 2) return 'weak';
    if (score < 4) return 'fair';
    if (score < 5) return 'good';
    return 'strong';
}

function updateStrengthMeter(meter, strength) {
    // Remove all strength classes
    meter.classList.remove('strength-weak', 'strength-fair', 'strength-good', 'strength-strong');
    
    // Add current strength class
    if (strength) {
        meter.textContent = strength.charAt(0).toUpperCase() + strength.slice(1);
    }
}
</script>

<style>
.alert-info {
    background: #dbeafe;
    color: #1e40af;
    border: 1px solid #93c5fd;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-info code {
    background: rgba(0, 0, 0, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}
</style>

<?php include 'includes/footer.php'; ?>
