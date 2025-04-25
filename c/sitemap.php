<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albatross Tours</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #0047AB;
            --light-gray: #f8f9fa;
            --dark-blue: #003366;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue);
        }
        
        .nav-link {
            font-weight: 500;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-blue);
            color: white;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }
        
        .hero-section {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            margin: 20px;
            height: 400px;
        }
        
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4));
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: white;
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .section-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .section-subtitle {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        
        .attraction-card {
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .attraction-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .attraction-info {
            padding: 15px;
        }
        
        .attraction-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .attraction-description {
            font-size: 0.9rem;
            color: #666;
        }
        
        .tour-card {
            border-radius: 16px;
            background-color: var(--light-gray);
            padding: 20px;
            text-align: center;
            height: 100%;
        }
        
        .tour-icon {
            width: 60px;
            height: 60px;
            background-color: #e9ecef;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .blue-section {
            background-color: var(--primary-blue);
            color: white;
            border-radius: 16px;
            padding: 20px;
            margin: 40px 20px;
        }
        
        .blue-section .thumbnail {
            width: 100%;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .green-section {
            background-color: #00C853;
            color: white;
            border-radius: 16px;
            padding: 40px 20px;
            margin: 40px 0;
        }
        
        .feature-card {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .blog-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            height: 300px;
            margin-bottom: 20px;
        }
        
        .blog-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .blog-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
        }
        
        .blog-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .small-blog-card {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }
        
        .small-blog-image {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .small-blog-title {
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .insight-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            height: 200px;
        }
        
        .insight-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .insight-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            color: white;
        }
        
        .insight-title {
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .insight-subtitle {
            font-size: 0.8rem;
        }
        
        footer {
            background-color: var(--light-gray);
            padding: 40px 0;
            margin-top: 40px;
        }
        
        .section-container {
            padding: 40px 20px;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                height: 300px;
            }
            
            .hero-title {
                font-size: 1.8rem;
            }
            
            .section-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand" href="#">@Albatross</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
/Novemberli>
                        <a class="nav-link" href="#">Tours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="#" class="btn btn-outline-primary me-2">Get inspired</a>
                    <a href="#" class="btn btn-primary">Explore</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container">
        <div class="hero-section">
            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="hero-image">
            <div class="hero-overlay">
                <h1 class="hero-title">This is a super nice<br>powerful header</h1>
                <p class="mb-4">Explore Tours, Discover, Travel</p>
                <a href="#" class="btn btn-light px-4">See More</a>
            </div>
        </div>
    </div>

    <!-- Must-see Attractions Section -->
    <div class="section-container bg-light">
        <div class="container">
            <p class="section-title text-muted">Things to do</p>
            <h2 class="section-subtitle">Must-see attractions</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                            <p class="attraction-description">The panoramic view of the ancient fortified city of Skanderbeg on a mountainside. Write a large part of the story of the...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                            <p class="attraction-description">The panoramic view of the ancient fortified city of Skanderbeg on a mountainside. Write a large part of the story of the...</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                            <p class="attraction-description">The panoramic view of the ancient fortified city of Skanderbeg on a mountainside. Write a large part of the story of the...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-secondary px-4">See More</a>
            </div>
        </div>
    </div>

    <!-- Daily Tours Section -->
    <div class="section-container">
        <div class="container">
            <p class="section-title text-muted">See More</p>
            <h2 class="section-subtitle">What are you for?</h2>
            <div class="row g-4">
                <div class="col-md-15 col-6">
                    <div class="tour-card">
                        <div class="tour-icon">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <h5>Daily Tours</h5>
                        <a href="#" class="text-decoration-none">See Tours</a>
                    </div>
                </div>
                <div class="col-md-15 col-6">
                    <div class="tour-card">
                        <div class="tour-icon">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <h5>Daily Tours</h5>
                        <a href="#" class="text-decoration-none">See Tours</a>
                    </div>
                </div>
                <div class="col-md-15 col-6">
                    <div class="tour-card">
                        <div class="tour-icon">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <h5>Daily Tours</h5>
                        <a href="#" class="text-decoration-none">See Tours</a>
                    </div>
                </div>
                <div class="col-md-15 col-6">
                    <div class="tour-card">
                        <div class="tour-icon">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <h5>Daily Tours</h5>
                        <a href="#" class="text-decoration-none">See Tours</a>
                    </div>
                </div>
                <div class="col-md-15 col-6">
                    <div class="tour-card">
                        <div class="tour-icon">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <h5>Daily Tours</h5>
                        <a href="#" class="text-decoration-none">See Tours</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- More Attractions Section -->
    <div class="section-container bg-light">
        <div class="container">
            <p class="section-title text-muted">See More</p>
            <h2 class="section-subtitle">What are you for?</h2>
            <div class="row">
                <div class="col-md-3 col-6 mb-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="attraction-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="attraction-image">
                        <div class="attraction-info">
                            <p class="text-muted mb-1">Albania</p>
                            <h5 class="attraction-title">Kruja Castle</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue Section -->
    <div class="blue-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-3">Check these properties</h4>
                    <h3 class="mb-4">Only in this site</h3>
                    <div class="row">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="thumbnail mb-2">
                            <p class="small text-center">Albania</p>
                        </div>
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="thumbnail mb-2">
                            <p class="small text-center">Albania</p>
                        </div>
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="thumbnail mb-2">
                            <p class="small text-center">Albania</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <a href="#" class="btn btn-light px-4">See More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Insights Section -->
    <div class="section-container">
        <div class="container">
            <p class="section-title text-muted">Expertise</p>
            <h2 class="section-subtitle">Latest insights</h2>
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="insight-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="insight-image">
                        <div class="insight-overlay">
                            <p class="insight-title">@username</p>
                            <p class="insight-subtitle">Trip to Albania</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="insight-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="insight-image">
                        <div class="insight-overlay">
                            <p class="insight-title">@username</p>
                            <p class="insight-subtitle">Trip to Albania</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="insight-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="insight-image">
                        <div class="insight-overlay">
                            <p class="insight-title">@username</p>
                            <p class="insight-subtitle">Trip to Albania</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="insight-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="insight-image">
                        <div class="insight-overlay">
                            <p class="insight-title">@username</p>
                            <p class="insight-subtitle">Trip to Albania</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Green About Us Section -->
    <div class="green-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-2">Check these properties</h4>
                    <h3 class="mb-4">About Us</h3>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-check"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Feature</h5>
                            <p class="mb-0 small">The panoramic view of the ancient fortified city of Skanderbeg on a mountainside.</p>
                        </div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-check"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Feature</h5>
                            <p class="mb-0 small">The panoramic view of the ancient fortified city of Skanderbeg on a mountainside.</p>
                        </div>
                    </div>
                    
                    <a href="#" class="btn btn-light px-4 mt-4">See More</a>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="img-fluid rounded-4">
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Section -->
    <div class="section-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-card">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="blog-image">
                        <div class="blog-overlay">
                            <h4 class="blog-title">How to sell better blogs to people and boost site</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3">
                        <h4 class="mb-4">Check these properties</h4>
                        
                        <div class="small-blog-card">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="small-blog-image">
                            <div>
                                <h5 class="small-blog-title">How to sell better blogs to people and boost site</h5>
                            </div>
                        </div>
                        
                        <div class="small-blog-card">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="small-blog-image">
                            <div>
                                <h5 class="small-blog-title">How to sell better blogs to people and boost site</h5>
                            </div>
                        </div>
                        
                        <div class="small-blog-card">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Mountain landscape" class="small-blog-image">
                            <div>
                                <h5 class="small-blog-title">How to sell better blogs to people and boost site</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3">@Albatross</h5>
                    <p class="text-muted">Explore the world with our guided tours and discover breathtaking destinations.</p>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-decoration-none me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-decoration-none me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-decoration-none"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Home</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Tours</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Destinations</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">About Us</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3">Popular Tours</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Albania Highlights</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Mountain Expeditions</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Cultural Tours</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Adventure Packages</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Family Vacations</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> 123 Tour Street, Albania</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> +1 (234) 567-8900</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@albatross.com</li>
                        <li><i class="bi bi-clock me-2"></i> Mon-Fri: 9AM - 5PM</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted">© 2023 Albatross Tours. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-decoration-none text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-decoration-none text-muted me-3">Terms of Service</a>
                    <a href="#" class="text-decoration-none text-muted">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Dropdown Menu JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
            
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>
</html>