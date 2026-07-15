<?php
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete the question
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirect back to the manage page
header("Location: manage_questions.php");
exit();
?>