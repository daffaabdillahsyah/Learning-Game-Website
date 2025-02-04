<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['nickname'])) {
    header("Location: index.php");
    exit();
}

$sort_by = $_GET['sort'] ?? 'points';

// Get players from database
if ($sort_by === 'nickname') {
    $stmt = $pdo->query("SELECT * FROM leaderboard ORDER BY nickname ASC");
} else {
    $stmt = $pdo->query("SELECT * FROM leaderboard ORDER BY points DESC");
}
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Leaderboard</h1>
        
        <div class="sort-options">
            <a href="?sort=points" class="button <?php echo $sort_by === 'points' ? 'active' : ''; ?>">Sort by Points</a>
            <a href="?sort=nickname" class="button <?php echo $sort_by === 'nickname' ? 'active' : ''; ?>">Sort by Nickname</a>
        </div>
        
        <table class="leaderboard">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nickname</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $index => $player): ?>
                    <tr <?php echo $player['nickname'] === $_SESSION['nickname'] ? 'class="current-player"' : ''; ?>>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($player['nickname']); ?></td>
                        <td><?php echo $player['points']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="menu">
            <a href="game.php" class="button">Back to Game</a>
        </div>
    </div>
</body>
</html> 