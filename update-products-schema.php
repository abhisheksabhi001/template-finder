<?php
require_once 'config/config.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<h1>Updating Products Table Schema</h1>";
    echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}h1,h2{color:#333;}p{margin:10px 0;}.success{color:#059669;}.error{color:#dc2626;}</style>";
    
    // Check current table structure
    $stmt = $conn->query("DESCRIBE products");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Add missing columns
    $new_columns = [
        'tools_used' => "ALTER TABLE products ADD COLUMN tools_used TEXT AFTER tags",
        'demo_url' => "ALTER TABLE products ADD COLUMN demo_url VARCHAR(255) AFTER tools_used",
        'screenshots' => "ALTER TABLE products ADD COLUMN screenshots JSON AFTER demo_url"
    ];
    
    foreach ($new_columns as $column => $sql) {
        if (!in_array($column, $columns)) {
            try {
                $conn->exec($sql);
                echo "<p class='success'>✅ Added column: {$column}</p>";
            } catch (Exception $e) {
                echo "<p class='error'>❌ Failed to add column {$column}: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>ℹ️ Column '{$column}' already exists</p>";
        }
    }
    
    echo "<h2>✨ Schema Update Complete!</h2>";
    echo "<p><a href='add-sample-products.php' style='color:#3b82f6;'>Add Sample Products</a></p>";
    
} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p style='color:#dc2626;'>Error updating schema: " . $e->getMessage() . "</p>";
}
?>
