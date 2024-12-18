<?php
$host = 'localhost';
$username = 'sinam.ametewee';
$password = 'diamonds34#';
$database = 'webtech_fall2024_sinam_ametewee';

try {
    $db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
