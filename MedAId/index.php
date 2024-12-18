<?php
session_start();

// Log the user out by destroying the session
session_unset();
session_destroy();

// Start a fresh session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAId - Medical Assistance Platform</title>
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><span>MedAId</span></div>
        <div class="links">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="./public/login.php">Login</a>
                <a href="./public/register_proc.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <img src="./assets/images/MedAId.jpg" alt="MedAId Image">
            <h1>Welcome to MedAId</h1>
            <p>Your trusted platform for medical assistance, resources, and healthcare solutions.</p>
            <div class="action-buttons">
                <a href="./public/register_proc.php" class="btn">Get Started</a>
                <a href="./public/login.php" class="btn">Login</a>
                <a href="view/about.php" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </div>

    <footer><p>&copy; 2024 MedAId. All Rights Reserved.</p></footer>
</body>
</html>
