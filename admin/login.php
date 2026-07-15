<?php
session_start();
require_once '../config/database.php';

// If admin is already logged in, redirect to admin dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Find the admin by username
        $stmt = $pdo->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        // Verify password (using password_verify because we hashed it in the SQL file)
        if ($admin && password_verify($password, $admin['password'])) {
            // Password is correct, start session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            
            // Redirect to admin dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}

include '../includes/header.php'; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6 col-lg-5">
        
        <div class="card border-1 border-light-subtle shadow-none bg-white">
            <div class="card-body p-4 p-md-5">
                
                <div class="text-center mb-5">
                    <h4 class="fw-semibold text-dark mb-1">Admin Portal</h4>
                    <p class="text-muted small">Sign in to manage the quiz system</p>
                </div>
                
                <?php if($error): ?>
                    <div class="alert alert-danger rounded-1"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-4">
                        <label for="username" class="form-label text-muted small text-uppercase fw-semibold">Username</label>
                        <input type="text" class="form-control rounded-1" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="form-label text-muted small text-uppercase fw-semibold">Password</label>
                        <input type="password" class="form-control rounded-1" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-1">Secure Login</button>
                </form>
                
            </div>
        </div>
        
    </div>
</div>

<?php include '../includes/footer.php'; ?>