<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Tap</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(to bottom, #5F68E2, #34397C);
            min-height: 100vh;
            background-size: 100% 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Navigation bar */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-bottom: 2px solid #ccc;
        }

        .logo-img {
            height: 40px;
        }

        .menu {
            display: flex;
            gap: 20px;
        }

        .menu-item {
            text-decoration: none;
            color: #000;
            font-weight: 500;
            font-size: 18px;
        }

        .pfp-img {
            height: 40px;
            border-radius: 50%;
        }

        /* Main content */
        .content {
            text-align: center;
            margin: 40px 20px;
        }

        .content h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 300;
        }

        /* Game board */
        #game-board {
            display: grid;
            grid-template-columns: repeat(2, 150px);
            grid-template-rows: repeat(2, 150px);
            gap: 20px;
            justify-content: center;
            margin: 20px 0;
        }

        .button {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            background-color: #333; /* Dark color for inactive state */
        }

        .red {
            background-color: darkred;
        }

        .yellow {
            background-color: darkgoldenrod;
        }

        .green {
            background-color: darkgreen;
        }

        .blue {
            background-color: darkblue;
        }

        .button.active {
            background-color: #777; /* Slightly lighter color for active state */
            transform: scale(1.1); /* Slightly bigger when active */
        }

        .button:active {
            transform: scale(0.95); /* Slightly smaller when clicked */
        }

        #start-button {
            padding: 10px 20px;
            background-color: #fff;
            border: none;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #message {
            margin-top: 20px;
            font-size: 18px;
            color: #fff;
        }

        .hidden {
            display: none;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 14px;
            width: 100%;
            position: relative; /* Change to relative for better positioning */
        }

    </style>
</head>
<body>
    <div class="flex justify-between items-center px-5 py-2 bg-white border-b-2 border-gray-300">
        <div class="logo">
            <a href="{{ route('dashboard') }}">
                <img src="assets/logo.png" alt="Logo" class="h-10">
            </a>
        </div>
        <div class="flex gap-5">
            <a href="{{ route('dashboard') }}" class="text-black font-medium text-lg">Home</a>
            <a href="{{ route('scores') }}" class="text-black font-medium text-lg">Scores</a>
            <a href="{{ route('profile-view') }}" class="text-black font-medium text-lg">Profile</a>
        </div>
        <div class="pfp">
            <a href="{{ route('profile') }}">
                <img src="assets/pfp.png" alt="Profile Picture" class="h-10 rounded-full">
            </a>
        </div>
    </div>

    <div class="content">
        <h2>Memory Tap Game</h2>
        <div id="game-board">
            <div class="button red" data-color="red"></div>
            <div class="button yellow" data-color="yellow"></div>
            <div class="button green" data-color="green"></div>
            <div class="button blue" data-color="blue"></div>
        </div>
        
        <button id="start-button">Start</button>
        <p id="message"></p>

        <div id="gameOverSection" class="hidden">
            <h1>Game Over</h1>
            <p>Your score: <span id="finalScoreDisplay"></span></p>
        </div>
    </div>

    <footer>
        <a href="about.html" class="footer-link">about</a>
        <span>2024 © it.fun | All rights reserved</span>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const colorButtons = document.querySelectorAll('.button');
    const startButton = document.getElementById('start-button');
    const messageElement = document.getElementById('message');
    const gameOverSection = document.getElementById('gameOverSection');
    const finalScoreDisplay = document.getElementById('finalScoreDisplay');

    const sounds = {
        red: new Audio('assets/red.wav'),
        yellow: new Audio('assets/yellow.wav'),
        green: new Audio('assets/green.wav'),
        blue: new Audio('assets/blue.wav')
    };

    let gameSequence = [];
    let playerSequence = [];
    let level = 0;
    let gameStarted = false;
    let gameOver = false;

    function playSound(color) {
        sounds[color].play();
    }

    function lightUpButton(color) {
        const button = document.querySelector(`.${color}`);
        button.classList.add('active');
        setTimeout(() => button.classList.remove('active'), 500);
    }

    function playSequence() {
        let delay = 0;
        gameSequence.forEach((color, index) => {
            setTimeout(() => {
                lightUpButton(color);
                playSound(color);
            }, (index + 1) * 1000);
        });
    }

    function nextLevel() {
        level++;
        messageElement.textContent = `Level ${level}`;
        playerSequence = [];
        const colors = ['red', 'yellow', 'green', 'blue'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        gameSequence.push(randomColor);
        playSequence();
    }

    function checkPlayerMove(color) {
        if (gameOver) return;

        playerSequence.push(color);
        playSound(color);
        const currentMoveIndex = playerSequence.length - 1;
        if (playerSequence[currentMoveIndex] !== gameSequence[currentMoveIndex]) {
            messageElement.textContent = 'Game Over! Press Start to try again.';
            finalScoreDisplay.textContent = level; // Show final score
            gameOverSection.classList.remove('hidden'); // Show game over section
            gameSequence = [];
            gameStarted = false;
            gameOver = true;
            startButton.textContent = 'Restart'; // Change button text to "Restart"
            startButton.style.display = 'block'; // Ensure the button is visible after game over
            return;
        }
        if (playerSequence.length === gameSequence.length) {
            setTimeout(nextLevel, 1000);
        }
    }

    function saveScore() {
    const username = 'Dzul'; // You can get this from localStorage or another source
    const game = 'Catcher'; // Game name
    const scoreReal = score; // The score you want to send

    console.log('Sending score:', scoreReal); // Debugging output

    fetch('/save-score', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            username: username,
            game: game,
            score: scoreReal + "pts",
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Score saved:', data.message);  // Debugging success message
    })
    .catch(error => {
        console.error('Error saving score:', error);
    });
    }

    colorButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (gameStarted && !gameOver) {
                const color = button.getAttribute('data-color');
                checkPlayerMove(color);
                lightUpButton(color);
            }
        });
    });

    startButton.addEventListener('click', () => {
        if (!gameStarted || gameOver) {  // Check if the game is not started or game is over
            if (gameOver) {
                level = 0; // Reset score to 0 on restart
                gameSequence = [];
                playerSequence = [];
                gameOver = false;
                gameStarted = false;
                startButton.textContent = 'Start'; // Change button text back to "Start"
                gameOverSection.classList.add('hidden'); // Hide game over section
                messageElement.textContent = ''; // Clear message
            }
            messageElement.textContent = 'Good luck!';
            startButton.style.display = 'none'; // Hide the button during gameplay
            gameStarted = true;
            gameOver = false;
            nextLevel();
        }
    });
});




    </script>
</body>
</html>
