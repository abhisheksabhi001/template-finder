<?php
require_once 'config/config.php';
require_once 'classes/Database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    echo "Database connection successful!<br>";
    
    // Check products table
    $tables = $conn->query("SHOW TABLES LIKE 'products'")->rowCount();
    echo "Products table exists: " . ($tables > 0 ? 'Yes' : 'No') . "<br>";
    
    if ($tables > 0) {
        $count = $conn->query("SELECT COUNT(*) as count FROM products")->fetch();
        echo "Number of products: " . $count['count'] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>
