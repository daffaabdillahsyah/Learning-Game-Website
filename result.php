<?php
session_start();

if (!isset($_SESSION['nickname'])) {
    header("Location: index.php");
    exit();
}

$correct = $_GET['correct'] ?? 0;
$incorrect = $_GET['incorrect'] ?? 0;
$points = $_GET['points'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Quiz Results</h1>
        <div class="results">
            <p>Correct Answers: <?php echo $correct; ?></p>
            <p>Incorrect Answers: <?php echo $incorrect; ?></p>
            <p>Points from this quiz: <?php echo $points; ?></p>
            <p>Current Game Points: <?php echo $_SESSION['current_game_points']; ?></p>
            <p>Overall Points: <?php echo $_SESSION['overall_points']; ?></p>
        </div>
        
        <div class="menu">
            <h2>What would you like to do next?</h2>
            <a href="game.php" class="button">New Quiz</a>
            <a href="leaderboard.php" class="button">View Leaderboard</a>
            <a href="game.php?action=exit" class="button">Exit Game</a>
        </div>
    </div>
</body>
</html> 