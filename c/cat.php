<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marketplace Top Categories</title>
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
      background-color: #f8f9fa;
    }
    
    .container {
      max-width: 1200px;
      padding: 20px;
    }
    
    .section-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 24px;
      color: var(--ebay-text);
      text-align: center;
    }
    
    /* Top Categories Styles */
    .top-categories {
      margin: 20px 0 40px;
    }
    
    .category-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 20px;
    }
    
    .category-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 20px 10px;
      border-radius: 12px;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    
    .category-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--ebay-blue), var(--ebay-green));
      transform: translateY(-100%);
      transition: transform 0.3s ease;
    }
    
    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .category-card:hover::before {
      transform: translateY(0);
    }
    
    .category-icon {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: var(--ebay-light-gray);
      border-radius: 50%;
      margin-bottom: 12px;
      transition: all 0.3s ease;
    }
    
    .category-card:hover .category-icon {
      background-color: #e6f0ff;
    }
    
    .category-icon i {
      font-size: 28px;
      color: var(--ebay-blue);
    }
    
    .category-name {
      font-weight: 500;
      font-size: 15px;
      color: var(--ebay-text);
      margin-bottom: 4px;
    }
    
    .category-count {
      font-size: 13px;
      color: var(--ebay-text-light);
    }
    
    /* Custom colors for different categories */
    .category-card.electronics .category-icon i {
      color: var(--ebay-blue);
    }
    
    .category-card.fashion .category-icon i {
      color: #9c27b0;
    }
    
    .category-card.home .category-icon i {
      color: var(--ebay-green);
    }
    
    .category-card.sports .category-icon i {
      color: #ff9800;
    }
    
    .category-card.toys .category-icon i {
      color: var(--ebay-red);
    }
    
    .category-card.collectibles .category-icon i {
      color: #795548;
    }
    
    .category-card.electronics:hover .category-icon {
      background-color: #e6f0ff;
    }
    
    .category-card.fashion:hover .category-icon {
      background-color: #f8e6ff;
    }
    
    .category-card.home:hover .category-icon {
      background-color: #e6ffe8;
    }
    
    .category-card.sports:hover .category-icon {
      background-color: #fff5e6;
    }
    
    .category-card.toys:hover .category-icon {
      background-color: #ffe6e6;
    }
    
    .category-card.collectibles:hover .category-icon {
      background-color: #f0e6e0;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      .category-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    @media (max-width: 576px) {
      .category-grid {
        gap: 15px;
      }
      
      .category-icon {
        width: 50px;
        height: 50px;
      }
      
      .category-icon i {
        font-size: 24px;
      }
      
      .category-name {
        font-size: 14px;
      }
      
      .category-count {
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Top Categories Section -->
    <section class="top-categories">
      <h2 class="section-title">Top Categories</h2>
      
      <div class="category-grid">
        <!-- Category 1: Electronics -->
        <div class="category-card electronics">
          <div class="category-icon">
            <i class="bi bi-laptop"></i>
          </div>
          <h3 class="category-name">Electronics</h3>
          <span class="category-count">24,531 items</span>
        </div>
        
        <!-- Category 2: Fashion -->
        <div class="category-card fashion">
          <div class="category-icon">
            <i class="bi bi-handbag"></i>
          </div>
          <h3 class="category-name">Fashion</h3>
          <span class="category-count">18,429 items</span>
        </div>
        
        <!-- Category 3: Home & Garden -->
        <div class="category-card home">
          <div class="category-icon">
            <i class="bi bi-house-heart"></i>
          </div>
          <h3 class="category-name">Home & Garden</h3>
          <span class="category-count">15,782 items</span>
        </div>
        
        <!-- Category 4: Sports & Outdoors -->
        <div class="category-card sports">
          <div class="category-icon">
            <i class="bi bi-bicycle"></i>
          </div>
          <h3 class="category-name">Sports</h3>
          <span class="category-count">9,654 items</span>
        </div>
        
        <!-- Category 5: Toys & Hobbies -->
        <div class="category-card toys">
          <div class="category-icon">
            <i class="bi bi-controller"></i>
          </div>
          <h3 class="category-name">Toys & Hobbies</h3>
          <span class="category-count">12,345 items</span>
        </div>
        
        <!-- Category 6: Collectibles -->
        <div class="category-card collectibles">
          <div class="category-icon">
            <i class="bi bi-gem"></i>
          </div>
          <h3 class="category-name">Collectibles</h3>
          <span class="category-count">8,976 items</span>
        </div>
      </div>
    </section>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
