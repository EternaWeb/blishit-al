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
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch current user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
    $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);

    // Handle profile picture upload
    $profile_picture = $user['profile_picture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_picture'];
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_name = 'user_' . $user['id'] . '_' . time() . '.' . $ext;
            $upload_path = 'uploads/' . $new_name;

            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                $profile_picture = $upload_path;
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid image type or size (max 2MB, JPG/PNG only).";
        }
    }

    if (!isset($error)) {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ?, bio = ?, location = ?, profile_picture = ? WHERE id = ?");
        $stmt->execute([$full_name, $bio, $location, $profile_picture, $_SESSION['user_id']]);
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
    <title>Edit Profile - Trevali</title>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
        :root {
            --ebay-blue: #3665f3;
            --ebay-light-gray: #f8f8f8;
            --ebay-border: #e5e5e5;
            --ebay-text: #333;
            --ebay-text-light: #767676;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            padding: 20px;
            border-bottom: 1px solid var(--ebay-border);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            height: 40px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .auth-container {
            max-width: 450px;
            width: 100%;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .auth-subtitle {
            color: var(--ebay-text-light);
            font-size: 16px;
        }

        .auth-form {
            background-color: white;
            border-radius: 8px;
            border: 1px solid var(--ebay-border);
            padding: 30px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
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

        .form-button {
            width: 100%;
            padding: 14px;
            background-color: var(--ebay-blue);
            color: white;
            border: none;
            border-radius: 24px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .form-button:hover {
            background-color: #2b4fb4;
        }

        /* Footer */
        .footer {
            background-color: var(--ebay-light-gray);
            padding: 30px 0;
            border-top: 1px solid var(--ebay-border);
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-link {
            color: var(--ebay-text-light);
            text-decoration: none;
            font-size: 14px;
        }

        .footer-link:hover {
            color: var(--ebay-blue);
            text-decoration: underline;
        }

        .footer-copyright {
            color: var(--ebay-text-light);
            font-size: 14px;
        }

        /* Custom styles for edit profile */
        .profile-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 20px auto;
            display: block;
            border: 1px solid var(--ebay-border);
        }

        .cropper-container {
            max-width: 400px;
            margin: 20px auto;
            border: 1px solid var(--ebay-border);
            border-radius: 8px;
            overflow: hidden;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 100px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .auth-form {
                padding: 20px;
            }

            .footer-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <a href="profile.php">
                <img src="blishit.png" alt="Trevali Logo" class="logo">
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="auth-container">
            <div class="auth-header">
                <h1 class="auth-title">Edit Profile</h1>
                <p class="auth-subtitle">Update your personal information</p>
            </div>

            <form method="POST" enctype="multipart/form-data" class="auth-form">
                <?php if (isset($error)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-input" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea id="bio" name="bio" class="form-input"><?php echo htmlspecialchars($user['bio'] ?: ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-input" value="<?php echo htmlspecialchars($user['location'] ?: ''); ?>">
                </div>
                <div class="form-group">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png" class="form-input">
                    <img id="preview" src="<?php echo htmlspecialchars($user['profile_picture'] ?: '/placeholder.svg?height=150&width=150'); ?>" alt="Preview" class="profile-preview">
                    <div id="cropper-container" class="cropper-container" style="display: none;">
                        <img id="image-to-crop">
                    </div>
                </div>
                <button type="submit" class="form-button">Save Changes</button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#" class="footer-link">About</a>
                    <a href="#" class="footer-link">Help & Contact</a>
                    <a href="#" class="footer-link">Policies</a>
                    <a href="#" class="footer-link">Affiliates</a>
                    <a href="#" class="footer-link">Sitemap</a>
                </div>
                <div class="footer-copyright">
                    © 1995-2025 Trevali Inc. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Cropper.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        const input = document.getElementById('profile_picture');
        const preview = document.getElementById('preview');
        const cropperContainer = document.getElementById('cropper-container');
        const imageToCrop = document.getElementById('image-to-crop');
        let cropper;

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    cropperContainer.style.display = 'block';
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1,
                        viewMode: 1,
                        preview: '#preview',
                        crop() {
                            const canvas = this.cropper.getCroppedCanvas({ width: 150, height: 150 });
                            preview.src = canvas.toDataURL('image/jpeg');
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>