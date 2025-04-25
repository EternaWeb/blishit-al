<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$listing_id = $data['productId'];
$action = $data['action'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=trevali_db", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($action === 'add') {
        // Check if the entry already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM watchlist WHERE user_id = ? AND listing_id = ?");
        $stmt->execute([$user_id, $listing_id]);
        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO watchlist (user_id, listing_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $listing_id]);
        }
    } elseif ($action === 'remove') {
        $stmt = $pdo->prepare("DELETE FROM watchlist WHERE user_id = ? AND listing_id = ?");
        $stmt->execute([$user_id, $listing_id]);
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>