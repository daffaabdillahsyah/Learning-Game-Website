<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Over</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Game Over</h1>
        
        <div class="final-score">
            <h2>Final Score</h2>
            <p>Nickname: <?php echo htmlspecialchars($_GET['nickname'] ?? ''); ?></p>
            <p>Total Points: <?php echo $_GET['points'] ?? 0; ?></p>
        </div>
        
        <div class="menu">
            <h2>Would you like to play again?</h2>
            <a href="index.php" class="button">Start New Game</a>
            <a href="leaderboard.php" class="button">View Leaderboard</a>
        </div>
    </div>
</body>
</html> 