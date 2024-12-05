<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch quiz questions
$questionsQuery = "SELECT * FROM quiz_questions ORDER BY RAND() LIMIT 5";
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
    <title>Quiz Game</title>
    <link rel="stylesheet" href="css/quiz_style.css">
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
        <section class="quiz-section">
            <h1>Quiz Game</h1>
            <form action="quiz_result.php" method="POST" class="quiz-form">
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question">
                        <p><?php echo ($index + 1) . ". " . htmlspecialchars($question['question']); ?></p>
                        <input type="radio" name="answer<?php echo $index; ?>" value="1" required> <?php echo htmlspecialchars($question['option1']); ?><br>
                        <input type="radio" name="answer<?php echo $index; ?>" value="2"> <?php echo htmlspecialchars($question['option2']); ?><br>
                        <input type="radio" name="answer<?php echo $index; ?>" value="3"> <?php echo htmlspecialchars($question['option3']); ?><br>
                        <input type="radio" name="answer<?php echo $index; ?>" value="4"> <?php echo htmlspecialchars($question['option4']); ?><br>
                        <input type="hidden" name="question_id<?php echo $index; ?>" value="<?php echo $question['id']; ?>">
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="Submit Answers">
            </form>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>