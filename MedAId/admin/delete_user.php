<?php
require_once "../db/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $emailToDelete = trim($_POST['email_to_delete']);
    if (!empty($emailToDelete)) {
        try {
            $stmt = $db->prepare('DELETE FROM users WHERE email = :email');
            $stmt->execute([':email' => $emailToDelete]);
            $successMessage = "User deleted successfully.";
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    } else {
        $error = 'Please provide an email to delete.';
    }
}
?>
