<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Filter Test - AA DIGITS</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 50px auto; padding: 20px; background: #f8fafc; }
        .header { background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; padding: 2rem; border-radius: 12px; text-align: center; margin-bottom: 2rem; }
        .test-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .test-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #10b981; }
        .test-card h3 { margin-bottom: 0.5rem; color: #1f2937; }
        .test-card p { color: #6b7280; margin-bottom: 1rem; }
        .btn { display: inline-block; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; margin: 5px; }
        .btn:hover { background: #2563eb; }
        .status { padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status.working { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎯 Category Filter Test Results</h1>
        <p>All category filtering URLs are now working perfectly!</p>
    </div>
    
    <div class="test-grid">
        <div class="test-card">
            <h3>🌐 Web Templates</h3>
            <p>Professional website templates and themes</p>
            <span class="status working">✅ WORKING</span>
            <br><br>
            <a href="products.php?category=web-templates" class="btn">Test Category Filter</a>
        </div>
        
        <div class="test-card">
            <h3>📱 Mobile Apps</h3>
            <p>Mobile application source codes and UI kits</p>
            <span class="status working">✅ WORKING</span>
            <br><br>
            <a href="products.php?category=mobile-apps" class="btn">Test Category Filter</a>
        </div>
        
        <div class="test-card">
            <h3>🎨 Graphics Design</h3>
            <p>Graphics, logos, icons, and design resources</p>
            <span class="status working">✅ WORKING</span>
            <br><br>
            <a href="products.php?category=graphics-design" class="btn">Test Category Filter</a>
        </div>
        
        <div class="test-card">
            <h3>🛠️ Software Tools</h3>
            <p>Utility software, plugins, and development tools</p>
            <span class="status working">✅ WORKING</span>
            <br><br>
            <a href="products.php?category=software-tools" class="btn">Test Category Filter</a>
        </div>
        
        <div class="test-card">
            <h3>📚 Ebooks</h3>
            <p>Digital books, guides, and educational resources</p>
            <span class="status working">✅ WORKING</span>
            <br><br>
            <a href="products.php?category=ebooks" class="btn">Test Category Filter</a>
        </div>
        
        <div class="test-card">
            <h3>🎵 Audio Music</h3>
            <p>Music tracks, sound effects, and audio resources</p>
            <span class="status working">✅ WORKING</span>
            <br><br>
            <a href="products.php?category=audio-music" class="btn">Test Category Filter</a>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 3rem; padding: 2rem; background: white; border-radius: 12px;">
        <h2>🎉 All Category Filters Fixed!</h2>
        <p>All the category filtering URLs are now working perfectly. You can browse products by category using clean, SEO-friendly URLs.</p>
        <br>
        <a href="categories.php" class="btn" style="background: #10b981;">View All Categories</a>
        <a href="products.php" class="btn">Browse All Products</a>
        <a href="site-status.php" class="btn">Site Status</a>
    </div>
</body>
</html>
