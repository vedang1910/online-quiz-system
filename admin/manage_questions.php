<?php
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all questions from the database
$stmt = $pdo->query("SELECT * FROM questions ORDER BY id DESC");
$questions = $stmt->fetchAll();

include '../includes/header.php'; 
?>

<div class="container mt-3 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h4 class="fw-semibold text-dark mb-1">Manage Questions</h4>
            <a href="dashboard.php" class="text-muted small text-decoration-none">&larr; Back to Dashboard</a>
        </div>
        <a href="add_question.php" class="btn btn-dark btn-sm px-3 rounded-1">
            Add New Question
        </a>
    </div>

    <div class="card border-1 border-light-subtle shadow-none bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-muted small text-uppercase fw-semibold py-3">#</th>
                            <th class="text-muted small text-uppercase fw-semibold py-3">Question</th>
                            <th class="text-muted small text-uppercase fw-semibold py-3">Correct Option</th>
                            <th class="text-end pe-4 text-muted small text-uppercase fw-semibold py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($questions) > 0): ?>
                            <?php foreach ($questions as $index => $q): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?php echo $index + 1; ?></td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-dark mb-1"><?php echo htmlspecialchars($q['question']); ?></div>
                                        <div class="text-muted small">
                                            A) <?php echo htmlspecialchars($q['option_a']); ?> &nbsp;|&nbsp; 
                                            B) <?php echo htmlspecialchars($q['option_b']); ?> <br>
                                            C) <?php echo htmlspecialchars($q['option_c']); ?> &nbsp;|&nbsp; 
                                            D) <?php echo htmlspecialchars($q['option_d']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge border border-dark text-dark bg-white rounded-1">
                                            Option <?php echo $q['correct_option']; ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="edit_question.php?id=<?php echo $q['id']; ?>" class="btn btn-sm btn-outline-dark rounded-1 me-1">
                                            Edit
                                        </a>
                                        <a href="delete_question.php?id=<?php echo $q['id']; ?>" class="btn btn-sm btn-outline-danger rounded-1" onclick="return confirm('Are you sure you want to delete this question?');">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <p class="mb-0">No questions added yet. Click "Add New Question" to get started.</p>
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