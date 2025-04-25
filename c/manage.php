<?php
// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bug", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add Category
    if (isset($_POST['add_category'])) {
        $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$_POST['category_name']]);
    }
    // Delete Category
    if (isset($_POST['delete_category'])) {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->execute([$_POST['category_id']]);
    }

    // Add Subcategory
    if (isset($_POST['add_subcategory'])) {
        $stmt = $pdo->prepare("INSERT INTO subcategories (subcategory_name, category_id) VALUES (?, ?)");
        $stmt->execute([$_POST['subcategory_name'], $_POST['category_id']]);
    }
    // Delete Subcategory
    if (isset($_POST['delete_subcategory'])) {
        $stmt = $pdo->prepare("DELETE FROM subcategories WHERE subcategory_id = ?");
        $stmt->execute([$_POST['subcategory_id']]);
    }

    // Add Brand
    if (isset($_POST['add_brand'])) {
        $stmt = $pdo->prepare("INSERT INTO brands (brand_name) VALUES (?)");
        $stmt->execute([$_POST['brand_name']]);
    }
    // Delete Brand
    if (isset($_POST['delete_brand'])) {
        $stmt = $pdo->prepare("DELETE FROM brands WHERE brand_id = ?");
        $stmt->execute([$_POST['brand_id']]);
    }

    // Add Subcategory-Brand Assignment
    if (isset($_POST['add_subcategory_brand'])) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO subcategory_brands (subcategory_id, brand_id) VALUES (?, ?)");
        $stmt->execute([$_POST['subcategory_id'], $_POST['brand_id']]);
    }
    // Delete Subcategory-Brand Assignment
    if (isset($_POST['delete_subcategory_brand'])) {
        $stmt = $pdo->prepare("DELETE FROM subcategory_brands WHERE subcategory_brand_id = ?");
        $stmt->execute([$_POST['subcategory_brand_id']]);
    }

    // Add Model
    if (isset($_POST['add_model'])) {
        $stmt = $pdo->prepare("INSERT INTO models (model_name, subcategory_brand_id) VALUES (?, ?)");
        $stmt->execute([$_POST['model_name'], $_POST['subcategory_brand_id']]);
    }
    // Delete Model
    if (isset($_POST['delete_model'])) {
        $stmt = $pdo->prepare("DELETE FROM models WHERE model_id = ?");
        $stmt->execute([$_POST['model_id']]);
    }

    // Add Location
    if (isset($_POST['add_location'])) {
        $stmt = $pdo->prepare("INSERT INTO locations (location_name) VALUES (?)");
        $stmt->execute([$_POST['location_name']]);
    }
    // Delete Location
    if (isset($_POST['delete_location'])) {
        $stmt = $pdo->prepare("DELETE FROM locations WHERE location_id = ?");
        $stmt->execute([$_POST['location_id']]);
    }

    // Add Shipping Option
    if (isset($_POST['add_shipping_option'])) {
        $stmt = $pdo->prepare("INSERT INTO shipping_options (name, start_location_id) VALUES (?, ?)");
        $stmt->execute([$_POST['shipping_name'], $_POST['start_location_id']]);
    }
    // Delete Shipping Option
    if (isset($_POST['delete_shipping_option'])) {
        $stmt = $pdo->prepare("DELETE FROM shipping_options WHERE shipping_option_id = ?");
        $stmt->execute([$_POST['shipping_option_id']]);
    }

    // Add Shipping Option Location
    if (isset($_POST['add_shipping_option_location'])) {
        $stmt = $pdo->prepare("INSERT INTO shipping_option_locations (shipping_option_id, location_id, cost) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['shipping_option_id'], $_POST['location_id'], $_POST['cost']]);
    }
    // Delete Shipping Option Location
    if (isset($_POST['delete_shipping_option_location'])) {
        $stmt = $pdo->prepare("DELETE FROM shipping_option_locations WHERE shipping_option_location_id = ?");
        $stmt->execute([$_POST['shipping_option_location_id']]);
    }
    header("Location: manage.php");
    exit;
}

