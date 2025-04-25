<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MacBook Pro 16' ne shitje</title>
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
    }
    
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
    }
    
    .header {
      border-bottom: 1px solid #e5e5e5;
      padding: 10px 0;
      background-color: white;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    
    .logo {
      height: 40px;
    }
    
    .search-container {
      position: relative;
      flex-grow: 1;
    }
    
    .search-input {
      width: 100%;
      padding: 10px 40px 10px 15px;
      border: 2px solid #ccc;
      border-radius: 25px;
      font-size: 14px;
    }
    
    .search-input:focus {
      outline: none;
      border-color: var(--ebay-blue);
    }
    
    .search-btn {
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--ebay-blue);
      font-size: 20px;
      cursor: pointer;
    }
    
    .search-suggestions {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  margin-top: 5px;
  padding: 10px 0;
  display: none;
  z-index: 1002;
}

.search-suggestions.active {
  display: block;
}

.suggestion-item {
  padding: 10px 15px;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.suggestion-item:hover {
  background-color: #f8f9fa;
}

.suggestion-icon {
  color: var(--ebay-text-light);
  font-size: 16px;
}

.suggestion-text {
  font-size: 14px;
}

.suggestion-category {
  font-size: 12px;
  color: #767676;
  margin-left: auto;
}

.recent-searches {
  padding: 10px 15px;
  border-bottom: 1px solid #e5e5e5;
}

.recent-searches-title {
  font-size: 12px;
  font-weight: 600;
  color: #767676;
  margin-bottom: 5px;
}

.popular-searches {
  padding: 10px 15px;
}

.popular-searches-title {
  font-size: 12px;
  font-weight: 600;
  color: #767676;
  margin-bottom: 5px;
}
    
    .nav-icon {
      color: #333;
      font-size: 22px;
      cursor: pointer;
      padding: 8px;
      position: relative;
    }
    
    .nav-icon:hover {
      color: var(--ebay-blue);
    }
    
    /* Replace the existing dropdown-menu CSS with this enhanced version */
.dropdown-menu {
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  padding: 0;
  min-width: 200px;
}

/* Add these new styles for the mega menu */
.mega-menu {
  width: 800px;
  padding: 20px;
  left: auto !important;
  right: 0;
  display: flex;
  flex-wrap: wrap;
}

.category-column {
  width: 25%;
  padding: 10px 15px;
}

.category-title {
  font-weight: 600;
  font-size: 14px;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--ebay-text);
}

.category-title i {
  font-size: 18px;
  color: var(--ebay-blue);
}

.subcategory-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.subcategory-item {
  margin-bottom: 8px;
}

.subcategory-link {
  font-size: 13px;
  color: var(--ebay-text-light);
  text-decoration: none;
  display: block;
  padding: 4px 0;
  transition: color 0.2s;
}

.subcategory-link:hover {
  color: var(--ebay-blue);
  text-decoration: none;
}

.featured-category {
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid var(--ebay-border);
}

.featured-title {
  font-weight: 600;
  font-size: 13px;
  margin-bottom: 10px;
  color: var(--ebay-text);
}

.featured-link {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: var(--ebay-blue);
  text-decoration: none;
}

.featured-link:hover {
  text-decoration: underline;
}

/* Mobile category navigation */
.mobile-categories {
  position: fixed;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100vh;
  background-color: white;
  z-index: 1002;
  transition: left 0.3s ease;
  overflow-y: auto;
}

.mobile-categories.active {
  left: 0;
}

.mobile-category-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  border-bottom: 1px solid var(--ebay-border);
  position: sticky;
  top: 0;
  background-color: white;
  z-index: 1;
}

.mobile-category-title {
  font-weight: 600;
  font-size: 16px;
  margin: 0;
}

.mobile-category-close,
.mobile-category-back {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
}

.mobile-category-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.mobile-category-item {
  border-bottom: 1px solid var(--ebay-border);
}

.mobile-category-link {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  color: var(--ebay-text);
  text-decoration: none;
  font-size: 15px;
}

.mobile-category-link i {
  color: var(--ebay-text-light);
}

.mobile-subcategory-container {
  position: fixed;
  top: 0;
  left: 100%;
  width: 100%;
  height: 100vh;
  background-color: white;
  z-index: 1003;
  transition: left 0.3s ease;
  overflow-y: auto;
}

.mobile-subcategory-container.active {
  left: 0;
}

