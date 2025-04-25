<?php
session_start();

$host = 'localhost';
$dbname = 'trevali_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get listing ID from URL
$listing_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$listing_id) {
    die("Invalid listing ID.");
}

// Fetch listing details
$stmt = $pdo->prepare("
    SELECT l.*, u.username, loc.name AS location_name, b.name AS brand_name 
    FROM listings l 
    LEFT JOIN users u ON l.user_id = u.id 
    LEFT JOIN locations loc ON l.location_id = loc.id 
    LEFT JOIN brands b ON l.brand_id = b.id 
    WHERE l.id = ? AND l.status = 'active'
");


$stmt->execute([$listing_id]);
$listing = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    die("Listing not found or inactive.");
}

// Increment views
$stmt = $pdo->prepare("UPDATE listings SET views = views + 1 WHERE id = ?");
$stmt->execute([$listing_id]);

// Fetch listing images
$stmt = $pdo->prepare("SELECT image_path, alt_text FROM listing_images WHERE listing_id = ? ORDER BY id ASC");
$stmt->execute([$listing_id]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user stats: total listings, total likes, total views
$stmt = $pdo->prepare("
    SELECT 
        COUNT(*) as total_listings,
        SUM(likes) as total_likes,
        SUM(views) as total_views
    FROM listings 
    WHERE user_id = ? AND status = 'active'
");
$stmt->execute([$listing['user_id']]);
$user_stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Default values for missing fields
$listing['description'] = $listing['description'] ?? 'No description provided.';
$listing['price'] = $listing['price'] ?? 0.00;
$listing['category'] = ucfirst($listing['category'] ?? 'other');
$listing['quantity'] = $listing['quantity'] ?? 1;
$listing['brand'] = $listing['brand_name'] ?? 'Unknown';
$listing['condition'] = ucfirst($listing['condition'] ?? 'Not specified');
$listing['location'] = $listing['location_name'] ?? 'Not specified';
$listing['sku'] = $listing['sku'] ?? 'N/A';
$listing['weight'] = $listing['weight'] ?? '';
$listing['weight_unit'] = $listing['weight_unit'] ?? '';
$listing['length'] = $listing['length'] ?? '';
$listing['width'] = $listing['width'] ?? '';
$listing['height'] = $listing['height'] ?? '';
$listing['dimension_unit'] = $listing['dimension_unit'] ?? '';
$user_stats['total_listings'] = $user_stats['total_listings'] ?? 0;
$user_stats['total_likes'] = $user_stats['total_likes'] ?? 0;
$user_stats['total_views'] = $user_stats['total_views'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($listing['title']); ?> - Trevali</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    :root {
      --ebay-blue: #3665f3;
      --ebay-red: #e53238;
      --ebay-yellow: #f5af02;
      --ebay-green: #86b817;
      --ebay-border: #e5e5e5;
      --ebay-light-gray: #f8f8f8;
      --ebay-text: #333;
      --ebay-text-light: #767676;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #fff;
      color: var(--ebay-text);
    }
    
    /* Breadcrumb */
    .breadcrumb-container {
      padding: 10px 0;
      background-color: var(--ebay-light-gray);
    }
    
    .breadcrumb {
      margin-bottom: 0;
    }
    
    .breadcrumb-item a {
      color: var(--ebay-text-light);
      text-decoration: none;
      font-size: 14px;
    }
    
    .breadcrumb-item a:hover {
      color: var(--ebay-blue);
      text-decoration: underline;
    }
    
    .breadcrumb-item.active {
      color: var(--ebay-text);
      font-size: 14px;
    }
    
    /* Product Container */
    .product-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    /* Product Gallery */
    .product-gallery {
      position: relative;
      margin-bottom: 30px;
      padding-bottom: 15px;
    }
    
    .main-image-container {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      border: 1px solid var(--ebay-border);    }
    
    .main-image {
      width: 100%;
      height: auto;
      object-fit: contain;
      aspect-ratio: 1/1;
      transition: transform 0.3s;
    }
    
    .zoom-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.1);
      cursor: zoom-in;
    }
    
    .thumbnails {
      display: flex;
      gap: 10px;
      overflow-x: auto;
      padding-bottom: 10px;
    }
    
    .thumbnail {
      width: 80px;
      height: 80px;
      border-radius: 4px;
      border: 1px solid var(--ebay-border);
      cursor: pointer;
      object-fit: cover;
      transition: border-color 0.2s;
    }
    
    .thumbnail:hover, .thumbnail.active {
      border-color: var(--ebay-blue);
    }
    
    .gallery-actions {
      position: absolute;
      top: 10px;
      right: 10px;
      display: flex;
      gap: 10px;
    }
    
    .gallery-action {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: white;
      border: 1px solid var(--ebay-border);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .gallery-action:hover {
      background-color: var(--ebay-light-gray);
    }
    
    /* Product Info */
    .product-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 15px;
      line-height: 1.3;
    }
    
    .product-subtitle {
      font-size: 16px;
      color: var(--ebay-text-light);
      margin-bottom: 20px;
    }
    
    .product-stats {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    .product-stat {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .product-price {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 20px;
      color: var(--ebay-text);
    }
    
    .product-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 15px 30px;
      margin-bottom: 20px;
    }
    
    .meta-item {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    
    .meta-label {
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    .meta-value {
      font-size: 16px;
      font-weight: 500;
    }
    
    .product-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 30px;
    }
    
    .action-btn {
      padding: 12px 24px;
      border-radius: 24px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    .cart-btn {
      background-color: white;
      color: var(--ebay-blue);
      border: 2px solid var(--ebay-blue);
      flex: 1;
      min-width: 150px;
    }
    
    .cart-btn:hover {
      background-color: rgba(54, 101, 243, 0.1);
    }
    
    .buy-btn {
      background-color: var(--ebay-blue);
      color: white;
      border: none;
      flex: 1;
      min-width: 150px;
    }
    
    .buy-btn:hover {
      background-color: #2b4fb4;
    }
    
    .like-btn {
      background-color: white;
      color: var(--ebay-text);
      border: 1px solid var(--ebay-border);
      width: 48px;
      padding: 12px;
    }
    
    .like-btn:hover {
      background-color: var(--ebay-light-gray);
    }
    
    .quantity-selector {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .quantity-label {
      font-size: 16px;
      margin-right: 15px;
      min-width: 80px;
    }
    
    .quantity-control {
      display: flex;
      align-items: center;
      border: 1px solid var(--ebay-border);
      border-radius: 4px;
      overflow: hidden;
    }
    
    .quantity-btn {
      width: 36px;
      height: 36px;
      background-color: white;
      border: none;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .quantity-btn:hover {
      background-color: var(--ebay-light-gray);
    }
    
    .quantity-input {
      width: 50px;
      height: 36px;
      border: none;
      border-left: 1px solid var(--ebay-border);
      border-right: 1px solid var(--ebay-border);
      text-align: center;
      font-size: 16px;
    }
    
    .quantity-input::-webkit-inner-spin-button,
    .quantity-input::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    
    .quantity-available {
      font-size: 14px;
      color: var(--ebay-text-light);
      margin-left: 15px;
    }
    
    /* Tabs */
    .product-tabs {
      margin-bottom: 30px;
      border-bottom: 1px solid var(--ebay-border);
    }
    
    .nav-tabs {
      border-bottom: none;
    }
    
    .nav-tabs .nav-link {
      border: none;
      border-bottom: 2px solid transparent;
      color: var(--ebay-text-light);
      font-weight: 500;
      padding: 12px 20px;
      margin-right: 10px;
    }
    
    .nav-tabs .nav-link:hover {
      border-color: transparent;
      color: var(--ebay-blue);
    }
    
    .nav-tabs .nav-link.active {
      border-color: var(--ebay-blue);
      color: var(--ebay-blue);
      background-color: transparent;
    }
    
    .tab-content {
      padding: 20px 0;
    }
    
    .tab-pane {
      line-height: 1.6;
    }
    
    /* Specifications Table */
    .specs-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    
    .specs-table tr:nth-child(odd) {
      background-color: var(--ebay-light-gray);
    }
    
    .specs-table th, .specs-table td {
      padding: 12px 15px;
      text-align: left;
      border: none;
    }
    
    .specs-table th {
      font-weight: 500;
      width: 30%;
      color: var(--ebay-text-light);
    }
    
    /* Seller Info */
    .seller-info {
      border: 1px solid var(--ebay-border);
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 30px;
    }
    
    .seller-header {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 15px;
    }
    
    .seller-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }
    
    .seller-name {
      font-size: 18px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .verified-badge {
      color: var(--ebay-blue);
      font-size: 16px;
    }
    
    .seller-stats {
      display: flex;
      flex-wrap: wrap;
      gap: 15px 30px;
      margin-bottom: 15px;
    }
    
    .seller-stat {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    
    .stat-label {
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    .stat-value {
      font-size: 16px;
      font-weight: 500;
    }
    
    /* Shipping Info */
    .shipping-info {
      border: 1px solid var(--ebay-border);
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 30px;
    }
    
    .shipping-header {
      font-size: 18px;
      font-weight: 500;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .shipping-options {
      margin-bottom: 15px;
    }
    
    .shipping-option {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid var(--ebay-border);
    }
    
    .shipping-option:last-child {
      border-bottom: none;
    }
    
    .option-name {
      font-weight: 500;
    }
    
    .option-price {
      font-weight: 500;
    }
    
    .shipping-location {
      font-size: 14px;
      color: var(--ebay-text-light);
      margin-bottom: 15px;
    }
    
    .shipping-returns {
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    /* Similar Items */
    .similar-items {
      margin-bottom: 30px;
    }
    
    .section-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .see-all {
      font-size: 14px;
      color: var(--ebay-blue);
      text-decoration: none;
    }
    
    .see-all:hover {
      text-decoration: underline;
    }
    
    .items-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
    }
    
    .item-card {
      border: 1px solid var(--ebay-border);
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .item-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .item-image {
      width: 100%;
      aspect-ratio: 1/1;
      object-fit: cover;
    }
    
    .item-details {
      padding: 10px;
    }
    
    .item-title {
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 5px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .item-price {
      font-size: 16px;
      font-weight: 600;
      color: var(--ebay-text);
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .items-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    @media (max-width: 768px) {
      .product-title {
        font-size: 20px;
      }
      
      .product-price {
        font-size: 24px;
      }
      
      .items-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .action-btn {
        flex: 1 0 calc(50% - 10px);
      }
    }
    
    @media (max-width: 576px) {
      .product-meta {
        gap: 10px 20px;
      }
      
      .meta-item {
        flex: 1 0 calc(50% - 20px);
      }
      
      .items-grid {
        grid-template-columns: 1fr;
      }
      
      .action-btn {
        flex: 1 0 100%;
      }
      
      .specs-table th {
        width: 40%;
      }
    }
  </style>
</head>
<body>
  <?php include 'nav.php'; ?>
  <!-- Breadcrumb -->
  <div class="breadcrumb-container">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($listing['category']); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($listing['title']); ?></li>
        </ol>
      </nav>
    </div>
  </div>
  
  <!-- Product Content -->
  <div class="product-container">
    <div class="row">
      <!-- Product Gallery -->
      <div class="col-lg-6">
        <div class="product-gallery">
          <div class="main-image-container">
            <img src="<?php echo htmlspecialchars($images[0]['image_path'] ?? '/placeholder.svg?height=600&width=600'); ?>" 
                 alt="<?php echo htmlspecialchars($images[0]['alt_text'] ?? $listing['title']); ?>" 
                 class="main-image" id="main-image">
            <div class="zoom-overlay"></div>
          </div>
          
          <div class="thumbnails">
            <?php foreach ($images as $index => $image): ?>
              <img src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                   alt="<?php echo htmlspecialchars($image['alt_text'] ?? 'Thumbnail ' . ($index + 1)); ?>" 
                   class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" 
                   data-src="<?php echo htmlspecialchars($image['image_path']); ?>">
            <?php endforeach; ?>
          </div>
          
          <div class="gallery-actions">
            <div class="gallery-action">
              <i class="bi bi-share"></i>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Product Info -->
      <div class="col-lg-6">
        <h1 class="product-title"><?php echo htmlspecialchars($listing['title']); ?></h1>
        <div class="product-subtitle"><?php echo htmlspecialchars($listing['condition']); ?></div>
        
        <div class="product-stats">
          <div class="product-stat">
            <i class="bi bi-heart-fill"></i>
            <span><?php echo $listing['likes']; ?> likes</span>
          </div>
          <div class="product-stat">
            <i class="bi bi-eye-fill"></i>
            <span><?php echo $listing['views']; ?> views</span>
          </div>
        </div>
        
        <div class="product-price">$<?php echo number_format($listing['price'], 2); ?></div>
        
        <div class="quantity-selector">
          <div class="quantity-label">Quantity:</div>
          <div class="quantity-control">
            <button class="quantity-btn" id="decrease-quantity">-</button>
            <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="<?php echo $listing['quantity']; ?>">
            <button class="quantity-btn" id="increase-quantity">+</button>
          </div>
          <div class="quantity-available"><?php echo $listing['quantity']; ?> available</div>
        </div>
        
        <div class="product-meta">
          <div class="meta-item">
            <div class="meta-label">Brand</div>
            <div class="meta-value"><?php echo htmlspecialchars($listing['brand']); ?></div>
          </div>
          <div class="meta-item">
            <div class="meta-label">Condition</div>
            <div class="meta-value"><?php echo htmlspecialchars($listing['condition']); ?></div>
          </div>
          <div class="meta-item">
            <div class="meta-label">SKU</div>
            <div class="meta-value"><?php echo htmlspecialchars($listing['sku']); ?></div>
          </div>
          <div class="meta-item">
            <div class="meta-label">Category</div>
            <div class="meta-value"><?php echo htmlspecialchars($listing['category']); ?></div>
          </div>
        </div>
        
        <div class="product-actions">
          <button class="action-btn cart-btn">
            <i class="bi bi-cart-plus"></i> Add to Cart
          </button>
          <button class="action-btn buy-btn">
            <i class="bi bi-bag"></i> Buy Now
          </button>
          <button class="action-btn like-btn">
            <i class="bi bi-heart"></i>
          </button>
        </div>
        
        <!-- Updated Seller Info -->
        <div class="seller-info">
          <div class="seller-header">
            <img src="/placeholder.svg?height=50&width=50" alt="Seller Avatar" class="seller-avatar">
            <div>
              <div class="seller-name">
                <?php echo htmlspecialchars($listing['username']); ?> 
                <span class="verified-badge"><i class="bi bi-patch-check-fill"></i></span>
              </div>
            </div>
          </div>
          
          <div class="seller-stats">
            <div class="seller-stat">
              <div class="stat-label">Listings</div>
              <div class="stat-value"><?php echo $user_stats['total_listings']; ?></div>
            </div>
            <div class="seller-stat">
              <div class="stat-label">Total Likes</div>
              <div class="stat-value"><?php echo $user_stats['total_likes']; ?></div>
            </div>
            <div class="seller-stat">
              <div class="stat-label">Total Views</div>
              <div class="stat-value"><?php echo $user_stats['total_views']; ?></div>
            </div>
            <div class="seller-stat">
              <div class="stat-label">Location</div>
              <div class="stat-value"><?php echo htmlspecialchars($listing['location']); ?></div>
            </div>
          </div>
        </div>
        
        <!-- Shipping Info -->
        <div class="shipping-info">
          <div class="shipping-header">
            <i class="bi bi-truck"></i> Shipping & Returns
          </div>
          
          <div class="shipping-options">
            <div class="shipping-option">
              <div class="option-name">Standard Shipping</div>
              <div class="option-price">$12.99</div>
            </div>
          </div>
          
          <div class="shipping-location">
            <i class="bi bi-geo-alt"></i> Ships from <?php echo htmlspecialchars($listing['location']); ?>
          </div>
          
          <div class="shipping-returns">
            <i class="bi bi-arrow-return-left"></i> 30-day returns accepted. Buyer pays return shipping.
          </div>
        </div>

       

      </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="product-tabs">
      <ul class="nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">Specifications</button>
        </li>
      </ul>
      <div class="tab-content" id="productTabsContent">
        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
          <p><?php echo nl2br(htmlspecialchars($listing['description'])); ?></p>
        </div>
        
        <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
          <table class="specs-table">
            <tr><th>Brand</th><td><?php echo htmlspecialchars($listing['brand']); ?></td></tr>
            <tr><th>Condition</th><td><?php echo htmlspecialchars($listing['condition']); ?></td></tr>
            <tr><th>SKU</th><td><?php echo htmlspecialchars($listing['sku']); ?></td></tr>
            <tr><th>Category</th><td><?php echo htmlspecialchars($listing['category']); ?></td></tr>
            <?php if ($listing['weight']): ?>
              <tr><th>Weight</th><td><?php echo htmlspecialchars($listing['weight'] . ' ' . $listing['weight_unit']); ?></td></tr>
            <?php endif; ?>
            <?php if ($listing['length'] && $listing['width'] && $listing['height']): ?>
              <tr><th>Dimensions</th><td><?php echo htmlspecialchars($listing['length'] . ' x ' . $listing['width'] . ' x ' . $listing['height'] . ' ' . $listing['dimension_unit']); ?></td></tr>
            <?php endif; ?>
            <tr><th>Status</th><td><?php echo htmlspecialchars($listing['status']); ?></td></tr>
            <tr><th>Created At</th><td><?php echo htmlspecialchars($listing['created_at']); ?></td></tr>
          </table>
        </div>
      </div>
    </div>
    
    <!-- Similar Items (Placeholder) -->
    <div class="similar-items">
      <div class="section-title">
        Similar Items
        <a href="#" class="see-all">See All</a>
      </div>
      <div class="items-grid">
        <div class="item-card">
          <img src="/placeholder.svg?height=200&width=200" alt="Similar Item" class="item-image">
          <div class="item-details">
            <div class="item-title">Placeholder Item</div>
            <div class="item-price">$999.99</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Thumbnail gallery functionality
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
      thumbnail.addEventListener('click', function() {
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        const mainImage = document.getElementById('main-image');
        mainImage.src = this.getAttribute('data-src');
      });
    });
    
    // Quantity selector functionality
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decrease-quantity');
    const increaseBtn = document.getElementById('increase-quantity');
    
    decreaseBtn.addEventListener('click', function() {
      const currentValue = parseInt(quantityInput.value);
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
      }
    });
    
    increaseBtn.addEventListener('click', function() {
      const currentValue = parseInt(quantityInput.value);
      const maxValue = parseInt(quantityInput.getAttribute('max'));
      if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
      }
    });
    
    quantityInput.addEventListener('input', function() {
      const value = parseInt(this.value);
      const max = parseInt(this.getAttribute('max'));
      if (isNaN(value) || value < 1) {
        this.value = 1;
      } else if (value > max) {
        this.value = max;
      }
    });
    
    // Like button functionality (client-side toggle only)
    const likeButton = document.querySelector('.like-btn');
    likeButton.addEventListener('click', function() {
      const icon = this.querySelector('i');
      if (icon.classList.contains('bi-heart')) {
        icon.classList.remove('bi-heart');
        icon.classList.add('bi-heart-fill');
        icon.style.color = 'var(--ebay-red)';
      } else {
        icon.classList.remove('bi-heart-fill');
        icon.classList.add('bi-heart');
        icon.style.color = '';
      }
    });

    // Inside p.php, after fetching $listing
    
    // Store category in localStorage
    document.addEventListener('DOMContentLoaded', function() {
        let categories = JSON.parse(localStorage.getItem('clicked_categories')) || [];
        const category = '<?php echo htmlspecialchars($listing['category']); ?>';
        if (!categories.includes(category)) {
            categories.push(category);
            localStorage.setItem('clicked_categories', JSON.stringify(categories));
        }
    });
  </script>
</body>
</html>