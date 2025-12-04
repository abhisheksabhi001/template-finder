<?php
require_once 'config/config.php';
require_once 'classes/Product.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes with database connection
$product = new Product($db);

// Get template ID from URL
$template_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get template details
$template = null;
if ($template_id > 0) {
    $template = $product->getProductById($template_id);
}

// If template not found, show error
if (!$template) {
    echo '<div style="display: flex; align-items: center; justify-content: center; height: 100vh; font-family: Arial, sans-serif;">';
    echo '<div style="text-align: center;">';
    echo '<h1>Template Not Found</h1>';
    echo '<p>The requested template could not be found.</p>';
    echo '<a href="javascript:window.close();" style="color: #007bff; text-decoration: none;">Close Preview</a>';
    echo '</div>';
    echo '</div>';
    exit;
}

// Get screenshots
$screenshots = !empty($template['screenshots']) ? json_decode($template['screenshots'], true) : [];
if (empty($screenshots)) {
    $screenshots = [
        'https://via.placeholder.com/1200x800/f8f9fa/6c757d?text=Homepage+Preview',
        'https://via.placeholder.com/1200x800/f8f9fa/6c757d?text=About+Page',
        'https://via.placeholder.com/1200x800/f8f9fa/6c757d?text=Services+Page',
        'https://via.placeholder.com/1200x800/f8f9fa/6c757d?text=Contact+Page'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: <?php echo htmlspecialchars($template['title']); ?> - AA DIGITS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }
        
        .preview-header {
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }
        
        .preview-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .device-selector {
            display: flex;
            gap: 0.5rem;
            background: #f8f9fa;
            padding: 0.25rem;
            border-radius: 8px;
        }
        
        .device-btn {
            padding: 0.5rem 1rem;
            border: none;
            background: transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }
        
        .device-btn.active {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .device-btn:hover {
            background: #e9ecef;
        }
        
        .preview-content {
            margin-top: 80px;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .preview-frame {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .preview-frame.desktop {
            width: 100%;
            max-width: 1200px;
            height: 80vh;
        }
        
        .preview-frame.tablet {
            width: 768px;
            height: 90vh;
        }
        
        .preview-frame.mobile {
            width: 375px;
            height: 90vh;
        }
        
        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .preview-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .preview-nav:hover {
            background: #fff;
            transform: translateY(-50%) scale(1.1);
        }
        
        .preview-nav.prev {
            left: 20px;
        }
        
        .preview-nav.next {
            right: 20px;
        }
        
        .preview-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }
        
        .preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .preview-dot.active {
            background: #fff;
            width: 30px;
            border-radius: 5px;
        }
        
        .close-preview {
            padding: 0.5rem 1.5rem;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .close-preview:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        
        .buy-template {
            padding: 0.5rem 1.5rem;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .buy-template:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }
        
        @media (max-width: 768px) {
            .preview-header {
                padding: 1rem;
            }
            
            .preview-title {
                font-size: 1rem;
            }
            
            .device-selector {
                display: none;
            }
            
            .preview-content {
                padding: 1rem;
                margin-top: 60px;
            }
            
            .preview-frame {
                width: 100%;
                height: 70vh;
            }
            
            .preview-nav {
                width: 30px;
                height: 30px;
            }
            
            .preview-nav.prev {
                left: 10px;
            }
            
            .preview-nav.next {
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <header class="preview-header">
        <div class="preview-title">
            <?php echo htmlspecialchars($template['title']); ?>
        </div>
        <div class="preview-actions">
            <div class="device-selector">
                <button class="device-btn active" data-device="desktop">
                    <i class="fas fa-desktop"></i> Desktop
                </button>
                <button class="device-btn" data-device="tablet">
                    <i class="fas fa-tablet-alt"></i> Tablet
                </button>
                <button class="device-btn" data-device="mobile">
                    <i class="fas fa-mobile-alt"></i> Mobile
                </button>
            </div>
            <a href="template-details.php?id=<?php echo $template['id']; ?>" class="buy-template" target="_blank">
                <i class="fas fa-shopping-cart me-1"></i> Buy Template
            </a>
            <button class="close-preview" onclick="window.close()">
                <i class="fas fa-times me-1"></i> Close
            </button>
        </div>
    </header>
    
    <main class="preview-content">
        <div class="preview-frame desktop" id="previewFrame">
            <img src="<?php echo $screenshots[0]; ?>" alt="Template Preview" class="preview-image" id="previewImage">
            <button class="preview-nav prev" onclick="changeScreenshot(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="preview-nav next" onclick="changeScreenshot(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="preview-dots" id="previewDots">
                <?php foreach ($screenshots as $index => $screenshot): ?>
                    <span class="preview-dot <?php echo $index === 0 ? 'active' : ''; ?>" onclick="goToScreenshot(<?php echo $index; ?>)"></span>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    
    <script>
        const screenshots = <?php echo json_encode($screenshots); ?>;
        let currentScreenshot = 0;
        
        // Device selector functionality
        const deviceBtns = document.querySelectorAll('.device-btn');
        const previewFrame = document.getElementById('previewFrame');
        
        deviceBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                deviceBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const device = this.dataset.device;
                previewFrame.className = `preview-frame ${device}`;
            });
        });
        
        // Screenshot navigation
        function changeScreenshot(direction) {
            currentScreenshot += direction;
            
            if (currentScreenshot < 0) {
                currentScreenshot = screenshots.length - 1;
            } else if (currentScreenshot >= screenshots.length) {
                currentScreenshot = 0;
            }
            
            updateScreenshot();
        }
        
        function goToScreenshot(index) {
            currentScreenshot = index;
            updateScreenshot();
        }
        
        function updateScreenshot() {
            const previewImage = document.getElementById('previewImage');
            const dots = document.querySelectorAll('.preview-dot');
            
            previewImage.src = screenshots[currentScreenshot];
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentScreenshot);
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                changeScreenshot(-1);
            } else if (e.key === 'ArrowRight') {
                changeScreenshot(1);
            } else if (e.key === 'Escape') {
                window.close();
            }
        });
        
        // Auto-play slideshow (optional)
        let autoPlayInterval;
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                changeScreenshot(1);
            }, 5000);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        // Start auto-play on load
        startAutoPlay();
        
        // Stop auto-play on user interaction
        previewFrame.addEventListener('mouseenter', stopAutoPlay);
        previewFrame.addEventListener('mouseleave', startAutoPlay);
        
        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;
        
        previewFrame.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        previewFrame.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                changeScreenshot(1); // Swipe left - next
            }
            if (touchEndX > touchStartX + 50) {
                changeScreenshot(-1); // Swipe right - previous
            }
        }
    </script>
</body>
</html>
