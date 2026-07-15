<?php 
// Start the session on every page that includes the header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Define the base URL so assets load correctly from any folder
$base_url = "http://localhost/OnlineQuizSystem/"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $base_url; ?>index.php">
                <i class="bi bi-mortarboard-fill"></i> Quiz System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    </ul>
            </div>
        </div>
    </nav>

    <div class="container"></div>