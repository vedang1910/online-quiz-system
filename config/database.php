<?php
// config/database.php

$host = "localhost";
$db_name = "online_quiz";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password is empty
$port = "3307";     // Your specific MySQL port

try {
    // Create a new PDO instance with the custom port
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name;charset=utf8", $username, $password);
    
    // Set PDO error mode to exception for easier debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // If connection fails, stop the script and show error
    die("Database Connection Failed: " . $e->getMessage());
}
?>