<?php
session_start();
require_once 'config/database.php';

// If student is already logged in, redirect to dashboard
if (isset($_SESSION['student_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Find the user by email
        $stmt = $pdo->prepare("SELECT id, full_name, password FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $student = $stmt->fetch();

        // Verify password
        if ($student && password_verify($password, $student['password'])) {
            // Password is correct, start session
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['full_name'];
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}

include 'includes/header.php'; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6 col-lg-5">
        
        <div class="card border-1 border-light-subtle shadow-none bg-white">
            <div class="card-body p-4 p-md-5">
                
                <div class="text-center mb-5">
                    <h4 class="fw-semibold text-dark mb-1">Student Login</h4>
                    <p class="text-muted small">Sign in to access your dashboard</p>
                </div>
                
                <?php if($error): ?>
                    <div class="alert alert-danger rounded-1"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted small text-uppercase fw-semibold">Email Address</label>
                        <input type="email" class="form-control rounded-1" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="form-label text-muted small text-uppercase fw-semibold">Password</label>
                        <input type="password" class="form-control rounded-1" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-1 mb-4">Login</button>
                    
                    <div class="text-center">
                        <span class="text-muted small">Don't have an account?</span> 
                        <a href="register.php" class="text-dark fw-semibold text-decoration-none small">Register here</a>
                    </div>
                </form>
                
            </div>
        </div>
        
    </div>
</div>

<?php include 'includes/footer.php'; ?>