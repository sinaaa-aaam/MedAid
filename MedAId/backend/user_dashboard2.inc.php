<?php
// Include the configuration file for database connection
require_once '../db/config.php';

// Start session
session_start();

// Fetch user ID from session
$user_id = $_SESSION['user_id'] ?? null;

// Initialize variables
$health_data = [];
$prediction = [
    'risk_level' => 'N/A',
    'advice' => 'No advice available.',
];

if ($user_id) {
    // Fetch health data from the database
    try {
        $stmt = $db->prepare("SELECT * FROM health_metrics WHERE user_id = :user_id ORDER BY date DESC");
        $stmt->execute([':user_id' => $user_id]);
        $health_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch health predictions from the database
        $stmt = $db->prepare("SELECT risk_level, advice FROM predictions WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute([':user_id' => $user_id]);
        $prediction_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($prediction_data) {
            $prediction['risk_level'] = $prediction_data['risk_level'];
            $prediction['advice'] = $prediction_data['advice'];
        }
    } catch (PDOException $e) {
        die("Error fetching data: " . $e->getMessage());
    }
}

?>
