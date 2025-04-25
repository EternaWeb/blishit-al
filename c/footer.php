<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Detail - eBay</title>
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
    
   

/* Footer Styles */
.footer {
  background-color: #fff;
  border-top: 1px solid var(--ebay-border);
  padding: 40px 0 20px;
  margin-top: 40px;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.footer-sections {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 30px;
  margin-bottom: 40px;
}

.footer-section h4 {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 15px;
  color: var(--ebay-text);
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 10px;
}

.footer-links a {
  color: var(--ebay-text-light);
  text-decoration: none;
  font-size: 14px;
  transition: color 0.2s;
}

.footer-links a:hover {
  color: var(--ebay-blue);
  text-decoration: underline;
}

.footer-logo-container {
  display: flex;
  justify-content: center;
  margin-bottom: 30px;
}

.footer-logo {
  height: 40px;
  width: auto;
}

.footer-bottom {
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid var(--ebay-border);
  font-size: 12px;
  color: var(--ebay-text-light);
}

.footer-bottom p {
  margin-bottom: 10px;
}

.accessibility-nav {
  background-color: var(--ebay-light-gray);
  padding: 12px 0;
  border-top: 1px solid var(--ebay-border);
}

.accessibility-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.accessibility-links {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.accessibility-links a {
  color: var(--ebay-text-light);
  text-decoration: none;
  font-size: 12px;
  transition: color 0.2s;
}

.accessibility-links a:hover {
  color: var(--ebay-blue);
  text-decoration: underline;
}

.language-selector {
  position: relative;
}

.language-btn {
  background: none;
  border: none;
  color: var(--ebay-text-light);
  font-size: 12px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 5px 10px;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.language-btn:hover {
  background-color: rgba(0, 0, 0, 0.05);
}

.language-dropdown {
  position: absolute;
  bottom: 100%;
  right: 0;
  background-color: white;
  border: 1px solid var(--ebay-border);
  border-radius: 4px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  padding: 10px 0;
  min-width: 200px;
  display: none;
  z-index: 100;
  margin-bottom: 5px;
}

.language-dropdown.active {
  display: block;
}

.language-option {
  padding: 8px 15px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-size: 14px;
}

.language-option:hover {
  background-color: var(--ebay-light-gray);
}

.language-option.active {
  font-weight: 500;
  color: var(--ebay-blue);
}

@media (max-width: 991px) {
  .footer-sections {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 768px) {
  .footer-sections {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 576px) {
  .footer-sections {
    grid-template-columns: 1fr;
  }
  
  .accessibility-container {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .accessibility-links {
    flex-direction: column;
    gap: 10px;
  }
}
  </style>
</head>
<body>
  
<!-- Footer -->
<footer class="footer">
  <div class="footer-container">
    <div class="footer-sections">
      <div class="footer-section">
        <h4>Buy</h4>
        <ul class="footer-links">
          <li><a href="#">Registration</a></li>
          <li><a href="#">eBay Money Back Guarantee</a></li>
          <li><a href="#">Bidding & buying help</a></li>
          <li><a href="#">Stores</a></li>
          <li><a href="#">eBay Refurbished</a></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h4>Sell</h4>
        <ul class="footer-links">
          <li><a href="#">Start selling</a></li>
          <li><a href="#">Learn to sell</a></li>
          <li><a href="#">Affiliates</a></li>
          <li><a href="#">Site map</a></li>
          <li><a href="#">Seller center</a></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h4>About eBay</h4>
        <ul class="footer-links">
          <li><a href="#">Company info</a></li>
          <li><a href="#">News</a></li>
          <li><a href="#">Investors</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Government relations</a></li>
          <li><a href="#">Advertise with us</a></li>
          <li><a href="#">Policies</a></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h4>Help & Contact</h4>
        <ul class="footer-links">
          <li><a href="#">Seller Information Center</a></li>
          <li><a href="#">Contact us</a></li>
          <li><a href="#">eBay returns</a></li>
          <li><a href="#">Community</a></li>
          <li><a href="#">eBay for Charity</a></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h4>Stay Connected</h4>
        <ul class="footer-links">
          <li><a href="#"><i class="bi bi-facebook"></i> Facebook</a></li>
          <li><a href="#"><i class="bi bi-twitter"></i> Twitter</a></li>
          <li><a href="#"><i class="bi bi-instagram"></i> Instagram</a></li>
          <li><a href="#"><i class="bi bi-youtube"></i> YouTube</a></li>
          <li><a href="#"><i class="bi bi-envelope"></i> Newsletter</a></li>
        </ul>
      </div>
    </div>
    
    <div class="footer-logo-container">
      <img src="blishit.png" alt="eBay Logo" class="footer-logo">
    </div>
    
    <div class="footer-bottom">
      <p>Copyright © 2025 Blishit. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<!-- Accessibility Navigation -->
<div class="accessibility-nav">
  <div class="accessibility-container">
    <div class="accessibility-links">
      <a href="#">Accessibility</a>
      <a href="sitemap.php">Sitemap</a>
      <a href="#">Privacy</a>
      <a href="#">Cookies</a>
      <a href="#">Your Privacy Choices</a>
      <a href="#">AdChoice</a>
    </div>
    
    <div class="language-selector">
      <button class="language-btn" id="language-btn">
        <i class="bi bi-globe"></i> English <i class="bi bi-chevron-up"></i>
      </button>
      <div class="language-dropdown" id="language-dropdown">
        <div class="language-option active">English</div>
        <div class="language-option">Español</div>
        <div class="language-option">Français</div>
        <div class="language-option">Deutsch</div>
        <div class="language-option">Italiano</div>
        <div class="language-option">日本語</div>
        <div class="language-option">한국어</div>
        <div class="language-option">中文</div>
      </div>
    </div>
  </div>
</div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Thumbnail gallery functionality
    document.querySelectorAll('.thumbnail').forEach(thumbnail => {
      thumbnail.addEventListener('click', function() {
        // Update active thumbnail
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        // Update main image
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
    
    // Prevent non-numeric input
    quantityInput.addEventListener('input', function() {
      const value = parseInt(this.value);
      const max = parseInt(this.getAttribute('max'));
      
      if (isNaN(value) || value < 1) {
        this.value = 1;
      } else if (value > max) {
        this.value = max;
      }
    });
    
    // Like button functionality
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

// Language selector functionality
const languageBtn = document.getElementById('language-btn');
const languageDropdown = document.getElementById('language-dropdown');

languageBtn.addEventListener('click', function() {
  languageDropdown.classList.toggle('active');
  
  // Change the chevron direction
  const chevron = this.querySelector('.bi-chevron-up, .bi-chevron-down');
  if (chevron.classList.contains('bi-chevron-up')) {
    chevron.classList.remove('bi-chevron-up');
    chevron.classList.add('bi-chevron-down');
  } else {
    chevron.classList.remove('bi-chevron-down');
    chevron.classList.add('bi-chevron-up');
  }
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  if (!languageBtn.contains(event.target) && !languageDropdown.contains(event.target)) {
    languageDropdown.classList.remove('active');
    const chevron = languageBtn.querySelector('.bi-chevron-up, .bi-chevron-down');
    if (chevron.classList.contains('bi-chevron-down')) {
      chevron.classList.remove('bi-chevron-down');
      chevron.classList.add('bi-chevron-up');
    }
  }
});

// Language option selection
document.querySelectorAll('.language-option').forEach(option => {
  option.addEventListener('click', function() {
    document.querySelectorAll('.language-option').forEach(opt => opt.classList.remove('active'));
    this.classList.add('active');
    
    // Update button text
    const languageText = this.textContent;
    languageBtn.innerHTML = `<i class="bi bi-globe"></i> ${languageText} <i class="bi bi-chevron-up"></i>`;
    
    // Close dropdown
    languageDropdown.classList.remove('active');
  });
});
  </script>
</body>
</html>

