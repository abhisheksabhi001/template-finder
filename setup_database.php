<?php
// Database setup script
require_once 'config/config.php';
require_once 'classes/Database.php';

$database = new Database();
$conn = $database->getConnection();

// SQL to create categories table
$sql_categories = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id INT DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// SQL to create products table
$sql_products = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description LONGTEXT,
    short_description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    sale_price DECIMAL(10, 2) DEFAULT NULL,
    category_id INT,
    file_path VARCHAR(255),
    file_size INT,
    demo_url VARCHAR(255),
    screenshots TEXT,
    tags VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    meta_title VARCHAR(255),
    meta_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_slug (slug),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// SQL to insert sample categories
$sql_insert_categories = "
INSERT IGNORE INTO categories (id, name, slug, description) VALUES 
(1, 'Web Templates', 'web-templates', 'Premium website templates for various industries'),
(2, 'Mobile Apps', 'mobile-apps', 'Mobile application templates and UI kits'),
(3, 'Graphics', 'graphics', 'Icons, logos, and graphic elements'),
(4, 'Plugins', 'plugins', 'WordPress and other CMS plugins'),
(5, 'UI Kits', 'ui-kits', 'User interface component libraries')";

// SQL to insert sample products
$sql_insert_products = "
INSERT IGNORE INTO products (title, slug, description, price, category_id, is_featured, is_active) VALUES 
('Ecommerce Store Template', 'ecommerce-store-template', 'A modern and responsive eCommerce template with all the essential features for your online store.', 49.99, 1, 1, 1),
('iOS Social Media App', 'ios-social-media-app', 'A fully functional iOS social media app template built with SwiftUI and Firebase backend.', 99.99, 2, 1, 1),
('Fitness Tracker App', 'fitness-tracker-app', 'Complete fitness tracking application with workout plans and progress tracking.', 89.99, 2, 1, 1),
('Restaurant Website Template', 'restaurant-website-template', 'Elegant website template for restaurants and cafes with online ordering system.', 39.99, 1, 0, 1),
('Portfolio Template', 'portfolio-template', 'Minimalist portfolio template for creative professionals and agencies.', 29.99, 1, 0, 1),
('WordPress Business Theme', 'wordpress-business-theme', 'Professional WordPress theme for business websites with customizer options.', 59.99, 4, 1, 1)";

try {
    // Create tables
    $conn->exec($sql_categories);
    $conn->exec($sql_products);
    
    // Insert sample data
    $conn->exec($sql_insert_categories);
    $conn->exec($sql_insert_products);
    
    echo "Database setup completed successfully!<br>";
    echo "<a href='products.php'>View Products</a>";
    
} catch(PDOException $e) {
    echo "Error setting up database: " . $e->getMessage();
}
?>
