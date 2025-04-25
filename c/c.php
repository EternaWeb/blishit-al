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

// Get user ID if logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch user's watchlist if logged in
if ($user_id) {
    $stmt = $pdo->prepare("SELECT listing_id FROM watchlist WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $watchlist = $stmt->fetchAll(PDO::FETCH_COLUMN);
} else {
    $watchlist = [];
}

// Get category from URL
$category = filter_input(INPUT_GET, 'cat', FILTER_SANITIZE_STRING);
if (!$category) {
    die("No category specified.");
}

// Fetch products for the category
$stmt = $pdo->prepare("
    SELECT l.id, l.title, l.price, li.image_path 
    FROM listings l 
    LEFT JOIN listing_images li ON l.id = li.listing_id 
    WHERE l.status = 'active' AND l.category = ? 
    ORDER BY l.created_at DESC
");
$stmt->execute([$category]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category); ?> - Trevali Marketplace</title>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --ebay-blue: #3665f3;
            --ebay-light-gray: #f8f8f8;
            --ebay-border: #e5e5e5;
            --ebay-red: #e53238;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        .products-section {
            margin-top: 40px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 70px;
        }

        .section-title {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .section-subtitle {
            color: #666;
            font-size: 14px;
            margin: 4px 0 0 0;
        }

        .see-all {
            color: var(--ebay-blue);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .see-all:hover {
            text-decoration: underline;
        }

        .products-container {
            position: relative;
            padding-bottom: 50px;
        }

        .products-wrapper {
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 10px 0;
            padding-left: 50px;
            padding-right: 50px;
        }

        .products-wrapper::-webkit-scrollbar {
            display: none;
        }

        .products-grid {
            display: flex;
            gap: 20px;
            padding: 0 20px;
        }

        .product-card {
            flex: 0 0 auto;
            width: 280px;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .wishlist-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.2s;
        }

        .wishlist-button:hover {
            background-color: #f5f5f5;
        }

        .wishlist-button i {
            font-size: 16px;
            color: inherit;
            transition: color 0.3s;
        }

        .wishlist-button.liked i {
            color: var(--ebay-red);
        }

        .notification {
            position: absolute;
            top: 50px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .notification.show {
            opacity: 1;
        }

        .product-title {
            font-size: 14px;
            margin: 0 0 8px 0;
            color: #333;
            text-decoration: none;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-title:hover {
            color: var(--ebay-blue);
        }

        .product-price {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            color: #222;
        }

        .scroll-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 1px solid var(--ebay-border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1;
        }

        .scroll-button:hover {
            background-color: #f5f5f5;
        }

        .scroll-left {
            left: -20px;
        }

        .scroll-right {
            right: -20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .modal-content h2 {
            margin: 0 0 10px 0;
            font-size: 20px;
        }

        .modal-content p {
            margin: 0 0 20px 0;
            color: #666;
        }

        .modal-content a {
            background-color: var(--ebay-blue);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .modal-content a:hover {
            background-color: #2b4fb4;
        }

        @media (max-width: 768px) {
            .products-wrapper {
                padding-left: 7px;
                padding-right: 7px;
            }

            .section-header {
                padding: 0 30px;
            }

            .scroll-button {
                display: none;
            }

            .product-card {
                width: 200px;
            }

            .product-image {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <!-- Category Section -->
    <section class="products-section">
        <div class="section-header">
            <div>
                <h2 class="section-title"><?php echo htmlspecialchars($category); ?></h2>
                <p class="section-subtitle">All products in this category</p>
            </div>
            <a href="#" class="see-all">See all</a>
        </div>

        <div class="products-container">
            <button class="scroll-button scroll-left" onclick="scrollProducts('category-products-wrapper', -300)">&#8249;</button>
            <div class="products-wrapper" id="category-products-wrapper">
                <div class="products-grid">
                    <?php if (empty($products)): ?>
                        <p>No products found in this category.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <img src="<?php echo htmlspecialchars($product['image_path'] ?? '/placeholder.svg?height=280&width=280'); ?>" 
                                     alt="<?php echo htmlspecialchars($product['title']); ?>" 
                                     class="product-image">
                                <button class="wishlist-button" data-product-id="<?php echo $product['id']; ?>">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <div class="notification"></div>
                                <a href="p.php?id=<?php echo $product['id']; ?>" class="product-title">
                                    <?php echo htmlspecialchars($product['title']); ?>
                                </a>
                                <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <button class="scroll-button scroll-right" onclick="scrollProducts('category-products-wrapper', 300)">&#8250;</button>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <h2>Please Log In</h2>
            <p>You need to be logged in to add products to your watchlist.</p>
            <a href="login.php">Log In</a>
        </div>
    </div>

    <script>
        // Make user ID and watchlist available in JavaScript
        const userId = <?php echo json_encode($user_id); ?>;
        const watchlist = <?php echo json_encode($watchlist); ?>;

        // Function to show notification
        function showNotification(button, message) {
            const notification = button.nextElementSibling;
            notification.textContent = message;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 800);
        }

        // Function to scroll products
        function scrollProducts(wrapperId, amount) {
            const container = document.getElementById(wrapperId);
            container.scrollBy({ left: amount, behavior: 'smooth' });
        }

        // Set initial state of wishlist buttons and handle clicks
        document.querySelectorAll('.wishlist-button').forEach(button => {
            const productId = button.dataset.productId;
            if (watchlist.includes(productId)) {
                const icon = button.querySelector('i');
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                button.classList.add('liked');
            }

            button.addEventListener('click', function() {
                if (!userId) {
                    document.getElementById('loginModal').style.display = 'flex';
                    return;
                }

                const icon = this.querySelector('i');
                const isAdding = icon.classList.contains('bi-heart');
                const productId = this.dataset.productId;

                // Toggle the icon and show notification
                icon.classList.toggle('bi-heart');
                icon.classList.toggle('bi-heart-fill');
                this.classList.toggle('liked');
                showNotification(this, isAdding ? 'Added' : 'Removed');

                // Send AJAX request to update watchlist
                fetch('watchlist.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ productId: productId, action: isAdding ? 'add' : 'remove' })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update watchlist: ' + (data.message || 'Unknown error'));
                        // Revert the icon state
                        icon.classList.toggle('bi-heart');
                        icon.classList.toggle('bi-heart-fill');
                        this.classList.toggle('liked');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                    // Revert the icon state
                    icon.classList.toggle('bi-heart');
                    icon.classList.toggle('bi-heart-fill');
                    this.classList.toggle('liked');
                });
            });
        });

        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    </script>
</body>
</html>