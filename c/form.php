<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$host = 'localhost';
$dbname = 'trevali_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $locations = $pdo->query("SELECT * FROM locations ORDER BY country_code, name")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] == 5) {
    $required = ['name', 'description', 'location_id', 'price', 'category', 'quantity'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . " is required.";
        }
    }

    $title = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category = filter_var($_POST['category'] ?? '', FILTER_SANITIZE_STRING);
    $quantity = filter_var($_POST['quantity'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $brand_id = filter_var($_POST['brand_id'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $condition = filter_var($_POST['condition'] ?? '', FILTER_SANITIZE_STRING);
    $location_id = filter_var($_POST['location_id'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $sku = filter_var($_POST['sku'] ?? '', FILTER_SANITIZE_STRING);
    $weight = filter_var($_POST['weight'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $weight_unit = filter_var($_POST['weightUnit'] ?? '', FILTER_SANITIZE_STRING);
    $length = filter_var($_POST['length'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $width = filter_var($_POST['width'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $height = filter_var($_POST['height'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $dimension_unit = filter_var($_POST['dimensionUnit'] ?? '', FILTER_SANITIZE_STRING);

    $images = [];
    $max_images = 10;
    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!is_dir('listings')) {
        mkdir('listings', 0755, true);
    }

    for ($i = 0; $i < $max_images; $i++) {
        if (isset($_FILES["image_$i"]) && $_FILES["image_$i"]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES["image_$i"];
            if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_name = 'listing_' . $_SESSION['user_id'] . '_' . time() . '_' . $i . '.' . $ext;
                $upload_path = 'listings/' . $new_name;

                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $images[] = [
                        'path' => $upload_path,
                        'alt' => filter_var($_POST["image_{$i}_alt"] ?? '', FILTER_SANITIZE_STRING),
                        'caption' => filter_var($_POST["image_{$i}_caption"] ?? '', FILTER_SANITIZE_STRING)
                    ];
                } else {
                    $errors[] = "Failed to upload image " . ($i + 1) . ".";
                }
            } else {
                $errors[] = "Invalid image type or size for image " . ($i + 1) . " (max 5MB, JPEG/PNG/WebP).";
            }
        }
    }

    if (empty($images)) {
        $errors[] = "At least one image is required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO listings (
                user_id, title, description, price, category, quantity, brand_id, `condition`, 
                location_id, sku, weight, weight_unit, length, width, height, dimension_unit, 
                likes, views
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0)
        ");
        $stmt->execute([
            $_SESSION['user_id'], $title, $description, $price, $category, $quantity,
            $brand_id ?: null, $condition ?: null, $location_id ?: null, $sku ?: null,
            $weight ?: null, $weight_unit ?: null, $length ?: null, $width ?: null, 
            $height ?: null, $dimension_unit ?: null
        ]);

        $listing_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("
            INSERT INTO listing_images (listing_id, image_path, alt_text, caption) 
            VALUES (?, ?, ?, ?)
        ");
        foreach ($images as $image) {
            $stmt->execute([$listing_id, $image['path'], $image['alt'] ?: null, $image['caption'] ?: null]);
        }

        header("Location: profile.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Listing - Trevali</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Your existing CSS remains unchanged */
        :root {
            --ebay-blue: #3665f3;
            --ebay-light-gray: #f8f8f8;
            --ebay-border: #e5e5e5;
            --ebay-text: #333;
            --ebay-text-light: #767676;
            --ebay-success: #36b37e;
            --ebay-error: #e53238;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: var(--ebay-text);
            line-height: 1.5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: var(--ebay-text-light);
            font-size: 16px;
        }

        /* Form Steps */
        .form-steps {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--ebay-border);
            padding-bottom: 20px;
        }

        .step {
            display: flex;
            align-items: center;
            margin-right: 40px;
            position: relative;
            cursor: pointer;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--ebay-light-gray);
            color: var(--ebay-text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .step.active .step-number {
            background-color: var(--ebay-blue);
            color: white;
        }

        .step.completed .step-number {
            background-color: var(--ebay-success);
            color: white;
        }

        .step-label {
            font-weight: 500;
            color: var(--ebay-text-light);
            transition: all 0.3s;
        }

        .step.active .step-label {
            color: var(--ebay-text);
            font-weight: 600;
        }

        .step.completed .step-label {
            color: var(--ebay-success);
        }

        .step::after {
            content: "";
            position: absolute;
            top: 15px;
            left: 30px;
            width: calc(100% + 40px);
            height: 2px;
            background-color: var(--ebay-light-gray);
            z-index: -1;
        }

        .step:last-child::after {
            display: none;
        }

        .step.completed::after {
            background-color: var(--ebay-success);
        }

        /* Form Container */
        .form-container {
            background-color: white;
            border-radius: 8px;
            border: 1px solid var(--ebay-border);
            padding: 30px;
            margin-bottom: 20px;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--ebay-border);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--ebay-blue);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--ebay-border);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--ebay-blue);
        }

        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--ebay-border);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            min-height: 150px;
            resize: vertical;
            transition: border-color 0.2s;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--ebay-blue);
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group-text {
            padding: 12px 15px;
            background-color: var(--ebay-light-gray);
            border: 1px solid var(--ebay-border);
            border-right: none;
            border-radius: 8px 0 0 8px;
            font-size: 16px;
            color: var(--ebay-text);
        }

        .input-group .form-input {
            border-radius: 0 8px 8px 0;
        }

        /* Image Upload */
        .image-upload-container {
            margin-bottom: 20px;
        }

        .image-upload-area {
            border: 2px dashed var(--ebay-border);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .image-upload-area:hover {
            border-color: var(--ebay-blue);
            background-color: rgba(54, 101, 243, 0.05);
        }

        .image-upload-icon {
            font-size: 40px;
            color: var(--ebay-text-light);
            margin-bottom: 15px;
        }

        .image-upload-text {
            font-size: 16px;
            color: var(--ebay-text);
            margin-bottom: 5px;
        }

        .image-upload-subtext {
            font-size: 14px;
            color: var(--ebay-text-light);
        }

        .image-upload-input {
            display: none;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--ebay-border);
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-actions {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .image-preview-item:hover .image-preview-actions {
            opacity: 1;
        }

        .image-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            color: var(--ebay-text);
            transition: all 0.2s;
        }

        .image-action-btn:hover {
            transform: scale(1.1);
        }

        .image-action-btn.remove:hover {
            background-color: var(--ebay-error);
            color: white;
        }

        .image-action-btn.edit:hover {
            background-color: var(--ebay-blue);
            color: white;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 24px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background-color: var(--ebay-blue);
            color: white;
        }

        .btn-primary:hover {
            background-color: #2b4fb4;
        }

        .btn-secondary {
            background-color: white;
            color: var(--ebay-text);
            border: 1px solid var(--ebay-border);
        }

        .btn-secondary:hover {
            background-color: var(--ebay-light-gray);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-20px);
            transition: transform 0.3s;
        }

        .modal-overlay.active .modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--ebay-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--ebay-text-light);
        }

        .modal-close:hover {
            color: var(--ebay-text);
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--ebay-border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .form-container {
                padding: 20px;
            }

            .form-steps {
                flex-direction: column;
                gap: 15px;
            }

            .step {
                margin-right: 0;
            }

            .step::after {
                display: none;
            }

            .form-actions {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
            }
        }

        .form-actions {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            max-width: 1000px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .form-actions {
                flex-direction: row;
                gap: 10px;
                position: static;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Add a New Listing</h1>
            <p class="page-subtitle">Fill in the details below to list your product</p>
        </header>

        <div class="form-steps">
            <div class="step active" data-step="1"><div class="step-number">1</div><div class="step-label">Basic Info</div></div>
            <div class="step" data-step="2"><div class="step-number">2</div><div class="step-label">Images</div></div>
            <div class="step" data-step="3"><div class="step-number">3</div><div class="step-label">Pricing</div></div>
            <div class="step" data-step="4"><div class="step-number">4</div><div class="step-label">Details</div></div>
            <div class="step" data-step="5"><div class="step-number">5</div><div class="step-label">Finalize</div></div>
        </div>

        <form id="productForm" method="POST" enctype="multipart/form-data">
            <div class="form-container">
                <?php if (!empty($errors)): ?>
                    <div class="error-message"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                <?php endif; ?>

                <!-- Step 1: Basic Information -->
                <div class="form-section active" id="step1">
                    <div class="form-group">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" id="productName" name="name" class="form-input" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea id="productDescription" name="description" class="form-textarea" placeholder="Describe your product in detail" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productCategory" class="form-label">Category</label>
                        <select id="productCategory" name="category" class="form-select" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing & Accessories</option>
                            <option value="home">Home & Garden</option>
                            <option value="toys">Toys & Hobbies</option>
                            <option value="sports">Sporting Goods</option>
                            <option value="collectibles">Collectibles</option>
                            <option value="automotive">Automotive</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Step 2: Images -->
                <div class="form-section" id="step2">
                    <div class="form-group">
                        <label class="form-label">Product Images</label>
                        <div class="image-upload-container">
                            <div class="image-upload-area" id="imageUploadArea">
                                <div class="image-upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                                <div class="image-upload-text">Drag & drop images here or click to browse</div>
                                <div class="image-upload-subtext">Upload up to 10 images (JPEG, PNG, WebP)</div>
                                <input type="file" id="imageUpload" class="image-upload-input" accept="image/*" multiple>
                            </div>
                            <div class="image-preview-container" id="imagePreviewContainer"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Pricing -->
                <div class="form-section" id="step3">
                    <div class="form-group">
                        <label for="productPrice" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" id="productPrice" name="price" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="productQuantity" class="form-label">Stock Quantity</label>
                        <input type="number" id="productQuantity" name="quantity" class="form-input" placeholder="Enter quantity" min="1" required>
                    </div>
                </div>

                <!-- Step 4: Advanced Details -->
                <div class="form-section" id="step4">
                    <div class="form-group">
                        <label for="productBrand" class="form-label">Brand</label>
                        <select id="productBrand" name="brand_id" class="form-select">
                            <option value="">Select a category first</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productCondition" class="form-label">Condition</label>
                        <select id="productCondition" name="condition" class="form-select">
                            <option value="" disabled selected>Select condition</option>
                            <option value="new">New</option>
                            <option value="like-new">Like New</option>
                            <option value="excellent">Excellent</option>
                            <option value="good">Good</option>
                            <option value="fair">Fair</option>
                            <option value="for-parts">For Parts or Not Working</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productSKU" class="form-label">SKU/Item Number</label>
                        <input type="text" id="productSKU" name="sku" class="form-input" placeholder="Enter SKU or item number">
                    </div>
                    <div class="form-group">
                        <label for="productWeight" class="form-label">Weight</label>
                        <div class="input-group">
                            <input type="number" id="productWeight" name="weight" class="form-input" placeholder="Enter weight" step="0.01" min="0">
                            <select id="weightUnit" name="weightUnit" class="form-select" style="border-radius: 0 8px 8px 0; width: auto;">
                                <option value="lb">lb</option>
                                <option value="oz">oz</option>
                                <option value="kg">kg</option>
                                <option value="g">g</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="productDimensions" class="form-label">Dimensions (L × W × H)</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="productLength" name="length" class="form-input" placeholder="Length" step="0.1" min="0">
                            <input type="number" id="productWidth" name="width" class="form-input" placeholder="Width" step="0.1" min="0">
                            <input type="number" id="productHeight" name="height" class="form-input" placeholder="Height" step="0.1" min="0">
                            <select id="dimensionUnit" name="dimensionUnit" class="form-select" style="width: auto;">
                                <option value="in">in</option>
                                <option value="cm">cm</option>
                                <option value="mm">mm</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Finalize -->
                <div class="form-section" id="step5">
                    <div class="form-group">
                        <label for="productLocation" class="form-label">Location</label>
                        <select id="productLocation" name="location_id" class="form-select" required>
                            <option value="" disabled selected>Select location</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?php echo $location['id']; ?>">
                                    <?php echo htmlspecialchars($location['name'] . ' (' . $location['country_code'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="step" value="5">
                </div>
            </div>

            <div class="form-actions">
                <button type="button" id="prevBtn" class="btn btn-secondary" style="display: none;">Back</button>
                <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-primary" style="display: none;">Add Listing</button>
            </div>
        </form>
    </div>

    <!-- Image Alt Text Modal -->
    <div class="modal-overlay" id="imageModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Image Details</h3>
                <button type="button" class="modal-close" id="modalClose">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="imageAlt" class="form-label">Alt Text</label>
                    <input type="text" id="imageAlt" class="form-input" placeholder="Describe this image for accessibility">
                </div>
                <div class="form-group">
                    <label for="imageCaption" class="form-label">Caption (optional)</label>
                    <input type="text" id="imageCaption" class="form-input" placeholder="Add a caption for this image">
                </div>
                <div class="form-group">
                    <label class="form-label">Preview</label>
                    <div style="text-align: center; margin-top: 10px;">
                        <img id="modalImagePreview" src="/placeholder.svg" alt="Image preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalCancel">Cancel</button>
                <button type="button" class="btn btn-primary" id="modalSave">Save</button>
            </div>
        </div>
    </div>

    <!-- Draft Modal -->
    <div class="modal-overlay" id="draftModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Save Draft?</h3>
            </div>
            <div class="modal-body">
                <p>Would you like to save your progress as a draft or discard it?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="discardDraft" class="btn btn-secondary">Discard</button>
                <button type="button" id="saveDraft" class="btn btn-primary">Save Draft</button>
            </div>
        </div>
    </div>

    <script>
        const steps = document.querySelectorAll('.step');
        const formSections = document.querySelectorAll('.form-section');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('productForm');
        const draftModal = document.getElementById('draftModal');
        let currentStep = 1;

        function updateSteps() {
            steps.forEach(step => {
                const stepNum = parseInt(step.dataset.step);
                step.classList.remove('active', 'completed');
                if (stepNum === currentStep) step.classList.add('active');
                else if (stepNum < currentStep) step.classList.add('completed');
            });

            formSections.forEach((section, index) => {
                section.classList.toggle('active', index === currentStep - 1);
            });

            prevBtn.style.display = currentStep === 1 ? 'none' : 'block';
            nextBtn.style.display = currentStep === 5 ? 'none' : 'block';
            submitBtn.style.display = currentStep === 5 ? 'block' : 'none';
            saveFormState();
        }

        function saveFormState() {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => data[key] = value);
            localStorage.setItem('listingDraft', JSON.stringify(data));
        }

        function loadFormState() {
            const draft = localStorage.getItem('listingDraft');
            if (draft) {
                const data = JSON.parse(draft);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) input.value = data[key];
                });
                const category = document.getElementById('productCategory').value;
                if (category) loadBrands(category);
            }
        }

        nextBtn.addEventListener('click', () => {
            const currentSection = formSections[currentStep - 1];
            const requiredFields = currentSection.querySelectorAll('[required]');
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = 'red';
                    isValid = false;
                } else {
                    field.style.borderColor = '';
                }
            });
            if (!isValid) {
                alert('Please fill in all required fields.');
                return;
            }
            if (currentStep === 2 && uploadedImages.length === 0) {
                alert('Please upload at least one image.');
                return;
            }
            currentStep++;
            updateSteps();
        });

        prevBtn.addEventListener('click', () => {
            currentStep--;
            updateSteps();
        });

        window.addEventListener('beforeunload', (e) => {
            const inputs = form.querySelectorAll('input, select, textarea');
            let hasData = false;
            inputs.forEach(input => {
                if (input.value.trim()) hasData = true;
            });
            if (hasData) {
                e.preventDefault();
                draftModal.classList.add('active');
                return false;
            }
        });

        document.getElementById('saveDraft').addEventListener('click', () => {
            saveFormState();
            draftModal.classList.remove('active');
            window.location.reload();
        });

        document.getElementById('discardDraft').addEventListener('click', () => {
            localStorage.removeItem('listingDraft');
            draftModal.classList.remove('active');
            window.location.reload();
        });

        // Load brands dynamically based on category
        async function loadBrands(category) {
            const response = await fetch(`brand.php?category=${encodeURIComponent(category)}`);
            const brands = await response.json();
            const brandSelect = document.getElementById('productBrand');
            brandSelect.innerHTML = '<option value="">Select a brand (optional)</option>';
            brands.forEach(brand => {
                brandSelect.innerHTML += `<option value="${brand.id}">${brand.name}</option>`;
            });
        }

        document.getElementById('productCategory').addEventListener('change', (e) => {
            const category = e.target.value;
            if (category) loadBrands(category);
            else {
                const brandSelect = document.getElementById('productBrand');
                brandSelect.innerHTML = '<option value="">Select a category first</option>';
            }
        });

        // Image handling (unchanged from your code)
        const imageUploadArea = document.getElementById('imageUploadArea');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imageModal = document.getElementById('imageModal');
        const modalClose = document.getElementById('modalClose');
        const modalCancel = document.getElementById('modalCancel');
        const modalSave = document.getElementById('modalSave');
        const imageAlt = document.getElementById('imageAlt');
        const imageCaption = document.getElementById('imageCaption');
        const modalImagePreview = document.getElementById('modalImagePreview');
        let currentEditingImage = null;
        let uploadedImages = [];

        imageUploadArea.addEventListener('click', () => imageUpload.click());

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            imageUploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            imageUploadArea.addEventListener(eventName, () => {
                imageUploadArea.style.borderColor = 'var(--ebay-blue)';
                imageUploadArea.style.backgroundColor = 'rgba(54, 101, 243, 0.05)';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            imageUploadArea.addEventListener(eventName, () => {
                imageUploadArea.style.borderColor = '';
                imageUploadArea.style.backgroundColor = '';
            });
        });

        imageUploadArea.addEventListener('drop', e => handleFiles(e.dataTransfer.files));
        imageUpload.addEventListener('change', () => handleFiles(imageUpload.files));

        function handleFiles(files) {
            if (uploadedImages.length + files.length > 10) {
                alert('You can upload a maximum of 10 images.');
                return;
            }

            [...files].forEach(file => {
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const imageData = {
                            id: Date.now() + Math.random().toString(36).substr(2, 9),
                            src: e.target.result,
                            file: file,
                            alt: '',
                            caption: '',
                            index: uploadedImages.length
                        };
                        uploadedImages.push(imageData);
                        displayImage(imageData);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        function displayImage(imageData) {
            const imageItem = document.createElement('div');
            imageItem.className = 'image-preview-item';
            imageItem.dataset.id = imageData.id;

            const img = document.createElement('img');
            img.src = imageData.src;
            img.className = 'image-preview';
            img.alt = imageData.alt || 'Product image';

            const actions = document.createElement('div');
            actions.className = 'image-preview-actions';

            const editBtn = document.createElement('button');
            editBtn.className = 'image-action-btn edit';
            editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
            editBtn.addEventListener('click', () => openImageModal(imageData.id));

            const removeBtn = document.createElement('button');
            removeBtn.className = 'image-action-btn remove';
            removeBtn.innerHTML = '<i class="bi bi-trash"></i>';
            removeBtn.addEventListener('click', () => removeImage(imageData.id));

            const hiddenInputs = `
                <input type="hidden" name="image_${imageData.index}_alt" value="${imageData.alt}">
                <input type="hidden" name="image_${imageData.index}_caption" value="${imageData.caption}">
            `;
            imageItem.innerHTML = hiddenInputs;

            actions.appendChild(editBtn);
            actions.appendChild(removeBtn);
            imageItem.appendChild(img);
            imageItem.appendChild(actions);
            imagePreviewContainer.appendChild(imageItem);

            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = `image_${imageData.index}`;
            fileInput.style.display = 'none';
            fileInput.files = createFileList(imageData.file);
            imagePreviewContainer.appendChild(fileInput);
        }

        function createFileList(file) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            return dataTransfer.files;
        }

        function removeImage(id) {
            if (confirm('Are you sure you want to remove this image?')) {
                uploadedImages = uploadedImages.filter(img => img.id !== id);
                const imageItem = document.querySelector(`.image-preview-item[data-id="${id}"]`);
                if (imageItem) imageItem.remove();
                updateImageIndexes();
            }
        }

        function updateImageIndexes() {
            uploadedImages.forEach((img, index) => {
                img.index = index;
                const item = document.querySelector(`.image-preview-item[data-id="${img.id}"]`);
                if (item) {
                    item.querySelector(`input[name^="image_"]`).name = `image_${index}_alt`;
                    item.querySelector(`input[name^="image_"] + input`).name = `image_${index}_caption`;
                    const fileInput = imagePreviewContainer.querySelector(`input[name="image_${index}"]`);
                    if (fileInput) fileInput.name = `image_${index}`;
                }
            });
        }

        function openImageModal(id) {
            const imageData = uploadedImages.find(img => img.id === id);
            if (imageData) {
                currentEditingImage = imageData;
                imageAlt.value = imageData.alt || '';
                imageCaption.value = imageData.caption || '';
                modalImagePreview.src = imageData.src;
                imageModal.classList.add('active');
            }
        }

        function closeImageModal() {
            imageModal.classList.remove('active');
            if (currentEditingImage) {
                const item = document.querySelector(`.image-preview-item[data-id="${currentEditingImage.id}"]`);
                if (item) {
                    item.querySelector(`input[name="image_${currentEditingImage.index}_alt"]`).value = imageAlt.value;
                    item.querySelector(`input[name="image_${currentEditingImage.index}_caption"]`).value = imageCaption.value;
                }
                currentEditingImage.alt = imageAlt.value;
                currentEditingImage.caption = imageCaption.value;
            }
            currentEditingImage = null;
        }

        modalClose.addEventListener('click', closeImageModal);
        modalCancel.addEventListener('click', closeImageModal);
        modalSave.addEventListener('click', closeImageModal);

        loadFormState();
        updateSteps();
    </script>
</body>
</html>