.mobile-featured {
  padding: 15px;
  background-color: var(--ebay-light-gray);
  margin-top: 15px;
}

.mobile-featured-title {
  font-weight: 600;
  font-size: 14px;
  margin-bottom: 10px;
}

.mobile-featured-link {
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--ebay-blue);
  text-decoration: none;
  font-size: 14px;
  margin-bottom: 8px;
}

.mobile-featured-link i {
  font-size: 16px;
}
    
    .dropdown-item {
      padding: 8px 20px;
      font-size: 14px;
    }
    
    .dropdown-item:hover {
      background-color: #f8f9fa;
      color: var(--ebay-blue);
    }
    
    .category-btn {
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 20px;
      padding: 8px 15px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .category-btn:hover {
      border-color: var(--ebay-blue);
    }
    
    .mobile-menu {
      position: fixed;
      top: 0;
      right: -280px;
      width: 280px;
      height: 100vh;
      background-color: white;
      z-index: 1001;
      transition: right 0.3s ease;
      box-shadow: -5px 0 15px rgba(0,0,0,0.1);
      overflow-y: auto;
    }
    
    .mobile-menu.active {
      right: 0;
    }
    
    .mobile-menu-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px;
      border-bottom: 1px solid #e5e5e5;
    }
    
    .mobile-menu-close {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
    }
    
    .mobile-menu-items {
      padding: 15px;
    }
    
    .mobile-menu-item {
      padding: 12px 0;
      border-bottom: 1px solid #f1f1f1;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      z-index: 1000;
      display: none;
    }
    
    .overlay.active {
      display: block;
    }
    
    /* Cart Panel */
    .cart-panel {
      position: fixed;
      top: 0;
      right: -350px;
      width: 350px;
      height: 100vh;
      background-color: white;
      z-index: 1001;
      transition: right 0.3s ease;
      box-shadow: -5px 0 15px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
    }
    
    .cart-panel.active {
      right: 0;
    }
    
    .cart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px;
      border-bottom: 1px solid #e5e5e5;
    }
    
    .cart-header h5 {
      margin: 0;
      font-weight: 600;
    }
    
    .cart-close {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #333;
    }
    
    .cart-items {
      flex: 1;
      overflow-y: auto;
      padding: 15px;
    }
    
    .cart-item {
      display: flex;
      gap: 15px;
      padding: 15px 0;
      border-bottom: 1px solid #f1f1f1;
    }
    
    .cart-item-image {
      width: 80px;
      height: 80px;
      flex-shrink: 0;
    }
    
    .cart-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid #e5e5e5;
    }
    
    .cart-item-details {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    
    .cart-item-title {
      font-size: 14px;
      font-weight: 500;
    }
    
    .cart-item-price {
      font-size: 16px;
      font-weight: 600;
      color: #333;
    }
    
    .cart-item-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 5px;
    }
    
    .quantity-control {
      display: flex;
      align-items: center;
      border: 1px solid #e5e5e5;
      border-radius: 4px;
      overflow: hidden;
    }
    
    .quantity-btn {
      width: 28px;
      height: 28px;
      background-color: #f8f8f8;
      border: none;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .quantity-btn:hover {
      background-color: #e5e5e5;
    }
    
    .quantity-input {
      width: 40px;
      height: 28px;
      border: none;
      border-left: 1px solid #e5e5e5;
      border-right: 1px solid #e5e5e5;
      text-align: center;
      font-size: 14px;
    }
    
    .quantity-input::-webkit-inner-spin-button,
    .quantity-input::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    
    .remove-btn {
      background: none;
      border: none;
      color: #767676;
      cursor: pointer;
      font-size: 16px;
    }
    
    .remove-btn:hover {
      color: var(--ebay-red);
    }
    
    .cart-summary {
      padding: 15px;
      background-color: #f8f8f8;
      border-top: 1px solid #e5e5e5;
      border-bottom: 1px solid #e5e5e5;
    }
    
    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
    }
    
    .summary-row.total {
      font-size: 18px;
      font-weight: 600;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #e5e5e5;
    }
    
    .cart-footer {
      padding: 15px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .checkout-btn {
      background-color: var(--ebay-blue);
      color: white;
      border: none;
      border-radius: 24px;
      padding: 12px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    
    .checkout-btn:hover {
      background-color: #2b4fb4;
    }
    
    .view-cart-link {
      text-align: center;
      color: var(--ebay-blue);
      text-decoration: none;
      font-size: 14px;
      padding: 8px;
    }
    
    .view-cart-link:hover {
      text-decoration: underline;
    }
    
    @media (max-width: 768px) {
      .desktop-only {
        display: none !important;
      }
    }
    
    @media (min-width: 769px) {
      .mobile-only {
        display: none !important;
      }
    }

    /* Cart Panel Styles */
    /* Cart Panel */
    .cart-panel {
      position: fixed;
      top: 0;
      right: -400px;
      width: 400px;
      height: 100vh;
      background-color: white;
      z-index: 1002;
      transition: right 0.3s ease;
      box-shadow: -5px 0 15px rgba(0,0,0,0.1);
      overflow-y: auto;
      padding: 0;
    }

    .cart-panel.active {
      right: 0;
    }

    .cart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px;
      border-bottom: 1px solid #e5e5e5;
    }

    .cart-close {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
    }

    .cart-items {
      padding: 15px;
    }

    .cart-item {
      display: flex;
      gap: 10px;
      padding: 10px 0;
      border-bottom: 1px solid #f1f1f1;
    }

    .cart-item-image {
      width: 80px;
      height: 80px;
    }

    .cart-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .cart-item-details {
      flex-grow: 1;
    }

    .cart-item-title {
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 5px;
    }

    .cart-item-price {
      font-size: 16px;
      color: var(--ebay-blue);
      margin-bottom: 8px;
    }

    .cart-item-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .quantity-control {
      display: flex;
      align-items: center;
      border: 1px solid #ccc;
      border-radius: 5px;
      overflow: hidden;
    }

    .quantity-btn {
      background: none;
      border: none;
      padding: 5px 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .quantity-input {
      width: 40px;
      text-align: center;
      border: none;
      border-left: 1px solid #ccc;
      border-right: 1px solid #ccc;
      padding: 5px;
      font-size: 14px;
    }

    .remove-btn {
      background: none;
      border: none;
      color: var(--ebay-red);
      font-size: 20px;
      cursor: pointer;
    }

    .cart-summary {
      padding: 15px;
      border-top: 1px solid #e5e5e5;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      font-size: 14px;
    }

    .summary-row.total {
      font-weight: 600;
      font-size: 16px;
    }

    .cart-footer {
      padding: 15px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .checkout-btn {
      background-color: var(--ebay-blue);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .view-cart-link {
      text-align: center;
      color: var(--ebay-blue);
      text-decoration: none;
      font-size: 14px;
    }
  </style>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="row align-items-center">
        <!-- Logo -->
        <div class="col-auto">
          <a href="#">
            <img src="/placeholder.svg?height=40&width=100" alt="eBay Logo" class="logo">
          </a>
        </div>
        
        <!-- Search - Desktop -->
        <div class="col desktop-only">
          <div class="search-container">
            <input type="text" class="search-input" id="desktop-search" placeholder="Search for anything">
            <button class="search-btn">
              <i class="bi bi-search"></i>
            </button>
            <div class="search-suggestions" id="desktop-search-suggestions">
              <div class="recent-searches">
                <div class="recent-searches-title">RECENT SEARCHES</div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-clock-history"></i></span>
                  <span class="suggestion-text">vintage watch</span>
                </div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-clock-history"></i></span>
                  <span class="suggestion-text">mechanical keyboard</span>
                </div>
              </div>
              <div class="popular-searches">
                <div class="popular-searches-title">POPULAR RIGHT NOW</div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-graph-up-arrow"></i></span>
                  <span class="suggestion-text">nintendo switch</span>
                  <span class="suggestion-category">Electronics</span>
                </div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-graph-up-arrow"></i></span>
                  <span class="suggestion-text">air jordan</span>
                  <span class="suggestion-category">Shoes</span>
                </div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-graph-up-arrow"></i></span>
                  <span class="suggestion-text">pokemon cards</span>
                  <span class="suggestion-category">Collectibles</span>
                </div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-graph-up-arrow"></i></span>
                  <span class="suggestion-text">iphone 15 pro</span>
                  <span class="suggestion-category">Cell Phones</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Replace the existing desktop category dropdown with this enhanced version -->
<!-- Category Dropdown - Desktop -->
<div class="col-auto desktop-only">
  <div class="dropdown">
    <button class="category-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      Categories <i class="bi bi-chevron-down"></i>
    </button>
    <div class="dropdown-menu mega-menu">
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-laptop"></i> Electronics
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Cell Phones & Accessories</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Computers & Tablets</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Cameras & Photo</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">TV, Audio & Surveillance</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Video Games & Consoles</a></li>
        </ul>
        <div class="featured-category">
          <div class="featured-title">Featured</div>
          <a href="#" class="featured-link">
            <i class="bi bi-lightning-fill"></i> Tech Deals of the Week
          </a>
        </div>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-handbag"></i> Fashion
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Women's Clothing</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Men's Clothing</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Shoes</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Jewelry & Watches</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Bags & Accessories</a></li>
        </ul>
        <div class="featured-category">
          <div class="featured-title">Featured</div>
          <a href="#" class="featured-link">
            <i class="bi bi-stars"></i> Luxury Brands
          </a>
        </div>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-house"></i> Home & Garden
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Furniture</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Kitchen & Dining</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Tools & Home Improvement</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Home Décor</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Yard, Garden & Outdoor</a></li>
        </ul>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-gem"></i> Collectibles & Art
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Collectibles</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Antiques</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Sports Memorabilia</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Art</a></li>
        </ul>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-bicycle"></i> Sporting Goods
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Outdoor Sports</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Team Sports</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Exercise & Fitness</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Golf</a></li>
        </ul>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-controller"></i> Toys & Hobbies
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Action Figures</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Building Toys</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Collectible Card Games</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Radio Control & RC Toys</a></li>
        </ul>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-car-front"></i> Motors
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Auto Parts & Accessories</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Motorcycles</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Cars & Trucks</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Other Vehicles</a></li>
        </ul>
      </div>
      
      <div class="category-column">
        <div class="category-title">
          <i class="bi bi-building"></i> Business & Industrial
        </div>
        <ul class="subcategory-list">
          <li class="subcategory-item"><a href="#" class="subcategory-link">Healthcare & Lab</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Industrial Supply & MRO</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Office Supplies</a></li>
          <li class="subcategory-item"><a href="#" class="subcategory-link">Restaurant & Food Service</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
        
        <!-- Icons - Desktop -->
        <div class="col-auto desktop-only">
          <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
              <span class="nav-icon" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person"></i>
              </span>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Sign In</a></li>
                <li><a class="dropdown-item" href="#">Register</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">My Account</a></li>
                <li><a class="dropdown-item" href="#">Orders</a></li>
                <li><a class="dropdown-item" href="#">Messages</a></li>
              </ul>
            </div>
            <span class="nav-icon">
              <i class="bi bi-heart"></i>
            </span>
            <span class="nav-icon">
              <i class="bi bi-cart"></i>
            </span>
          </div>
        </div>
        
        <!-- Mobile Layout -->
        <div class="col mobile-only">
          <div class="search-container">
            <input type="text" class="search-input" id="mobile-search" placeholder="Search">
            <button class="search-btn">
              <i class="bi bi-search"></i>
            </button>
            <div class="search-suggestions" id="mobile-search-suggestions">
              <div class="recent-searches">
                <div class="recent-searches-title">RECENT SEARCHES</div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-clock-history"></i></span>
                  <span class="suggestion-text">vintage watch</span>
                </div>
              </div>
              <div class="popular-searches">
                <div class="popular-searches-title">POPULAR RIGHT NOW</div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-graph-up-arrow"></i></span>
                  <span class="suggestion-text">nintendo switch</span>
                </div>
                <div class="suggestion-item">
                  <span class="suggestion-icon"><i class="bi bi-graph-up-arrow"></i></span>
                  <span class="suggestion-text">air jordan</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Replace the mobile category dropdown with this enhanced version -->
<div class="col-auto mobile-only">
  <div class="d-flex align-items-center gap-2">
    <span class="nav-icon" id="mobile-category-btn">
      <i class="bi bi-grid"></i>
    </span>
    <span class="nav-icon">
      <i class="bi bi-cart"></i>
    </span>
    <span class="nav-icon" id="hamburger-menu">
      <i class="bi bi-list"></i>
    </span>
  </div>
</div>

  
      </div>
    </div>
  </header>
  
  <!-- Add this mobile categories navigation after the overlay div -->
<!-- Mobile Categories -->
<div class="mobile-categories" id="mobile-categories">
  <div class="mobile-category-header">
    <h5 class="mobile-category-title">Shop by Category</h5>
    <button class="mobile-category-close" id="mobile-category-close">
      <i class="bi bi-x"></i>
    </button>
  </div>
  <ul class="mobile-category-list">
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="electronics">
        <span><i class="bi bi-laptop"></i> Electronics</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="fashion">
        <span><i class="bi bi-handbag"></i> Fashion</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="home">
        <span><i class="bi bi-house"></i> Home & Garden</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="collectibles">
        <span><i class="bi bi-gem"></i> Collectibles & Art</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="sporting">
        <span><i class="bi bi-bicycle"></i> Sporting Goods</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="toys">
        <span><i class="bi bi-controller"></i> Toys & Hobbies</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="motors">
        <span><i class="bi bi-car-front"></i> Motors</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link" data-category="business">
        <span><i class="bi bi-building"></i> Business & Industrial</span>
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
  </ul>
  
  <div class="mobile-featured">
    <div class="mobile-featured-title">Featured Categories</div>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-lightning-fill"></i> Daily Deals
    </a>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-stars"></i> Featured Brands
    </a>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-shop"></i> eBay Refurbished
    </a>
  </div>
</div>

<!-- Electronics Subcategory -->
<div class="mobile-subcategory-container" id="electronics-subcategory">
  <div class="mobile-category-header">
    <button class="mobile-category-back" id="electronics-back">
      <i class="bi bi-chevron-left"></i>
    </button>
    <h5 class="mobile-category-title">Electronics</h5>
    <button class="mobile-category-close">
      <i class="bi bi-x"></i>
    </button>
  </div>
  <ul class="mobile-category-list">
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Cell Phones & Accessories</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Computers & Tablets</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Cameras & Photo</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>TV, Audio & Surveillance</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Video Games & Consoles</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Smart Home Devices</span>
      </a>
    </li>
  </ul>
  
  <div class="mobile-featured">
    <div class="mobile-featured-title">Featured in Electronics</div>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-lightning-fill"></i> Tech Deals of the Week
    </a>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-phone"></i> Latest Smartphones
    </a>
  </div>
</div>

<!-- Fashion Subcategory -->
<div class="mobile-subcategory-container" id="fashion-subcategory">
  <div class="mobile-category-header">
    <button class="mobile-category-back" id="fashion-back">
      <i class="bi bi-chevron-left"></i>
    </button>
    <h5 class="mobile-category-title">Fashion</h5>
    <button class="mobile-category-close">
      <i class="bi bi-x"></i>
    </button>
  </div>
  <ul class="mobile-category-list">
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Women's Clothing</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Men's Clothing</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Shoes</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Jewelry & Watches</span>
      </a>
    </li>
    <li class="mobile-category-item">
      <a href="#" class="mobile-category-link">
        <span>Bags & Accessories</span>
      </a>
    </li>
  </ul>
  
  <div class="mobile-featured">
    <div class="mobile-featured-title">Featured in Fashion</div>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-stars"></i> Luxury Brands
    </a>
    <a href="#" class="mobile-featured-link">
      <i class="bi bi-tag"></i> Seasonal Sales
    </a>
  </div>
</div>
  
  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu-header">
      <h5>Menu</h5>
      <button class="mobile-menu-close" id="mobile-menu-close">
        <i class="bi bi-x"></i>
      </button>
    </div>
    <div class="mobile-menu-items">
      <div class="mobile-menu-item">
        <i class="bi bi-person"></i>
        <span>Account</span>
      </div>
      <div class="mobile-menu-item">
        <i class="bi bi-heart"></i>
        <span>Wishlist</span>
      </div>
      <div class="mobile-menu-item">
        <i class="bi bi-box"></i>
        <span>Orders</span>
      </div>
      <div class="mobile-menu-item">
        <i class="bi bi-chat"></i>
        <span>Messages</span>
      </div>
      <div class="mobile-menu-item">
        <i class="bi bi-gear"></i>
        <span>Settings</span>
      </div>
      <div class="mobile-menu-item">
        <i class="bi bi-question-circle"></i>
        <span>Help & Contact</span>
      </div>
      <div class="mobile-menu-item">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
      </div>
    </div>
  </div>
  
  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>
  
  <!-- Cart Panel -->
  <div class="cart-panel" id="cart-panel">
    <div class="cart-header">
      <h5>Shopping Cart (2)</h5>
      <button class="cart-close" id="cart-close">
        <i class="bi bi-x"></i>
      </button>
    </div>
    <div class="cart-items">
      <div class="cart-item">
        <div class="cart-item-image">
          <img src="/placeholder.svg?height=80&width=80" alt="Vintage Watch">
        </div>
        <div class="cart-item-details">
          <div class="cart-item-title">Vintage Seiko Automatic Diver's Watch 200m</div>
          <div class="cart-item-price">$249.99</div>
          <div class="cart-item-actions">
            <div class="quantity-control">
              <button class="quantity-btn minus">-</button>
              <input type="number" class="quantity-input" value="1" min="1" max="10">
              <button class="quantity-btn plus">+</button>
            </div>
            <button class="remove-btn">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="cart-item">
        <div class="cart-item-image">
          <img src="/placeholder.svg?height=80&width=80" alt="Mechanical Keyboard">
        </div>
        <div class="cart-item-details">
          <div class="cart-item-title">Mechanical Keyboard with Cherry MX Blue Switches</div>
          <div class="cart-item-price">$89.95</div>
          <div class="cart-item-actions">
            <div class="quantity-control">
              <button class="quantity-btn minus">-</button>
              <input type="number" class="quantity-input" value="1" min="1" max="10">
              <button class="quantity-btn plus">+</button>
            </div>
            <button class="remove-btn">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="cart-summary">
      <div class="summary-row">
        <span>Subtotal (2 items)</span>
        <span>$339.94</span>
      </div>
      <div class="summary-row">
        <span>Shipping</span>
        <span>$12.99</span>
      </div>
      <div class="summary-row">
        <span>Tax</span>
        <span>$28.23</span>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span>$381.16</span>
      </div>
    </div>
    <div class="cart-footer">
      <button class="checkout-btn">Continue to Checkout</button>
      <a href="#" class="view-cart-link">View Cart</a>
    </div>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Mobile menu functionality
    const hamburgerMenu = document.getElementById('hamburger-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const overlay = document.getElementById('overlay');
    
    hamburgerMenu.addEventListener('click', function() {
      mobileMenu.classList.add('active');
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    });
    
    mobileMenuClose.addEventListener('click', function() {
      closeMenu();
    });
    
    overlay.addEventListener('click', function() {
      closeMenu();
    });
    
    function closeMenu() {
      mobileMenu.classList.remove('active');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
      const dropdowns = document.querySelectorAll('.dropdown-menu.show');
      dropdowns.forEach(dropdown => {
        const dropdownToggle = dropdown.previousElementSibling;
        if (!dropdown.contains(event.target) && !dropdownToggle.contains(event.target)) {
          const bsDropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
          if (bsDropdown) {
            bsDropdown.hide();
          }
        }
      });
    });
    
// Search suggestions functionality
const desktopSearch = document.getElementById('desktop-search');
const mobileSearch = document.getElementById('mobile-search');
const desktopSuggestions = document.getElementById('desktop-search-suggestions');
const mobileSuggestions = document.getElementById('mobile-search-suggestions');

// Desktop search
desktopSearch.addEventListener('focus', function() {
  desktopSuggestions.classList.add('active');
  overlay.classList.add('active');
});

desktopSearch.addEventListener('input', function() {
  desktopSuggestions.classList.add('active');
  overlay.classList.add('active');
});

// Mobile search
mobileSearch.addEventListener('focus', function() {
  mobileSuggestions.classList.add('active');
  overlay.classList.add('active');
});

mobileSearch.addEventListener('input', function() {
  mobileSuggestions.classList.add('active');
  overlay.classList.add('active');
});

// Close suggestions when clicking outside
document.addEventListener('click', function(event) {
  // Desktop suggestions
  if (!desktopSearch.contains(event.target) && !desktopSuggestions.contains(event.target)) {
    desktopSuggestions.classList.remove('active');
    if (!mobileMenu.classList.contains('active') && !document.querySelector('.dropdown-menu.show')) {
      overlay.classList.remove('active');
    }
  }
  
  // Mobile suggestions
  if (!mobileSearch.contains(event.target) && !mobileSuggestions.contains(event.target)) {
    mobileSuggestions.classList.remove('active');
    if (!mobileMenu.classList.contains('active') && !document.querySelector('.dropdown-menu.show')) {
      overlay.classList.remove('active');
    }
  }
});

// Prevent clicks inside suggestions from closing them
desktopSuggestions.addEventListener('click', function(event) {
  event.stopPropagation();
});

mobileSuggestions.addEventListener('click', function(event) {
  event.stopPropagation();
});

// Handle suggestion item clicks
document.querySelectorAll('.suggestion-item').forEach(item => {
  item.addEventListener('click', function() {
    const searchText = this.querySelector('.suggestion-text').textContent;
    desktopSearch.value = searchText;
    mobileSearch.value = searchText;
    desktopSuggestions.classList.remove('active');
    mobileSuggestions.classList.remove('active');
    if (!mobileMenu.classList.contains('active')) {
      overlay.classList.remove('active');
    }
  });
});

// Cart functionality
const cartIcon = document.querySelector('.nav-icon .bi-cart').parentElement;
const cartPanel = document.getElementById('cart-panel');
const cartClose = document.getElementById('cart-close');

cartIcon.addEventListener('click', function(event) {
  event.stopPropagation();
  cartPanel.classList.add('active');
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
});

cartClose.addEventListener('click', function() {
  closeCart();
});

function closeCart() {
  cartPanel.classList.remove('active');
  if (!mobileMenu.classList.contains('active') && 
      !desktopSuggestions.classList.contains('active') && 
      !mobileSuggestions.classList.contains('active')) {
    overlay.classList.remove('active');
  }
  document.body.style.overflow = '';
}

// Close cart when clicking overlay
overlay.addEventListener('click', function() {
  closeCart();
  closeMenu();
  desktopSuggestions.classList.remove('active');
  mobileSuggestions.classList.remove('active');
});

// Quantity controls
document.querySelectorAll('.quantity-btn.minus').forEach(btn => {
  btn.addEventListener('click', function() {
    const input = this.nextElementSibling;
    const value = parseInt(input.value);
    if (value > 1) {
      input.value = value - 1;
    }
  });
});

document.querySelectorAll('.quantity-btn.plus').forEach(btn => {
  btn.addEventListener('click', function() {
    const input = this.previousElementSibling;
    const value = parseInt(input.value);
    if (value < 10) {
      input.value = value + 1;
    }
  });
});

// Remove item buttons
document.querySelectorAll('.remove-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    if (confirm('Remove this item from your cart?')) {
      const cartItem = this.closest('.cart-item');
      cartItem.style.opacity = '0';
      setTimeout(() => {
        cartItem.remove();
        // Update cart count and totals here in a real implementation
      }, 300);
    }
  });
});

