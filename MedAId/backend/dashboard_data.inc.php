<?php


function get_health_dashboard_metrics($pdo, $user_id) {
    try {
        // Get total steps in the last 30 days
        $query = "SELECT SUM(steps) AS total_steps FROM health_metrics WHERE user_id = :user_id AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $total_steps = $stmt->fetchColumn() ?: 0;

        // Get average heart rate in the last 30 days
        $query = "SELECT AVG(heart_rate) AS avg_heart_rate FROM health_metrics WHERE user_id = :user_id AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $avg_heart_rate = round($stmt->fetchColumn(), 2) ?: 0;

        // Get total calories burned in the last 30 days
        $query = "SELECT SUM(calories) AS total_calories FROM health_metrics WHERE user_id = :user_id AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $total_calories = $stmt->fetchColumn() ?: 0;

        // Get sleep metrics in the last 30 days
        $query = "SELECT AVG(sleep) AS avg_sleep FROM health_metrics WHERE user_id = :user_id AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $avg_sleep = round($stmt->fetchColumn(), 2) ?: 0;

        return [
            'total_steps' => $total_steps,
            'avg_heart_rate' => $avg_heart_rate,
            'total_calories' => $total_calories,
            'avg_sleep' => $avg_sleep
        ];
    } catch (PDOException $e) {
        error_log("Error fetching health metrics: " . $e->getMessage());
        return [
            'total_steps' => 0,
            'avg_heart_rate' => 0,
            'total_calories' => 0,
            'avg_sleep' => 0
        ];
    }
}

function generate_health_insights($metrics) {
    $insights = [];

    if ($metrics['avg_heart_rate'] > 100) {
        $insights[] = "Your average heart rate is higher than normal. Consider consulting a doctor.";
    }
    if ($metrics['avg_sleep'] < 7) {
        $insights[] = "You're getting less than the recommended amount of sleep. Aim for at least 7 hours per night.";
    }
    if ($metrics['total_steps'] < 10000) {
        $insights[] = "Your total steps in the last 30 days are below the target. Try to increase daily activity.";
    }

    return $insights ?: ["Great job! Keep up the healthy lifestyle!"];
}
?>
