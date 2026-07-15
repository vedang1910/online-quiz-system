<?php 
// Include the header
include 'includes/header.php'; 
?>

<div class="container py-5 my-md-5">
    <div class="row align-items-center">
        
        <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0 pe-lg-5">
            <span class="badge border border-dark text-dark rounded-1 px-3 py-2 mb-4 text-uppercase fw-semibold" style="letter-spacing: 1px;">
                Online Assessment
            </span>
            <h1 class="display-4 fw-bold text-dark mb-4" style="letter-spacing: -1px;">
                Master your knowledge.
            </h1>
            <p class="lead text-muted mb-5 pe-lg-4">
                A clean, distraction-free environment to test your skills, practice quizzes, and track your progress instantly.
            </p>
            
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mb-5">
                <a href="register.php" class="btn btn-dark btn-lg px-5 py-3 rounded-1">Student Register</a>
                <a href="login.php" class="btn btn-outline-dark btn-lg px-5 py-3 rounded-1">Student Login</a>
            </div>
            
            <a href="admin/login.php" class="text-decoration-none text-muted small text-uppercase fw-semibold border-bottom border-secondary pb-1">
                Admin Portal &rarr;
            </a>
        </div>
        
        <div class="col-lg-6">
            <div class="row g-4">
                <div class="col-6">
                    <div class="card border-1 border-light-subtle shadow-none bg-light h-100 p-4 rounded-1">
                        <i class="bi bi-ui-checks text-dark mb-3" style="font-size: 2rem;"></i>
                        <h6 class="fw-semibold text-dark">Minimal UI</h6>
                        <p class="text-muted small mb-0">Focus entirely on the questions.</p>
                    </div>
                </div>
                <div class="col-6 mt-lg-5">
                    <div class="card border-1 border-dark shadow-none bg-white h-100 p-4 rounded-1">
                        <i class="bi bi-stopwatch text-dark mb-3" style="font-size: 2rem;"></i>
                        <h6 class="fw-semibold text-dark">Instant Results</h6>
                        <p class="text-muted small mb-0">Get your score immediately.</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-1 border-light-subtle shadow-none bg-white h-100 p-4 rounded-1">
                        <i class="bi bi-bar-chart text-dark mb-3" style="font-size: 2rem;"></i>
                        <h6 class="fw-semibold text-dark">Track Progress</h6>
                        <p class="text-muted small mb-0">Monitor your past performance.</p>
                    </div>
                </div>
                <div class="col-6 mt-lg-5">
                    <div class="card border-1 border-light-subtle shadow-none bg-light h-100 p-4 rounded-1">
                        <i class="bi bi-shield-check text-dark mb-3" style="font-size: 2rem;"></i>
                        <h6 class="fw-semibold text-dark">Secure</h6>
                        <p class="text-muted small mb-0">Private dashboards and data.</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php 
// Include the footer
include 'includes/footer.php'; 
?>