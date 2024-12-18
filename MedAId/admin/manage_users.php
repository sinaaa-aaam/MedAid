<?php
session_start();

// Restrict access to logged-in superadmin users
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 'superadmin') {
    header('Location: index.php');
    exit();
}

require_once "../db/config.php";

// Include modular backend files
$error = '';
$successMessage = '';
$searchResult = [];

include "../admin/search_user.php";
include "../admin/delete_user.php";
include "../admin/update_user.php";
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
        <section class="messages">
            <?php if (!empty($successMessage)): ?>
                <p class="success-message"><?= htmlspecialchars($successMessage) ?></p>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </section>

        <section class="manage-users">
            <h2>Search Users</h2>
            <form action="../admin/search_user.php" method="POST">
                <label for="email">Search User by Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter user email">
                <button type="submit" name="search_user">Search</button>
            </form>
        </section>

        <?php if (!empty($searchResult)): ?>
            <section class="search-results">
                <h2>Search Results</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResult as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['full_name']) ?></td>
                                <td><?= htmlspecialchars($user['age']) ?></td>
                                <td><?= htmlspecialchars($user['gender']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['user_role']) ?></td>
                                <td><?= htmlspecialchars($user['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>

        
                <!-- Update user role form -->
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


        <!-- Delete user -->
        <section class="manage-users">
            <h2>Delete User</h2>
            <form action="./delete_user.php" method="POST">
                <label for="email_to_delete">User Email:</label>
                <input type="email" id="email_to_delete" name="email_to_delete" placeholder="Enter user email">
                <button type="submit" name="delete_user">Delete User</button>
            </form>
        </section>
    </main>
</body>
</html>
