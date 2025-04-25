<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MacBook Pro 16" | Marketplace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #6366F1;
            --primary-hover: #4F46E5;
            --light-gray:rgb(255, 255, 255);
            --border-color: #e0e0e0;
            --text-dark: #333333;
            --text-light: #666666;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
            line-height: 1.5;
        }
        
        .container {
            max-width: 1200px;
            padding: 0 15px;
            margin: 0 auto;
        }
        
        /* Breadcrumb */
        .breadcrumb-container {
            padding: 15px 0;
            margin-bottom: 10px;
        }
        
        .breadcrumb {
            margin-bottom: 0;
            font-size: 12px;
        }
        
        .breadcrumb-item a {
            color: var(--text-light);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: var(--primary-color);
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            color: var(--text-light);
        }
        
        /* Product Gallery */
        .product-gallery {
            position: relative;
            margin-bottom: 20px;
        }
        
        .main-image-container {
            position: relative;
            background-color: var(--light-gray);
            border-radius: var(--radius-sm);
            overflow: hidden;
            aspect-ratio: 4/3;
        }
        
        .carousel-item {
            height: 100%;
        }
        
        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
        }
        
        .carousel-control-prev {
            left: 10px;
        }
        
        .carousel-control-next {
            right: 10px;
        }
        
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
            background-size: 100%;
            filter: invert(1) grayscale(100);
        }
        
        .like-counter {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background-color: white;
            border-radius: 20px;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
            z-index: 10;
        }
        
        .heart-icon {
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .heart-icon:hover,
        .heart-icon.active {
            color: #e53935;
        }
        
        .thumbnails-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
        }
        
        .thumbnail {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }
        
        .thumbnail:hover {
            border-color: var(--primary-color);
        }
        
        .thumbnail.active {
            border-color: var(--primary-color);
        }
        
        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Product Info */
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .product-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        
        .product-category {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .action-links {
            display: flex;
            gap: 15px;
        }
        
        .action-link {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .action-link:hover {
            background-color: var(--light-gray);
            color: var(--text-dark);
        }
        
        .product-price {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .price-note {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        
        .meta-label {
            font-size: 13px;
            color: var(--text-light);
        }
        
        .meta-value {
            font-weight: 500;
            font-size: 14px;
        }
        
        /* Seller Info */
        .seller-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            background-color: white;
        }
        
        .seller-profile {
            display: flex;
            align-items: center;
        }
        
        .seller-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 12px;
        }
        
        .seller-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .seller-details {
            display: flex;
            flex-direction: column;
        }
        
        .seller-name {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 2px;
        }
        
        .seller-listings {
            font-size: 13px;
            color: var(--text-light);
        }
        
        .seller-actions {
            display: flex;
            gap: 10px;
        }
        
        /* Buttons */
        .btn {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 20px;
        }
        
        .btn-md {
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 8px;
        }
        
        .btn-lg {
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .btn-outline {
            background-color: white;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
        }
        
        .btn-outline:hover {
            background-color: var(--light-gray);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        /* Action Buttons */
        .action-buttons {
            margin-bottom: 20px;
        }
        
        /* Ask Question */
        .ask-question {
            padding: 15px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
            background-color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .question-icon {
            font-size: 20px;
            color: var(--text-light);
        }
        
        .question-content {
            flex: 1;
        }
        
        .question-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .question-subtitle {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 0;
        }
        
        /* Shipping Options */
        .shipping-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .section-subtitle {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }
        
        .shipping-option {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 10px;
            background-color: white;
        }
        
        .shipper-avatar {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background-color: var(--light-gray);
            margin-right: 12px;
            overflow: hidden;
        }
        
        .shipper-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .shipping-details {
            flex: 1;
        }
        
        .shipper-name {
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 2px;
        }
        
        .shipping-location {
            font-size: 13px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .shipping-price {
            font-weight: 600;
            font-size: 14px;
        }
        
        /* Tabs */
        .product-tabs {
            margin-bottom: 30px;
        }
        
        .nav-tabs {
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--text-light);
            font-weight: 500;
            padding: 10px 0;
            margin-right: 20px;
            font-size: 15px;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: var(--primary-color);
        }
        
        .nav-tabs .nav-link.active {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background-color: transparent;
        }
        
        .tab-content {
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Explore Section */
        .explore-section {
            margin-bottom: 30px;
        }
        
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .tag {
            display: inline-block;
            padding: 8px 16px;
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 14px;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .tag:hover {
            background-color: var(--light-gray);
            border-color: var(--text-light);
            color: var(--text-dark);
        }
        
        /* Similar Products */
        .similar-products {
            margin-bottom: 30px;
        }
        
        .product-scroll {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding-bottom: 15px;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        .product-scroll::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        .product-card {
            flex: 0 0 150px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            background-color: white;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }
        
        .product-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .product-card-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
        }
        
        .product-card-body {
            padding: 10px;
        }
        
        .product-card-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .product-card-price {
            font-size: 14px;
            font-weight: 600;
        }
        
        /* Specs Table */
        .specs-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .specs-table tr {
            border-bottom: 1px solid var(--border-color);
        }
        
        .specs-table th, .specs-table td {
            padding: 10px;
            text-align: left;
        }
        
        .specs-table th {
            font-weight: 500;
            width: 40%;
        }
        
        /* Desktop Styles */
        @media (min-width: 992px) {
            .product-main {
                display: flex;
                gap: 30px;
                margin-bottom: 40px;
            }
            
            .product-gallery {
                flex: 0 0 60%;
                display: flex;
                gap: 15px;
            }
            
            .thumbnails-container {
                flex-direction: column;
                margin-top: 0;
                margin-right: 15px;
                justify-content: flex-start;
            }
            
            .main-image-container {
                flex: 1;
            }
            
            .product-info {
                flex: 0 0 40%;
            }
            
            .product-title {
                font-size: 24px;
            }
            
            .product-price {
                font-size: 28px;
            }
            
            .product-card {
                flex: 0 0 180px;
            }
            
            .desktop-layout {
                display: flex;
                gap: 30px;
            }
            
            .left-column {
                flex: 0 0 60%;
            }
            
            .right-column {
                flex: 0 0 40%;
            }
            
            .product-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
            }
            
            .product-card {
                flex: none;
            }
        }
        
        @media (max-width: 991px) {
            .desktop-thumbnails {
                display: none;
            }
        }
        
        @media (min-width: 992px) {
            .mobile-thumbnails {
                display: none;
            }
            
            .desktop-thumbnails {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Elektronika</a></li>
                    <li class="breadcrumb-item active" aria-current="page">MacBook Pro 16</li>
                </ol>
            </nav>
        </div>

        <!-- Product Main Section -->
        <div class="product-main">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <!-- Desktop Thumbnails -->
                <div class="thumbnails-container desktop-thumbnails">
                    <div class="thumbnail active" data-bs-target="#productCarousel" data-bs-slide-to="0">
                        <img src="../listings/listing_1_1742337998_0.jpeg" alt="MacBook Pro 16 thumbnail 1">
                    </div>
                    <div class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="1">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" alt="MacBook Pro 16 thumbnail 2">
                    </div>
                    <div class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="2">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" alt="MacBook Pro 16 thumbnail 3">
                    </div>
                </div>

                <!-- Main Image Carousel -->
                <div class="main-image-container">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="d-block" alt="MacBook Pro 16">
                            </div>
                            <div class="carousel-item">
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="d-block" alt="MacBook Pro 16">
                            </div>
                            <div class="carousel-item">
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="d-block" alt="MacBook Pro 16">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="like-counter">
                            <span>000</span>
                            <i class="bi bi-heart heart-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <div class="product-header">
                    <div>
                        <h1 class="product-title">MacBook Pro 16' ne shitje</h1>
                        <p class="product-category">Elektronika</p>
                    </div>
                    <div class="action-links">
                        <button class="action-link" id="reportBtn">
                            <i class="bi bi-flag"></i> Report
                        </button>
                        <button class="action-link" id="shareBtn">
                            <i class="bi bi-share"></i> Share
                        </button>
                    </div>
                </div>
                
                <h2 class="product-title">EUR 688</h2>
                <p class="price-note">Çmimi i diskutueshëm</p>
                
                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Condition:</span>
                        <span class="meta-value">Used</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Location:</span>
                        <span class="meta-value">Tirana, Albania</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Published:</span>
                        <span class="meta-value">2 Days Ago</span>
                    </div>
                </div>
                
                <!-- Seller Info -->
                <div class="seller-info">
                    <div class="seller-profile">
                        <div class="seller-avatar">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Seller Avatar">
                        </div>
                        <div class="seller-details">
                            <h3 class="seller-name">Username</h3>
                            <p class="seller-listings">6 Listings</p>
                        </div>
                    </div>
                    <div class="seller-actions">
                        <button class="btn btn-outline btn-sm">Contact</button>
                        <button class="btn btn-primary btn-sm">Follow</button>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn btn-primary btn-lg btn-block mb-3">Make an offer</button>
                    <button class="btn btn-outline btn-lg btn-block btn-icon mb-3">
                        <i class="bi bi-heart"></i> Add to wishlist
                    </button>
                </div>
                
                <!-- Ask Question -->
                <div class="ask-question">
                    <div class="question-icon">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                    <div class="question-content">
                        <div class="question-title">Kerkese e larte</div>
                        <p class="question-subtitle">Produkti eshte shikuar mbi 100 here.</p>
                    </div>
                </div>
                
                <!-- Shipping Options -->
                <div class="shipping-section">
                    <h2 class="section-title">Dergesa</h2>
                    <p class="section-subtitle">Zgjidh posten qe dfrrohet nga ky shites dhe bej porosine. Meso si funksionon</p>
                    
                    <div class="shipping-option">
                        <div class="shipper-avatar">
                            <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="Shipper Avatar">
                        </div>
                        <div class="shipping-details">
                            <h3 class="shipper-name">Shipper Name</h3>
                            <p class="shipping-location">
                                <i class="bi bi-geo-alt"></i> Dergesa ne Elbasan
                            </p>
                        </div>
                        <div class="shipping-price">EUR 3.00</div>
                    </div>
                    
                    <div class="shipping-option">
                        <div class="shipper-avatar">
                            <img src="https://randomuser.me/api/portraits/men/42.jpg" alt="Shipper Avatar">
                        </div>
                        <div class="shipping-details">
                            <h3 class="shipper-name">Shipper Name</h3>
                            <p class="shipping-location">
                                <i class="bi bi-geo-alt"></i> Dergesa ne Elbasan
                            </p>
                        </div>
                        <div class="shipping-price">EUR 3.00</div>
                    </div>
                    
                    <div class="shipping-option">
                        <div class="shipper-avatar">
                            <img src="https://randomuser.me/api/portraits/men/43.jpg" alt="Shipper Avatar">
                        </div>
                        <div class="shipping-details">
                            <h3 class="shipper-name">Shipper Name</h3>
                            <p class="shipping-location">
                                <i class="bi bi-geo-alt"></i> Dergesa ne Elbasan
                            </p>
                        </div>
                        <div class="shipping-price">EUR 3.00</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Thumbnails -->
        <div class="thumbnails-container mobile-thumbnails">
            <div class="thumbnail active" data-bs-target="#productCarousel" data-bs-slide-to="0">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" alt="MacBook Pro 16 thumbnail 1">
            </div>
            <div class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="1">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" alt="MacBook Pro 16 thumbnail 2">
            </div>
            <div class="thumbnail" data-bs-target="#productCarousel" data-bs-slide-to="2">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" alt="MacBook Pro 16 thumbnail 3">
            </div>
        </div>

        <!-- Desktop Layout for Explore and Similar Products -->
        <div class="desktop-layout">
            <div class="left-column">
                <!-- Explore Section -->
                <div class="explore-section">
                    <h2 class="section-title">Eksploro</h2>
                    <p class="section-subtitle">Zgjidh fjalen kyçe dhe shiko shites dhe produkte.</p>
                    <div class="tags-container">
                        <a href="#" class="tag">Laptop Apple</a>
                        <a href="#" class="tag">Laptop Apple</a>
                        <a href="#" class="tag">Laptop Apple</a>
                        <a href="#" class="tag">Laptop Apple</a>
                        <a href="#" class="tag">Laptop Apple</a>
                    </div>
                </div>

                <!-- Similar Products -->
                <div class="similar-products">
                    <h2 class="section-title">Shiko dhe keto</h2>
                    <p class="section-subtitle">Produkte te ngjashme qe mund tju pelqejne</p>
                    
                    <!-- Mobile Scroll View -->
                    <div class="product-scroll d-block d-lg-none">
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Desktop Grid View -->
                    <div class="product-grid d-none d-lg-grid">
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                        <div class="product-card">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/MacBook%20Pro%2016_%20-%201-8PEvOQVB5b3gtkhXSiqexvc2twka5E.png" class="product-card-img" alt="Laptop Apple">
                            <div class="product-card-body">
                                <h5 class="product-card-title">Laptop Apple</h5>
                                <p class="product-card-price">EUR 80</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="right-column d-none d-lg-block">
                <!-- Right column content for desktop -->
            </div>
        </div>
        
        <!-- Product Tabs (Full Width) -->
        <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Pershkrimi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="false">Specifikikat</button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                    <table class="specs-table">
                        <tr>
                            <th>Processor</th>
                            <td>Apple M1 Pro</td>
                        </tr>
                        <tr>
                            <th>RAM</th>
                            <td>16GB</td>
                        </tr>
                        <tr>
                            <th>Storage</th>
                            <td>512GB SSD</td>
                        </tr>
                        <tr>
                            <th>Display</th>
                            <td>16-inch Retina XDR</td>
                        </tr>
                        <tr>
                            <th>Graphics</th>
                            <td>16-core GPU</td>
                        </tr>
                        <tr>
                            <th>Battery</th>
                            <td>Up to 21 hours</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thumbnail click handler
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    const slideIndex = this.getAttribute('data-bs-slide-to');
                    const carousel = document.getElementById('productCarousel');
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    
                    // Update active thumbnail
                    thumbnails.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Go to slide
                    bsCarousel.to(slideIndex);
                });
            });
            
            // Carousel slide event handler
            const carousel = document.getElementById('productCarousel');
            carousel.addEventListener('slid.bs.carousel', function(event) {
                const slideIndex = event.to;
                
                // Update active thumbnail
                thumbnails.forEach(item => {
                    if (item.getAttribute('data-bs-slide-to') == slideIndex) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            });
            
            // Heart icon click handler
            const heartIcon = document.querySelector('.heart-icon');
            heartIcon.addEventListener('click', function() {
                this.classList.toggle('active');
                
                // Update counter (for demo purposes)
                const counter = this.previousElementSibling;
                if (this.classList.contains('active')) {
                    counter.textContent = '001';
                } else {
                    counter.textContent = '000';
                }
            });
            
            // Share button handler
            const shareBtn = document.getElementById('shareBtn');
            shareBtn.addEventListener('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'MacBook Pro 16" ne shitje',
                        text: 'Check out this MacBook Pro 16" on Marketplace',
                        url: window.location.href
                    })
                    .catch(error => console.log('Error sharing:', error));
                } else {
                    alert('Web Share API not supported in your browser');
                }
            });
            
            // Report button handler
            const reportBtn = document.getElementById('reportBtn');
            reportBtn.addEventListener('click', function() {
                alert('Report functionality would open here');
            });
        });
    </script>
</body>
</html>

