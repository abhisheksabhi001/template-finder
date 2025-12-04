<?php
// Test file to check if template-details.php works
require_once 'config/config.php';
require_once 'classes/Product.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes with database connection
$product = new Product($db);

// Check if we can get a product
$test_product = null;
try {
    $test_product = $product->getProductById(1);
    if ($test_product) {
        echo "Product found: " . $test_product['title'];
    } else {
        echo "No product found with ID 1";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Try to get all products
try {
    $all_products = $product->getAllProducts(1, 0);
    echo "<br>Total products: " . count($all_products);
    if (!empty($all_products)) {
        echo "<br>First product ID: " . $all_products[0]['id'];
    }
} catch (Exception $e) {
    echo "<br>Error getting all products: " . $e->getMessage();
}

// Check database connection
if ($db) {
    echo "<br>Database connected successfully";
} else {
    echo "<br>Database connection failed";
}
?>
