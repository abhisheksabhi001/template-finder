<?php
require_once 'config/config.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Categories to add
    $categories = [
        [
            'name' => 'Web Templates',
            'slug' => 'web-templates',
            'description' => 'Professional website templates and themes for modern web development',
            'icon' => 'code'
        ],
        [
            'name' => 'Mobile Apps',
            'slug' => 'mobile-apps', 
            'description' => 'Mobile application source codes and UI kits for iOS and Android',
            'icon' => 'mobile-alt'
        ],
        [
            'name' => 'Graphics Design',
            'slug' => 'graphics-design',
            'description' => 'Graphics, logos, icons, and design resources for creative projects',
            'icon' => 'paint-brush'
        ],
        [
            'name' => 'Software Tools',
            'slug' => 'software-tools',
            'description' => 'Utility software, plugins, and development tools',
            'icon' => 'tools'
        ],
        [
            'name' => 'Ebooks',
            'slug' => 'ebooks',
            'description' => 'Digital books, guides, and educational resources',
            'icon' => 'book'
        ],
        [
            'name' => 'Audio Music',
            'slug' => 'audio-music',
            'description' => 'Music tracks, sound effects, and audio resources',
            'icon' => 'music'
        ]
    ];
    
    echo "<h1>Setting up Categories</h1>";
    
    // Check if categories table exists and has slug column
    $check_table = $conn->query("DESCRIBE categories");
    $columns = $check_table->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('slug', $columns)) {
        echo "<p>Adding slug column to categories table...</p>";
        $conn->exec("ALTER TABLE categories ADD COLUMN slug VARCHAR(100) UNIQUE AFTER name");
    }
    
    if (!in_array('icon', $columns)) {
        echo "<p>Adding icon column to categories table...</p>";
        $conn->exec("ALTER TABLE categories ADD COLUMN icon VARCHAR(50) DEFAULT 'folder' AFTER description");
    }
    
    foreach ($categories as $category) {
        // Check if category already exists
        $stmt = $conn->prepare("SELECT id FROM categories WHERE slug = ? OR name = ?");
        $stmt->execute([$category['slug'], $category['name']]);
        
        if ($stmt->fetch()) {
            echo "<p>✓ Category '{$category['name']}' already exists</p>";
            continue;
        }
        
        // Insert new category
        $stmt = $conn->prepare("
            INSERT INTO categories (name, slug, description, icon, is_active, created_at) 
            VALUES (?, ?, ?, ?, 1, NOW())
        ");
        
        if ($stmt->execute([$category['name'], $category['slug'], $category['description'], $category['icon']])) {
            echo "<p>✅ Added category: {$category['name']}</p>";
        } else {
            echo "<p>❌ Failed to add category: {$category['name']}</p>";
        }
    }
    
    echo "<h2>Categories Setup Complete!</h2>";
    echo "<p><a href='categories.php'>View Categories</a> | <a href='products.php'>View Products</a></p>";
    
} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p>Error setting up categories: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
h1, h2 { color: #333; }
p { margin: 10px 0; }
a { color: #3b82f6; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
