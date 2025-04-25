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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6366F1;
            --light-gray: #f5f5f5;
            --border-color: #e0e0e0;
            --text-dark: #333333;
            --text-light: #666666;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        
        .breadcrumb {
            padding: 15px 0;
            margin-bottom: 0;
            font-size: 10px;
        }
        
        .breadcrumb-item a {
            color: var(--text-light);
            text-decoration: none;
        }
        
        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .product-main {
            display: flex;
            flex-direction: column;
        }
        
        .product-gallery {
            position: relative;
            margin-bottom: 20px;
        }
        
        .product-thumbnails {
            display: none;
        }
        
        .main-image-container {
            position: relative;
            background-color: var(--light-gray);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .main-image {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .like-counter {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: white;
            border-radius: 20px;
            padding: 5px 15px;
            display: flex;
            align-items: center;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .like-counter .heart {
            margin-left: 8px;
            color: #333;
            cursor: pointer;
        }
        
        .like-counter .heart.active {
            color: red;
        }
        
        .product-info {
            padding: 0;
        }
        
        .product-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .product-category {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .product-price {
            font-size: 22px;
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
            gap: 15px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .meta-item {
            color: var(--text-light);
        }
        
        .meta-item span {
            color: var(--text-dark);
            font-weight: 500;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .seller-profile {
            display: flex;
            align-items: center;
        }
        
        .seller-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .seller-name {
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .seller-listings {
            color: var(--text-light);
            font-size: 12px;
        }
        
        .seller-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-contact {
            background-color: white;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            border-radius: 20px;
            padding: 6px 15px;
            font-size: 14px;
        }
        
        .btn-follow {
            background-color: var(--primary-color);
            border: none;
            color: white;
            border-radius: 20px;
            padding: 6px 15px;
            font-size: 14px;
        }
        
        .action-buttons {
            margin-bottom: 20px;
        }
        
        .btn-offer {
            background-color: var(--primary-color);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .btn-wishlist {
            background-color: white;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-wishlist i {
            margin-right: 8px;
        }
        
        .high-demand {
            background-color: white;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .high-demand i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .high-demand-text {
            font-size: 14px;
            color: var(--text-light);
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .section-subtitle {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }
        
        .shipping-info {
            margin-bottom: 30px;
        }
        
        .shipper-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .shipper-profile {
            display: flex;
            align-items: center;
        }
        
        .shipper-avatar {
            width: 30px;
            height: 30px;
            background-color: var(--light-gray);
            border-radius: 4px;
            margin-right: 10px;
        }
        
        .shipper-location {
            display: flex;
            align-items: center;
            color: var(--text-light);
            font-size: 14px;
        }
        
        .shipper-location i {
            margin-right: 5px;
        }
        
        .shipper-price {
            font-weight: 500;
        }
        
        .explore-section {
            margin-bottom: 30px;
        }
        
        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .tag {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 14px;
            color: var(--text-dark);
            text-decoration: none;
        }
        
        .related-products {
            margin-bottom: 30px;
        }
        
        /* Updated product grid for mobile horizontal scroll */
        .product-grid {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding-bottom: 15px;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        .product-grid::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        .product-card {
            flex: 0 0 150px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .product-card-img {
            width: 100%;
            height: auto;
            background-color: var(--light-gray);
        }
        
        .product-card-info {
            padding: 10px 0;
        }
        
        .product-card-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .product-card-price {
            font-size: 14px;
            font-weight: 600;
        }
        
        .tabs-section {
            margin-bottom: 30px;
        }
        
        .nav-tabs {
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }
        
        .nav-tabs .nav-link {
            color: var(--text-light);
            border: none;
            padding: 10px 0;
            margin-right: 20px;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        .tab-content {
            font-size: 14px;
            line-height: 1.6;
        }
        
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
        
        /* Updated action links (Report, Share) */
        .action-link {
            color: var(--text-dark);
            text-decoration: underline;
            background: none;
            border: none;
            padding: 0;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            margin-left: 15px;
        }
        
        .action-link i {
            margin-left: 5px;
            text-decoration: none;
        }
        
        /* Desktop styles */
        @media (min-width: 992px) {
            .product-main {
                flex-direction: row;
                gap: 30px;
                margin-bottom: 40px;
            }
            
            .product-gallery {
                flex: 0 0 60%;
                display: flex;
                gap: 15px;
            }
            
            .product-thumbnails {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 80px;
            }
            
            .thumbnail {
                width: 80px;
                height: 80px;
                border-radius: 4px;
                cursor: pointer;
                background-color: var(--light-gray);
                overflow: hidden;
            }
            
            .thumbnail img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .thumbnail.active {
                border: 2px solid var(--primary-color);
            }
            
            .main-image-container {
                flex: 1;
            }
            
            .product-info {
                flex: 0 0 40%;
                padding-left: 20px;
            }
            
            .product-title {
                font-size: 24px;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }
            
            /* New desktop layout for sections */
            .content-layout {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 30px;
                margin-bottom: 40px;
            }
            
            .left-column {
                grid-column: 1 / 2;
            }
            
            .right-column {
                grid-column: 2 / 3;
            }
            
            /* Reset product grid for desktop */
            .product-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                overflow-x: visible;
                gap: 15px;
            }
            
            .product-card {
                flex: none;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="product-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Elektronika</a></li>
                <li class="breadcrumb-item active" aria-current="page">MacBook Pro 16</li>
            </ol>
        </nav>
        
        <div class="product-main">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <!-- Thumbnails for desktop -->
                <div class="product-thumbnails">
                    <div class="thumbnail active">
                        <img src="/placeholder.svg?height=80&width=80" alt="MacBook Pro thumbnail 1">
                    </div>
                    <div class="thumbnail">
                        <img src="/placeholder.svg?height=80&width=80" alt="MacBook Pro thumbnail 2">
                    </div>
                    <div class="thumbnail">
                        <img src="/placeholder.svg?height=80&width=80" alt="MacBook Pro thumbnail 3">
                    </div>
                </div>
                
                <!-- Main Image / Carousel -->
                <div class="main-image-container">
                    <!-- Bootstrap Carousel for Mobile -->
                    <div id="productCarousel" class="carousel slide d-lg-none" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/placeholder.svg?height=500&width=700" class="d-block w-100" alt="MacBook Pro">
                            </div>
                            <div class="carousel-item">
                                <img src="/placeholder.svg?height=500&width=700" class="d-block w-100" alt="MacBook Pro">
                            </div>
                            <div class="carousel-item">
                                <img src="/placeholder.svg?height=500&width=700" class="d-block w-100" alt="MacBook Pro">
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
                    </div>
                    
                    <!-- Static Image for Desktop -->
                    <img src="/placeholder.svg?height=500&width=700" class="main-image d-none d-lg-block" alt="MacBook Pro">
                    
                    <!-- Like Counter -->
                    <div class="like-counter">
                        <span class="count">000</span>
                        <i class="fa-regular fa-heart heart"></i>
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-info">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1 class="product-title">MacBook Pro 16' ne shitje</h1>
                    <div class="d-none d-lg-flex">
                        <button class="action-link">
                            Report <i class="fa-regular fa-flag"></i>
                        </button>
                        <button class="action-link">
                            Share <i class="fa-solid fa-share"></i>
                        </button>
                    </div>
                </div>
                
                <p class="product-category">Elektronika</p>
                
                <h2 class="product-price">EUR 688</h2>
                <p class="price-note">Cmimi i diskutueshem</p>
                
                <div class="product-meta">
                    <div class="meta-item">Condition: <span>Used</span></div>
                    <div class="meta-item">Location: <span>Tirana, Albania</span></div>
                    <div class="meta-item">Published: <span>2 Days Ago</span></div>
                </div>
                
                <div class="seller-info">
                    <div class="seller-profile">
                        <img src="/placeholder.svg?height=40&width=40" alt="Seller" class="seller-avatar">
                        <div>
                            <p class="seller-name">Username</p>
                            <p class="seller-listings">6 Listings</p>
                        </div>
                    </div>
                    <div class="seller-actions">
                        <button class="btn-contact">Contact</button>
                        <button class="btn-follow">Follow</button>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <button class="btn-offer">Make an offer</button>
                    <button class="btn-wishlist">
                        <i class="fa-regular fa-heart"></i> Add to wishlist
                    </button>
                    <div class="high-demand">
                        <i class="fa-solid fa-chart-line"></i>
                        <div>
                            <div>Kerkese e larte</div>
                            <div class="high-demand-text">Produkti eshte shikuar mbi 100 here.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Layout -->
        <div class="d-lg-none">
            <!-- Shipping Info -->
            <div class="shipping-info">
                <h3 class="section-title">Dergesa</h3>
                <p class="section-subtitle">Zgjidh posten qe ofrohet nga ky shites dhe bej porosi. Meso si funksionon</p>
                
                <div class="shipper-item">
                    <div class="shipper-profile">
                        <div class="shipper-avatar"></div>
                        <div>
                            <div>Shipper Name</div>
                            <div class="shipper-location">
                                <i class="fa-solid fa-location-dot"></i> Dergesa ne Elbasan
                            </div>
                        </div>
                    </div>
                    <div class="shipper-price">EUR 3.00</div>
                </div>
                
                <div class="shipper-item">
                    <div class="shipper-profile">
                        <div class="shipper-avatar"></div>
                        <div>
                            <div>Shipper Name</div>
                            <div class="shipper-location">
                                <i class="fa-solid fa-location-dot"></i> Dergesa ne Elbasan
                            </div>
                        </div>
                    </div>
                    <div class="shipper-price">EUR 3.00</div>
                </div>
                
                <div class="shipper-item">
                    <div class="shipper-profile">
                        <div class="shipper-avatar"></div>
                        <div>
                            <div>Shipper Name</div>
                            <div class="shipper-location">
                                <i class="fa-solid fa-location-dot"></i> Dergesa ne Elbasan
                            </div>
                        </div>
                    </div>
                    <div class="shipper-price">EUR 3.00</div>
                </div>
            </div>
            
            <!-- Explore Section -->
            <div class="explore-section">
                <h3 class="section-title">Eksploro</h3>
                <p class="section-subtitle">Zgjidh fjalen kyce dhe shiko shites dhe produkte.</p>
                
                <div class="tag-container">
                    <a href="#" class="tag">Laptop Apple</a>
                    <a href="#" class="tag">Laptop Apple</a>
                    <a href="#" class="tag">Laptop Apple</a>
                    <a href="#" class="tag">Laptop Apple</a>
                    <a href="#" class="tag">Laptop Apple</a>
                </div>
            </div>
            
            <!-- Related Products - Horizontal Scroll for Mobile -->
            <div class="related-products">
                <h3 class="section-title">Shiko dhe keto</h3>
                <p class="section-subtitle">Produkte te ngjashme qe mund tju pelqejne</p>
                
                <div class="product-grid">
                    <div class="product-card">
                        <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                        <div class="product-card-info">
                            <div class="product-card-title">Laptop Apple</div>
                            <div class="product-card-price">EUR 80</div>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                        <div class="product-card-info">
                            <div class="product-card-title">Laptop Apple</div>
                            <div class="product-card-price">EUR 80</div>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                        <div class="product-card-info">
                            <div class="product-card-title">Laptop Apple</div>
                            <div class="product-card-price">EUR 80</div>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                        <div class="product-card-info">
                            <div class="product-card-title">Laptop Apple</div>
                            <div class="product-card-price">EUR 80</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Description and Specifications Tabs -->
            <div class="tabs-section">
                <ul class="nav nav-tabs" id="productTabsMobile" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab-mobile" data-bs-toggle="tab" data-bs-target="#description-mobile" type="button" role="tab" aria-controls="description-mobile" aria-selected="true">Pershkrimi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab-mobile" data-bs-toggle="tab" data-bs-target="#specs-mobile" type="button" role="tab" aria-controls="specs-mobile" aria-selected="false">Specifikat</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="productTabsContentMobile">
                    <div class="tab-pane fade show active" id="description-mobile" role="tabpanel" aria-labelledby="description-tab-mobile">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="tab-pane fade" id="specs-mobile" role="tabpanel" aria-labelledby="specs-tab-mobile">
                        <table class="specs-table">
                            <tr>
                                <th>Model</th>
                                <td>MacBook Pro 16-inch</td>
                            </tr>
                            <tr>
                                <th>Processor</th>
                                <td>Intel Core i7/i9</td>
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
                                <td>16-inch Retina Display</td>
                            </tr>
                            <tr>
                                <th>Graphics</th>
                                <td>AMD Radeon Pro 5300M</td>
                            </tr>
                            <tr>
                                <th>Condition</th>
                                <td>Used</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Desktop Layout with 2 columns -->
        <div class="d-none d-lg-block">
            <div class="content-layout">
                <!-- Left Column: Explore and Related Products -->
                <div class="left-column">
                    <!-- Explore Section -->
                    <div class="explore-section">
                        <h3 class="section-title">Eksploro</h3>
                        <p class="section-subtitle">Zgjidh fjalen kyce dhe shiko shites dhe produkte.</p>
                        
                        <div class="tag-container">
                            <a href="#" class="tag">Laptop Apple</a>
                            <a href="#" class="tag">Laptop Apple</a>
                            <a href="#" class="tag">Laptop Apple</a>
                            <a href="#" class="tag">Laptop Apple</a>
                            <a href="#" class="tag">Laptop Apple</a>
                        </div>
                    </div>
                    
                    <!-- Related Products -->
                    <div class="related-products">
                        <h3 class="section-title">Shiko dhe keto</h3>
                        <p class="section-subtitle">Produkte te ngjashme qe mund tju pelqejne</p>
                        
                        <div class="product-grid">
                            <div class="product-card">
                                <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                                <div class="product-card-info">
                                    <div class="product-card-title">Laptop Apple</div>
                                    <div class="product-card-price">EUR 80</div>
                                </div>
                            </div>
                            
                            <div class="product-card">
                                <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                                <div class="product-card-info">
                                    <div class="product-card-title">Laptop Apple</div>
                                    <div class="product-card-price">EUR 80</div>
                                </div>
                            </div>
                            
                            <div class="product-card">
                                <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                                <div class="product-card-info">
                                    <div class="product-card-title">Laptop Apple</div>
                                    <div class="product-card-price">EUR 80</div>
                                </div>
                            </div>
                            
                            <div class="product-card">
                                <img src="/placeholder.svg?height=150&width=150" alt="Related Product" class="product-card-img">
                                <div class="product-card-info">
                                    <div class="product-card-title">Laptop Apple</div>
                                    <div class="product-card-price">EUR 80</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Shipping Info -->
                <div class="right-column">
                    <div class="shipping-info">
                        <h3 class="section-title">Dergesa</h3>
                        <p class="section-subtitle">Zgjidh posten qe ofrohet nga ky shites dhe bej porosi. Meso si funksionon</p>
                        
                        <div class="shipper-item">
                            <div class="shipper-profile">
                                <div class="shipper-avatar"></div>
                                <div>
                                    <div>Shipper Name</div>
                                    <div class="shipper-location">
                                        <i class="fa-solid fa-location-dot"></i> Dergesa ne Elbasan
                                    </div>
                                </div>
                            </div>
                            <div class="shipper-price">EUR 3.00</div>
                        </div>
                        
                        <div class="shipper-item">
                            <div class="shipper-profile">
                                <div class="shipper-avatar"></div>
                                <div>
                                    <div>Shipper Name</div>
                                    <div class="shipper-location">
                                        <i class="fa-solid fa-location-dot"></i> Dergesa ne Elbasan
                                    </div>
                                </div>
                            </div>
                            <div class="shipper-price">EUR 3.00</div>
                        </div>
                        
                        <div class="shipper-item">
                            <div class="shipper-profile">
                                <div class="shipper-avatar"></div>
                                <div>
                                    <div>Shipper Name</div>
                                    <div class="shipper-location">
                                        <i class="fa-solid fa-location-dot"></i> Dergesa ne Elbasan
                                    </div>
                                </div>
                            </div>
                            <div class="shipper-price">EUR 3.00</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Full-width Description and Specifications Tabs -->
            <div class="tabs-section">
                <ul class="nav nav-tabs" id="productTabsDesktop" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab-desktop" data-bs-toggle="tab" data-bs-target="#description-desktop" type="button" role="tab" aria-controls="description-desktop" aria-selected="true">Pershkrimi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab-desktop" data-bs-toggle="tab" data-bs-target="#specs-desktop" type="button" role="tab" aria-controls="specs-desktop" aria-selected="false">Specifikat</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="productTabsContentDesktop">
                    <div class="tab-pane fade show active" id="description-desktop" role="tabpanel" aria-labelledby="description-tab-desktop">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="tab-pane fade" id="specs-desktop" role="tabpanel" aria-labelledby="specs-tab-desktop">
                        <table class="specs-table">
                            <tr>
                                <th>Model</th>
                                <td>MacBook Pro 16-inch</td>
                            </tr>
                            <tr>
                                <th>Processor</th>
                                <td>Intel Core i7/i9</td>
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
                                <td>16-inch Retina Display</td>
                            </tr>
                            <tr>
                                <th>Graphics</th>
                                <td>AMD Radeon Pro 5300M</td>
                            </tr>
                            <tr>
                                <th>Condition</th>
                                <td>Used</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thumbnail functionality
            const thumbnails = document.querySelectorAll('.thumbnail');
            const mainImage = document.querySelector('.main-image');
            
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(t => t.classList.remove('active'));
                    
                    // Add active class to clicked thumbnail
                    this.classList.add('active');
                    
                    // Update main image source
                    const imgSrc = this.querySelector('img').src;
                    mainImage.src = imgSrc;
                });
            });
            
            // Like functionality
            const heartIcon = document.querySelector('.heart');
            const likeCount = document.querySelector('.count');
            let count = 0;
            
            heartIcon.addEventListener('click', function() {
                this.classList.toggle('fa-regular');
                this.classList.toggle('fa-solid');
                this.classList.toggle('active');
                
                if (this.classList.contains('active')) {
                    count++;
                } else {
                    count--;
                }
                
                // Format count with leading zeros
                likeCount.textContent = String(count).padStart(3, '0');
            });
            
            // Initialize Bootstrap tabs for mobile
            const triggerTabListMobile = document.querySelectorAll('#productTabsMobile button');
            triggerTabListMobile.forEach(triggerEl => {
                const tabTrigger = new bootstrap.Tab(triggerEl);
                
                triggerEl.addEventListener('click', event => {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });
            
            // Initialize Bootstrap tabs for desktop
            const triggerTabListDesktop = document.querySelectorAll('#productTabsDesktop button');
            triggerTabListDesktop.forEach(triggerEl => {
                const tabTrigger = new bootstrap.Tab(triggerEl);
                
                triggerEl.addEventListener('click', event => {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>