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

// Determine profile to show
$profile_user = null;
$is_own_profile = false;

if (isset($_GET['username'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_GET['username']]);
    $profile_user = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $profile_user = $stmt->fetch(PDO::FETCH_ASSOC);
    $is_own_profile = true;
}

if (!$profile_user) {
    die("User not found.");
}

// Handle follow/unfollow (unchanged)
if (isset($_POST['follow']) && isset($_SESSION['user_id'])) {
    $follower_id = $_SESSION['user_id'];
    $following_id = $profile_user['id'];

    if ($follower_id != $following_id) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM followers WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$follower_id, $following_id]);
        $is_following = $stmt->fetchColumn();

        if ($is_following) {
            $stmt = $pdo->prepare("DELETE FROM followers WHERE follower_id = ? AND following_id = ?");
            $stmt->execute([$follower_id, $following_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO followers (follower_id, following_id) VALUES (?, ?)");
            $stmt->execute([$follower_id, $following_id]);
        }
        header("Location: profile.php?username=" . urlencode($profile_user['username']));
        exit;
    }
} elseif (isset($_POST['follow']) && !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user's listings
$stmt = $pdo->prepare("
    SELECT l.id, l.title, l.price, li.image_path 
    FROM listings l 
    LEFT JOIN listing_images li ON l.id = li.listing_id 
    WHERE l.user_id = ? AND l.status = 'active'
");
$stmt->execute([$profile_user['id']]);
$user_listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch watchlist if it's the user's own profile
if ($is_own_profile) {
    $stmt = $pdo->prepare("
        SELECT l.id, l.title, l.price, li.image_path 
        FROM watchlist w
        JOIN listings l ON w.listing_id = l.id
        LEFT JOIN listing_images li ON l.id = li.listing_id
        WHERE w.user_id = ?
    ");
    $stmt->execute([$profile_user['id']]);
    $watchlist_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch dynamic stats (unchanged)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM listings WHERE user_id = ?");
$stmt->execute([$profile_user['id']]);
$listings_count = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM followers WHERE following_id = ?");
$stmt->execute([$profile_user['id']]);
$followers_count = $stmt->fetchColumn();

$stats = [
    'listings' => $listings_count,
    'followers' => $followers_count,
    'likes' => 4800,
];

$is_following = false;
if (isset($_SESSION['user_id']) && !$is_own_profile) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM followers WHERE follower_id = ? AND following_id = ?");
    $stmt->execute([$_SESSION['user_id'], $profile_user['id']]);
    $is_following = $stmt->fetchColumn() > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile_user['full_name']); ?>'s Profile - Trevali</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    
    .header {
      border-bottom: 1px solid var(--ebay-border);
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
    
    /* Profile Styles */
    .profile-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .profile-header {
      display: flex;
      align-items: center;
      gap: 30px;
      margin-bottom: 30px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--ebay-border);
    }
    
    .profile-picture {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 1px solid var(--ebay-border);
    }
    
    .profile-info {
      flex: 1;
    }
    
    .profile-name {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 5px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .verified-badge {
      color: var(--ebay-blue);
      font-size: 18px;
    }
    
    .profile-username {
      color: var(--ebay-text-light);
      font-size: 16px;
      margin-bottom: 10px;
    }
    
    .profile-stats {
      display: flex;
      gap: 20px;
      margin-bottom: 15px;
    }
    
    .stat {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .stat-value {
      font-weight: 600;
      font-size: 18px;
    }
    
    .stat-label {
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    .profile-bio {
      margin-bottom: 15px;
      line-height: 1.5;
    }
    
    .profile-location {
      display: flex;
      align-items: center;
      gap: 5px;
      color: var(--ebay-text-light);
      font-size: 14px;
      margin-bottom: 15px;
    }
    
    .profile-actions {
      display: flex;
      gap: 10px;
    }
    
    .action-btn {
      padding: 8px 20px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .primary-btn {
      background-color: var(--ebay-blue);
      color: white;
      border: none;
      text-decoration: none;
    }
    
    .primary-btn:hover {
      background-color: #2b4fb4;
    }
    
    .secondary-btn {
      background-color: white;
      color: var(--ebay-text);
      border: 1px solid var(--ebay-border);
    }
    
    .secondary-btn:hover {
      background-color: var(--ebay-light-gray);
    }
    
    /* Tabs */
    .profile-tabs {
      display: flex;
      border-bottom: 1px solid var(--ebay-border);
      margin-bottom: 20px;
    }
    
    .profile-tab {
      padding: 15px 20px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      position: relative;
      color: var(--ebay-text-light);
    }
    
    .profile-tab.active {
      color: var(--ebay-text);
    }
    
    .profile-tab.active::after {
      content: "";
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 2px;
      background-color: var(--ebay-blue);
    }
    
    /* Listings Grid */
    .listings-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
      margin-bottom: 30px;
    }
    
    .listing-item {
      position: relative;
      aspect-ratio: 1/1;
      overflow: hidden;
      border-radius: 8px;
      cursor: pointer;
    }
    
    .listing-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;
    }
    
    .listing-item:hover .listing-image {
      transform: scale(1.05);
    }
    
    .listing-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.3);
      opacity: 0;
      transition: opacity 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 14px;
      gap: 15px;
    }
    
    .listing-item:hover .listing-overlay {
      opacity: 1;
    }
    
    .overlay-stat {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    /* Featured Items */
    .featured-section {
      margin-bottom: 30px;
    }
    
    .section-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 15px;
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
    
    .featured-items {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
    }
    
    .featured-item {
      border: 1px solid var(--ebay-border);
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .featured-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .featured-image {
      width: 100%;
      aspect-ratio: 1/1;
      object-fit: cover;
    }
    
    .featured-details {
      padding: 10px;
    }
    
    .featured-title {
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 5px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .featured-price {
      font-size: 16px;
      font-weight: 600;
      color: var(--ebay-text);
    }
    
    /* Reviews Section */
    .reviews-section {
      margin-bottom: 30px;
    }
    
    .review-stats {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
    }
    
    .rating-overview {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 15px;
      border: 1px solid var(--ebay-border);
      border-radius: 8px;
      min-width: 120px;
    }
    
    .rating-value {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .rating-stars {
      color: var(--ebay-yellow);
      font-size: 18px;
      margin-bottom: 5px;
    }
    
    .rating-count {
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    .rating-bars {
      flex: 1;
    }
    
    .rating-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }
    
    .rating-label {
      min-width: 30px;
      font-size: 14px;
    }
    
    .progress {
      flex: 1;
      height: 8px;
      border-radius: 4px;
      background-color: var(--ebay-light-gray);
    }
    
    .progress-bar {
      background-color: var(--ebay-yellow);
      height: 100%;
      border-radius: 4px;
    }
    
    .rating-percentage {
      min-width: 40px;
      font-size: 14px;
      color: var(--ebay-text-light);
      text-align: right;
    }
    
    .reviews-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    
    .review-item {
      padding: 15px;
      border: 1px solid var(--ebay-border);
      border-radius: 8px;
    }
    
    .review-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    
    .reviewer {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .reviewer-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    
    .reviewer-name {
      font-weight: 500;
    }
    
    .review-date {
      color: var(--ebay-text-light);
      font-size: 14px;
    }
    
    .review-rating {
      color: var(--ebay-yellow);
    }
    
    .review-content {
      line-height: 1.5;
      margin-bottom: 10px;
    }
    
    .review-product {
      font-size: 14px;
      color: var(--ebay-text-light);
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .featured-items {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    @media (max-width: 768px) {
      .profile-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
      }
      
      .profile-stats {
        justify-content: center;
      }
      
      .profile-actions {
        justify-content: center;
      }
      
      .listings-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .featured-items {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .review-stats {
        flex-direction: column;
        align-items: stretch;
      }
      
      .rating-overview {
        margin-bottom: 15px;
      }
    }
    
    @media (max-width: 480px) {
      .profile-tabs {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 5px;
      }
      
      .profile-tab {
        padding: 15px 15px;
      }
      
      .listings-grid {
        grid-template-columns: 1fr;
      }
      
      .featured-items {
        grid-template-columns: 1fr;
      }
    }</style> 
</head>
<body>
    <?php include 'nav.php'; ?>
        <div class="profile-container">
        <div class="profile-header">
            <img src="<?php echo htmlspecialchars($profile_user['profile_picture'] ?: '/placeholder.svg?height=150&width=150'); ?>" alt="Profile Picture" class="profile-picture">
            <div class="profile-info">
                <div class="profile-name">
                    <?php echo htmlspecialchars($profile_user['full_name']); ?>
                    <span class="verified-badge"><i class="bi bi-patch-check-fill"></i></span>
                </div>
                <div class="profile-username">@<?php echo htmlspecialchars($profile_user['username']); ?></div>
                <div class="profile-stats">
                    <div class="stat">
                        <div class="stat-value"><?php echo $stats['listings']; ?></div>
                        <div class="stat-label">Listings</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value"><?php echo number_format($stats['followers']); ?></div>
                        <div class="stat-label">Followers</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value"><?php echo number_format($stats['likes']); ?></div>
                        <div class="stat-label">Likes</div>
                    </div>
                </div>
                <div class="profile-bio"><?php echo htmlspecialchars($profile_user['bio'] ?: 'No bio provided.'); ?></div>
                <div class="profile-location">
                    <i class="bi bi-geo-alt"></i>
                    <?php echo htmlspecialchars($profile_user['location'] ?: 'Location not set'); ?>
                </div>
                <div class="profile-actions">
                    <?php if ($is_own_profile): ?>
                        <a href="edit_profile.php" class="action-btn primary-btn">Edit Profile</a>
                        <button class="action-btn secondary-btn" onclick="navigator.clipboard.writeText(window.location.href); alert('Profile link copied!');">Share</button>
                    <?php else: ?>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="follow" class="action-btn primary-btn"><?php echo $is_following ? 'Following' : 'Follow'; ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="profile-tabs">
            <div class="profile-tab active" data-tab="listings">Listings</div>
            <?php if ($is_own_profile): ?>
                <div class="profile-tab" data-tab="watchlist">Watchlist</div>
            <?php endif; ?>
            <div class="profile-tab" data-tab="drafts">Drafts</div>
            <div class="profile-tab" data-tab="about">About</div>
        </div>
        <!-- Listings Tab -->
        <div id="listings-content" class="tab-content">
            <div class="listings-grid">
                <?php if (!empty($user_listings)): ?>
                    <?php foreach ($user_listings as $listing): ?>
                        <div class="listing-item">
                            <img src="<?php echo htmlspecialchars($listing['image_path'] ?? '/placeholder.svg?height=280&width=280'); ?>" 
                                 alt="<?php echo htmlspecialchars($listing['title']); ?>" 
                                 class="listing-image">
                            <div class="listing-overlay">
                                <!-- Add stats if needed -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No listings found.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Watchlist Tab -->
        <?php if ($is_own_profile): ?>
        <div id="watchlist-content" class="tab-content">
            <div class="listings-grid">
                <?php if (!empty($watchlist_products)): ?>
                    <?php foreach ($watchlist_products as $product): ?>
                        <div class="listing-item">
                            <img src="<?php echo htmlspecialchars($product['image_path'] ?? '/placeholder.svg?height=280&width=280'); ?>" 
                                 alt="<?php echo htmlspecialchars($product['title']); ?>" 
                                 class="listing-image">
                            <div class="listing-overlay">
                                <!-- Add stats if needed -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products in watchlist.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- Placeholder for other tabs -->
        <div id="drafts-content" class="tab-content">
            <p>Drafts coming soon.</p>
        </div>
        <div id="about-content" class="tab-content">
            <p>About section coming soon.</p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.profile-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const tabId = this.dataset.tab;
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.style.display = content.id === `${tabId}-content` ? 'block' : 'none';
                });
            });
        });
    </script>
</body>
</html>