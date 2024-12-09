<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aim Trainer</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>* {
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
    }
    
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
    
    .content {
        text-align: center;
        margin: 40px 20px;
    }
    
    #aim-trainer-game {
        position: relative;
        width: 80vw; 
        height: 60vh;
        max-width: 800px; 
        max-height: 500px; 
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
    }
    
    #start-button, #restart-button {
        background-color: #5F68E2;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 18px;
        cursor: pointer;
        border-radius: 5px;
    }
    
    #target {
        width: 100px;
        height: 100px;
        background-color: #ff6347;
        border-radius: 50%;
        position: absolute;
        cursor: pointer;
    }
    
    .hidden {
        display: none;
    }
    
    #timer {
        font-size: 24px;
        margin: 20px 0;
    }
    
    footer {
        text-align: center;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        font-size: 14px;
        position: absolute;
        width: 100%;
        bottom: 0;
    }
    
    .footer-link {
        color: #fff;
        text-decoration: none;
        margin-right: 10px;
        font-weight: 500;
    }
    
    .footer-link:hover {
        text-decoration: underline;
    }
    
    /* Media Queries for Responsive Design */
    
    /* For tablets and larger mobile devices */
    @media (max-width: 768px) {
        .nav {
            flex-direction: column;
            padding: 15px;
        }
    
        .logo-img {
            height: 35px;
        }
    
        .menu {
            flex-direction: column;
            gap: 10px;
        }
    
        .menu-item {
            font-size: 16px;
        }
    
        #aim-trainer-game {
            width: 90vw; 
            height: 50vh;
        }
    
        #start-button, #restart-button {
            font-size: 16px;
            padding: 8px 16px;
        }
    
        #target {
            width: 80px;
            height: 80px;
        }
    
        #timer {
            font-size: 20px;
        }
    
        footer {
            padding: 15px;
        }
    }
    
    /* For smaller mobile devices */
    @media (max-width: 480px) {
        .nav {
            padding: 10px;
        }
    
        .logo-img {
            height: 30px;
        }
    
        .menu {
            gap: 5px;
        }
    
        .menu-item {
            font-size: 14px;
        }
    
        #aim-trainer-game {
            width: 100vw; 
            height: 40vh;
            padding: 10px;
        }
    
        #start-button, #restart-button {
            font-size: 14px;
            padding: 6px 12px;
        }
    
        #target {
            width: 60px;
            height: 60px;
        }
    
        #timer {
            font-size: 18px;
        }
    
        footer {
            padding: 10px;
            font-size: 12px;
        }
    }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div id="aim-trainer-game">
            <button id="start-button">Start</button>
            <div id="target" class="hidden"></div>
            <div id="result" class="hidden">
                <p id="average-time">Average Reaction Time: 0 ms</p>
                <button id="restart-button">Restart</button>
            </div>
            <p id="timer">Time Left: 30s</p>
        </div>
    </div>

    <footer>        
        <a href="{{ route('about') }}" class="footer-link">about</a>
        <p>2024 © it.fun | All rights reserved</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const startButton = document.getElementById('start-button');
        const target = document.getElementById('target');
        const result = document.getElementById('result');
        const restartButton = document.getElementById('restart-button');
        const timerElement = document.getElementById('timer');
        const averageTimeElement = document.getElementById('average-time');
    
        let gameStartTime, targetAppearanceTime, totalReactionTime = 0, numShots = 0, gameInterval;
    
        function startGame() {
            startButton.classList.add('hidden');
            target.classList.remove('hidden');
            result.classList.add('hidden');
            numShots = 0;
            totalReactionTime = 0;
            timerElement.textContent = 'Time Left: 30s';
    
            gameStartTime = Date.now(); // Record the time when the game starts
            targetAppearanceTime = gameStartTime; // Record target appearance time when game starts
            gameInterval = setInterval(updateTimer, 1000);
    
            // Use 'mousedown' event for registering shots
            target.addEventListener('mousedown', handleShot);
    
            // Position the target within canvas bounds initially
            repositionTarget();
        }
    
        function handleShot(event) {
            // Ensure that the event is from a left mouse button press
            if (event.button === 0) {
                const endTime = Date.now();
                const reactionTime = endTime - targetAppearanceTime;
                totalReactionTime += reactionTime;
                numShots++;
    
                // Reposition target
                repositionTarget();
    
                // Update the time when the target appears again
                targetAppearanceTime = Date.now();
            }
        }
    
        function repositionTarget() {
            const gameArea = document.getElementById('aim-trainer-game');
            const maxX = gameArea.clientWidth - 120; // Adjust based on target size
            const maxY = gameArea.clientHeight - 120; // Adjust based on target size
            const x = Math.random() * maxX;
            const y = Math.random() * maxY;
            target.style.left = `${x}px`;
            target.style.top = `${y}px`;
        }
    
        function updateTimer() {
            const elapsedTime = Math.floor((Date.now() - gameStartTime) / 1000);
            const timeLeft = Math.max(0, 2 - elapsedTime); // Corrected to 30 seconds
            timerElement.textContent = `Time Left: ${timeLeft}s`;
    
            if (timeLeft <= 0) {
                clearInterval(gameInterval);
                endGame();
            }
        }
    
        function endGame() {
            target.classList.add('hidden');
            result.classList.remove('hidden');
            averageTimeElement.textContent = `Average Reaction Time: ${Math.round(totalReactionTime / numShots)} ms`;
            saveScore();
        }
    
        function saveScore() {
            const username = 'Dzul'; // You can get this from localStorage or another source
            const game = 'Aim Trainer'; // Game name
            const score = Math.round(totalReactionTime / numShots); // Calculate average reaction time

            // Send the score to the server
            fetch('/save-score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    username: username,
                    game: game,
                    score: score,
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Score saved:', data.message);
            })
            .catch(error => {
                console.error('Error saving score:', error);
            });
        }

    
        function restartGame() {
            startGame();
        }
    
        startButton.addEventListener('click', startGame);
        restartButton.addEventListener('click', restartGame);
    });
    </script>
</body>
</html>
