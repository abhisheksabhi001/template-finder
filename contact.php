<?php
$page_title = 'Contact Us';
$page_description = 'Get in touch with AA DIGITS - We\'re here to help with your digital product needs and questions.';

require_once 'config/config.php';

$message = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $subject = sanitize_input($_POST['subject']);
    $message_text = sanitize_input($_POST['message']);
    
    if (empty($name) || empty($email) || empty($subject) || empty($message_text)) {
        $message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        // Here you would typically save to database or send email
        // For now, we'll just show a success message
        $success = 'Thank you for your message! We\'ll get back to you within 24 hours.';
        
        // Clear form data
        $_POST = [];
    }
}

include 'includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
    </div>
</div>

<div class="container">
    <div class="contact-section">
        <div class="contact-content">
            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <h2>Send us a Message</h2>
                
                <?php if ($message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                   placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                   placeholder="Enter your email address">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'General Inquiry') ? 'selected' : ''; ?>>General Inquiry</option>
                            <option value="Product Support" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Product Support') ? 'selected' : ''; ?>>Product Support</option>
                            <option value="Technical Issue" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Technical Issue') ? 'selected' : ''; ?>>Technical Issue</option>
                            <option value="Billing Question" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Billing Question') ? 'selected' : ''; ?>>Billing Question</option>
                            <option value="Partnership" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Partnership') ? 'selected' : ''; ?>>Partnership</option>
                            <option value="Other" <?php echo (isset($_POST['subject']) && $_POST['subject'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" required 
                                  placeholder="Tell us how we can help you..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <p>Have questions? We're here to help! Reach out to us through any of the following channels.</p>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="method-content">
                            <h3>Email Us</h3>
                            <p>support@aadigits.com</p>
                            <small>We'll respond within 24 hours</small>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="method-content">
                            <h3>Call Us</h3>
                            <p>+1 (555) 123-4567</p>
                            <small>Mon-Fri, 9AM-6PM EST</small>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="method-content">
                            <h3>Live Chat</h3>
                            <p>Available on our website</p>
                            <small>Mon-Fri, 9AM-6PM EST</small>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="method-content">
                            <h3>Visit Us</h3>
                            <p>123 Digital Street<br>Tech City, TC 12345</p>
                            <small>By appointment only</small>
                        </div>
                    </div>
                </div>
                
                <div class="social-links">
                    <h3>Follow Us</h3>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <section class="faq-section">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-grid">
            <div class="faq-item">
                <h3>How do I download my purchased products?</h3>
                <p>After successful payment, you'll receive an email with download links. You can also access your downloads from your account dashboard.</p>
            </div>
            
            <div class="faq-item">
                <h3>What payment methods do you accept?</h3>
                <p>We accept all major credit cards, PayPal, and various other secure payment methods through our payment processors.</p>
            </div>
            
            <div class="faq-item">
                <h3>Do you offer refunds?</h3>
                <p>Yes, we offer a 30-day money-back guarantee on all digital products if you're not satisfied with your purchase.</p>
            </div>
            
            <div class="faq-item">
                <h3>Can I use the products for commercial purposes?</h3>
                <p>Most of our products come with commercial licenses. Please check the specific license terms for each product before purchase.</p>
            </div>
        </div>
    </section>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.page-header h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-header p {
    font-size: 1.2rem;
    opacity: 0.9;
}

.contact-section {
    padding: 4rem 0;
}

.contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
}

.contact-form-wrapper h2,
.contact-info h2 {
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.contact-form {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid var(--border-color);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    background: var(--bg-primary);
    color: var(--text-primary);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    width: 100%;
}

.contact-info p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.contact-methods {
    margin-bottom: 3rem;
}

.contact-method {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.method-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.method-content h3 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.method-content p {
    margin-bottom: 0.25rem;
    color: var(--text-primary);
    font-weight: 600;
}

.method-content small {
    color: var(--text-secondary);
}

.social-links {
    text-align: center;
}

.social-links h3 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
}

.faq-section {
    padding: 4rem 0;
    background: var(--bg-secondary);
    border-radius: 16px;
    margin-top: 4rem;
}

.faq-section h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 3rem;
    color: var(--text-primary);
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.faq-item {
    background: var(--bg-primary);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.faq-item h3 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.faq-item p {
    color: var(--text-secondary);
    line-height: 1.6;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 2rem 0;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .contact-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .contact-form {
        padding: 1.5rem;
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
