<?php
session_start();

if (!isset($_SESSION['nickname'])) {
    header("Location: index.php");
    exit();
}

// Initialize questions if not exists
if (!file_exists('questions_science.txt')) {
    $science_questions = [
        "The Earth is flat.|false",
        "Water boils at 100 degrees Celsius at sea level.|true",
        "Dolphins are fish.|false",
        "The Sun is a star.|true",
        "Spiders are insects.|false",
        "Plants need sunlight to grow.|true",
        "The human body has 206 bones.|true"
    ];
    file_put_contents('questions_science.txt', implode("\n", $science_questions));
}

if (!file_exists('questions_numbers.txt')) {
    $numbers_questions = [
        "5*11=55|55",
        "12+8=20|20",
        "15-7=8|8",
        "6*6=36|36",
        "25/5=5|5",
        "9+9=18|18",
        "7*8=56|56"
    ];
    file_put_contents('questions_numbers.txt', implode("\n", $numbers_questions));
}

$topic = $_GET['topic'] ?? '';
if (!in_array($topic, ['science', 'numbers'])) {
    header("Location: game.php");
    exit();
}

// Load and randomize questions
$questions = file('questions_' . $topic . '.txt', FILE_IGNORE_NEW_LINES);
shuffle($questions);
$quiz_questions = array_slice($questions, 0, 3);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correct = 0;
    $incorrect = 0;
    
    for ($i = 0; $i < 3; $i++) {
        list($question, $answer) = explode('|', $quiz_questions[$i]);
        $user_answer = $_POST['answer' . $i] ?? '';
        
        if ($topic === 'science') {
            if (strtolower($user_answer) === $answer) {
                $correct++;
            } else {
                $incorrect++;
            }
        } else { // numbers
            if ($user_answer === $answer) {
                $correct++;
            } else {
                $incorrect++;
            }
        }
    }
    
    $points = ($correct * 3) - ($incorrect * 2);
    $_SESSION['current_game_points'] += $points;
    $_SESSION['overall_points'] += $points;
    
    header("Location: result.php?correct=$correct&incorrect=$incorrect&points=$points");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - <?php echo ucfirst($topic); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo ucfirst($topic); ?> Quiz</h1>
        <form method="POST">
            <?php foreach ($quiz_questions as $i => $q): ?>
                <?php list($question, $answer) = explode('|', $q); ?>
                <div class="question">
                    <p><?php echo htmlspecialchars($question); ?></p>
                    <?php if ($topic === 'science'): ?>
                        <select name="answer<?php echo $i; ?>" required>
                            <option value="">Select answer</option>
                            <option value="true">True</option>
                            <option value="false">False</option>
                        </select>
                    <?php else: ?>
                        <input type="number" name="answer<?php echo $i; ?>" required>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Answers</button>
        </form>
    </div>
</body>
</html> 