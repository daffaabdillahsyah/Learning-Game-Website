# Kids Learning Game

An interactive learning game website for kids featuring science facts and math questions.

## Features

- Two quiz categories: Science & Nature and Numbers
- 5 random questions per quiz
- True/False questions for Science & Nature
- Mathematical equations for Numbers
- Point system: +3 for correct answers, -2 for incorrect answers
- Leaderboard with sorting options
- Multiple quizzes in one game session
- Progress tracking across sessions

## Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Web server (Apache/Nginx) or PHP's built-in server

## Installation

1. Clone the repository or download the files
2. Set up the database:
   ```sql
   CREATE DATABASE kids_learning_game;
   ```

3. Configure database connection in `config.php`:
   ```php
   $host = 'localhost';
   $dbname = 'kids_learning_game';
   $username = 'root';
   $password = '(your password)';
   ```

4. Run using PHP's built-in server:
   ```bash
   php -S localhost:8000
   ```

## File Structure

- `index.php` - Entry point and nickname input
- `game.php` - Main menu and game management
- `quiz.php` - Quiz interface and logic
- `result.php` - Quiz results display
- `leaderboard.php` - Player rankings
- `exit.php` - Game over screen
- `config.php` - Database configuration and initialization
- `style.css` - Styling for all pages

## Game Rules

1. **Starting the Game**
   - Enter your nickname
   - Choose a quiz topic
   - Start with 0 points

2. **Quiz Format**
   - 5 questions per quiz
   - Science & Nature: True/False questions
   - Numbers: Mathematical equations

3. **Scoring System**
   - Correct answer: +3 points
   - Incorrect answer: -2 points
   - Maximum points per quiz: +15 (all correct)
   - Minimum points per quiz: -10 (all incorrect)

4. **Question Bank**
   - 15 unique questions per topic
   - Questions randomly selected
   - No repeats within same quiz

5. **Features**
   - View quiz results after each attempt
   - Track current game points
   - View overall points across all games
   - Sort leaderboard by points or nickname
   - Start new game at any time

## Navigation

1. **Main Menu**
   - Science and Nature Quiz
   - Numbers Quiz
   - Leaderboard
   - Exit Game

2. **After Quiz**
   - View Results
   - Start New Quiz
   - View Leaderboard
   - Exit Game

3. **Leaderboard**
   - Sort by Points
   - Sort by Nickname
   - Return to Game

## Database Structure

1. **Leaderboard Table**
   ```sql
   CREATE TABLE leaderboard (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nickname VARCHAR(50) NOT NULL,
       points INT NOT NULL,
       UNIQUE KEY unique_nickname (nickname)
   );
   ```

2. **Questions Table**
   ```sql
   CREATE TABLE questions (
       id INT AUTO_INCREMENT PRIMARY KEY,
       topic VARCHAR(20) NOT NULL,
       question TEXT NOT NULL,
       answer VARCHAR(255) NOT NULL
   );
   ```

## Contributing

Feel free to submit issues and enhancement requests.
