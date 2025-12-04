<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Products Page</h1>";
echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}h1,h2{color:#333;}p{margin:10px 0;}.success{color:#059669;}.error{color:#dc2626;}</style>";

try {
    echo "<p>1. Loading config...</p>";
    require_once 'config/config.php';
    echo "<p class='success'>✅ Config loaded</p>";
    
    echo "<p>2. Loading Product class...</p>";
    require_once 'classes/Product.php';
    echo "<p class='success'>✅ Product class loaded</p>";
    
    echo "<p>3. Creating Product instance...</p>";
    $product = new Product();
    echo "<p class='success'>✅ Product instance created</p>";
    
    echo "<p>4. Testing getAllProducts...</p>";
    $products = $product->getAllProducts(5, 0);
    echo "<p class='success'>✅ Found " . count($products) . " products</p>";
    
    if (!empty($products)) {
        echo "<h2>Sample Products:</h2>";
        foreach ($products as $p) {
            echo "<p>• {$p['title']} - \${$p['price']}</p>";
        }
    }
    
    echo "<p>5. Testing getProductsCount...</p>";
    $total = $product->getProductsCount();
    echo "<p class='success'>✅ Total products: {$total}</p>";
    
    echo "<p>6. Testing categories...</p>";
    $database = new Database();
    $conn = $database->getConnection();
    $categories_stmt = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
    $categories = $categories_stmt->fetchAll();
    echo "<p class='success'>✅ Found " . count($categories) . " categories</p>";
    
    foreach ($categories as $cat) {
        echo "<p>• {$cat['name']} (ID: {$cat['id']})</p>";
    }
    
    echo "<h2>✅ All tests passed! Products page should work.</h2>";
    echo "<p><a href='products.php'>Test Products Page</a></p>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p class='error'>File: " . $e->getFile() . "</p>";
    echo "<p class='error'>Line: " . $e->getLine() . "</p>";
}
?>
