<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page after a short delay
header("Refresh: 2; url=login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - Blishit Tregu Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ebay-blue: #3665f3;
            --ebay-light-gray: #f8f8f8;
            --ebay-border: #e5e5e5;
            --ebay-red: #e53238;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--ebay-light-gray);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .logout-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .logout-container h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 10px 0;
        }

        .logout-container p {
            font-size: 16px;
            color: #666;
            margin: 0 0 20px 0;
        }

        .spinner {
            display: inline-block;
            width: 24px;
            height: 24px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--ebay-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .redirect-link {
            color: var(--ebay-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .redirect-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h1>Logging Out</h1>
        <p>You have been logged out successfully. Redirecting to login page...</p>
        <div class="spinner"></div>
        <p><a href="login.php" class="redirect-link">Click here if not redirected</a></p>
    </div>
</body>
</html>