<?php
// Include database connection
require_once "../db/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input
    $full_name = trim($_POST['full_name']); // updated to 'full_name'
    $age = trim($_POST['age']); // added 'age'
    $gender = trim($_POST['gender']); // added 'gender'
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if the email is the superadmin email
    $user_role = ($email === 'ameteweesinam413@gmail.com') ? 'superadmin' : 'regular'; // Assign superadmin role to this email

    // Error messages
    $errors = [];

    // Validate input
    if (empty($full_name) || empty($age) || empty($gender) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = 'Please fill in all fields.';
    } elseif ($confirm_password != $password) {
        $errors[] = 'Passwords do not match.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Validate age (must be between 1 and 120)
    if ($age < 1 || $age > 120) {
        $errors[] = 'Please enter a valid age between 1 and 120.';
    }

    // Validate gender
    $valid_genders = ['male', 'female', 'other'];
    if (!in_array($gender, $valid_genders)) {
        $errors[] = 'Please select a valid gender.';
    }

    // Check if email already exists in the database
    if (empty($errors)) {
        try {
            // Check if the email already exists
            $stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                $errors[] = 'Email is already registered.';
            } else {
                // Hash password and insert into the database
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $query = $db->prepare(
                    "INSERT INTO users (full_name, age, gender, email, password, user_role, created_at) 
                    VALUES (:full_name, :age, :gender, :email, :password, :user_role, NOW())"
                );
                $query->execute([
                    ':full_name' => $full_name,
                    ':age' => $age,
                    ':gender' => $gender,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':user_role' => $user_role,
                ]);

                // Redirect to login page on success
                header('Location: ../public/login.php?success=registered');
                exit();
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Display errors if there are any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
    }
}
?>
