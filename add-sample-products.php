<?php
require_once 'config/config.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Get category IDs
    $categories = [];
    $stmt = $conn->query("SELECT id, name, slug FROM categories WHERE is_active = 1");
    while ($row = $stmt->fetch()) {
        $categories[$row['slug']] = $row['id'];
    }
    
    // Sample products to add
    $products = [
        // Web Templates
        [
            'title' => 'Modern Business Website Template',
            'slug' => 'modern-business-website-template',
            'short_description' => 'Professional responsive business website template with modern design',
            'description' => 'A complete modern business website template featuring responsive design, contact forms, portfolio sections, and SEO optimization. Perfect for agencies, startups, and corporate websites. Includes HTML, CSS, JavaScript, and documentation.',
            'price' => 49.99,
            'sale_price' => 39.99,
            'category_id' => $categories['web-templates'] ?? 1,
            'tags' => 'html, css, javascript, responsive, business, corporate',
            'is_featured' => 1,
            'tools' => 'HTML5, CSS3, JavaScript, Bootstrap 5, Font Awesome',
            'demo_url' => 'https://demo.example.com/business-template'
        ],
        [
            'title' => 'E-commerce Store Template',
            'slug' => 'ecommerce-store-template',
            'short_description' => 'Complete e-commerce website template with shopping cart functionality',
            'description' => 'Full-featured e-commerce template with product catalog, shopping cart, checkout process, and admin panel. Built with modern technologies and optimized for conversions. Includes payment gateway integration guides.',
            'price' => 79.99,
            'sale_price' => 59.99,
            'category_id' => $categories['web-templates'] ?? 1,
            'tags' => 'ecommerce, shopping, cart, payment, store',
            'is_featured' => 1,
            'tools' => 'React.js, Node.js, MongoDB, Stripe API, PayPal Integration',
            'demo_url' => 'https://demo.example.com/ecommerce-template'
        ],
        
        // Mobile Apps
        [
            'title' => 'iOS Social Media App Template',
            'slug' => 'ios-social-media-app-template',
            'short_description' => 'Complete iOS app template for social media applications',
            'description' => 'Professional iOS app template with user authentication, photo sharing, messaging, and social features. Built with Swift and includes all necessary UI components, animations, and backend integration examples.',
            'price' => 129.99,
            'sale_price' => 99.99,
            'category_id' => $categories['mobile-apps'] ?? 2,
            'tags' => 'ios, swift, social media, chat, photos',
            'is_featured' => 1,
            'tools' => 'Xcode, Swift 5, UIKit, Core Data, Firebase',
            'demo_url' => 'https://apps.apple.com/demo/social-app'
        ],
        [
            'title' => 'Android E-commerce App Template',
            'slug' => 'android-ecommerce-app-template',
            'short_description' => 'Feature-rich Android shopping app template with modern UI',
            'description' => 'Complete Android e-commerce app template with product browsing, cart management, payment integration, and user accounts. Features material design, smooth animations, and offline support.',
            'price' => 119.99,
            'sale_price' => 89.99,
            'category_id' => $categories['mobile-apps'] ?? 2,
            'tags' => 'android, kotlin, ecommerce, material design, shopping',
            'is_featured' => 1,
            'tools' => 'Android Studio, Kotlin, Material Design, Room Database, Retrofit',
            'demo_url' => 'https://play.google.com/demo/ecommerce-app'
        ],
        
        // Graphics Design
        [
            'title' => 'Premium Logo Design Bundle',
            'slug' => 'premium-logo-design-bundle',
            'short_description' => '50+ professional logo designs in multiple formats',
            'description' => 'Comprehensive logo design bundle featuring 50+ unique, professional logos suitable for various industries. Each logo comes in multiple formats (AI, EPS, PNG, SVG) and color variations. Perfect for businesses, startups, and design projects.',
            'price' => 39.99,
            'sale_price' => 29.99,
            'category_id' => $categories['graphics-design'] ?? 3,
            'tags' => 'logo, branding, vector, ai, eps, business',
            'is_featured' => 1,
            'tools' => 'Adobe Illustrator, Photoshop, Figma, Sketch',
            'demo_url' => 'https://demo.example.com/logo-bundle'
        ],
        [
            'title' => 'Icon Pack Collection - 1000+ Icons',
            'slug' => 'icon-pack-collection-1000-icons',
            'short_description' => 'Massive collection of 1000+ premium icons in multiple styles',
            'description' => 'Ultimate icon collection featuring over 1000 carefully crafted icons in various styles including line, filled, outline, and duotone. Available in SVG, PNG, and icon font formats. Perfect for web, mobile, and print projects.',
            'price' => 24.99,
            'sale_price' => 19.99,
            'category_id' => $categories['graphics-design'] ?? 3,
            'tags' => 'icons, svg, png, ui, interface, design',
            'is_featured' => 0,
            'tools' => 'Adobe Illustrator, Figma, Sketch, IconJar',
            'demo_url' => 'https://demo.example.com/icon-collection'
        ],
        
        // Software Tools
        [
            'title' => 'Website Builder Pro',
            'slug' => 'website-builder-pro',
            'short_description' => 'Drag-and-drop website builder with advanced features',
            'description' => 'Professional website builder software with drag-and-drop interface, responsive templates, SEO tools, and e-commerce integration. Build stunning websites without coding knowledge. Includes hosting integration and domain management.',
            'price' => 199.99,
            'sale_price' => 149.99,
            'category_id' => $categories['software-tools'] ?? 4,
            'tags' => 'website builder, drag drop, templates, seo, ecommerce',
            'is_featured' => 1,
            'tools' => 'Electron, React, Node.js, MongoDB, AWS Integration',
            'demo_url' => 'https://demo.example.com/website-builder'
        ],
        [
            'title' => 'Code Editor Plus',
            'slug' => 'code-editor-plus',
            'short_description' => 'Advanced code editor with syntax highlighting and plugins',
            'description' => 'Feature-rich code editor supporting 50+ programming languages with syntax highlighting, auto-completion, plugin system, and integrated terminal. Perfect for developers and programmers working on multiple projects.',
            'price' => 89.99,
            'sale_price' => 69.99,
            'category_id' => $categories['software-tools'] ?? 4,
            'tags' => 'code editor, programming, syntax, plugins, terminal',
            'is_featured' => 0,
            'tools' => 'Electron, Monaco Editor, Node.js, TypeScript',
            'demo_url' => 'https://demo.example.com/code-editor'
        ],
        
        // Ebooks
        [
            'title' => 'Complete Web Development Guide 2025',
            'slug' => 'complete-web-development-guide-2025',
            'short_description' => 'Comprehensive guide to modern web development technologies',
            'description' => 'Master modern web development with this comprehensive 500-page guide covering HTML5, CSS3, JavaScript, React, Node.js, databases, and deployment. Includes practical projects, code examples, and industry best practices.',
            'price' => 29.99,
            'sale_price' => 19.99,
            'category_id' => $categories['ebooks'] ?? 5,
            'tags' => 'web development, html, css, javascript, react, nodejs',
            'is_featured' => 1,
            'tools' => 'PDF, EPUB, Code Examples, Project Files',
            'demo_url' => 'https://demo.example.com/web-dev-guide'
        ],
        [
            'title' => 'Mobile App Design Principles',
            'slug' => 'mobile-app-design-principles',
            'short_description' => 'Essential guide to creating stunning mobile app interfaces',
            'description' => 'Learn the principles of mobile app design with this detailed guide covering UX/UI design, user psychology, design patterns, and platform-specific guidelines for iOS and Android. Includes design templates and resources.',
            'price' => 24.99,
            'sale_price' => 17.99,
            'category_id' => $categories['ebooks'] ?? 5,
            'tags' => 'mobile design, ui ux, ios, android, app design',
            'is_featured' => 0,
            'tools' => 'PDF, Figma Templates, Sketch Files, Design Assets',
            'demo_url' => 'https://demo.example.com/mobile-design-guide'
        ],
        
        // Audio Music
        [
            'title' => 'Royalty-Free Music Pack Vol.1',
            'slug' => 'royalty-free-music-pack-vol1',
            'short_description' => '25 high-quality background music tracks for commercial use',
            'description' => 'Professional collection of 25 royalty-free music tracks perfect for videos, presentations, podcasts, and commercial projects. Includes various genres: corporate, upbeat, ambient, and cinematic. All tracks are high-quality 320kbps MP3 and WAV formats.',
            'price' => 49.99,
            'sale_price' => 34.99,
            'category_id' => $categories['audio-music'] ?? 6,
            'tags' => 'royalty free, music, background, commercial, mp3, wav',
            'is_featured' => 1,
            'tools' => 'Pro Tools, Logic Pro X, Ableton Live, Audio Editing',
            'demo_url' => 'https://demo.example.com/music-pack'
        ],
        [
            'title' => 'Sound Effects Library - 500+ SFX',
            'slug' => 'sound-effects-library-500-sfx',
            'short_description' => 'Comprehensive sound effects library for multimedia projects',
            'description' => 'Massive collection of over 500 professional sound effects including UI sounds, nature sounds, mechanical sounds, and ambient textures. Perfect for games, apps, videos, and multimedia presentations. High-quality WAV format.',
            'price' => 34.99,
            'sale_price' => 24.99,
            'category_id' => $categories['audio-music'] ?? 6,
            'tags' => 'sound effects, sfx, games, ui sounds, ambient',
            'is_featured' => 0,
            'tools' => 'Pro Tools, Audacity, Reaper, Sound Forge',
            'demo_url' => 'https://demo.example.com/sound-effects'
        ]
    ];
    
    echo "<h1>Adding Sample Products</h1>";
    echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}h1,h2{color:#333;}p{margin:10px 0;}.success{color:#059669;}.error{color:#dc2626;}</style>";
    
    foreach ($products as $product) {
        // Check if product already exists
        $stmt = $conn->prepare("SELECT id FROM products WHERE slug = ?");
        $stmt->execute([$product['slug']]);
        
        if ($stmt->fetch()) {
            echo "<p class='error'>⚠️ Product '{$product['title']}' already exists</p>";
            continue;
        }
        
        // Insert new product
        $stmt = $conn->prepare("
            INSERT INTO products (
                title, slug, short_description, description, price, sale_price, 
                category_id, tags, is_featured, is_active, created_at,
                demo_url, tools_used
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), ?, ?)
        ");
        
        $result = $stmt->execute([
            $product['title'],
            $product['slug'],
            $product['short_description'],
            $product['description'],
            $product['price'],
            $product['sale_price'],
            $product['category_id'],
            $product['tags'],
            $product['is_featured'],
            $product['demo_url'],
            $product['tools']
        ]);
        
        if ($result) {
            echo "<p class='success'>✅ Added: {$product['title']} - \${$product['sale_price']}</p>";
        } else {
            echo "<p class='error'>❌ Failed to add: {$product['title']}</p>";
        }
    }
    
    echo "<h2>✨ Sample Products Added Successfully!</h2>";
    echo "<p><a href='products.php' style='color:#3b82f6;'>View Products Page</a> | <a href='categories.php' style='color:#3b82f6;'>View Categories</a></p>";
    
} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p style='color:#dc2626;'>Error adding products: " . $e->getMessage() . "</p>";
}
?>
