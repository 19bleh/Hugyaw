<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission for adding a new question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_question'])) {
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct_option = $_POST['correct_option'];

    $stmt = $conn->prepare("INSERT INTO quiz_questions (question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $question, $option1, $option2, $option3, $option4, $correct_option);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for editing a question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_question'])) {
    $question_id = $_POST['question_id'];
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct_option = $_POST['correct_option'];

    $stmt = $conn->prepare("UPDATE quiz_questions SET question = ?, option1 = ?, option2 = ?, option3 = ?, option4 = ?, correct_option = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $question, $option1, $option2, $option3, $option4, $correct_option, $question_id);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for deleting a question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_question'])) {
    $question_id = $_POST['question_id'];

    $stmt = $conn->prepare("DELETE FROM quiz_questions WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all quiz questions
$questionsQuery = "SELECT * FROM quiz_questions";
$questionsResult = $conn->query($questionsQuery);

if (!$questionsResult) {
    die("Query failed: " . $conn->error);
}

$questions = $questionsResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Quiz Management</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="Festival.php">Home</a></li>
                <li><a href="feedback.php">Feedbacks</a></li>
                <li><a href="quiz.php">Quiz</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <h1 class="logo">Hugyaw</h1>
    </header>
    <main>
        <section class="admin-section">
            <h1>Admin Quiz Management</h1>

            <!-- Add Question Form -->
            <h2>Add New Question</h2>
            <form action="admin_quiz.php" method="POST" class="admin-form">
                <label for="question">Question:</label>
                <textarea name="question" id="question" rows="4" required></textarea><br><br>
                <label for="option1">Option 1:</label>
                <input type="text" name="option1" id="option1" required><br><br>
                <label for="option2">Option 2:</label>
                <input type="text" name="option2" id="option2" required><br><br>
                <label for="option3">Option 3:</label>
                <input type="text" name="option3" id="option3" required><br><br>
                <label for="option4">Option 4:</label>
                <input type="text" name="option4" id="option4" required><br><br>
                <label for="correct_option">Correct Option (1-4):</label>
                <input type="number" name="correct_option" id="correct_option" min="1" max="4" required><br><br>
                <input type="submit" name="add_question" value="Add Question">
            </form>

            <!-- Edit/Delete Questions -->
            <h2>Manage Questions</h2>
            <?php foreach ($questions as $question): ?>
                <form action="admin_quiz.php" method="POST" class="admin-form">
                    <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                    <label for="question">Question:</label>
                    <textarea name="question" rows="4" required><?php echo htmlspecialchars($question['question']); ?></textarea><br><br>
                    <label for="option1">Option 1:</label>
                    <input type="text" name="option1" value="<?php echo htmlspecialchars($question['option1']); ?>" required><br><br>
                    <label for="option2">Option 2:</label>
                    <input type="text" name="option2" value="<?php echo htmlspecialchars($question['option2']); ?>" required><br><br>
                    <label for="option3">Option 3:</label>
                    <input type="text" name="option3" value="<?php echo htmlspecialchars($question['option3']); ?>" required><br><br>
                    <label for="option4">Option 4:</label>
                    <input type="text" name="option4" value="<?php echo htmlspecialchars($question['option4']); ?>" required><br><br>
                    <label for="correct_option">Correct Option (1-4):</label>
                    <input type="number" name="correct_option" value="<?php echo $question['correct_option']; ?>" min="1" max="4" required><br><br>
                    <input type="submit" name="edit_question" value="Edit Question">
                    <input type="submit" name="delete_question" value="Delete Question">
                </form>
                <hr>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>