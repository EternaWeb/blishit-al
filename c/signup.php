<?php
// Start session
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'trevali_db';
$username = 'root'; // Default localhost username
$password = '';     // Default localhost password (empty)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Email already registered.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $username = strtolower(str_replace(' ', '', $full_name));

            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, username) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$full_name, $email, $hashed_password, $username])) {
                // Auto-login after signup
                $user_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'user';
                $_SESSION['token'] = bin2hex(random_bytes(32));

                header("Location: profile.php");
                exit;
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Trevali</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--ebay-text-light);
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: var(--ebay-border);
        }

        .divider::before {
            margin-right: 15px;
        }

        .divider::after {
            margin-left: 15px;
        }

        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid var(--ebay-border);
            border-radius: 24px;
            background-color: white;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .social-button:hover {
            background-color: var(--ebay-light-gray);
        }

        .social-icon {
            font-size: 20px;
        }

        .auth-footer {
            text-align: center;
            font-size: 14px;
            color: var(--ebay-text-light);
        }

        .auth-footer a {
            color: var(--ebay-blue);
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
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
    <header class="header">
        <div class="container">
            <a href="#"><img src="blishit.png" alt="Tervali Logo" class="logo"></a>
        </div>
    </header>

    <main class="main-content">
        <div class="auth-container">
            <div class="auth-header">
                <h1 class="auth-title">Create an account</h1>
                <p class="auth-subtitle">Sign up to start shopping and selling on Trevali</p>
            </div>

            <form class="auth-form" method="POST" action="signup.php">
                <?php if (isset($error)): ?>
                    <p style="color: red; text-align: center;"><?php echo $error; ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email address" autocomplete="username" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Create a password" autocomplete="new-password" required>
                </div>

                <button type="submit" class="form-button">Create account</button>

                <div class="divider">or</div>

                <div class="social-buttons">
                    <button type="button" class="social-button">
                        <i class="bi bi-google social-icon"></i>
                        Continue with Google
                    </button>
                </div>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="login.php">Sign in</a>
            </div>
        </div>
    </main>

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
                    © 1995-2025 Blishit Inc. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>