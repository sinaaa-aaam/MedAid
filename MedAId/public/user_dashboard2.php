<?php
// Include the backend logic
require_once '../backend/user_dashboard2.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dashboard</title>
    <link rel="stylesheet" href="../styles/user_dashboard2.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($settings['user_name'] ?? 'User'); ?></h1>
            <p>Manage and track your health metrics.</p>
            <div class="header-buttons">
                <a href="../logout.php" class="logout-btn">Logout</a>
                <a href="user_form.php" class="back-btn">User Form</a>
            </div>
        </div>

        <h2>Your Health Data</h2>
        <div class="health-data-container">
    <?php if (!empty($health_data)): ?>
        <?php foreach ($health_data as $data): ?>
            <div class="health-card">
                <p><strong>Date:</strong> <?php echo htmlspecialchars($data['date']); ?></p>
                <p><strong>Steps:</strong> <?php echo htmlspecialchars($data['steps']); ?></p>
                <p><strong>Sleep:</strong> <?php echo htmlspecialchars($data['sleep']); ?> hours</p>
                <p><strong>Heart Rate:</strong> <?php echo htmlspecialchars($data['heart_rate']); ?> bpm</p>
                <p><strong>Calories Burned:</strong> <?php echo htmlspecialchars($data['calories']); ?></p>
                <h2>Your Health Predictions</h2>
                        <div class="predictions-container">
                            <h3>Risk Level: <?php echo htmlspecialchars($prediction['risk_level']); ?></h3>
                            <p><strong>Advice:</strong> <?php echo htmlspecialchars($prediction['advice']); ?></p>
                        </div>
                        
                <div class="card-actions">
                <button onclick="location.href='../backend/update_userdata.php?id=<?php echo $data['id']; ?>'">Edit</button>

                <button onclick="if(confirm('Are you sure you want to delete this entry?')) 
                        location.href='../backend/delete_userdata.php?id=<?php echo $data['id']; ?>';">
                        Delete
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No health data available.</p>
    <?php endif; ?>
</div>

    </div>
</body>
</html>
