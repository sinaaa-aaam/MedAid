<?php
// Include the backend logic
require_once '../backend/user_dashboard2.inc.php';

// Fetch all health data for the user
$allDataQuery = $db->prepare("
    SELECT id, date, steps, sleep, heart_rate, calories 
    FROM health_metrics 
    WHERE user_id = :user_id 
    ORDER BY date DESC
");
$allDataQuery->execute([':user_id' => $user_id]);
$health_data = $allDataQuery->fetchAll(PDO::FETCH_ASSOC);

// Function to predict health risk based on health data
function predict_health_risk($steps, $sleep, $heart_rate, $calories) {
    // Prediction logic (you can replace this with an actual ML model)
    if ($steps < 5000 || $sleep < 6) {
        return ['risk_level' => 'High', 'advice' => 'Increase physical activity and sleep more.'];
    } elseif ($heart_rate > 100 || $calories > 3500) {
        return ['risk_level' => 'Medium', 'advice' => 'Monitor heart rate and adjust calorie intake.'];
    } else {
        return ['risk_level' => 'Low', 'advice' => 'Your health metrics are within normal ranges.'];
    }
}
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
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></h1>
            <p>Manage and track your health metrics.</p>
            <div class="header-buttons">
                <a href="../logout.php" class="logout-btn">Logout</a>
                <a href="user_form.php" class="back-btn">Add New Metrics</a>
            </div>
        </div>

        <h2>Your Health Data</h2>
        <div class="health-data-container">
            <?php if (!empty($health_data)): ?>
                <?php foreach ($health_data as $data): ?>
                    <?php
                    // Generate prediction for the current health entry
                    $prediction = predict_health_risk($data['steps'], $data['sleep'], $data['heart_rate'], $data['calories']);
                    ?>
                    <div class="health-card">
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($data['date']); ?></p>
                        <p><strong>Steps:</strong> <?php echo htmlspecialchars($data['steps']); ?></p>
                        <p><strong>Sleep:</strong> <?php echo htmlspecialchars($data['sleep']); ?> hours</p>
                        <p><strong>Heart Rate:</strong> <?php echo htmlspecialchars($data['heart_rate']); ?> bpm</p>
                        <p><strong>Calories Burned:</strong> <?php echo htmlspecialchars($data['calories']); ?></p>

                        <div class="health-prediction">
                            <p><strong>Risk Level:</strong> <?php echo htmlspecialchars($prediction['risk_level']); ?></p>
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
