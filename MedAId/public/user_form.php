<?php
session_start();
require_once '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$checkUser = $db->prepare("SELECT id FROM users WHERE id = :user_id");
$checkUser->execute([':user_id' => $user_id]);
if ($checkUser->rowCount() === 0) {
    die("Error: Invalid user ID.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $steps = $_POST['steps'];
    $sleep = $_POST['sleep'];
    $heart_rate = $_POST['heart_rate'];
    $calories = $_POST['calories'];
    $reminder = $_POST['reminder'];
    $units = $_POST['units'];
    $goal = $_POST['goal'];

    if ($steps < 0 || $sleep < 0 || $heart_rate < 0 || $calories < 0) {
        die("Error: Health metrics must be positive numbers.");
    }

    try {
        $db->beginTransaction();

        $query = $db->prepare("
            INSERT INTO health_metrics (user_id, steps, sleep, heart_rate, calories, date)
            VALUES (:user_id, :steps, :sleep, :heart_rate, :calories, CURDATE())
        ");
        $query->execute([
            ':user_id' => $user_id,
            ':steps' => $steps,
            ':sleep' => $sleep,
            ':heart_rate' => $heart_rate,
            ':calories' => $calories
        ]);

        $reminderQuery = $db->prepare("
            INSERT INTO reminders (user_id, reminder_time, reminder_type)
            VALUES (:user_id, CURTIME(), :reminder)
        ");
        $reminderQuery->execute([
            ':user_id' => $user_id,
            ':reminder' => $reminder
        ]);

        $settingsQuery = $db->prepare("
            INSERT INTO user_settings (user_id, units, goal)
            VALUES (:user_id, :units, :goal)
            ON DUPLICATE KEY UPDATE units = :units, goal = :goal, updated_at = CURRENT_TIMESTAMP
        ");
        $settingsQuery->execute([
            ':user_id' => $user_id,
            ':units' => $units,
            ':goal' => $goal
        ]);

        $db->commit();

        header("Location: user_dashboard2.php");
        exit;
    } catch (PDOException $e) {
        $db->rollBack();
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Health Metrics</title>
    <link rel="stylesheet" href="../styles/user_form.css">
</head>
<body>
    <header class="admin-header">
        <h1>Health Tracker</h1>
        <nav>
            <a href="user_dashboard2.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <form method="POST" action="user_form.php">
            <h2>Update Your Health Data</h2>
            <p>Enter your latest health metrics below:</p>

            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="number" name="age" placeholder="Age (1-120)" required min="1" max="120">
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="number" name="steps" placeholder="Steps" required>
            <input type="number" name="sleep" placeholder="Sleep (hours)" required>
            <input type="number" name="heart_rate" placeholder="Heart Rate (bpm)" required>
            <input type="number" name="calories" placeholder="Calories Burned" required>
            <input type="text" name="goal" placeholder="Your Overall Goal" required>
            <input type="text" name="reminder" placeholder="Reminder" required>
            <select name="units" required>
                <option value="metric">Metric</option>
                <option value="imperial">Imperial</option>
            </select>

            <button type="submit">Save Metrics</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Health Tracker. All rights reserved.</p>
    </footer>
</body>
</html>
