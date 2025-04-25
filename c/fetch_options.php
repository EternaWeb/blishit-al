<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bug", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$type = $_GET['type'];
header('Content-Type: application/json');

if ($type === 'subcategories') {
    $category_id = $_GET['category_id'];
    $stmt = $pdo->prepare("SELECT * FROM subcategories WHERE category_id = ?");
    $stmt->execute([$category_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($type === 'brands') {
    $subcategory_id = $_GET['subcategory_id'];
    $stmt = $pdo->prepare("SELECT b.brand_id, b.brand_name FROM brands b JOIN subcategory_brands sb ON b.brand_id = sb.brand_id WHERE sb.subcategory_id = ?");
    $stmt->execute([$subcategory_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($type === 'models') {
    $subcategory_id = $_GET['subcategory_id'];
    $brand_id = $_GET['brand_id'];
    $stmt = $pdo->prepare("SELECT m.model_id, m.model_name FROM models m JOIN subcategory_brands sb ON m.subcategory_brand_id = sb.subcategory_brand_id WHERE sb.subcategory_id = ? AND sb.brand_id = ?");
    $stmt->execute([$subcategory_id, $brand_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($type === 'shipping') {
    $location_id = $_GET['location_id'];
    $stmt = $pdo->prepare("
        SELECT 
            so.shipping_option_id, 
            so.name, 
            AVG(sol.cost) AS avg_price,
            MAX(CASE WHEN l.location_name = 'Albania' THEN 1 ELSE 0 END) AS ships_to_albania
        FROM shipping_options so 
        LEFT JOIN shipping_option_locations sol ON so.shipping_option_id = sol.shipping_option_id 
        LEFT JOIN locations l ON sol.location_id = l.location_id 
        WHERE so.start_location_id = ? 
        GROUP BY so.shipping_option_id, so.name
    ");
    $stmt->execute([$location_id]);
    $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($options as &$option) {
        $option['avg_price'] = $option['avg_price'] ? floatval($option['avg_price']) : 0;
        $option['ships_to_albania'] = (bool)$option['ships_to_albania'];
    }
    echo json_encode($options);
}
?>