// Add this JavaScript at the end of the script section
// Mobile category navigation
const mobileCategoryBtn = document.getElementById('mobile-category-btn');
const mobileCategories = document.getElementById('mobile-categories');
const mobileCategoryClose = document.getElementById('mobile-category-close');
const mobileSubcategories = document.querySelectorAll('.mobile-subcategory-container');
const mobileBackBtns = document.querySelectorAll('.mobile-category-back');
const mobileCloseButtons = document.querySelectorAll('.mobile-category-close');

// Open main categories
mobileCategoryBtn.addEventListener('click', function() {
  mobileCategories.classList.add('active');
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
});

// Close main categories
mobileCategoryClose.addEventListener('click', function() {
  closeMobileCategories();
});

// Close all category menus
mobileCloseButtons.forEach(btn => {
  btn.addEventListener('click', function() {
    closeMobileCategories();
    mobileSubcategories.forEach(sub => {
      sub.classList.remove('active');
    });
  });
});

function closeMobileCategories() {
  mobileCategories.classList.remove('active');
  if (!mobileMenu.classList.contains('active') && 
      !desktopSuggestions.classList.contains('active') && 
      !mobileSuggestions.classList.contains('active') &&
      !cartPanel.classList.contains('active')) {
    overlay.classList.remove('active');
  }
  document.body.style.overflow = '';
}

// Open subcategories
document.querySelectorAll('.mobile-category-link[data-category]').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const category = this.getAttribute('data-category');
    const subcategoryContainer = document.getElementById(`${category}-subcategory`);
    if (subcategoryContainer) {
      subcategoryContainer.classList.add('active');
    }
  });
});

// Back buttons for subcategories
mobileBackBtns.forEach(btn => {
  btn.addEventListener('click', function() {
    const subcategoryContainer = this.closest('.mobile-subcategory-container');
    subcategoryContainer.classList.remove('active');
  });
});

// Close categories when clicking overlay
overlay.addEventListener('click', function() {
  closeMobileCategories();
  mobileSubcategories.forEach(sub => {
    sub.classList.remove('active');
  });
});
  </script>
</body>
</html>

