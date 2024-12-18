<?php
session_start();
require_once '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Initialize $latest_data
$latest_data = null;

// Fetch latest health data for the user
$query = $db->prepare("
    SELECT users.age, users.gender, health_metrics.steps, health_metrics.sleep, 
           health_metrics.heart_rate, health_metrics.calories 
    FROM users
    JOIN health_metrics ON users.id = health_metrics.user_id
    WHERE users.id = :user_id
    ORDER BY health_metrics.date DESC
    LIMIT 1
");
$query->execute([':user_id' => $user_id]);
$latest_data = $query->fetch(PDO::FETCH_ASSOC);

// Check if health data is available
if ($latest_data && !empty($latest_data)) {
    // Load risk dataset
    $risk_data = json_decode(file_get_contents('../backend/risk_levels.json'), true);

    // Default predictions
    $risk_level = "Unknown";
    $advice = "No advice available.";

    if ($risk_data && is_array($risk_data)) {
        // Find matching risk level and advice
        foreach ($risk_data as $entry) {
            if (
                $latest_data['steps'] >= $entry['steps'][0] && $latest_data['steps'] <= $entry['steps'][1] &&
                $latest_data['sleep'] >= $entry['sleep'][0] && $latest_data['sleep'] <= $entry['sleep'][1] &&
                $latest_data['heart_rate'] >= $entry['heart_rate'][0] && $latest_data['heart_rate'] <= $entry['heart_rate'][1] &&
                $latest_data['calories'] >= $entry['calories'][0] && $latest_data['calories'] <= $entry['calories'][1]
            ) {
                $risk_level = $entry['risk_level'];
                $advice = $entry['advice'];
                break;
            }
        }
    } else {
        $risk_level = "No data";
        $advice = "Please ensure the risk_levels.json file is valid.";
    }

    // Save prediction in the database
    $savePrediction = $db->prepare("
        INSERT INTO predictions (user_id, prediction_type, risk_level, advice)
        VALUES (:user_id, 'general', :risk_level, :advice)
    ");
    $savePrediction->execute([
        ':user_id' => $user_id,
        ':risk_level' => $risk_level,
        ':advice' => $advice
    ]);
} else {
    $risk_level = "No data";
    $advice = "Please update your health data.";
}

// Pass predictions and other settings to the frontend
$prediction = [
    'risk_level' => $risk_level,
    'advice' => $advice
];
?>
