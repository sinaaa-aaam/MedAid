<?php
session_start();
require_once './db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // User input from the health form
    $steps = $_POST['steps'];
    $sleep = $_POST['sleep'];
    $heart_rate = $_POST['heart_rate'];
    $calories = $_POST['calories'];

    // Call Python script for prediction
    $command = escapeshellcmd("python3 predict_health.py $steps $sleep $heart_rate $calories");
    $output = shell_exec($command);
    
    // Process the output (predictions)
    $predictions = json_decode($output, true);

    // Insert user data into the database
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare("INSERT INTO health_metrics (user_id, steps, sleep, heart_rate, calories) 
                           VALUES (:user_id, :steps, :sleep, :heart_rate, :calories)");
    $query->execute([
        ':user_id' => $user_id,
        ':steps' => $steps,
        ':sleep' => $sleep,
        ':heart_rate' => $heart_rate,
        ':calories' => $calories
    ]);

    // Save the prediction data (risk level, advice)
    $risk_level = $predictions['risk_level'];
    $advice = $predictions['advice'];

    // Store the predictions and advice
    $prediction_query = $db->prepare("INSERT INTO predictions (user_id, risk_level, advice) 
                                      VALUES (:user_id, :risk_level, :advice)");
    $prediction_query->execute([
        ':user_id' => $user_id,
        ':risk_level' => $risk_level,
        ':advice' => $advice
    ]);

    // Redirect to the user dashboard
    header("Location: ./public/user_dashboard2.php");
    exit;
}
?>
