<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['nickname'])) {
    header("Location: index.php");
    exit();
}

$correct = $_GET['correct'] ?? 0;
$incorrect = $_GET['incorrect'] ?? 0;
$points = $_GET['points'] ?? 0;

// Update leaderboard immediately after quiz
$stmt = $pdo->prepare("INSERT INTO leaderboard (nickname, points) VALUES (?, ?) 
                      ON DUPLICATE KEY UPDATE points = VALUES(points)");
$stmt->execute([$_SESSION['nickname'], $_SESSION['overall_points']]);

// Get debug info if available
$debug = $_SESSION['debug'] ?? [];
unset($_SESSION['debug']); // Clear debug info after use
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .debug-info {
            margin: 20px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .debug-item {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .correct {
            color: #28a745;
            font-weight: bold;
        }
        .incorrect {
            color: #dc3545;
            font-weight: bold;
        }
        .points-change {
            font-size: 1.1em;
            font-weight: bold;
        }
        .points-positive {
            color: #28a745;
        }
        .points-negative {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quiz Results</h1>
        <div class="results">
            <p>Correct Answers: <?php echo $correct; ?></p>
            <p>Incorrect Answers: <?php echo $incorrect; ?></p>
            <p>Points from this quiz: 
                <span class="points-change <?php echo $points >= 0 ? 'points-positive' : 'points-negative'; ?>">
                    <?php echo $points > 0 ? '+' . $points : $points; ?>
                </span>
            </p>
            <p>Current Game Points: <?php echo $_SESSION['current_game_points']; ?></p>
            <p>Overall Points: <?php echo $_SESSION['overall_points']; ?></p>
        </div>
        
        <?php if (!empty($debug)): ?>
        <div class="debug-info">
            <h2>Answer Details:</h2>
            <?php foreach ($debug as $item): ?>
            <div class="debug-item">
                <p>Question: <?php echo htmlspecialchars($item['question']); ?></p>
                <p>Your Answer: 
                    <span class="<?php echo strcasecmp(trim($item['user_answer']), trim($item['correct_answer'])) === 0 ? 'correct' : 'incorrect'; ?>">
                        <?php echo htmlspecialchars($item['user_answer']); ?>
                    </span>
                </p>
                <?php if (strcasecmp(trim($item['user_answer']), trim($item['correct_answer'])) !== 0): ?>
                    <p>Correct Answer: <span class="correct"><?php echo htmlspecialchars($item['correct_answer']); ?></span></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="menu">
            <h2>What would you like to do next?</h2>
            <a href="game.php" class="button">New Quiz</a>
            <a href="leaderboard.php" class="button">View Leaderboard</a>
            <a href="game.php?action=exit" class="button">Exit Game</a>
        </div>
    </div>
</body>
</html> 