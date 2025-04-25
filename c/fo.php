<?php
// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bug", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Error and success message variables
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_product'])) {
    try {
        // Collect form data
        $category_id = $_POST['category'];
        $subcategory_id = $_POST['subcategory'];
        $brand_id = $_POST['brand'];
        $model_id = $_POST['model'];
        $title = $_POST['title'];
        $condition = $_POST['condition'];
        $location_id = $_POST['location'];
        $shipping_options = $_POST['shipping'] ?? [];
        $keywords = $_POST['keywords'];
        $description = $_POST['description'];
        $alt_texts = $_POST['alt_text'] ?? [];

        // Validate required fields
        if (empty($category_id) || empty($subcategory_id) || empty($brand_id) || empty($model_id) || empty($title) || empty($condition) || empty($location_id) || empty($description)) {
            throw new Exception("All required fields must be filled.");
        }

        // Insert into products table
        $stmt = $pdo->prepare("INSERT INTO products (model_id, title, `condition`, location_id, keywords, description, like_count, view_count, created_at) VALUES (?, ?, ?, ?, ?, ?, 0, 0, NOW())");
        $stmt->execute([$model_id, $title, $condition, $location_id, $keywords, $description]);
        $product_id = $pdo->lastInsertId();

        // Insert shipping options
        if (!empty($shipping_options)) {
            $stmt = $pdo->prepare("INSERT INTO product_shipping_options (product_id, shipping_option_id) VALUES (?, ?)");
            foreach ($shipping_options as $shipping_option_id) {
                $stmt->execute([$product_id, $shipping_option_id]);
            }
        }

        // Handle image uploads
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $key => $name) {
                if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['images']['tmp_name'][$key];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $filename = uniqid() . '.' . $ext;
                    $destination = $upload_dir . $filename;
                    if (move_uploaded_file($tmp_name, $destination)) {
                        $alt_text = $alt_texts[$key] ?? 'Product Image';
                        $stmt = $pdo->prepare("INSERT INTO product_images (product_id, image_url, alt_text) VALUES (?, ?, ?)");
                        $stmt->execute([$product_id, $destination, $alt_text]);
                    } else {
                        throw new Exception("Failed to upload image: " . $name);
                    }
                }
            }
        } else {
            throw new Exception("At least one image is required.");
        }

        // Insert specifications
        $spec_keys = $_POST['spec_key'] ?? [];
        $spec_values = $_POST['spec_value'] ?? [];
        foreach ($spec_keys as $index => $key) {
            if (!empty($key) && !empty($spec_values[$index])) {
                $stmt = $pdo->prepare("INSERT INTO product_specifications (product_id, spec_name, spec_value) VALUES (?, ?, ?)");
                $stmt->execute([$product_id, $key, $spec_values[$index]]);
            }
        }

        $success_message = "Product added successfully!";
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Fetch initial dropdown options
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$locations = $pdo->query("SELECT * FROM locations")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .image-preview-container { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .image-preview-item { position: relative; }
        .image-preview { width: 100px; height: 100px; object-fit: cover; }
        .remove { position: absolute; top: 0; right: 0; background: red; color: white; border: none; cursor: pointer; padding: 2px 5px; }
        .spec-row { display: flex; gap: 10px; margin-bottom: 10px; }
        .spec-row input { flex: 1; }
        .error { color: red; margin-bottom: 20px; }
        .success { color: green; margin-bottom: 20px; }
        button[type="submit"] { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button[type="button"] { background: #007bff; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <h1>Add Product</h1>
    <form method="post" enctype="multipart/form-data">
        <h2>Product Category and Model</h2>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" required>
                <option value="">Select category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="subcategory">Subcategory</label>
            <select name="subcategory" id="subcategory" required disabled>
                <option value="">Select subcategory</option>
            </select>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <select name="brand" id="brand" required disabled>
                <option value="">Select brand</option>
            </select>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <select name="model" id="model" required disabled>
                <option value="">Select model</option>
            </select>
        </div>

        <h2>Product Details</h2>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="condition">Condition</label>
            <select name="condition" id="condition" required>
                <option value="">Select condition</option>
                <option value="New">New</option>
                <option value="Like New">Like New</option>
                <option value="Good">Good</option>
                <option value="Fair">Fair</option>
                <option value="Solid">Solid</option>
                <option value="Bad">Bad</option>
            </select>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <select name="location" id="location" required>
                <option value="">Select location</option>
                <?php foreach ($locations as $loc): ?>
                    <option value="<?php echo $loc['location_id']; ?>"><?php echo $loc['location_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <h2>Shipping Options</h2>
        <div id="shipping-options"></div>

        <h2>Description and Keywords</h2>
        <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" name="keywords" id="keywords">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" required></textarea>
        </div>

        <h2>Images</h2>
        <div class="form-group">
            <label for="images">Upload Images</label>
            <input type="file" name="images[]" id="image-upload" multiple required>
            <div id="image-preview-container" class="image-preview-container"></div>
        </div>

        <h2>Specifications</h2>
        <div id="specs-container">
            <?php $default_specs = ['Weight', 'Color', 'Dimensions', 'Material', 'Warranty']; ?>
            <?php foreach ($default_specs as $spec): ?>
                <div class="spec-row">
                    <input type="text" name="spec_key[]" value="<?php echo $spec; ?>" readonly>
                    <input type="text" name="spec_value[]" placeholder="Value for <?php echo $spec; ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-spec-btn">Add Specification</button>

        <button type="submit" name="submit_product">Submit Listing</button>
    </form>

    <script>
        // Dynamic dropdowns
        const categorySelect = document.getElementById('category');
        const subcategorySelect = document.getElementById('subcategory');
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');
        const locationSelect = document.getElementById('location');
        const shippingOptions = document.getElementById('shipping-options');

        categorySelect.addEventListener('change', () => {
            const categoryId = categorySelect.value;
            fetch(`fetch_options.php?type=subcategories&category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    subcategorySelect.innerHTML = '<option value="">Select subcategory</option>' + data.map(item => `<option value="${item.subcategory_id}">${item.subcategory_name}</option>`).join('');
                    subcategorySelect.disabled = false;
                    brandSelect.innerHTML = '<option value="">Select brand</option>';
                    brandSelect.disabled = true;
                    modelSelect.innerHTML = '<option value="">Select model</option>';
                    modelSelect.disabled = true;
                });
        });

        subcategorySelect.addEventListener('change', () => {
            const subcategoryId = subcategorySelect.value;
            fetch(`fetch_options.php?type=brands&subcategory_id=${subcategoryId}`)
                .then(response => response.json())
                .then(data => {
                    brandSelect.innerHTML = '<option value="">Select brand</option>' + data.map(item => `<option value="${item.brand_id}">${item.brand_name}</option>`).join('');
                    brandSelect.disabled = false;
                    modelSelect.innerHTML = '<option value="">Select model</option>';
                    modelSelect.disabled = true;
                });
        });

        brandSelect.addEventListener('change', () => {
            const subcategoryId = subcategorySelect.value;
            const brandId = brandSelect.value;
            fetch(`fetch_options.php?type=models&subcategory_id=${subcategoryId}&brand_id=${brandId}`)
                .then(response => response.json())
                .then(data => {
                    modelSelect.innerHTML = '<option value="">Select model</option>' + data.map(item => `<option value="${item.model_id}">${item.model_name}</option>`).join('');
                    modelSelect.disabled = false;
                });
        });

        locationSelect.addEventListener('change', () => {
            const locationId = locationSelect.value;
            fetch(`fetch_options.php?type=shipping&location_id=${locationId}`)
                .then(response => response.json())
                .then(data => {
                    shippingOptions.innerHTML = data.map((item, index) => `
                        <div>
                            <input type="checkbox" name="shipping[]" value="${item.shipping_option_id}" id="shipping-${index}">
                            <label for="shipping-${index}">${item.name}</label>
                        </div>
                    `).join('');
                });
        });

        // Image upload and preview
        const imageUpload = document.getElementById('image-upload');
        const imagePreviewContainer = document.getElementById('image-preview-container');

        imageUpload.addEventListener('change', () => {
            imagePreviewContainer.innerHTML = '';
            Array.from(imageUpload.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const item = document.createElement('div');
                    item.className = 'image-preview-item';
                    item.innerHTML = `
                        <img src="${e.target.result}" class="image-preview">
                        <input type="text" name="alt_text[]" placeholder="Alt text" value="Product Image ${index + 1}">
                        <button type="button" class="remove">Remove</button>
                    `;
                    item.querySelector('.remove').addEventListener('click', () => {
                        item.remove();
                        const dt = new DataTransfer();
                        Array.from(imageUpload.files).forEach((f, i) => {
                            if (i !== index) dt.items.add(f);
                        });
                        imageUpload.files = dt.files;
                    });
                    imagePreviewContainer.appendChild(item);
                };
                reader.readAsDataURL(file);
            });
        });

        // Add specification
        const addSpecBtn = document.getElementById('add-spec-btn');
        const specsContainer = document.getElementById('specs-container');

        addSpecBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'spec-row';
            row.innerHTML = `
                <input type="text" name="spec_key[]" placeholder="Specification">
                <input type="text" name="spec_value[]" placeholder="Value">
            `;
            specsContainer.appendChild(row);
        });
    </script>
</body>
</html>