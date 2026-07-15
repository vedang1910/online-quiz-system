<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Redirect if accessed directly without submitting the quiz
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['answers'])) {
    header("Location: dashboard.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$submitted_answers = $_POST['answers']; // This is an array of [question_id => selected_option]

$score = 0;
$total_questions = count($submitted_answers);

// Fetch correct answers from database
$stmt = $pdo->query("SELECT id, correct_option FROM questions");
$correct_answers = [];
while ($row = $stmt->fetch()) {
    $correct_answers[$row['id']] = $row['correct_option'];
}

// Calculate Score
foreach ($submitted_answers as $question_id => $student_answer) {
    if (isset($correct_answers[$question_id]) && $correct_answers[$question_id] == $student_answer) {
        $score++; // Add 1 point for a correct answer
    }
}

// Calculate Percentage
$percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;

// Save the result to the database
$insert_stmt = $pdo->prepare("INSERT INTO results (student_id, score, total_questions) VALUES (?, ?, ?)");
$insert_stmt->execute([$student_id, $score, $total_questions]);

include 'includes/header.php'; 
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-8 col-lg-6 text-center">
        
        <div class="card border-1 border-light-subtle shadow-none bg-white py-4 rounded-1">
            <div class="card-body p-4 p-md-5">
                
                <?php if ($percentage >= 50): ?>
                    <i class="bi bi-check2-circle text-dark mb-4 d-block" style="font-size: 3.5rem;"></i>
                    <h3 class="fw-semibold text-dark">Quiz Completed</h3>
                    <p class="text-muted small">You have successfully passed the assessment.</p>
                <?php else: ?>
                    <i class="bi bi-arrow-counterclockwise text-dark mb-4 d-block" style="font-size: 3.5rem;"></i>
                    <h3 class="fw-semibold text-dark">Keep Practicing</h3>
                    <p class="text-muted small">You didn't pass this time, but you can try again.</p>
                <?php endif; ?>

                <div class="display-3 fw-bold text-dark my-5 border-top border-bottom py-4">
                    <?php echo $score; ?> <span class="fs-4 text-muted fw-normal">/ <?php echo $total_questions; ?></span>
                </div>
                
                <h6 class="text-muted small text-uppercase fw-semibold mb-5">Final Score: <?php echo number_format($percentage, 1); ?>%</h6>

                <a href="dashboard.php" class="btn btn-dark w-100 py-3 rounded-1">Return to Dashboard</a>
            </div>
        </div>
        
    </div>
</div>

<?php include 'includes/footer.php'; ?>