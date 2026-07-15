<?php
session_start();
require_once 'config/database.php';

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all questions
$stmt = $pdo->query("SELECT * FROM questions ORDER BY id ASC");
$questions = $stmt->fetchAll();

// If there are no questions, don't let them take the quiz
if (count($questions) == 0) {
    $no_questions = true;
} else {
    $no_questions = false;
}

include 'includes/header.php'; 
?>

<div class="container mt-3 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <div>
            <h4 class="fw-semibold text-dark mb-1">Final Quiz</h4>
            <p class="text-muted small mb-0">Answer all questions below and submit to see your score.</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-dark btn-sm px-4 rounded-1">Cancel</a>
    </div>

    <?php if ($no_questions): ?>
        <div class="card border-1 border-light-subtle shadow-none bg-white text-center py-5 rounded-1">
            <div class="card-body">
                <h5 class="fw-bold text-dark mb-2">Quiz Not Ready</h5>
                <p class="text-muted mb-4">The administrator hasn't added any questions yet. Please check back later.</p>
                <a href="dashboard.php" class="btn btn-dark rounded-1 px-4">Back to Dashboard</a>
            </div>
        </div>
    <?php else: ?>
        <form action="result.php" method="POST">
            <?php foreach ($questions as $index => $q): ?>
                <div class="card border-1 border-light-subtle shadow-none bg-white mb-4 rounded-1">
                    <div class="card-header bg-white py-3 fw-semibold fs-6 border-bottom-0">
                        <span class="text-dark me-2">Q<?php echo $index + 1; ?>.</span> 
                        <span class="text-dark"><?php echo htmlspecialchars($q['question']); ?></span>
                    </div>
                    <div class="card-body pt-0 pb-3">
                        <div class="list-group list-group-flush border-top">
                            <label class="list-group-item d-flex gap-3 py-3 border-light-subtle" style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0 border-dark mt-1" type="radio" name="answers[<?php echo $q['id']; ?>]" value="A" required>
                                <span class="text-dark"><?php echo htmlspecialchars($q['option_a']); ?></span>
                            </label>
                            <label class="list-group-item d-flex gap-3 py-3 border-light-subtle" style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0 border-dark mt-1" type="radio" name="answers[<?php echo $q['id']; ?>]" value="B" required>
                                <span class="text-dark"><?php echo htmlspecialchars($q['option_b']); ?></span>
                            </label>
                            <label class="list-group-item d-flex gap-3 py-3 border-light-subtle" style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0 border-dark mt-1" type="radio" name="answers[<?php echo $q['id']; ?>]" value="C" required>
                                <span class="text-dark"><?php echo htmlspecialchars($q['option_c']); ?></span>
                            </label>
                            <label class="list-group-item d-flex gap-3 py-3 border-light-subtle" style="cursor: pointer;">
                                <input class="form-check-input flex-shrink-0 border-dark mt-1" type="radio" name="answers[<?php echo $q['id']; ?>]" value="D" required>
                                <span class="text-dark"><?php echo htmlspecialchars($q['option_d']); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="text-center mb-5 mt-5">
                <button type="submit" class="btn btn-dark btn-lg px-5 py-2 rounded-1">Submit Quiz</button>
            </div>
        </form>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>