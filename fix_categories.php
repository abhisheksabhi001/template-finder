<?php
// Fix Categories Script
require_once 'config/config.php';
require_once 'classes/Database.php';

$database = new Database();
$conn = $database->getConnection();

try {
    // Update existing categories
    $update_categories = [
        ['id' => 1, 'name' => 'Web Templates', 'slug' => 'web-templates', 'description' => 'Premium website templates for various industries'],
        ['id' => 2, 'Mobile Apps', 'mobile-apps', 'Mobile application templates and UI kits'],
        ['id' => 3, 'name' => 'Graphics & Design', 'slug' => 'graphics-design', 'description' => 'Icons, logos, and graphic elements'],
        ['id' => 4, 'name' => 'Software & Tools', 'slug' => 'software-tools', 'description' => 'Useful software applications and utilities'],
        ['id' => 5, 'name' => 'eBooks', 'slug' => 'ebooks', 'description' => 'Digital books and guides for learning and reference'],
        ['id' => 6, 'name' => 'Audio & Music', 'slug' => 'audio-music', 'description' => 'Sound effects, music tracks, and audio tools']
    ];

    $stmt = $conn->prepare("INSERT INTO categories (id, name, slug, description) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), slug = VALUES(slug), description = VALUES(description)");
    
    foreach ($update_categories as $category) {
        $stmt->execute([$category['id'], $category['name'], $category['slug'], $category['description']]);
    }

    // Add sample products if they don't exist
    $sample_products = [
        // Web Templates
        ['Ecommerce Store', 'ecommerce-store', 'Complete eCommerce template with shopping cart and checkout', 49.99, 1],
        ['Portfolio Template', 'portfolio-template', 'Minimalist portfolio template for creative professionals', 39.99, 1],
        
        // Mobile Apps
        ['Fitness Tracker App', 'fitness-tracker', 'Complete fitness tracking application with workout plans', 89.99, 2],
        ['Food Delivery App', 'food-delivery', 'Food delivery app with real-time tracking', 99.99, 2],
        
        // Graphics & Design
        ['Business Logo Pack', 'business-logo-pack', 'Professional logo templates for businesses', 19.99, 3],
        
        // Software & Tools
        ['PDF Converter Pro', 'pdf-converter', 'Convert any document to PDF format', 29.99, 4],
        
        // eBooks
        ['Web Development Guide', 'web-dev-guide', 'Complete guide to modern web development', 24.99, 5],
        
        // Audio & Music
        ['Royalty Free Music Pack', 'music-pack-1', '10 royalty-free background music tracks', 14.99, 6]
    ];

    $stmt = $conn->prepare("INSERT IGNORE INTO products (title, slug, description, price, category_id, is_featured, is_active) VALUES (?, ?, ?, ?, ?, 1, 1)");
    
    foreach ($sample_products as $product) {
        $stmt->execute($product);
    }

    echo "<h2>Categories and products have been updated successfully!</h2>";
    echo "<p>You can now access the following category pages:</p>";
    echo "<ul>";
    echo "<li><a href='products.php'>All Products</a></li>";
    foreach ($update_categories as $cat) {
        echo "<li><a href='products.php?category=" . $cat['slug'] . "'>" . $cat['name'] . "</a></li>";
    }
    echo "</ul>";
    
    echo "<p>If you still see issues, please clear your browser cache (Ctrl+F5) and try again.</p>";
    
} catch(PDOException $e) {
    echo "<h2>Error updating categories:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Please check your database connection in config/database.php</p>";
}
?>

<style>
    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
    h2 { color: #4CAF50; }
    ul { list-style-type: none; padding: 0; }
    li { margin: 10px 0; }
    a { 
        display: inline-block;
        padding: 10px 15px;
        background: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }
    a:hover { background: #45a049; }
</style>
