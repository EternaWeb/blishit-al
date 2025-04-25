<?php
session_start();

// Database connection (adjust credentials as needed)
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

// Get the search query
$query = $_GET['q'] ?? '';
if (empty($query)) {
    echo json_encode([]);
    exit;
}

// Include top-performing keywords
$top_keywords = include 'keyword.php';

// Fetch matching listings
$like_query = '%' . $query . '%';
$stmt = $pdo->prepare("
    SELECT id, title 
    FROM listings 
    WHERE (title LIKE :query OR description LIKE :query) 
    AND status = 'active' 
    LIMIT 5
");
$stmt->execute(['query' => $like_query]);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch matching keywords
$matching_keywords = array_filter($top_keywords, function($keyword) use ($query) {
    return stripos($keyword, $query) !== false;
});
$matching_keywords = array_slice($matching_keywords, 0, 5);

// Combine suggestions
$suggestions = [];
foreach ($listings as $listing) {
    $suggestions[] = [
        'type' => 'listing',
        'id' => $listing['id'],
        'title' => $listing['title']
    ];
}
foreach ($matching_keywords as $keyword) {
    $suggestions[] = [
        'type' => 'keyword',
        'keyword' => $keyword
    ];
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
?>