<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Summary - AA DIGITS</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 1200px; margin: 50px auto; padding: 20px; background: #f8fafc; }
        .header { background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; padding: 2rem; border-radius: 12px; text-align: center; margin-bottom: 2rem; }
        .header h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; }
        .product-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s ease; }
        .product-card:hover { transform: translateY(-5px); }
        .product-header { padding: 1.5rem; border-bottom: 1px solid #e5e7eb; }
        .product-title { font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; }
        .product-category { background: #3b82f6; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 500; display: inline-block; margin-bottom: 1rem; }
        .product-description { color: #6b7280; line-height: 1.6; }
        .product-details { padding: 1.5rem; }
        .product-price { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .price-current { font-size: 1.5rem; font-weight: 700; color: #059669; }
        .price-original { font-size: 1.1rem; color: #9ca3af; text-decoration: line-through; }
        .product-tools { margin-bottom: 1rem; }
        .tools-label { font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
        .tools-list { color: #6b7280; font-size: 0.9rem; }
        .product-actions { display: flex; gap: 1rem; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary { background: #3b82f6; color: white; }
        .btn-primary:hover { background: #2563eb; }
        .btn-outline { border: 1px solid #d1d5db; color: #374151; background: white; }
        .btn-outline:hover { border-color: #3b82f6; color: #3b82f6; }
        .featured-badge { position: absolute; top: 1rem; right: 1rem; background: #f59e0b; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
        .stats { background: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem; text-align: center; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 2rem; }
        .stat-item { }
        .stat-number { font-size: 2rem; font-weight: 700; color: #3b82f6; }
        .stat-label { color: #6b7280; font-size: 0.9rem; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-box-open"></i> AA DIGITS Products</h1>
        <p>Premium digital products, templates, and tools for modern businesses</p>
    </div>
    
    <div class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">12+</div>
                <div class="stat-label">Products Added</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">6</div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">$17-$149</div>
                <div class="stat-label">Price Range</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Working</div>
            </div>
        </div>
    </div>
    
    <div class="products-grid">
        <!-- Web Templates -->
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-code"></i> Web Templates</div>
                <h3 class="product-title">Modern Business Website Template</h3>
                <p class="product-description">Professional responsive business website template with modern design, contact forms, and SEO optimization.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$39.99</span>
                    <span class="price-original">$49.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">HTML5, CSS3, JavaScript, Bootstrap 5, Font Awesome</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=web-templates" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-code"></i> Web Templates</div>
                <h3 class="product-title">E-commerce Store Template</h3>
                <p class="product-description">Complete e-commerce template with shopping cart, checkout process, and admin panel.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$59.99</span>
                    <span class="price-original">$79.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">React.js, Node.js, MongoDB, Stripe API, PayPal Integration</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=web-templates" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <!-- Mobile Apps -->
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-mobile-alt"></i> Mobile Apps</div>
                <h3 class="product-title">iOS Social Media App Template</h3>
                <p class="product-description">Complete iOS app template with user authentication, photo sharing, and messaging features.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$99.99</span>
                    <span class="price-original">$129.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">Xcode, Swift 5, UIKit, Core Data, Firebase</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=mobile-apps" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-mobile-alt"></i> Mobile Apps</div>
                <h3 class="product-title">Android E-commerce App Template</h3>
                <p class="product-description">Feature-rich Android shopping app with material design and offline support.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$89.99</span>
                    <span class="price-original">$119.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">Android Studio, Kotlin, Material Design, Room Database</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=mobile-apps" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <!-- Graphics & Design -->
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-paint-brush"></i> Graphics Design</div>
                <h3 class="product-title">Premium Logo Design Bundle</h3>
                <p class="product-description">50+ professional logos in multiple formats (AI, EPS, PNG, SVG) with color variations.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$29.99</span>
                    <span class="price-original">$39.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">Adobe Illustrator, Photoshop, Figma, Sketch</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=graphics-design" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="product-card">
            <div class="product-header">
                <div class="product-category"><i class="fas fa-paint-brush"></i> Graphics Design</div>
                <h3 class="product-title">Icon Pack Collection - 1000+ Icons</h3>
                <p class="product-description">Massive collection of 1000+ premium icons in various styles and formats.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$19.99</span>
                    <span class="price-original">$24.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">Adobe Illustrator, Figma, Sketch, IconJar</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=graphics-design" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <!-- Software Tools -->
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-tools"></i> Software Tools</div>
                <h3 class="product-title">Website Builder Pro</h3>
                <p class="product-description">Professional drag-and-drop website builder with responsive templates and SEO tools.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$149.99</span>
                    <span class="price-original">$199.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">Electron, React, Node.js, MongoDB, AWS Integration</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=software-tools" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="product-card">
            <div class="product-header">
                <div class="product-category"><i class="fas fa-tools"></i> Software Tools</div>
                <h3 class="product-title">Code Editor Plus</h3>
                <p class="product-description">Advanced code editor with syntax highlighting, plugins, and integrated terminal.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$69.99</span>
                    <span class="price-original">$89.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Tools & Technologies:</div>
                    <div class="tools-list">Electron, Monaco Editor, Node.js, TypeScript</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=software-tools" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <!-- Ebooks -->
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-book"></i> Ebooks</div>
                <h3 class="product-title">Complete Web Development Guide 2025</h3>
                <p class="product-description">500-page comprehensive guide covering HTML5, CSS3, JavaScript, React, and Node.js.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$19.99</span>
                    <span class="price-original">$29.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Formats & Resources:</div>
                    <div class="tools-list">PDF, EPUB, Code Examples, Project Files</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=ebooks" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="product-card">
            <div class="product-header">
                <div class="product-category"><i class="fas fa-book"></i> Ebooks</div>
                <h3 class="product-title">Mobile App Design Principles</h3>
                <p class="product-description">Essential guide to UX/UI design with templates and platform-specific guidelines.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$17.99</span>
                    <span class="price-original">$24.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Formats & Resources:</div>
                    <div class="tools-list">PDF, Figma Templates, Sketch Files, Design Assets</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=ebooks" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <!-- Audio Music -->
        <div class="product-card" style="position: relative;">
            <div class="featured-badge">Featured</div>
            <div class="product-header">
                <div class="product-category"><i class="fas fa-music"></i> Audio Music</div>
                <h3 class="product-title">Royalty-Free Music Pack Vol.1</h3>
                <p class="product-description">25 high-quality background music tracks for commercial use in MP3 and WAV formats.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$34.99</span>
                    <span class="price-original">$49.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Production Tools:</div>
                    <div class="tools-list">Pro Tools, Logic Pro X, Ableton Live, Audio Editing</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=audio-music" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="product-card">
            <div class="product-header">
                <div class="product-category"><i class="fas fa-music"></i> Audio Music</div>
                <h3 class="product-title">Sound Effects Library - 500+ SFX</h3>
                <p class="product-description">Comprehensive collection of 500+ professional sound effects for multimedia projects.</p>
            </div>
            <div class="product-details">
                <div class="product-price">
                    <span class="price-current">$24.99</span>
                    <span class="price-original">$34.99</span>
                </div>
                <div class="product-tools">
                    <div class="tools-label">Production Tools:</div>
                    <div class="tools-list">Pro Tools, Audacity, Reaper, Sound Forge</div>
                </div>
                <div class="product-actions">
                    <a href="products.php?category=audio-music" class="btn btn-primary">View Details</a>
                    <a href="#" class="btn btn-outline">Add to Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 3rem; padding: 2rem; background: white; border-radius: 12px;">
        <h2>🎉 All Products Successfully Added!</h2>
        <p>Your AA DIGITS store now has a complete collection of premium digital products across all categories.</p>
        <br>
        <a href="products.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 12px 24px;">
            <i class="fas fa-shopping-bag"></i> Browse All Products
        </a>
        <a href="categories.php" class="btn btn-outline" style="font-size: 1.1rem; padding: 12px 24px;">
            <i class="fas fa-tags"></i> View Categories
        </a>
    </div>
</body>
</html>
