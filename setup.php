<?php
// Database Setup Script
require_once 'config/config.php';

echo "<h1>AA DIGITS - Database Setup</h1>";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception("Could not connect to database. Please check your database configuration.");
    }
    
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Read and execute schema
    $schema = file_get_contents('database/schema.sql');
    
    if (!$schema) {
        throw new Exception("Could not read schema.sql file");
    }
    
    // Split queries by semicolon and execute each one
    $queries = explode(';', $schema);
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            try {
                $conn->exec($query);
            } catch (PDOException $e) {
                // Ignore table already exists errors
                if (strpos($e->getMessage(), 'already exists') === false) {
                    echo "<p style='color: orange;'>Warning: " . $e->getMessage() . "</p>";
                }
            }
        }
    }
    
    echo "<p style='color: green;'>✓ Database schema created successfully</p>";
    
    // Insert sample products
    insertSampleProducts($conn);
    
    echo "<p style='color: green;'>✓ Sample products inserted</p>";
    
    echo "<h2>Setup Complete!</h2>";
    echo "<p>Your AA DIGITS website is now ready to use.</p>";
    echo "<p><strong>Default Admin Login:</strong></p>";
    echo "<p>Email: admin@aadigits.com<br>Password: admin123</p>";
    echo "<p><a href='index.php'>Go to Homepage</a> | <a href='admin/'>Admin Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

function insertSampleProducts($conn) {
    $sample_products = [
        [
            'title' => 'Modern Business Website Template',
            'slug' => 'modern-business-website-template',
            'description' => 'A professional and modern business website template built with HTML5, CSS3, and JavaScript. Perfect for corporate websites, agencies, and startups.',
            'short_description' => 'Professional business website template with modern design',
            'price' => 49.99,
            'sale_price' => 39.99,
            'category_id' => 1,
            'screenshots' => json_encode(['assets/images/products/template-1.jpg']),
            'tags' => 'business, corporate, website, template, html, css',
            'is_featured' => 1
        ],
        [
            'title' => 'E-commerce Mobile App UI Kit',
            'slug' => 'ecommerce-mobile-app-ui-kit',
            'description' => 'Complete mobile app UI kit for e-commerce applications. Includes 50+ screens, components, and design elements for iOS and Android.',
            'short_description' => 'Complete e-commerce mobile app UI kit with 50+ screens',
            'price' => 79.99,
            'sale_price' => null,
            'category_id' => 2,
            'screenshots' => json_encode(['assets/images/products/mobile-app-1.jpg']),
            'tags' => 'mobile, app, ui kit, ecommerce, ios, android',
            'is_featured' => 1
        ],
        [
            'title' => 'Premium Logo Design Collection',
            'slug' => 'premium-logo-design-collection',
            'description' => 'A collection of 100 premium logo designs in various styles. Perfect for businesses, startups, and personal brands. Includes vector files.',
            'short_description' => 'Collection of 100 premium logo designs with vector files',
            'price' => 29.99,
            'sale_price' => 19.99,
            'category_id' => 3,
            'screenshots' => json_encode(['assets/images/products/logos-1.jpg']),
            'tags' => 'logo, design, vector, branding, business',
            'is_featured' => 1
        ],
        [
            'title' => 'WordPress Theme - Creative Portfolio',
            'slug' => 'wordpress-theme-creative-portfolio',
            'description' => 'A stunning WordPress theme designed for creative professionals, photographers, and artists. Fully responsive and customizable.',
            'short_description' => 'Creative WordPress theme for portfolios and artists',
            'price' => 59.99,
            'sale_price' => null,
            'category_id' => 1,
            'screenshots' => json_encode(['assets/images/products/wordpress-1.jpg']),
            'tags' => 'wordpress, theme, portfolio, creative, photography',
            'is_featured' => 1
        ],
        [
            'title' => 'Social Media Graphics Pack',
            'slug' => 'social-media-graphics-pack',
            'description' => 'Complete social media graphics pack with templates for Instagram, Facebook, Twitter, and LinkedIn. Includes 200+ designs.',
            'short_description' => 'Social media graphics pack with 200+ templates',
            'price' => 24.99,
            'sale_price' => null,
            'category_id' => 3,
            'screenshots' => json_encode(['assets/images/products/social-media-1.jpg']),
            'tags' => 'social media, graphics, instagram, facebook, templates',
            'is_featured' => 1
        ],
        [
            'title' => 'React Admin Dashboard Template',
            'slug' => 'react-admin-dashboard-template',
            'description' => 'Modern admin dashboard template built with React.js. Includes charts, tables, forms, and various UI components.',
            'short_description' => 'Modern React.js admin dashboard template',
            'price' => 89.99,
            'sale_price' => 69.99,
            'category_id' => 1,
            'screenshots' => json_encode(['assets/images/products/react-dashboard-1.jpg']),
            'tags' => 'react, admin, dashboard, template, javascript',
            'is_featured' => 1
        ]
    ];
    
    $stmt = $conn->prepare("
        INSERT INTO products (title, slug, description, short_description, price, sale_price, category_id, screenshots, tags, is_featured) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    foreach ($sample_products as $product) {
        try {
            $stmt->execute([
                $product['title'],
                $product['slug'],
                $product['description'],
                $product['short_description'],
                $product['price'],
                $product['sale_price'],
                $product['category_id'],
                $product['screenshots'],
                $product['tags'],
                $product['is_featured']
            ]);
        } catch (PDOException $e) {
            // Product might already exist, skip
        }
    }
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    line-height: 1.6;
}

h1, h2 {
    color: #333;
}

p {
    margin: 10px 0;
}

a {
    color: #2563eb;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
