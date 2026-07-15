<?php
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all results, joining with the students table to get names and emails
$query = "SELECT results.score, results.total_questions, results.date, 
                 students.full_name, students.email 
          FROM results 
          JOIN students ON results.student_id = students.id 
          ORDER BY results.date DESC";
          
$stmt = $pdo->query($query);
$all_results = $stmt->fetchAll();

include '../includes/header.php'; 
?>

<div class="container mt-3 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h4 class="fw-semibold text-dark mb-1">Student Results</h4>
            <a href="dashboard.php" class="text-muted small text-decoration-none">&larr; Back to Dashboard</a>
        </div>
    </div>

    <div class="card border-1 border-light-subtle shadow-none bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-muted small text-uppercase fw-semibold py-3">Date & Time</th>
                            <th class="text-muted small text-uppercase fw-semibold py-3">Student Name</th>
                            <th class="text-muted small text-uppercase fw-semibold py-3">Email Address</th>
                            <th class="text-muted small text-uppercase fw-semibold py-3">Score</th>
                            <th class="text-end pe-4 text-muted small text-uppercase fw-semibold py-3">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($all_results) > 0): ?>
                            <?php foreach ($all_results as $row): 
                                $percentage = ($row['total_questions'] > 0) ? ($row['score'] / $row['total_questions']) * 100 : 0;
                            ?>
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        <div class="fw-semibold text-dark"><?php echo date('M d, Y', strtotime($row['date'])); ?></div>
                                        <?php echo date('h:i A', strtotime($row['date'])); ?>
                                    </td>
                                    <td class="fw-semibold text-dark"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td class="text-muted small"><?php echo htmlspecialchars($row['email']); ?></td>
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
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <p class="mb-0">No students have taken the quiz yet.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>