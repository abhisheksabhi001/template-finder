<?php
$page_title = 'Customize Template - AA DIGITS';
$page_description = 'Customize your selected template with our easy-to-use editor';

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

// If template not found, redirect to templates page
if (!$template) {
    header('Location: index.php#template-showcase');
    exit();
}

include 'includes/header.php';
?>

<!-- Customization Header -->
<section class="customization-header py-3 bg-white border-bottom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary me-3" onclick="window.history.back()">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </button>
                <div>
                    <h4 class="mb-0">Customizing: <?php echo htmlspecialchars($template['title']); ?></h4>
                    <small class="text-muted">Make this template uniquely yours</small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="saveDraft()">
                    <i class="fas fa-save me-1"></i> Save Draft
                </button>
                <button class="btn btn-success" onclick="publishTemplate()">
                    <i class="fas fa-rocket me-1"></i> Publish
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Customization Workspace -->
<section class="customization-workspace">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Left Sidebar - Tools -->
            <div class="col-md-3 col-lg-2 bg-light border-end p-3">
                <div class="customization-tools">
                    <h6 class="text-uppercase mb-3">Tools</h6>
                    <div class="tool-list">
                        <button class="tool-btn active" data-tool="select">
                            <i class="fas fa-mouse-pointer"></i>
                            <span>Select</span>
                        </button>
                        <button class="tool-btn" data-tool="text">
                            <i class="fas fa-font"></i>
                            <span>Text</span>
                        </button>
                        <button class="tool-btn" data-tool="image">
                            <i class="fas fa-image"></i>
                            <span>Image</span>
                        </button>
                        <button class="tool-btn" data-tool="shape">
                            <i class="fas fa-shapes"></i>
                            <span>Shape</span>
                        </button>
                        <button class="tool-btn" data-tool="color">
                            <i class="fas fa-palette"></i>
                            <span>Colors</span>
                        </button>
                    </div>
                    
                    <h6 class="text-uppercase mb-3 mt-4">Elements</h6>
                    <div class="elements-list">
                        <div class="element-item" draggable="true" data-element="heading">
                            <i class="fas fa-heading me-2"></i> Heading
                        </div>
                        <div class="element-item" draggable="true" data-element="paragraph">
                            <i class="fas fa-paragraph me-2"></i> Paragraph
                        </div>
                        <div class="element-item" draggable="true" data-element="button">
                            <i class="fas fa-square me-2"></i> Button
                        </div>
                        <div class="element-item" draggable="true" data-element="image">
                            <i class="fas fa-image me-2"></i> Image
                        </div>
                        <div class="element-item" draggable="true" data-element="icon">
                            <i class="fas fa-icons me-2"></i> Icon
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Canvas Area -->
            <div class="col-md-6 col-lg-8 p-0">
                <div class="canvas-container">
                    <div class="canvas-toolbar d-flex justify-content-between align-items-center p-2 bg-white border-bottom">
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="undoAction()">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="redoAction()">
                                <i class="fas fa-redo"></i>
                            </button>
                            <div class="vr"></div>
                            <button class="btn btn-sm btn-outline-secondary" onclick="zoomIn()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="zoomOut()">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="resetZoom()">
                                <i class="fas fa-compress"></i>
                            </button>
                        </div>
                        <div class="device-preview-selector">
                            <select class="form-select form-select-sm" id="devicePreview">
                                <option value="desktop">Desktop</option>
                                <option value="tablet">Tablet</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="canvas-wrapper" id="canvasWrapper">
                        <div class="canvas" id="canvas">
                            <!-- Template content will be loaded here -->
                            <div class="template-preview">
                                <img src="<?php 
                                    $screenshots = !empty($template['screenshots']) ? json_decode($template['screenshots'], true) : [];
                                    echo !empty($screenshots[0]) ? $screenshots[0] : 'https://via.placeholder.com/1200x800/f8f9fa/6c757d?text=Template+Preview';
                                ?>" alt="Template" class="template-background">
                                
                                <!-- Editable elements overlay -->
                                <div class="editable-overlay">
                                    <!-- Sample editable elements -->
                                    <div class="editable-element" contenteditable="true" data-type="heading">
                                        <h1>Your Headline Here</h1>
                                    </div>
                                    <div class="editable-element" contenteditable="true" data-type="paragraph">
                                        <p>Your description goes here. Click to edit this text and make it your own.</p>
                                    </div>
                                    <div class="editable-element" data-type="button">
                                        <button class="btn btn-primary">Call to Action</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar - Properties -->
            <div class="col-md-3 col-lg-2 bg-light border-start p-3">
                <div class="properties-panel">
                    <h6 class="text-uppercase mb-3">Properties</h6>
                    
                    <!-- Text Properties -->
                    <div id="textProperties" class="property-group">
                        <div class="mb-3">
                            <label class="form-label">Font Family</label>
                            <select class="form-select form-select-sm">
                                <option>Arial</option>
                                <option>Helvetica</option>
                                <option>Times New Roman</option>
                                <option>Georgia</option>
                                <option>Courier New</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Font Size</label>
                            <input type="range" class="form-range" min="12" max="72" value="16">
                            <small class="text-muted">16px</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Font Weight</label>
                            <select class="form-select form-select-sm">
                                <option>Normal</option>
                                <option>Bold</option>
                                <option>Light</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Text Color</label>
                            <input type="color" class="form-control form-control-color" value="#000000">
                        </div>
                    </div>
                    
                    <!-- Image Properties -->
                    <div id="imageProperties" class="property-group" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Image Source</label>
                            <input type="file" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alt Text</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Describe the image">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Border Radius</label>
                            <input type="range" class="form-range" min="0" max="50" value="0">
                        </div>
                    </div>
                    
                    <!-- Color Theme -->
                    <div class="property-group mt-4">
                        <h6 class="text-uppercase mb-3">Color Theme</h6>
                        <div class="color-presets">
                            <div class="color-preset" data-theme="default">
                                <div class="color-swatch" style="background: #007bff;"></div>
                                <div class="color-swatch" style="background: #6c757d;"></div>
                                <div class="color-swatch" style="background: #ffffff;"></div>
                            </div>
                            <div class="color-preset" data-theme="dark">
                                <div class="color-swatch" style="background: #212529;"></div>
                                <div class="color-swatch" style="background: #495057;"></div>
                                <div class="color-swatch" style="background: #f8f9fa;"></div>
                            </div>
                            <div class="color-preset" data-theme="nature">
                                <div class="color-swatch" style="background: #28a745;"></div>
                                <div class="color-swatch" style="background: #868e96;"></div>
                                <div class="color-swatch" style="background: #ffffff;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Layout Options -->
                    <div class="property-group mt-4">
                        <h6 class="text-uppercase mb-3">Layout</h6>
                        <div class="layout-options">
                            <button class="layout-btn" data-layout="center">
                                <i class="fas fa-align-center"></i>
                            </button>
                            <button class="layout-btn" data-layout="left">
                                <i class="fas fa-align-left"></i>
                            </button>
                            <button class="layout-btn" data-layout="right">
                                <i class="fas fa-align-right"></i>
                            </button>
                            <button class="layout-btn" data-layout="justify">
                                <i class="fas fa-align-justify"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.customization-header {
    position: sticky;
    top: 0;
    z-index: 1000;
}

