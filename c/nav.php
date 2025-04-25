<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trevali Marketplace</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
      height: 43px;
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
      color: #767676;
      font-size: 16px;
    }

    .suggestion-text {
      font-size: 14px;
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

    
    
    .dropdown-menu {
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      padding: 10px 0;
      min-width: 200px;
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
      padding: 10px 15px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
      transition: all 0.2s;
      height: 43px;
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
    
    
    
    .overlay.active {
      display: block;
    }
    
    /* Cart Panel Styles */
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
  </style>
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="row align-items-center">
        <!-- Logo -->
        <div class="col-auto">
          <a href="index.php">
            <img src="blishit.png" alt="Trevali Logo" class="logo">
          </a>
        </div>
        
        <!-- Search - Desktop -->
        <div class="col desktop-only">
          <div class="search-container">
            <form action="s.php" method="GET">
              <input type="text" name="q" autocomplete="off" class="search-input" id="desktop-search" 
                     placeholder="Kerko BliShit" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
              <button type="submit" class="search-btn">
                <i class="bi bi-search"></i>
              </button>
            </form>
            <div class="search-suggestions" id="desktop-search-suggestions"></div>
          </div>
        </div>
        
        <!-- Category Dropdown - Desktop -->
        <div class="col-auto desktop-only">
          <div class="dropdown">
            <button class="category-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Categories <i class="bi bi-chevron-down"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="c.php?cat=Electronics & Technology">Electronics & Technology</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Fashion & Accessories">Fashion & Accessories</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Home & Living">Home & Living</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Automotive & Vehicles">Automotive & Vehicles</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Sports & Outdoors">Sports & Outdoors</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Health & Beauty">Health & Beauty</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Toys & Hobbies">Toys & Hobbies</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Books & Education">Books & Education</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Real Estate & Rentals">Real Estate & Rentals</a></li>
              <li><a class="dropdown-item" href="c.php?cat=Services & Freelance">Services & Freelance</a></li>
            </ul>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                  <li><a class="dropdown-item" href="profile.php">My Account</a></li>
                  <li><a class="dropdown-item" href="orders.php">Orders</a></li>
                  <li><a class="dropdown-item" href="messages.php">Messages</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
                <?php else: ?>
                  <li><a class="dropdown-item" href="login.php">Sign In</a></li>
                  <li><a class="dropdown-item" href="signup.php">Register</a></li>
                <?php endif; ?>
              </ul>
            </div>
            <span class="nav-icon">
              <a href="form.php" style="color: inherit; text-decoration: none;">
                <i class="bi bi-plus-circle"></i>
              </a>
            </span>
            <span class="nav-icon" id="cart-icon">
              <i class="bi bi-cart"></i>
            </span>
          </div>
        </div>
        
        <!-- Mobile Layout -->
        <div class="col mobile-only">
          <div class="search-container">
            <form action="s.php" method="GET">
              <input type="text" name="q" class="search-input" id="mobile-search" 
                     placeholder="Search" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
              <button type="submit" class="search-btn">
                <i class="bi bi-search"></i>
              </button>
            </form>
            <div class="search-suggestions" id="mobile-search-suggestions"></div>
          </div>
        </div>
        
        <div class="col-auto mobile-only">
          <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
              <span class="nav-icon" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-grid"></i>
              </span>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="c.php?cat=Electronics & Technology">Electronics & Technology</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Fashion & Accessories">Fashion & Accessories</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Home & Living">Home & Living</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Automotive & Vehicles">Automotive & Vehicles</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Sports & Outdoors">Sports & Outdoors</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Health & Beauty">Health & Beauty</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Toys & Hobbies">Toys & Hobbies</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Books & Education">Books & Education</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Real Estate & Rentals">Real Estate & Rentals</a></li>
                <li><a class="dropdown-item" href="c.php?cat=Services & Freelance">Services & Freelance</a></li>
              </ul>
            </div>
            <span class="nav-icon" id="cart-icon-mobile">
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
  
  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu-header">
      <h5>Menu</h5>
      <button class="mobile-menu-close" id="mobile-menu-close">
        <i class="bi bi-x"></i>
      </button>
    </div>
    <div class="mobile-menu-items">
      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="mobile-menu-item">
          <i class="bi bi-person"></i>
          <span><a href="profile.php" style="text-decoration: none; color: #333;">Account</a></span>
        </div>
        <div class="mobile-menu-item">
          <i class="bi bi-heart"></i>
          <span><a href="wishlist.php" style="text-decoration: none; color: #333;">Wishlist</a></span>
        </div>
        <div class="mobile-menu-item">
          <i class="bi bi-box"></i>
          <span><a href="orders.php" style="text-decoration: none; color: #333;">Orders</a></span>
        </div>
        <div class="mobile-menu-item">
          <i class="bi bi-chat"></i>
          <span><a href="messages.php" style="text-decoration: none; color: #333;">Messages</a></span>
        </div>
        <div class="mobile-menu-item">
          <i class="bi bi-box-arrow-right"></i>
          <span><a href="logout.php" style="text-decoration: none; color: #333;">Sign Out</a></span>
        </div>
      <?php else: ?>
        <div class="mobile-menu-item">
          <i class="bi bi-person"></i>
          <span><a href="login.php" style="text-decoration: none; color: #333;">Sign In</a></span>
        </div>
        <div class="mobile-menu-item">
          <i class="bi bi-person-plus"></i>
          <span><a href="signup.php" style="text-decoration: none; color: #333;">Register</a></span>
        </div>
      <?php endif; ?>
    </div>
  </div>
  
  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>
  
  <!-- Cart Panel -->
  <div class="cart-panel" id="cart-panel">
    <div class="cart-header">
      <h5>Shopping Cart (0)</h5>
      <button class="cart-close" id="cart-close">
        <i class="bi bi-x"></i>
      </button>
    </div>
    <div class="cart-items">
      <p style="text-align: center; padding: 20px;">Your cart is empty.</p>
    </div>
    <div class="cart-summary">
      <div class="summary-row">
        <span>Subtotal (0 items)</span>
        <span>$0.00</span>
      </div>
      <div class="summary-row">
        <span>Shipping</span>
        <span>TBD</span>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span>$0.00</span>
      </div>
    </div>
    <div class="cart-footer">
      <button class="checkout-btn" disabled>Continue to Checkout</button>
      <a href="cart.php" class="view-cart-link">View Cart</a>
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
    
    // Cart functionality
    const cartIcons = [document.getElementById('cart-icon'), document.getElementById('cart-icon-mobile')];
    const cartPanel = document.getElementById('cart-panel');
    const cartClose = document.getElementById('cart-close');

    cartIcons.forEach(icon => {
      icon.addEventListener('click', function(event) {
        event.stopPropagation();
        cartPanel.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
      });
    });

    cartClose.addEventListener('click', function() {
      closeCart();
    });

    overlay.addEventListener('click', function() {
      closeCart();
    });

    function closeCart() {
      cartPanel.classList.remove('active');
      if (!mobileMenu.classList.contains('active')) {
        overlay.classList.remove('active');
      }
      document.body.style.overflow = '';
    }

    // Search functionality
    const searchInputs = [document.getElementById('desktop-search'), document.getElementById('mobile-search')];
    const suggestionsContainers = [document.getElementById('desktop-search-suggestions'), document.getElementById('mobile-search-suggestions')];
    let timeoutId;

    searchInputs.forEach((input, index) => {
      const suggestionsContainer = suggestionsContainers[index];

      input.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
          const query = this.value.trim();
          if (query.length > 0) {
            fetch(`search_suggestions.php?q=${encodeURIComponent(query)}`)
              .then(response => response.json())
              .then(suggestions => {
                suggestionsContainer.innerHTML = '';
                if (suggestions.length === 0) {
                  suggestionsContainer.innerHTML = '<div class="suggestion-item">No results found</div>';
                } else {
                  suggestions.forEach(suggestion => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.dataset.type = suggestion.type;
                    if (suggestion.type === 'listing') {
                      item.dataset.id = suggestion.id;
                      item.innerHTML = `<span class="suggestion-icon"><i class="bi bi-box"></i></span><span class="suggestion-text">${suggestion.title}</span>`;
                    } else {
                      item.dataset.keyword = suggestion.keyword;
                      item.innerHTML = `<span class="suggestion-icon"><i class="bi bi-search"></i></span><span class="suggestion-text">${suggestion.keyword}</span>`;
                    }
                    item.addEventListener('click', function() {
                      if (this.dataset.type === 'listing') {
                        window.location.href = `p.php?id=${this.dataset.id}`;
                      } else {
                        window.location.href = `s.php?q=${encodeURIComponent(this.dataset.keyword)}`;
                      }
                    });
                    suggestionsContainer.appendChild(item);
                  });
                }
                suggestionsContainer.classList.add('active');
                overlay.classList.add('active');
              })
              .catch(error => console.error('Error fetching suggestions:', error));
          } else {
            suggestionsContainer.classList.remove('active');
            if (!mobileMenu.classList.contains('active') && !cartPanel.classList.contains('active')) {
              overlay.classList.remove('active');
            }
          }
        }, 300); // Debounce delay
      });

      input.addEventListener('focus', function() {
        if (this.value.trim().length > 0) {
          suggestionsContainer.classList.add('active');
          overlay.classList.add('active');
        }
      });
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function(event) {
      searchInputs.forEach((input, index) => {
        const suggestionsContainer = suggestionsContainers[index];
        if (!input.contains(event.target) && !suggestionsContainer.contains(event.target)) {
          suggestionsContainer.classList.remove('active');
          if (!mobileMenu.classList.contains('active') && !cartPanel.classList.contains('active')) {
            overlay.classList.remove('active');
          }
        }
      });
    });
  </script>
</body>
</html>