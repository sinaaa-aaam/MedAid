<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Restrict access to logged-in superadmin users
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'superadmin') {
    header('Location: index.php');
    exit();
}

require_once "../db/config.php";

// Initialize variables for error and success messages
$error = '';
$successMessage = '';

// Process form submission when 'update_user' is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    // Check if both email and new role are provided
    if (isset($_POST['email_to_update']) && isset($_POST['new_role'])) {
        $email_to_update = $_POST['email_to_update'];
        $new_role = $_POST['new_role'];

        // Prepare SQL query to update user role
        $query = "UPDATE users SET user_role = :new_role WHERE email = :email";
        $stmt = $pdo->prepare($query);

        // Execute the query
        try {
            $stmt->execute([
                ':new_role' => $new_role,
                ':email' => $email_to_update
            ]);

            // Check if any row was affected
            if ($stmt->rowCount() > 0) {
                $successMessage = "User role updated successfully.";
            } else {
                $error = "No user found with that email.";
            }
        } catch (PDOException $e) {
            $error = "Error updating user role: " . $e->getMessage();
        }
    } else {
        $error = "Please provide both email and a new role.";
    }
}