.customization-workspace {
    height: calc(100vh - 80px);
    overflow: hidden;
}

.tool-btn, .element-item {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tool-btn:hover, .element-item:hover {
    background: #f8f9fa;
    transform: translateX(2px);
}

.tool-btn.active {
    background: var(--primary-color);
    color: #fff;
    border-color: var(--primary-color);
}

.tool-btn i, .element-item i {
    width: 20px;
    text-align: center;
}

.tool-btn span, .element-item span {
    margin-left: 0.5rem;
}

.canvas-container {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.canvas-wrapper {
    flex: 1;
    overflow: auto;
    background: #f8f9fa;
    background-image: 
        linear-gradient(45deg, #e9ecef 25%, transparent 25%),
                        linear-gradient(-45deg, #e9ecef 25%, transparent 25%),
                        linear-gradient(45deg, transparent 75%, #e9ecef 75%),
                        linear-gradient(-45deg, transparent 75%, #e9ecef 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
}

.canvas {
    min-height: 100%;
    padding: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.template-preview {
    position: relative;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    max-width: 1200px;
    width: 100%;
}

.template-background {
    width: 100%;
    height: auto;
    display: block;
}

.editable-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 2rem;
}

.editable-element {
    position: relative;
    margin-bottom: 1rem;
    padding: 0.5rem;
    border: 2px dashed transparent;
    border-radius: 4px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.editable-element:hover {
    border-color: var(--primary-color);
    background: rgba(0,123,255,0.05);
}

.editable-element:focus {
    outline: none;
    border-color: var(--primary-color);
    background: rgba(0,123,255,0.1);
}

.editable-element[contenteditable="true"]:empty:before {
    content: attr(data-placeholder);
    color: #999;
}

.property-group {
    margin-bottom: 2rem;
}

.color-presets {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.color-preset {
    display: flex;
    gap: 0.25rem;
    padding: 0.5rem;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.color-preset:hover {
    background: #f8f9fa;
}

.color-swatch {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    border: 1px solid #dee2e6;
}

.layout-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
}

.layout-btn {
    padding: 0.5rem;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.layout-btn:hover {
    background: #f8f9fa;
}

.vr {
    width: 1px;
    height: 24px;
    background: #dee2e6;
    margin: 0 0.5rem;
}

@media (max-width: 768px) {
    .customization-workspace .row {
        flex-direction: column;
    }
    
    .customization-workspace .col-md-3,
    .customization-workspace .col-md-6 {
        width: 100%;
        max-width: 100%;
    }
    
    .canvas-wrapper {
        height: 400px;
    }
}
</style>

<script>
let currentTool = 'select';
let selectedElement = null;
let zoomLevel = 1;

// Tool selection
document.querySelectorAll('.tool-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tool-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentTool = this.dataset.tool;
        
        // Update cursor
        const canvas = document.getElementById('canvas');
        if (currentTool === 'select') {
            canvas.style.cursor = 'default';
        } else {
            canvas.style.cursor = 'crosshair';
        }
    });
});

// Element dragging
document.querySelectorAll('.element-item').forEach(item => {
    item.addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('element', this.dataset.element);
    });
});

const canvas = document.getElementById('canvas');
canvas.addEventListener('dragover', function(e) {
    e.preventDefault();
});

canvas.addEventListener('drop', function(e) {
    e.preventDefault();
    const elementType = e.dataTransfer.getData('element');
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    createEditableElement(elementType, x, y);
});

function createEditableElement(type, x, y) {
    const element = document.createElement('div');
    element.className = 'editable-element';
    element.style.position = 'absolute';
    element.style.left = x + 'px';
    element.style.top = y + 'px';
    element.dataset.type = type;
    
    switch(type) {
        case 'heading':
            element.innerHTML = '<h2 contenteditable="true">New Heading</h2>';
            break;
        case 'paragraph':
            element.innerHTML = '<p contenteditable="true">New paragraph text</p>';
            break;
        case 'button':
            element.innerHTML = '<button class="btn btn-primary" contenteditable="false">Click Me</button>';
            break;
        case 'image':
            element.innerHTML = '<img src="https://via.placeholder.com/200x150" alt="Placeholder" style="max-width: 100%;">';
            break;
        case 'icon':
            element.innerHTML = '<i class="fas fa-star fa-2x"></i>';
            break;
    }
    
    // Make element draggable
    makeElementDraggable(element);
    
    // Add click handler for selection
    element.addEventListener('click', function(e) {
        e.stopPropagation();
        selectElement(this);
    });
    
    document.querySelector('.editable-overlay').appendChild(element);
}

function makeElementDraggable(element) {
    let isDragging = false;
    let currentX;
    let currentY;
    let initialX;
    let initialY;
    
    element.addEventListener('mousedown', function(e) {
        if (currentTool === 'select') {
            isDragging = true;
            initialX = e.clientX - element.offsetLeft;
            initialY = e.clientY - element.offsetTop;
        }
    });
    
    document.addEventListener('mousemove', function(e) {
        if (isDragging) {
            e.preventDefault();
            currentX = e.clientX - initialX;
            currentY = e.clientY - initialY;
            
            element.style.left = currentX + 'px';
            element.style.top = currentY + 'px';
        }
    });
    
    document.addEventListener('mouseup', function() {
        isDragging = false;
    });
}

function selectElement(element) {
    // Remove previous selection
    document.querySelectorAll('.editable-element').forEach(el => {
        el.style.border = '2px dashed transparent';
    });
    
    // Select new element
    selectedElement = element;
    element.style.border = '2px dashed var(--primary-color)';
    
    // Show relevant properties panel
    showPropertiesPanel(element.dataset.type);
}

function showPropertiesPanel(type) {
    // Hide all property groups
    document.querySelectorAll('.property-group').forEach(group => {
        group.style.display = 'none';
    });
    
    // Show relevant group
    if (type === 'heading' || type === 'paragraph') {
        document.getElementById('textProperties').style.display = 'block';
    } else if (type === 'image') {
        document.getElementById('imageProperties').style.display = 'block';
    }
}

// Zoom functions
function zoomIn() {
    zoomLevel = Math.min(zoomLevel + 0.1, 2);
    applyZoom();
}

function zoomOut() {
    zoomLevel = Math.max(zoomLevel - 0.1, 0.5);
    applyZoom();
}

function resetZoom() {
    zoomLevel = 1;
    applyZoom();
}

function applyZoom() {
    const canvas = document.getElementById('canvas');
    canvas.style.transform = `scale(${zoomLevel})`;
}

// Device preview
document.getElementById('devicePreview').addEventListener('change', function() {
    const device = this.value;
    const templatePreview = document.querySelector('.template-preview');
    
    switch(device) {
        case 'desktop':
            templatePreview.style.maxWidth = '1200px';
            break;
        case 'tablet':
            templatePreview.style.maxWidth = '768px';
            break;
        case 'mobile':
            templatePreview.style.maxWidth = '375px';
            break;
    }
});

// Color theme presets
document.querySelectorAll('.color-preset').forEach(preset => {
    preset.addEventListener('click', function() {
        const theme = this.dataset.theme;
        applyColorTheme(theme);
    });
});

function applyColorTheme(theme) {
    const root = document.documentElement;
    
    switch(theme) {
        case 'dark':
            root.style.setProperty('--primary-color', '#212529');
            root.style.setProperty('--secondary-color', '#495057');
            break;
        case 'nature':
            root.style.setProperty('--primary-color', '#28a745');
            root.style.setProperty('--secondary-color', '#868e96');
            break;
        default:
            root.style.setProperty('--primary-color', '#007bff');
            root.style.setProperty('--secondary-color', '#6c757d');
    }
}

// Save draft function
function saveDraft() {
    // Collect all editable elements
    const elements = document.querySelectorAll('.editable-element');
    const draftData = [];
    
    elements.forEach(element => {
        draftData.push({
            type: element.dataset.type,
            content: element.innerHTML,
            position: {
                left: element.style.left,
                top: element.style.top
            }
        });
    });
    
    // Save to localStorage
    localStorage.setItem('templateDraft_' + <?php echo $template_id; ?>, JSON.stringify(draftData));
    
    alert('Draft saved successfully!');
}

// Publish function
function publishTemplate() {
    if (confirm('Are you ready to publish your customized template?')) {
        // Here you would send the customizations to your server
        alert('Template published successfully!');
        window.location.href = 'template-details.php?id=<?php echo $template_id; ?>';
    }
}

// Undo/Redo functionality (simplified)
let history = [];
let historyIndex = -1;

function undoAction() {
    if (historyIndex > 0) {
        historyIndex--;
        restoreState(history[historyIndex]);
    }
}

function redoAction() {
    if (historyIndex < history.length - 1) {
        historyIndex++;
        restoreState(history[historyIndex]);
    }
}

function saveState() {
    const state = document.querySelector('.editable-overlay').innerHTML;
    history = history.slice(0, historyIndex + 1);
    history.push(state);
    historyIndex++;
}

function restoreState(state) {
    document.querySelector('.editable-overlay').innerHTML = state;
    
    // Re-attach event listeners
    document.querySelectorAll('.editable-element').forEach(element => {
        makeElementDraggable(element);
        element.addEventListener('click', function(e) {
            e.stopPropagation();
            selectElement(this);
        });
    });
}

// Save state on any change
document.addEventListener('keyup', saveState);
document.addEventListener('click', saveState);

// Click on canvas to deselect
canvas.addEventListener('click', function(e) {
    if (e.target === canvas || e.target.classList.contains('editable-overlay')) {
        document.querySelectorAll('.editable-element').forEach(el => {
            el.style.border = '2px dashed transparent';
        });
        selectedElement = null;
    }
});

// Load draft if exists
const savedDraft = localStorage.getItem('templateDraft_' + <?php echo $template_id; ?>);
if (savedDraft) {
    const draftData = JSON.parse(savedDraft);
    // Restore draft elements
    draftData.forEach(item => {
        createEditableElement(item.type, parseInt(item.position.left), parseInt(item.position.top));
    });
}
</script>

<?php include 'includes/footer.php'; ?>
