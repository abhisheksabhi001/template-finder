<?php
require_once 'config/config.php';
require_once 'classes/Product.php';
require_once 'classes/Category.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes
$product = new Product($db);
$category = new Category($db);

// Check if products table exists and has data
try {
    $query = "SELECT COUNT(*) as count FROM products";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Products in database: " . $result['count'] . "<br>";
    
    if ($result['count'] == 0) {
        // Add a test product
        $query = "INSERT INTO products (title, description, price, category_id, is_active, is_featured, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'Modern Business Template',
            'A professional business website template with modern design and responsive layout.',
            29.99,
            1,
            1,
            1
        ]);
        
        echo "Test product added successfully!<br>";
        
        // Get the ID of the inserted product
        $product_id = $db->lastInsertId();
        echo "New product ID: " . $product_id . "<br>";
        
        // Add more test products
        $test_products = [
            [
                'title' => 'Creative Portfolio Template',
                'description' => 'Stunning portfolio template for creative professionals',
                'price' => 24.99,
                'category_id' => 2,
                'is_active' => 1,
                'is_featured' => 1
            ],
            [
                'title' => 'E-commerce Pro Template',
                'description' => 'Complete e-commerce solution with shopping cart',
                'price' => 39.99,
                'category_id' => 3,
                'is_active' => 1,
                'is_featured' => 1
            ],
            [
                'title' => 'Restaurant Menu Template',
                'description' => 'Elegant restaurant website with online ordering',
                'price' => 19.99,
                'category_id' => 4,
                'is_active' => 1,
                'is_featured' => 0
            ],
            [
                'title' => 'Personal Blog Template',
                'description' => 'Clean and modern blog template for writers',
                'price' => 14.99,
                'category_id' => 5,
                'is_active' => 1,
                'is_featured' => 1
            ],
            [
                'title' => 'Creative Agency Template',
                'description' => 'Bold and creative agency website template',
                'price' => 34.99,
                'category_id' => 6,
                'is_active' => 1,
                'is_featured' => 1
            ]
        ];
        
        foreach ($test_products as $p) {
            $stmt = $db->prepare($query);
            $stmt->execute([
                $p['title'],
                $p['description'],
                $p['price'],
                $p['category_id'],
                $p['is_active'],
                $p['is_featured']
            ]);
        }
        
        echo "All test products added successfully!<br>";
    }
    
    // Now try to get a product
    $test_product = $product->getProductById(1);
    if ($test_product) {
        echo "Product found: " . $test_product['title'] . "<br>";
        echo "<a href='template-details.php?id=1'>View Product Details</a><br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    
    // Try to create the products table
    try {
        $create_table = "
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            sale_price DECIMAL(10,2) DEFAULT 0,
            category_id INT,
            slug VARCHAR(255),
            screenshots TEXT,
            tags VARCHAR(500),
            is_active TINYINT(1) DEFAULT 1,
            is_featured TINYINT(1) DEFAULT 0,
            average_rating DECIMAL(3,2) DEFAULT 0,
            review_count INT DEFAULT 0,
            downloads INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $db->exec($create_table);
        echo "Products table created successfully!<br>";
        
        // Add test products
        $insert_query = "INSERT INTO products (title, description, price, category_id, is_active, is_featured, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($insert_query);
        $stmt->execute([
            'Modern Business Template',
            'A professional business website template with modern design and responsive layout.',
            29.99,
            1,
            1,
            1
        ]);
        
        echo "Test product added!<br>";
        
    } catch (Exception $e2) {
        echo "Error creating table: " . $e2->getMessage() . "<br>";
    }
}
?>
