<?php
$host = 'localhost';
$dbname = 'kids_learning_game';
$username = 'root';
$password = '123456';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    // Create tables if not exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS leaderboard (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nickname VARCHAR(50) NOT NULL,
        points INT NOT NULL,
        UNIQUE KEY unique_nickname (nickname)
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        topic VARCHAR(20) NOT NULL,
        question TEXT NOT NULL,
        answer VARCHAR(255) NOT NULL
    )");
    
    // Initialize questions if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM questions");
    if ($stmt->fetchColumn() == 0) {
        // Science questions
        $science_questions = [
            ["science", "The Earth is flat.", "false"],
            ["science", "Water boils at 100 degrees Celsius at sea level.", "true"],
            ["science", "Dolphins are fish.", "false"],
            ["science", "The Sun is a star.", "true"],
            ["science", "Spiders are insects.", "false"],
            ["science", "Plants need sunlight to grow.", "true"],
            ["science", "The human body has 206 bones.", "true"],
            ["science", "A day on Venus is longer than its year.", "true"],
            ["science", "Bats are blind.", "false"],
            ["science", "Lightning never strikes the same place twice.", "false"],
            ["science", "Humans can breathe and swallow at the same time.", "false"],
            ["science", "The Great Wall of China is visible from space.", "false"],
            ["science", "Blood in your veins is blue.", "false"],
            ["science", "Goldfish have a memory span of only 3 seconds.", "false"],
            ["science", "Sound travels faster in water than in air.", "true"]
        ];
        
        // Numbers questions
        $numbers_questions = [
            ["numbers", "7 × 8 = ?", "56"],
            ["numbers", "15 - 7 = ?", "8"],
            ["numbers", "5 × 11 = ?", "55"],
            ["numbers", "6 × 6 = ?", "36"],
            ["numbers", "25 ÷ 5 = ?", "5"],
            ["numbers", "9 + 9 = ?", "18"],
            ["numbers", "12 + 8 = ?", "20"],
            ["numbers", "100 ÷ 4 = ?", "25"],
            ["numbers", "13 × 4 = ?", "52"],
            ["numbers", "45 - 17 = ?", "28"],
            ["numbers", "16 × 3 = ?", "48"],
            ["numbers", "72 ÷ 9 = ?", "8"],
            ["numbers", "28 + 14 = ?", "42"],
            ["numbers", "7 × 7 = ?", "49"],
            ["numbers", "60 ÷ 5 = ?", "12"]
        ];
        
        // Delete existing questions first
        $pdo->exec("TRUNCATE TABLE questions");
        
        $stmt = $pdo->prepare("INSERT INTO questions (topic, question, answer) VALUES (?, ?, ?)");
        foreach (array_merge($science_questions, $numbers_questions) as $q) {
            $stmt->execute($q);
        }
    }
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 