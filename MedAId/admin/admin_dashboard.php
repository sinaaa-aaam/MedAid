<?php
session_start();
require_once "../db/config.php";

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'superadmin') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch user statistics
try {
    $userCountStmt = $db->query("SELECT COUNT(*) AS count FROM users");
    $userCount = $userCountStmt->fetch(PDO::FETCH_ASSOC)['count'];

    $adminCountStmt = $db->query("SELECT COUNT(*) AS count FROM users WHERE user_role = 'superadmin'");
    $adminCount = $adminCountStmt->fetch(PDO::FETCH_ASSOC)['count'];

    $regularCountStmt = $db->query("SELECT COUNT(*) AS count FROM users WHERE user_role = 'regular'");
    $regularCount = $regularCountStmt->fetch(PDO::FETCH_ASSOC)['count'];

    $recentUsersStmt = $db->query("SELECT full_name, email, created_at FROM users ORDER BY created_at DESC LIMIT 5");
    $recentUsers = $recentUsersStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
</head>
<body>
    <header class="admin-header">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="../logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <section class="statistics">
            <div class="card">
                <h3>Total Users</h3>
                <p><?= htmlspecialchars($userCount) ?></p>
            </div>
            <div class="card">
                <h3>Superadmins</h3>
                <p><?= htmlspecialchars($adminCount) ?></p>
            </div>
            <div class="card">
                <h3>Regular Users</h3>
                <p><?= htmlspecialchars($regularCount) ?></p>
            </div>
        </section>

        <section class="recent-users">
            <h2>Recent Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="manage-users">
            <h2>Manage Users</h2>
            <form action="../admin/manage_users.php" method="POST">
                <button type="submit">Manage</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Admin Panel</p>
    </footer>
</body>
</html>
