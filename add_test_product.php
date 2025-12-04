<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/Product.php';

// Check if categories exist first
$database = new Database();
$conn = $database->getConnection();
$stmt = $conn->query("SELECT id FROM categories LIMIT 1");
$category = $stmt->fetch();

if (!$category) {
    // Create a test category if none exists
    $conn->exec("INSERT INTO categories (name, slug, description, is_active) 
                VALUES ('Test Category', 'test-category', 'A test category', 1)");
    $category_id = $conn->lastInsertId();
} else {
    $category_id = $category['id'];
}

// Add a test product
$product = new Product();
$test_product = [
    'title' => 'Test Product',
    'slug' => 'test-product',
    'description' => 'This is a test product',
    'short_description' => 'Test product short description',
    'price' => 99.99,
    'sale_price' => 79.99,
    'category_id' => $category_id,
    'file_path' => 'test/product.zip',
    'file_size' => '10MB',
    'demo_url' => 'https://example.com/demo',
    'screenshots' => '[]',
    'tags' => 'test, sample',
    'is_featured' => 1,
    'meta_title' => 'Test Product',
    'meta_description' => 'Test product meta description'
];

$product_id = $product->createProduct($test_product);

if ($product_id) {
    echo "Test product added successfully! ID: " . $product_id . "<br>";
    echo "<a href='products.php'>View Products Page</a>";
} else {
    echo "Failed to add test product. Check error logs.";
}
?>
