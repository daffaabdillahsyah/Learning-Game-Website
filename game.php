<?php
session_start();
require_once 'config.php';

// Handle nickname submission
if (isset($_POST['nickname']) && !isset($_SESSION['nickname'])) {
    $_SESSION['nickname'] = htmlspecialchars($_POST['nickname']);
    $_SESSION['overall_points'] = 0;
    $_SESSION['current_game_points'] = 0;
    
    // Check if user exists in leaderboard and get their points
    $stmt = $pdo->prepare("SELECT points FROM leaderboard WHERE nickname = ?");
    $stmt->execute([$_SESSION['nickname']]);
    if ($row = $stmt->fetch()) {
        $_SESSION['overall_points'] = $row['points'];
    }
}

// Check if user is logged in
if (!isset($_SESSION['nickname'])) {
    header("Location: index.php");
    exit();
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'exit') {
    $nickname = $_SESSION['nickname'];
    $points = $_SESSION['overall_points'];
    
    // Save latest score in leaderboard
    $stmt = $pdo->prepare("INSERT INTO leaderboard (nickname, points) VALUES (?, ?) 
                          ON DUPLICATE KEY UPDATE points = VALUES(points)");
    $stmt->execute([$nickname, $points]);
    
    session_destroy();
    header("Location: exit.php?nickname=" . urlencode($nickname) . "&points=" . $points);
    exit();
}

// Update leaderboard after each quiz
if ($_SESSION['current_game_points'] !== 0) {
    $stmt = $pdo->prepare("INSERT INTO leaderboard (nickname, points) VALUES (?, ?) 
                          ON DUPLICATE KEY UPDATE points = VALUES(points)");
    $stmt->execute([$_SESSION['nickname'], $_SESSION['overall_points']]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Learning Game - Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['nickname']); ?>!</h1>
        <p>Current Game Points: <?php echo $_SESSION['current_game_points']; ?></p>
        <p>Overall Points: <?php echo $_SESSION['overall_points']; ?></p>
        
        <div class="menu">
            <h2>Choose a Quiz Topic:</h2>
            <a href="quiz.php?topic=science" class="button">Science and Nature</a>
            <a href="quiz.php?topic=numbers" class="button">Numbers</a>
            <a href="leaderboard.php" class="button">Leaderboard</a>
            <a href="game.php?action=exit" class="button">Exit Game</a>
        </div>
    </div>
</body>
</html> 