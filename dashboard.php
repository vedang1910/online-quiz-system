<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_name = $_SESSION['student_name'];
$student_id = $_SESSION['student_id'];

// Fetch student's past quiz results
$stmt = $pdo->prepare("SELECT score, total_questions, date FROM results WHERE student_id = ? ORDER BY date DESC");
$stmt->execute([$student_id]);
$results = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="container mt-3 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <div>
            <h4 class="fw-semibold text-dark mb-1">Welcome, <?php echo htmlspecialchars($student_name); ?></h4>
            <p class="text-muted small mb-0">Ready to test your knowledge?</p>
        </div>
        <a href="logout.php" class="btn btn-outline-dark btn-sm px-4 rounded-1">Logout</a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-1 border-light-subtle shadow-none bg-white h-100">
                <div class="card-body text-center p-4 p-lg-5 d-flex flex-column">
                    <h5 class="fw-bold mb-3 mt-2">Take a Quiz</h5>
                    <p class="text-muted small mb-4">Answer multiple-choice questions and get your score immediately.</p>
                    <a href="quiz.php" class="btn btn-dark w-100 py-2 rounded-1 mt-auto">Start Quiz Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-1 border-light-subtle shadow-none bg-white h-100">
                <div class="card-body p-0">
                    
                    <div class="p-4 border-bottom">
                        <h6 class="fw-bold text-uppercase mb-0">Your Recent Scores</h6>
                    </div>

                    <?php if (count($results) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 text-muted small text-uppercase fw-semibold py-3">Date & Time</th>
                                        <th class="text-muted small text-uppercase fw-semibold py-3">Score</th>
                                        <th class="text-end pe-4 text-muted small text-uppercase fw-semibold py-3">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $row): 
                                        $percentage = ($row['score'] / $row['total_questions']) * 100;
                                    ?>
                                        <tr>
                                            <td class="ps-4 py-3 text-muted small">
                                                <div class="fw-semibold text-dark"><?php echo date('M d, Y', strtotime($row['date'])); ?></div>
                                                <?php echo date('h:i A', strtotime($row['date'])); ?>
                                            </td>
                                            <td>
                                                <span class="badge border border-dark text-dark bg-white rounded-1 px-3 py-2">
                                                    <?php echo $row['score']; ?> / <?php echo $row['total_questions']; ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <?php if ($percentage >= 50): ?>
                                                    <span class="fw-bold text-dark"><?php echo number_format($percentage, 1); ?>%</span>
                                                <?php else: ?>
                                                    <span class="fw-bold text-secondary"><?php echo number_format($percentage, 1); ?>%</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <p class="mb-0">You haven't taken any quizzes yet.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>