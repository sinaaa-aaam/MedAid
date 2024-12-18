<?php
require_once "../db/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $newName = trim($_POST['new_full_name']);
    $newAge = intval($_POST['new_age']);
    $newGender = trim($_POST['new_gender']);
    $newEmail = trim($_POST['new_email']);
    $newPassword = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);
    $newRole = trim($_POST['new_user_role']);

    if (!empty($newName) && !empty($newAge) && !empty($newGender) && !empty($newEmail) && !empty($newPassword) && !empty($newRole)) {
        try {
            $stmt = $db->prepare('INSERT INTO users (full_name, age, gender, email, password, user_role) VALUES (:full_name, :age, :gender, :email, :password, :user_role)');
            $stmt->execute([
                ':full_name' => $newName,
                ':age' => $newAge,
                ':gender' => $newGender,
                ':email' => $newEmail,
                ':password' => $newPassword,
                ':user_role' => $newRole,
            ]);
            $successMessage = "User created successfully.";
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    } else {
        $error = 'Please fill in all fields to create a new user.';
    }
}
?>
