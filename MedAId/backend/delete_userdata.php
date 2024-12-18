<?php
// Start session
session_start();

// Include the configuration file for database connection
require_once '../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Get the health data ID from the request
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: Missing health data ID.");
}

try {
    // Prepare the DELETE query
    $query = $db->prepare("DELETE FROM health_metrics WHERE id = :id AND user_id = :user_id");
    $query->execute([
        ':id' => $id,
        ':user_id' => $user_id,
    ]);

    // Redirect back to the dashboard
    header("Location: ../public/user_dashboard2.php");
    exit;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
