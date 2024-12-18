<!DOCTYPE HTML> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAID - Register</title>
    <link rel="stylesheet" href="../styles/register_proc.css">
</head>
<body>
    <div class="container">
        <h1>MedAID</h1>
        <p>Sign up to start your journey to better health with personalized insights and health risk prediction.</p>

        <div class="form-container">
            <h2>Register</h2>

            <!-- Display error messages -->
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form id="signup-form" action="../backend/register_proc.inc.php" method="POST">
                <!-- Full Name -->
                <div class="input-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>" required>
                </div>

                <!-- Age -->
                <div class="input-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" placeholder="Enter your age" value="<?php echo isset($age) ? htmlspecialchars($age) : ''; ?>" required min="1" max="120">
                </div>

                <!-- Gender -->
                <div class="input-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="male" <?php echo isset($gender) && $gender == 'male' ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo isset($gender) && $gender == 'female' ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo isset($gender) && $gender == 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <!-- Email -->
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit">Sign Up</button>
            </form>

            <p class="switch-text">
                Already have an account? <a href="../public/login.php">Login</a>
            </p>

            <!-- Back to Home Button -->
            <a href="../index.php">
                <button type="button" class="back-button">Back to Home</button>
            </a>
        </div>
    </div>
</body>
</html>
