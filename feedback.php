<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "hugyaw"; // Name of the database, replace it with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch municipalities for the dropdown
$municipalitiesQuery = "SELECT id, name FROM municipalities";
$municipalitiesResult = $conn->query($municipalitiesQuery);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
    $municipality_id = $_POST['municipality_id'];
    $comment = $_POST['comment'];

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (municipality_id, comment) VALUES (?, ?)");
    $stmt->bind_param("is", $municipality_id, $comment);
    $stmt->execute();
    $stmt->close();
}

// Get feedback for the selected municipality
$feedback = [];
if (isset($_GET['municipality_id'])) {
    $municipality_id = $_GET['municipality_id'];
    $feedbackQuery = "SELECT * FROM feedback WHERE municipality_id = ?";
    $stmt = $conn->prepare($feedbackQuery);
    $stmt->bind_param("i", $municipality_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $feedback[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Hugyaw</title>
    <link rel="stylesheet" href="css/feedback_style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="Festival.html">Home</a></li>
                <li><a href="feedback.html">Feedbacks</a></li>
            </ul>
        </nav>
        <h1 class="logo">Hugyaw</h1>
    </header>
    <main>
        <section class="feedback-section">
            <h1>Festival Feedback</h1>

            <!-- Feedback Form -->
            <form action="feedback.html" method="POST" class="feedback-form">
                <label for="municipality_id">Select Municipality:</label>
                <select name="municipality_id" id="municipality_id" required>
                    <option value="">--Select Municipality--</option>
                    <?php while ($row = $municipalitiesResult->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select><br><br>

                <label for="comment">Your Feedback:</label><br>
                <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br><br>

                <button type="submit" name="submit_feedback">Submit Feedback</button>
            </form>

            <hr>

            <!-- Feedback Display Section -->
            <?php if (isset($feedback) && count($feedback) > 0): ?>
                <h2>Feedback for Selected Municipality</h2>
                <div id="feedbackList">
                    <?php foreach ($feedback as $comment): ?>
                        <div class="feedback">
                            <p><strong>Feedback:</strong> <?php echo htmlspecialchars($comment['comment']); ?></p>
                            <p><small>Posted on: <?php echo $comment['created_at']; ?></small></p>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No feedback available for this municipality. Please select a municipality and submit your feedback!</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>© 2024 Hugyaw | All rights reserved.</p>
    </footer>
</body>
</html>
