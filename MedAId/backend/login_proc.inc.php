<?php 
require_once "../db/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = 'Please fill in all fields.';
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare('SELECT id, full_name, password, user_role FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['full_name'];
                    $_SESSION['user_role'] = $user['user_role'];
                    $_SESSION['logged_in'] = true;

                    if ($user['user_role'] === 'superadmin' || $email === 'ameteweesinam413@gmail.com') {
                        header("Location: ../admin/admin_dashboard.php");
                     } else {
                        header("Location: ../public/user_form.php");
                    }
                    exit();
                } else {
                    $errors[] = 'Incorrect password.';
                }
            } else {
                $errors[] = 'Email not found.';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        header("Location: ../public/login.php?error=" . urlencode(implode(", ", $errors)));
        exit();
    }
}
?>
