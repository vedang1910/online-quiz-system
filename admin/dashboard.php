<?php
session_start();
require_once '../config/database.php';

// Check if admin is logged in securely
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch some quick statistics for the dashboard
// 1. Total Students
$stmt_students = $pdo->query("SELECT COUNT(*) as total FROM students");
$total_students = $stmt_students->fetch()['total'];

// 2. Total Questions
$stmt_questions = $pdo->query("SELECT COUNT(*) as total FROM questions");
$total_questions = $stmt_questions->fetch()['total'];

// 3. Total Quizzes Taken
$stmt_results = $pdo->query("SELECT COUNT(*) as total FROM results");
$total_results = $stmt_results->fetch()['total'];

include '../includes/header.php'; 
?>

<div class="container mt-3 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <h4 class="fw-semibold text-dark mb-0">Admin Dashboard</h4>
        <a href="../logout.php" class="btn btn-outline-dark btn-sm px-4">Logout</a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-1 border-light-subtle shadow-none bg-white text-center py-4">
                <div class="display-5 fw-bold text-dark"><?php echo $total_students; ?></div>
                <div class="text-uppercase small text-muted fw-semibold mt-2">Students</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-1 border-light-subtle shadow-none bg-white text-center py-4">
                <div class="display-5 fw-bold text-dark"><?php echo $total_questions; ?></div>
                <div class="text-uppercase small text-muted fw-semibold mt-2">Questions</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-1 border-light-subtle shadow-none bg-white text-center py-4">
                <div class="display-5 fw-bold text-dark"><?php echo $total_results; ?></div>
                <div class="text-uppercase small text-muted fw-semibold mt-2">Quizzes Taken</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-1 border-light-subtle shadow-none bg-white p-4 h-100">
                <h5 class="fw-bold mb-2">Question Bank</h5>
                <p class="text-muted small mb-4">Add, edit, or delete the multiple-choice questions for the quiz.</p>
                <a href="manage_questions.php" class="btn btn-dark w-100 py-2 rounded-1 mt-auto">Manage Questions</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-1 border-light-subtle shadow-none bg-white p-4 h-100">
                <h5 class="fw-bold mb-2">Student Results</h5>
                <p class="text-muted small mb-4">View the detailed scores and performance of all students.</p>
                <a href="results.php" class="btn btn-outline-dark w-100 py-2 rounded-1 mt-auto">View All Results</a>
            </div>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>