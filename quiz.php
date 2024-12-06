<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch quiz questions
$questionsQuery = "SELECT * FROM quiz_questions ORDER BY RAND() LIMIT 15";
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
    <script>
        let currentQuestionIndex = 0;
        let score = 0;
        const questions = <?php echo json_encode($questions); ?>;

        function showQuestion(index) {
            const question = questions[index];
            document.getElementById('question-text').innerText = (index + 1) + ". " + question.question;
            document.getElementById('option1').innerText = question.option1;
            document.getElementById('option2').innerText = question.option2;
            document.getElementById('option3').innerText = question.option3;
            document.getElementById('option4').innerText = question.option4;
            document.getElementById('question_id').value = question.id;
        }

        function nextQuestion() {
            const selectedOption = document.querySelector('input[name="answer"]:checked');
            if (selectedOption) {
                const answer = selectedOption.value;
                const questionId = document.getElementById('question_id').value;
                const correctOption = questions[currentQuestionIndex].correct_option;

                if (answer == correctOption) {
                    score++;
                }

                selectedOption.checked = false;
                currentQuestionIndex++;

                if (currentQuestionIndex < questions.length) {
                    showQuestion(currentQuestionIndex);
                } else {
                    document.getElementById('score').value = score;
                    document.getElementById('quiz-form').submit();
                }
            } else {
                alert("Please select an answer before proceeding.");
            }
        }

        window.onload = function() {
            showQuestion(currentQuestionIndex);
        }
    </script>
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
            <form id="quiz-form" action="quiz_result.php" method="POST">
                <div class="question">
                    <p id="question-text"></p>
                    <input type="radio" name="answer" value="1" id="answer1"><label for="answer1" id="option1"></label><br>
                    <input type="radio" name="answer" value="2" id="answer2"><label for="answer2" id="option2"></label><br>
                    <input type="radio" name="answer" value="3" id="answer3"><label for="answer3" id="option3"></label><br>
                    <input type="radio" name="answer" value="4" id="answer4"><label for="answer4" id="option4"></label><br>
                    <input type="hidden" name="question_id" id="question_id">
                    <input type="hidden" name="score" id="score">
                </div>
                <button type="button" onclick="nextQuestion()">Next</button>
            </form>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>