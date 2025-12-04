<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Mode Test - AA DIGITS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .test-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .test-card {
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }
        .theme-info {
            background: var(--bg-primary);
            color: var(--text-secondary);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .btn {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 0.5rem;
        }
        .btn:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-card">
            <h1>🌙 Dark Mode Test</h1>
            <p>This page tests dark mode functionality across the site.</p>
            
            <div class="theme-info">
                <strong>Current Theme:</strong> <span id="current-theme">Loading...</span><br>
                <strong>Theme Toggles Found:</strong> <span id="toggle-count">Loading...</span><br>
                <strong>Local Storage:</strong> <span id="local-storage">Loading...</span>
            </div>
            
            <button class="btn theme-toggle">
                <i class="fas fa-moon"></i> Toggle Theme
            </button>
            
            <button class="btn" onclick="testCategories()">
                Test Categories Page
            </button>
            
            <button class="btn" onclick="testProducts()">
                Test Products Page
            </button>
            
            <div id="test-results" style="margin-top: 2rem;"></div>
        </div>
        
        <div class="test-card">
            <h2>Theme Variables Test</h2>
            <div style="background: var(--bg-primary); color: var(--text-primary); padding: 1rem; margin: 1rem 0; border-radius: 8px;">
                Primary Background & Text
            </div>
            <div style="background: var(--bg-secondary); color: var(--text-secondary); padding: 1rem; margin: 1rem 0; border-radius: 8px;">
                Secondary Background & Text
            </div>
            <div style="background: var(--primary-color); color: white; padding: 1rem; margin: 1rem 0; border-radius: 8px;">
                Primary Color
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
    <script>
        function updateThemeInfo() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const toggleCount = document.querySelectorAll('.theme-toggle').length;
            const localStorage = window.localStorage.getItem('theme') || 'not set';
            
            document.getElementById('current-theme').textContent = currentTheme;
            document.getElementById('toggle-count').textContent = toggleCount;
            document.getElementById('local-storage').textContent = localStorage;
        }
        
        function testCategories() {
            window.open('categories.php', '_blank');
        }
        
        function testProducts() {
            window.open('products.php', '_blank');
        }
        
        // Update info on load
        document.addEventListener('DOMContentLoaded', function() {
            updateThemeInfo();
            
            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                        updateThemeInfo();
                    }
                });
            });
            
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['data-theme']
            });
        });
    </script>
</body>
</html>
