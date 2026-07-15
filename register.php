<?php
// Start session if not started, and include database connection
require_once 'config/database.php';

$error = '';
$success = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // PHP Backend Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Check if email already exists in database
        $stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "This email is already registered. Please login.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new student into database
            $insert_stmt = $pdo->prepare("INSERT INTO students (full_name, email, password) VALUES (?, ?, ?)");
            
            if ($insert_stmt->execute([$full_name, $email, $hashed_password])) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}

// Include header AFTER backend logic so redirects work if needed
include 'includes/header.php'; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6 col-lg-5">
        
        <div class="card border-1 border-light-subtle shadow-none bg-white">
            <div class="card-body p-4 p-md-5">
                
                <div class="text-center mb-5">
                    <h4 class="fw-semibold text-dark mb-1">Student Register</h4>
                    <p class="text-muted small">Create an account to take the quiz</p>
                </div>
                
                <?php if($error): ?>
                    <div class="alert alert-danger rounded-1"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if($success): ?>
                    <div class="alert alert-success rounded-1">
                        <?php echo $success; ?> <a href="login.php" class="alert-link">Click here to login</a>.
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST" id="registerForm">
                    <div class="mb-4">
                        <label for="full_name" class="form-label text-muted small text-uppercase fw-semibold">Full Name</label>
                        <input type="text" class="form-control rounded-1" id="full_name" name="full_name" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted small text-uppercase fw-semibold">Email Address</label>
                        <input type="email" class="form-control rounded-1" id="email" name="email" required>
                        <div id="emailError" class="text-danger small mt-1" style="display: none;">Please enter a valid email.</div>
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="form-label text-muted small text-uppercase fw-semibold">Password</label>
                        <input type="password" class="form-control rounded-1" id="password" name="password" required>
                        <div id="passwordError" class="text-danger small mt-1" style="display: none;">Password must be at least 6 characters.</div>
                    </div>
                    
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-1 mb-4">Register</button>
                    
                    <div class="text-center">
                        <span class="text-muted small">Already have an account?</span> 
                        <a href="login.php" class="text-dark fw-semibold text-decoration-none small">Login here</a>
                    </div>
                </form>
                
            </div>
        </div>
        
    </div>
</div>

<?php include 'includes/footer.php'; ?>