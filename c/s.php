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

// Get search query and sort option
$search_query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING) ?? '';
$sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_STRING) ?? 'default';

if (!empty($search_query)) {
    $like_query = '%' . $search_query . '%';
    $query = "
        SELECT l.id, l.title, l.price, l.category, l.created_at, i.image_path 
        FROM listings l 
        LEFT JOIN listing_images i ON l.id = i.listing_id 
        AND i.id = (SELECT MIN(id) FROM listing_images WHERE listing_id = l.id)
        WHERE (l.title LIKE :query OR l.description LIKE :query) 
        AND l.status = 'active'
    ";

    // Apply sorting
    switch ($sort) {
        case 'price_asc':
            $query .= " ORDER BY l.price ASC";
            break;
        case 'price_desc':
            $query .= " ORDER BY l.price DESC";
            break;
        case 'newest':
            $query .= " ORDER BY l.created_at DESC";
            break;
        default:
            $query .= " ORDER BY l.created_at DESC";
            break;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute(['query' => $like_query]);
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $listings = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Trevali Marketplace</title>
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
            padding: 0 300px;
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

        .sort-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-filter label {
            font-size: 14px;
            color: #333;
        }

        .sort-filter select {
            padding: 8px;
            border: 1px solid var(--ebay-border);
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .sort-filter select:focus {
            outline: none;
            border-color: var(--ebay-blue);
        }

        .products-container {
            padding: 0 50px;
            display: flex;
            justify-content: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 280px);
            gap: 25px;
            justify-content: center;
            max-width: 1200px; /* Ensures grid doesn't stretch too wide */
        }

        .product-card {
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
            .section-header {
                padding: 0 30px;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .products-container {
                padding: 0 7px;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 13px;
                padding: 0 10px;
            }

            .product-card {
                width: 100%;
            }

            .product-image {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <!-- Search Results Section -->
    <section class="products-section">
        <div class="section-header">
            <div>
                <h2 class="section-title">Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
                <p class="section-subtitle"><?php echo count($listings); ?> results found</p>
            </div>
            <div class="sort-filter">
                <label for="sort">Sort By:</label>
                <select id="sort" onchange="applySort()">
                    <option value="default" <?php echo $sort === 'default' ? 'selected' : ''; ?>>Default</option>
                    <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                    <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest</option>
                </select>
            </div>
        </div>

        <div class="products-container">
            <?php if (empty($listings)): ?>
                <p>No results found for "<?php echo htmlspecialchars($search_query); ?>".</p>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($listings as $listing): ?>
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($listing['image_path'] ?? '/placeholder.svg?height=280&width=280'); ?>" 
                                 alt="<?php echo htmlspecialchars($listing['title']); ?>" 
                                 class="product-image">
                            <button class="wishlist-button" data-product-id="<?php echo $listing['id']; ?>">
                                <i class="bi bi-heart"></i>
                            </button>
                            <div class="notification"></div>
                            <a href="p.php?id=<?php echo $listing['id']; ?>" class="product-title">
                                <?php echo htmlspecialchars($listing['title']); ?>
                            </a>
                            <p class="product-price">$<?php echo number_format($listing['price'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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

        // Apply sort filter
        function applySort() {
            const sortValue = document.getElementById('sort').value;
            const url = new URL(window.location);
            url.searchParams.set('sort', sortValue);
            window.location.href = url.toString();
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