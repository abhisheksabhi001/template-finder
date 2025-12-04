<?php
$page_title = 'About Us';
$page_description = 'Learn about AA DIGITS - Your trusted source for premium digital products, templates, and software solutions.';

require_once 'config/config.php';

include 'includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>About AA DIGITS</h1>
        <p>Your trusted partner for premium digital products and solutions</p>
    </div>
</div>

<div class="container">
    <!-- About Section -->
    <section class="about-section">
        <div class="about-content">
            <div class="about-text">
                <h2>Who We Are</h2>
                <p>AA DIGITS is a leading digital marketplace dedicated to providing high-quality digital products, templates, and software solutions for businesses, developers, and creative professionals worldwide.</p>
                
                <p>Founded with the vision of making premium digital resources accessible to everyone, we curate and offer a comprehensive collection of web templates, mobile app designs, graphics, software tools, and more.</p>
                
                <p>Our mission is to empower creators, entrepreneurs, and businesses with the digital tools they need to succeed in today's competitive landscape.</p>
            </div>
            <div class="about-image">
                <div class="image-placeholder">
                    <i class="fas fa-laptop-code fa-5x"></i>
                    <p>Premium Digital Solutions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Digital Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">99%</div>
                <div class="stat-label">Satisfaction Rate</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support Available</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <h2>Why Choose AA DIGITS?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <h3>Premium Quality</h3>
                <p>All our products are carefully curated and tested to ensure the highest quality standards.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-download"></i>
                </div>
                <h3>Instant Downloads</h3>
                <p>Get immediate access to your purchased products with secure download links.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure Payments</h3>
                <p>Your transactions are protected with industry-standard security measures.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Expert Support</h3>
                <p>Our dedicated support team is here to help you with any questions or issues.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h3>Regular Updates</h3>
                <p>We continuously update our product catalog with the latest trends and technologies.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Community Driven</h3>
                <p>Join our community of creators and get inspired by fellow professionals.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <h2>Our Team</h2>
        <p class="team-intro">Meet the passionate individuals behind AA DIGITS</p>
        
        <div class="team-grid">
            <div class="team-member">
                <div class="member-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3>John Smith</h3>
                <p class="member-role">Founder & CEO</p>
                <p class="member-bio">Visionary leader with 10+ years in digital product development.</p>
            </div>
            
            <div class="team-member">
                <div class="member-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3>Sarah Johnson</h3>
                <p class="member-role">Head of Design</p>
                <p class="member-bio">Creative director ensuring all products meet our quality standards.</p>
            </div>
            
            <div class="team-member">
                <div class="member-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3>Mike Davis</h3>
                <p class="member-role">Technical Lead</p>
                <p class="member-bio">Expert developer maintaining our platform and infrastructure.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Get Started?</h2>
            <p>Join thousands of satisfied customers and discover premium digital products today!</p>
            <div class="cta-buttons">
                <a href="products.php" class="btn btn-primary">Browse Products</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
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

.about-section {
    padding: 4rem 0;
}

.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.about-text h2 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.about-text p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
    color: var(--text-secondary);
}

.image-placeholder {
    background: var(--bg-secondary);
    border-radius: 16px;
    padding: 3rem;
    text-align: center;
    border: 2px dashed var(--border-color);
}

.image-placeholder i {
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.image-placeholder p {
    color: var(--text-secondary);
    font-weight: 600;
}

.stats-section {
    background: var(--bg-secondary);
    padding: 4rem 0;
    margin: 4rem 0;
    border-radius: 16px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
}

.stat-item {
    padding: 1rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-secondary);
    font-weight: 600;
}

.features-section {
    padding: 4rem 0;
    text-align: center;
}

.features-section h2 {
    font-size: 2rem;
    margin-bottom: 3rem;
    color: var(--text-primary);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-color);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.feature-card h3 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.feature-card p {
    color: var(--text-secondary);
    line-height: 1.6;
}

.team-section {
    padding: 4rem 0;
    text-align: center;
}

.team-section h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.team-intro {
    color: var(--text-secondary);
    margin-bottom: 3rem;
    font-size: 1.1rem;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.team-member {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid var(--border-color);
}

.member-avatar {
    width: 80px;
    height: 80px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 2rem;
}

.team-member h3 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.member-role {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.member-bio {
    color: var(--text-secondary);
    line-height: 1.6;
}

.cta-section {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 4rem 0;
    border-radius: 16px;
    text-align: center;
    margin: 4rem 0;
}

.cta-content h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 2rem 0;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .about-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
