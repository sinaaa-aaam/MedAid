<?php 
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'superadmin') {
    header('Location: index.php');
    exit();
}

require_once "../db/config.php";

$error = $_GET['error'] ?? '';
$successMessage = $_GET['success'] ?? '';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../styles/manage_user.css">
</head>
<body>
    <header class="admin-header">
        <h1>Manage Users</h1>
        <nav>
            <a href="../logout.php">Logout</a>
            <a href="../admin/admin_dashboard.php">Back to Dashboard</a>
        </nav>
    </header>

    <main>
        <!-- Feedback Section -->
        <section class="messages">
            <?php if (!empty($successMessage)): ?>
                <p class="success-message"><?= htmlspecialchars($successMessage) ?></p>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </section>

        <!-- Search Users -->
        <section class="manage-users">
            <h2>Search Users</h2>
            <form action="./search_user.php" method="POST">
                <label for="email">Search User by Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter user email" required>
                <button type="submit" name="search_user">Search</button>
            </form>
        </section>

        <!-- Update User Role -->
        <section class="manage-users">
            <h2>Update User Role</h2>
            <form action="./update_user.php" method="POST">
                <label for="email_to_update">User Email:</label>
                <input type="email" id="email_to_update" name="email_to_update" placeholder="Enter user email" required>

                <label for="new_role">New Role:</label>
                <select id="new_role" name="new_role" required>
                    <option value="superadmin">Superadmin</option>
                    <option value="regular">Regular</option>
                </select>

                <button type="submit" name="update_user">Update Role</button>
            </form>
        </section>

        <!-- Delete User -->
        <section class="manage-users">
            <h2>Delete User</h2>
            <form action="./delete_user.php" method="POST">
                <label for="email_to_delete">User Email:</label>
                <input type="email" id="email_to_delete" name="email_to_delete" placeholder="Enter user email" required>
                <button type="submit" name="delete_user">Delete User</button>
            </form>
        </section>
    </main>
</body>
</html>
