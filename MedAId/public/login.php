
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAid - Login</title>
    <link rel="stylesheet" href="../styles/register_proc.css">
</head>
<body>
    <main class="login-container">
        <section class="form-section">
            <div class="brand-logo"><h1>MedAid</h1></div>
            <div class="form-content">
                <h2>Welcome Back!</h2>
                <p class="subtitle">Log in to your personalized health assistant</p>

                <?php
                session_start();

                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                    header("Location: user_form.php");
                    exit;
                }

                if (isset($_GET['error'])) {
                    echo "<p class='error-message'>" . htmlspecialchars($_GET['error']) . "</p>";
                }
                ?>

                <form class="login-form" action="../backend/login_proc.inc.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                    </div>
                    <button type="submit" class="submit-btn">Log In</button>
                </form>

                <div class="register-link">
                    <p>Don't have an account? <a href="../public/register_proc.php">Sign up</a></p>
                </div>
                <a href="../index.php"><button type="button" class="back-button">Back to Home</button></a>
            </div>
        </section>
    </main>
</body>
</html>
