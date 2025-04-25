<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'trevali_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => "Connection failed: " . $e->getMessage()]));
}

// Get categories from POST request
$input = json_decode(file_get_contents('php://input'), true);
$categories = $input['categories'] ?? [];

if (empty($categories)) {
    echo json_encode([]);
    exit;
}

// Prepare and execute query
$placeholders = implode(',', array_fill(0, count($categories), '?'));
$stmt = $pdo->prepare("
    SELECT l.id, l.title, l.price, li.image_path 
    FROM listings l 
    LEFT JOIN listing_images li ON l.id = li.listing_id 
    WHERE l.status = 'active' AND l.category IN ($placeholders) 
    ORDER BY l.created_at DESC 
    LIMIT 5
");
$stmt->execute($categories);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sanitize output
foreach ($products as &$product) {
    $product['title'] = htmlspecialchars($product['title']);
    $product['image_path'] = htmlspecialchars($product['image_path'] ?? '');
}
unset($product);

echo json_encode($products);
?>