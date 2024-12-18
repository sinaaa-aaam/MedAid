<?php 
session_start();
require_once '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../public/user_dashboard2.php?error=Missing+data+ID");
    exit;
}

try {
    $query = $db->prepare("DELETE FROM health_metrics WHERE id = :id AND user_id = :user_id");
    $query->execute([':id' => $id, ':user_id' => $user_id]);
    header("Location: ../public/user_dashboard2.php?success=Data+deleted");
    exit;
} catch (PDOException $e) {
    header("Location: ../public/user_dashboard2.php?error=" . urlencode($e->getMessage()));
    exit;
}
?>
