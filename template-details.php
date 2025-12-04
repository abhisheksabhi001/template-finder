<?php
$page_title = 'Template Details - AA DIGITS';
$page_description = 'View detailed information about our premium website templates';

require_once 'config/config.php';
require_once 'classes/Product.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize classes with database connection
$product = new Product($db);

// Get template ID from URL
$template_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get template details (using product data for now)
$template = null;
if ($template_id > 0) {
    $template = $product->getProductById($template_id);
}

// If template not found, redirect to templates page
if (!$template) {
    header('Location: index.php#template-showcase');
    exit();
}

// Get related templates
$related_templates = $product->getRelatedProducts($template_id, 4);

include 'includes/header.php';
?>

<!-- Template Details Hero -->
<section class="template-hero bg-gradient-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="template-breadcrumb mb-3">
                    <a href="index.php" class="text-decoration-none">Home</a> / 
                    <a href="index.php#template-showcase" class="text-decoration-none">Templates</a> / 
                    <span><?php echo htmlspecialchars($template['title']); ?></span>
                </div>
                <h1 class="display-4 fw-bold mb-3"><?php echo htmlspecialchars($template['title']); ?></h1>
                <p class="lead text-muted mb-4"><?php echo htmlspecialchars($template['description']); ?></p>
                
                <div class="template-meta-info mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rating">
                            <i class="fas fa-star text-warning"></i>
                            <span><?php echo number_format($template['average_rating'] ?? 4.5, 1); ?></span>
                            <small>(<?php echo $template['review_count'] ?? rand(10, 100); ?> reviews)</small>
                        </div>
                        <div class="downloads">
                            <i class="fas fa-download me-1"></i>
                            <?php echo number_format($template['downloads'] ?? rand(100, 1000)); ?>+ downloads
                        </div>
                    </div>
                    <div class="template-tags">
                        <?php 
                        $tags = !empty($template['tags']) ? explode(',', $template['tags']) : ['web', 'design', 'modern'];
                        foreach ($tags as $tag): 
                        ?>
                            <span class="badge bg-light text-dark me-2"><?php echo htmlspecialchars(trim($tag)); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="template-actions">
                    <div class="price-display mb-3">
                        <?php if ($template['sale_price'] > 0): ?>
                            <span class="h3 text-danger fw-bold">$<?php echo number_format($template['sale_price'], 2); ?></span>
                            <span class="text-muted text-decoration-line-through ms-2">$<?php echo number_format($template['price'], 2); ?></span>
                            <span class="badge bg-danger ms-2">Save <?php echo number_format((($template['price'] - $template['sale_price']) / $template['price']) * 100, 0); ?>%</span>
                        <?php else: ?>
                            <span class="h3 fw-bold">$<?php echo number_format($template['price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <button class="btn btn-primary btn-lg" onclick="purchaseTemplate(<?php echo $template['id']; ?>)">
                            <i class="fas fa-shopping-cart me-2"></i>Purchase Template
                        </button>
                        <button class="btn btn-outline-primary btn-lg" onclick="previewTemplate(<?php echo $template['id']; ?>)">
                            <i class="fas fa-eye me-2"></i>Live Preview
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="template-preview-large">
                    <img src="<?php 
                        $screenshots = !empty($template['screenshots']) ? json_decode($template['screenshots'], true) : [];
                        echo !empty($screenshots[0]) ? $screenshots[0] : 'https://via.placeholder.com/800x600/f8f9fa/6c757d?text=Template+Preview';
                    ?>" alt="<?php echo htmlspecialchars($template['title']); ?>" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Template Features -->
<section class="template-features py-5">
    <div class="container">
        <h2 class="mb-4">Template Features</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Responsive Design</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Cross-browser Compatible</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>SEO Optimized</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Easy Customization</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Documentation Included</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Free Updates</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>24/7 Support</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Money Back Guarantee</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Template Screenshots -->
<section class="template-screenshots py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">Template Screenshots</h2>
        <div class="screenshot-gallery">
            <?php 
            $screenshots = !empty($template['screenshots']) ? json_decode($template['screenshots'], true) : [];
            if (empty($screenshots)) {
                // Add placeholder screenshots
                $screenshots = [
                    'https://via.placeholder.com/800x600/f8f9fa/6c757d?text=Homepage',
                    'https://via.placeholder.com/800x600/f8f9fa/6c757d?text=About',
                    'https://via.placeholder.com/800x600/f8f9fa/6c757d?text=Services',
                    'https://via.placeholder.com/800x600/f8f9fa/6c757d?text=Contact'
                ];
            }
            
            foreach ($screenshots as $screenshot): 
            ?>
                <div class="screenshot-item">
                    <img src="<?php echo $screenshot; ?>" alt="Template Screenshot" class="img-fluid rounded shadow">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Related Templates -->
<?php if (!empty($related_templates)): ?>
<section class="related-templates py-5">
    <div class="container">
        <h2 class="mb-4">Related Templates</h2>
        <div class="row">
            <?php foreach ($related_templates as $related): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="template-card">
                        <div class="template-preview">
                            <img src="<?php 
                                $related_screenshots = !empty($related['screenshots']) ? json_decode($related['screenshots'], true) : [];
                                echo !empty($related_screenshots[0]) ? $related_screenshots[0] : 'https://via.placeholder.com/400x300/f8f9fa/6c757d?text=Template';
                            ?>" alt="<?php echo htmlspecialchars($related['title']); ?>">
                            <div class="template-overlay">
                                <button class="btn btn-primary btn-sm" onclick="window.location.href='template-details.php?id=<?php echo $related['id']; ?>'">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div class="template-info">
                            <h5><?php echo htmlspecialchars($related['title']); ?></h5>
                            <div class="template-price">
                                $<?php echo number_format($related['sale_price'] > 0 ? $related['sale_price'] : $related['price'], 2); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.template-hero {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.template-breadcrumb a {
    color: #6c757d;
}

.template-breadcrumb a:hover {
    color: var(--primary-color);
}

.template-preview-large img {
    width: 100%;
    height: auto;
}

.feature-list {
    margin-bottom: 2rem;
}

.feature-item {
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.screenshot-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.screenshot-item img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.screenshot-item:hover img {
    transform: scale(1.02);
}

.template-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.template-card:hover {
    transform: translateY(-5px);
}

.template-card .template-preview {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.template-card .template-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.template-card .template-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.template-card:hover .template-overlay {
    opacity: 1;
}

.template-card .template-info {
    padding: 1rem;
}

.template-card .template-price {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-color);
}

@media (max-width: 768px) {
    .template-hero {
        text-align: center;
    }
    
    .template-hero .d-flex {
        flex-direction: column;
    }
    
    .screenshot-gallery {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function purchaseTemplate(templateId) {
    // Add to cart functionality
    window.location.href = `cart.php?action=add&id=${templateId}`;
}

function previewTemplate(templateId) {
    // Open preview modal
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'templatePreviewModal';
    modal.innerHTML = `
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Template Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <iframe src="preview-template.php?id=${templateId}" 
                            style="width: 100%; height: 600px; border: none;">
                    </iframe>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    if (typeof bootstrap !== 'undefined') {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        modal.addEventListener('hidden.bs.modal', function() {
            modal.remove();
        });
    } else {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.classList.add('modal-open');
        
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
        
        const closeBtn = modal.querySelector('.btn-close');
        closeBtn.addEventListener('click', function() {
            modal.remove();
            backdrop.remove();
            document.body.classList.remove('modal-open');
        });
    }
}
</script>

<?php include 'includes/footer.php'; ?>
