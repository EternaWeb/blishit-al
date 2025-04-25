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

// API endpoint to get brands by category
if (isset($_GET['category'])) {
    $category = filter_var($_GET['category'], FILTER_SANITIZE_STRING);
    $stmt = $pdo->prepare("SELECT id, name FROM brands WHERE category = ? ORDER BY name");
    $stmt->execute([$category]);
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($brands);
    exit;
}

// Handle brand addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    
    $stmt = $pdo->prepare("INSERT INTO brands (name, category) VALUES (?, ?)");
    $stmt->execute([$name, $category]);
    header("Location: brand.php");
    exit;
}

// Fetch all brands for display
$brands = $pdo->query("SELECT * FROM brands ORDER BY category, name")->fetchAll(PDO::FETCH_ASSOC);
// Fetch categories from the database (assuming they're stored somewhere, or hardcode for now)
$categories = ['electronics', 'clothing', 'home', 'toys', 'sports', 'collectibles', 'automotive', 'other'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Brands</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Copy your full CSS from form.php here for consistency */
        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        .form-container { background: white; border: 1px solid #e5e5e5; border-radius: 8px; padding: 30px; }
        .form-group { margin-bottom: 25px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-input, .form-select { width: 100%; padding: 12px 15px; border: 1px solid #e5e5e5; border-radius: 8px; font-size: 16px; }
        .btn { padding: 12px 24px; border-radius: 24px; background: #3665f3; color: white; border: none; cursor: pointer; }
        .btn:hover { background: #2b4fb4; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Brands</h1>
        
        <form method="POST" class="form-container">
            <div class="form-group">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">Add Brand</button>
        </form>

        <div class="form-container" style="margin-top: 20px;">
            <h3>Existing Brands</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 1px solid #e5e5e5;">Name</th>
                        <th style="padding: 10px; border-bottom: 1px solid #e5e5e5;">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brands as $brand): ?>
                        <tr>
                            <td style="padding: 10px;"><?= htmlspecialchars($brand['name']) ?></td>
                            <td style="padding: 10px;"><?= htmlspecialchars($brand['category']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>