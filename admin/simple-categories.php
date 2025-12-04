<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - AA DIGITS Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8fafc; }
        .header { background: #1e40af; color: white; padding: 1rem 2rem; }
        .header h1 { font-size: 1.5rem; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .back-btn { background: #6b7280; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 6px; margin-bottom: 1rem; display: inline-block; }
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .category-card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .category-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .category-icon { width: 50px; height: 50px; background: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3b82f6; color: white; }
        .btn-success { background: #059669; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-tags"></i> Categories</h1>
    </div>
    
    <div class="container">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        
        <div style="margin-bottom: 2rem;">
            <button class="btn btn-success" onclick="alert('Add Category feature coming soon!')">
                <i class="fas fa-plus"></i> Add New Category
            </button>
        </div>
        
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span>
                </div>
                <h3>Web Templates</h3>
                <p style="color: #64748b; margin: 0.5rem 0;">Professional website templates and themes</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">25 Products</span>
                    <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                </div>
            </div>
            
            <div class="category-card">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span>
                </div>
                <h3>Mobile Apps</h3>
                <p style="color: #64748b; margin: 0.5rem 0;">Mobile application source codes and templates</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">18 Products</span>
                    <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                </div>
            </div>
            
            <div class="category-card">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span>
                </div>
                <h3>Graphics & Design</h3>
                <p style="color: #64748b; margin: 0.5rem 0;">Graphics, logos, and design resources</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">32 Products</span>
                    <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                </div>
            </div>
            
            <div class="category-card">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Active</span>
                </div>
                <h3>Software Tools</h3>
                <p style="color: #64748b; margin: 0.5rem 0;">Utility software and development tools</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <span style="color: #64748b; font-size: 0.9rem;">12 Products</span>
                    <button class="btn btn-primary" onclick="alert('Edit feature coming soon!')">Edit</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
