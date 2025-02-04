<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['nickname'])) {
    header("Location: index.php");
    exit();
}

$topic = $_GET['topic'] ?? '';
if (!in_array($topic, ['science', 'numbers'])) {
    header("Location: game.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correct = 0;
    $incorrect = 0;
    $debug = [];
    
    // Get questions from session
    $quiz_questions = $_SESSION['current_quiz_questions'] ?? [];
    
    if (empty($quiz_questions)) {
        header("Location: game.php");
        exit();
    }
    
    for ($i = 0; $i < 5; $i++) {
        $user_answer = $_POST['answer' . $i] ?? '';
        $correct_answer = $quiz_questions[$i]['answer'];
        $question = $quiz_questions[$i]['question'];
        
        // Store debug info for both science and numbers
        $debug[] = [
            'question' => $question,
            'user_answer' => $user_answer,
            'correct_answer' => $correct_answer
        ];
        
        if ($topic === 'science') {
            if (strcasecmp(trim($user_answer), trim($correct_answer)) === 0) {
                $correct++;
            } else {
                $incorrect++;
            }
        } else { // numbers
            if (trim($user_answer) === trim($correct_answer)) {
                $correct++;
            } else {
                $incorrect++;
            }
        }
    }
    
    $points = ($correct * 3) - ($incorrect * 2);
    $_SESSION['current_game_points'] += $points;
    $_SESSION['overall_points'] += $points;
    
    $_SESSION['debug'] = $debug;
    unset($_SESSION['current_quiz_questions']); // Clear the questions after use
    
    header("Location: result.php?correct=$correct&incorrect=$incorrect&points=$points");
    exit();
} else {
    // Get new random questions from database
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE topic = ? ORDER BY RAND() LIMIT 5");
    $stmt->execute([$topic]);
    $quiz_questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Store questions in session for later verification
    $_SESSION['current_quiz_questions'] = $quiz_questions;
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
                <div class="question">
                    <p><?php echo htmlspecialchars($q['question']); ?></p>
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