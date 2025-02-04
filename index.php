<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Learning Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Kids Learning Game</h1>
        <?php
        session_start();
        
        if (!isset($_SESSION['nickname'])) {
            // Show nickname form if not set
            ?>
            <form action="game.php" method="POST">
                <div class="form-group">
                    <label for="nickname">Enter your nickname:</label>
                    <input type="text" id="nickname" name="nickname" required>
                </div>
                <button type="submit">Start Game</button>
            </form>
            <?php
        } else {
            // Show menu if nickname is set
            header("Location: game.php");
            exit();
        }
        ?>
    </div>
</body>
</html> 