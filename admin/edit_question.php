<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

// Check if ID is in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_questions.php");
    exit();
}

$id = $_GET['id'];

// Fetch the existing question data
$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$id]);
$question_data = $stmt->fetch();

if (!$question_data) {
    header("Location: manage_questions.php");
    exit();
}

// Handle Form Submission for Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = trim($_POST['question']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $correct_option = $_POST['correct_option'];

    if (empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d) || empty($correct_option)) {
        $error = "All fields are required.";
    } else {
        $update_stmt = $pdo->prepare("UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?");
        if ($update_stmt->execute([$question, $option_a, $option_b, $option_c, $option_d, $correct_option, $id])) {
            $success = "Question updated successfully!";
            // Update the local variable so the form shows the new data
            $question_data = ['question'=>$question, 'option_a'=>$option_a, 'option_b'=>$option_b, 'option_c'=>$option_c, 'option_d'=>$option_d, 'correct_option'=>$correct_option];
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}

include '../includes/header.php'; 
?>

<div class="row justify-content-center mt-3 mb-5">
    <div class="col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-semibold text-dark mb-0">Edit Question</h4>
            <a href="manage_questions.php" class="btn btn-outline-dark btn-sm px-4">Back</a>
        </div>

        <div class="card border-1 border-light-subtle shadow-none bg-white">
            <div class="card-body p-4 p-md-5">
                
                <?php if($error): ?><div class="alert alert-danger rounded-1"><?php echo $error; ?></div><?php endif; ?>
                <?php if($success): ?><div class="alert alert-success rounded-1"><?php echo $success; ?></div><?php endif; ?>

                <form action="edit_question.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-semibold">Question Text</label>
                        <textarea class="form-control rounded-1" name="question" rows="3" required><?php echo htmlspecialchars($question_data['question']); ?></textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-semibold">Option A</label>
                            <input type="text" class="form-control rounded-1" name="option_a" value="<?php echo htmlspecialchars($question_data['option_a']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-semibold">Option B</label>
                            <input type="text" class="form-control rounded-1" name="option_b" value="<?php echo htmlspecialchars($question_data['option_b']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-semibold">Option C</label>
                            <input type="text" class="form-control rounded-1" name="option_c" value="<?php echo htmlspecialchars($question_data['option_c']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-semibold">Option D</label>
                            <input type="text" class="form-control rounded-1" name="option_d" value="<?php echo htmlspecialchars($question_data['option_d']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label text-muted small text-uppercase fw-semibold">Correct Option</label>
                        <select class="form-select rounded-1" name="correct_option" required>
                            <option value="A" <?php echo ($question_data['correct_option'] == 'A') ? 'selected' : ''; ?>>Option A</option>
                            <option value="B" <?php echo ($question_data['correct_option'] == 'B') ? 'selected' : ''; ?>>Option B</option>
                            <option value="C" <?php echo ($question_data['correct_option'] == 'C') ? 'selected' : ''; ?>>Option C</option>
                            <option value="D" <?php echo ($question_data['correct_option'] == 'D') ? 'selected' : ''; ?>>Option D</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-1">Update Question</button>
                </form>
            </div>
        </div>
        
    </div>
</div>

<?php include '../includes/footer.php'; ?>