// Fetch stats for dashboard
$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$total_subcategories = $pdo->query("SELECT COUNT(*) FROM subcategories")->fetchColumn();
$total_brands = $pdo->query("SELECT COUNT(*) FROM brands")->fetchColumn();
$total_models = $pdo->query("SELECT COUNT(*) FROM models")->fetchColumn();
$total_locations = $pdo->query("SELECT COUNT(*) FROM locations")->fetchColumn();
$total_shipping_options = $pdo->query("SELECT COUNT(*) FROM shipping_options")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Marketplace</title>
    <!-- Inter Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f7fa;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-header h2 {
            font-size: 1.2rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: #ecf0f1;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .nav-list {
            list-style: none;
            padding: 20px 0;
        }

        .nav-item {
            padding: 12px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
            white-space: nowrap;
        }

        .nav-item:hover {
            background-color: #34495e;
        }

        .nav-item.active {
            background-color: #3498db;
        }

        .nav-item i {
            margin-right: 15px;
            font-size: 1.2rem;
            min-width: 24px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .page {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .page.active {
            display: block;
        }

        .page-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: #2c3e50;
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            margin-bottom: 15px;
            font-weight: 600;
            color: #2c3e50;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            text-align: center;
            padding: 25px 15px;
        }

        .stat-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #3498db;
        }

        .stat-card h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar.expanded {
                width: 250px;
                position: absolute;
                height: 100%;
                z-index: 1000;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <ul class="nav-list">
            <li class="nav-item active" data-page="dashboard">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </li>
            <li class="nav-item" data-page="categories">
                <i class="bi bi-grid"></i>
                <span>Categories</span>
            </li>
            <li class="nav-item" data-page="subcategories">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Subcategories</span>
            </li>
            <li class="nav-item" data-page="brands">
                <i class="bi bi-tag"></i>
                <span>Brands</span>
            </li>
            <li class="nav-item" data-page="subcategory-brands">
                <i class="bi bi-link-45deg"></i>
                <span>Subcategory-Brands</span>
            </li>
            <li class="nav-item" data-page="models">
                <i class="bi bi-box"></i>
                <span>Models</span>
            </li>
            <li class="nav-item" data-page="locations">
                <i class="bi bi-geo-alt"></i>
                <span>Locations</span>
            </li>
            <li class="nav-item" data-page="shipping">
                <i class="bi bi-truck"></i>
                <span>Shipping</span>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Page -->
        <div class="page active" id="dashboard">
            <div class="page-header">
                <h1>Dashboard</h1>
            </div>
            <div class="dashboard-grid">
                <div class="card stat-card">
                    <i class="bi bi-grid"></i>
                    <h3><?php echo $total_categories; ?></h3>
                    <p>Total Categories</p>
                </div>
                <div class="card stat-card">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <h3><?php echo $total_subcategories; ?></h3>
                    <p>Total Subcategories</p>
                </div>
                <div class="card stat-card">
                    <i class="bi bi-tag"></i>
                    <h3><?php echo $total_brands; ?></h3>
                    <p>Total Brands</p>
                </div>
                <div class="card stat-card">
                    <i class="bi bi-box"></i>
                    <h3><?php echo $total_models; ?></h3>
                    <p>Total Models</p>
                </div>
                <div class="card stat-card">
                    <i class="bi bi-geo-alt"></i>
                    <h3><?php echo $total_locations; ?></h3>
                    <p>Total Locations</p>
                </div>
                <div class="card stat-card">
                    <i class="bi bi-truck"></i>
                    <h3><?php echo $total_shipping_options; ?></h3>
                    <p>Total Shipping Options</p>
                </div>
            </div>
        </div>

        <!-- Categories Page -->
        <div class="page" id="categories">
            <div class="page-header">
                <h1>Categories</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Category List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = $pdo->query("SELECT * FROM categories")->fetchAll();
                        foreach ($categories as $cat) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($cat['category_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='category_id' value='{$cat['category_id']}'><button type='submit' name='delete_category' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Category</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" id="category_name" name="category_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>

        <!-- Subcategories Page -->
        <div class="page" id="subcategories">
            <div class="page-header">
                <h1>Subcategories</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Subcategory List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subcategories = $pdo->query("SELECT s.*, c.category_name FROM subcategories s JOIN categories c ON s.category_id = c.category_id")->fetchAll();
                        foreach ($subcategories as $sub) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($sub['category_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($sub['subcategory_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='subcategory_id' value='{$sub['subcategory_id']}'><button type='submit' name='delete_subcategory' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Subcategory</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <?php
                            foreach ($categories as $cat) {
                                echo "<option value='{$cat['category_id']}'>" . htmlspecialchars($cat['category_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategory_name">Subcategory Name</label>
                        <input type="text" id="subcategory_name" name="subcategory_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_subcategory" class="btn btn-primary">Add Subcategory</button>
                </form>
            </div>
        </div>

        <!-- Brands Page -->
        <div class="page" id="brands">
            <div class="page-header">
                <h1>Brands</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Brand List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $brands = $pdo->query("SELECT * FROM brands")->fetchAll();
                        foreach ($brands as $brand) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($brand['brand_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='brand_id' value='{$brand['brand_id']}'><button type='submit' name='delete_brand' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Brand</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_brand" class="btn btn-primary">Add Brand</button>
                </form>
            </div>
        </div>

        <!-- Subcategory-Brands Page -->
        <div class="page" id="subcategory-brands">
            <div class="page-header">
                <h1>Subcategory-Brands</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Assigned Subcategory-Brands</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Subcategory</th>
                            <th>Brand</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subcategory_brands = $pdo->query("SELECT sb.*, s.subcategory_name, b.brand_name FROM subcategory_brands sb JOIN subcategories s ON sb.subcategory_id = s.subcategory_id JOIN brands b ON sb.brand_id = b.brand_id")->fetchAll();
                        foreach ($subcategory_brands as $sb) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($sb['subcategory_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($sb['brand_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='subcategory_brand_id' value='{$sb['subcategory_brand_id']}'><button type='submit' name='delete_subcategory_brand' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Assign Brand to Subcategory</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="subcategory_id">Subcategory</label>
                        <select id="subcategory_id" name="subcategory_id" class="form-control" required>
                            <?php
                            $subcategories = $pdo->query("SELECT * FROM subcategories")->fetchAll();
                            foreach ($subcategories as $sub) {
                                echo "<option value='{$sub['subcategory_id']}'>" . htmlspecialchars($sub['subcategory_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">Brand</label>
                        <select id="brand_id" name="brand_id" class="form-control" required>
                            <?php
                            foreach ($brands as $brand) {
                                echo "<option value='{$brand['brand_id']}'>" . htmlspecialchars($brand['brand_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="add_subcategory_brand" class="btn btn-primary">Assign Brand</button>
                </form>
            </div>
        </div>

        <!-- Models Page -->
        <div class="page" id="models">
            <div class="page-header">
                <h1>Models</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Model List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Subcategory - Brand</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $models = $pdo->query("SELECT m.*, sb.subcategory_brand_id, s.subcategory_name, b.brand_name FROM models m JOIN subcategory_brands sb ON m.subcategory_brand_id = sb.subcategory_brand_id JOIN subcategories s ON sb.subcategory_id = s.subcategory_id JOIN brands b ON sb.brand_id = b.brand_id")->fetchAll();
                        foreach ($models as $model) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($model['subcategory_name'] . " - " . $model['brand_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($model['model_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='model_id' value='{$model['model_id']}'><button type='submit' name='delete_model' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Model</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="subcategory_brand_id">Subcategory - Brand</label>
                        <select id="subcategory_brand_id" name="subcategory_brand_id" class="form-control" required>
                            <?php
                            $subcategory_brands = $pdo->query("SELECT sb.subcategory_brand_id, s.subcategory_name, b.brand_name FROM subcategory_brands sb JOIN subcategories s ON sb.subcategory_id = s.subcategory_id JOIN brands b ON sb.brand_id = b.brand_id")->fetchAll();
                            foreach ($subcategory_brands as $sb) {
                                echo "<option value='{$sb['subcategory_brand_id']}'>" . htmlspecialchars($sb['subcategory_name'] . " - " . $sb['brand_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="model_name">Model Name</label>
                        <input type="text" id="model_name" name="model_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_model" class="btn btn-primary">Add Model</button>
                </form>
            </div>
        </div>

        <!-- Locations Page -->
        <div class="page" id="locations">
            <div class="page-header">
                <h1>Locations</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Location List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $locations = $pdo->query("SELECT * FROM locations")->fetchAll();
                        foreach ($locations as $loc) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($loc['location_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='location_id' value='{$loc['location_id']}'><button type='submit' name='delete_location' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Location</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="location_name">Location Name</label>
                        <input type="text" id="location_name" name="location_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_location" class="btn btn-primary">Add Location</button>
                </form>
            </div>
        </div>

        <!-- Shipping Page -->
        <div class="page" id="shipping">
            <div class="page-header">
                <h1>Shipping</h1>
            </div>
            <div class="card">
                <h2 class="card-header">Shipping Option List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Start Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $shipping_options = $pdo->query("SELECT so.*, l.location_name FROM shipping_options so JOIN locations l ON so.start_location_id = l.location_id")->fetchAll();
                        foreach ($shipping_options as $so) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($so['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($so['location_name']) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='shipping_option_id' value='{$so['shipping_option_id']}'><button type='submit' name='delete_shipping_option' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Shipping Option</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="shipping_name">Shipping Option Name</label>
                        <input type="text" id="shipping_name" name="shipping_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="start_location_id">Start Location</label>
                        <select id="start_location_id" name="start_location_id" class="form-control" required>
                            <?php
                            foreach ($locations as $loc) {
                                echo "<option value='{$loc['location_id']}'>" . htmlspecialchars($loc['location_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="add_shipping_option" class="btn btn-primary">Add Shipping Option</button>
                </form>
            </div>
            <div class="card">
                <h2 class="card-header">Shipping Option Locations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Shipping Option</th>
                            <th>Location</th>
                            <th>Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $shipping_option_locations = $pdo->query("SELECT sol.*, so.name AS shipping_name, l.location_name FROM shipping_option_locations sol JOIN shipping_options so ON sol.shipping_option_id = so.shipping_option_id JOIN locations l ON sol.location_id = l.location_id")->fetchAll();
                        foreach ($shipping_option_locations as $sol) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($sol['shipping_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($sol['location_name']) . "</td>";
                            echo "<td>$" . number_format($sol['cost'], 2) . "</td>";
                            echo "<td><form method='post' style='display:inline;'><input type='hidden' name='shipping_option_location_id' value='{$sol['shipping_option_location_id']}'><button type='submit' name='delete_shipping_option_location' class='btn btn-danger'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h2 class="card-header">Add Shipping Option Location</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="shipping_option_id">Shipping Option</label>
                        <select id="shipping_option_id" name="shipping_option_id" class="form-control" required>
                            <?php
                            foreach ($shipping_options as $so) {
                                echo "<option value='{$so['shipping_option_id']}'>" . htmlspecialchars($so['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location_id">Location</label>
                        <select id="location_id" name="location_id" class="form-control" required>
                            <?php
                            foreach ($locations as $loc) {
                                echo "<option value='{$loc['location_id']}'>" . htmlspecialchars($loc['location_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input type="number" id="cost" name="cost" step="0.01" class="form-control" required>
                    </div>
                    <button type="submit" name="add_shipping_option_location" class="btn btn-primary">Add Location</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const navItems = document.querySelectorAll('.nav-item');
        const pages = document.querySelectorAll('.page');

        // Toggle Sidebar
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('expanded');
            }
        });

        // Tab Switching
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                navItems.forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');
                const pageId = item.getAttribute('data-page');
                pages.forEach(page => {
                    page.classList.remove('active');
                    if (page.id === pageId) {
                        page.classList.add('active');
                    }
                });
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('expanded');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('expanded');
            } else {
                sidebar.classList.remove('expanded');
            }
        });
    </script>
</body>
</html>