<?php
require_once "../db/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $emailToDelete = filter_var(trim($_POST['email_to_delete']), FILTER_VALIDATE_EMAIL);
    
    if ($emailToDelete) {
        try {
            $stmt = $db->prepare('DELETE FROM users WHERE email = :email');
            $stmt->execute([':email' => $emailToDelete]);
            header("Location: ./manage_users.php?success=User+deleted+successfully");
            exit;
        } catch (PDOException $e) {
            header("Location: ./manage_users.php?error=" . urlencode("Database error: " . $e->getMessage()));
            exit;
        }
    } else {
        header("Location: ./manage_users.php?error=Invalid+email+address");
        exit;
    }
}
?>
