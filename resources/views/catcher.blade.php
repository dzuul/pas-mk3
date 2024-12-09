<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catcher Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
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

        #catcher-game {
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

        canvas {
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: block;
        }

        .hidden {
            display: none;
        }

        #scoreBoard {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        #gameOver {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        #restartBtn {
            background-color: #5F68E2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
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

            #catcher-game {
                width: 90vw;
                height: 50vh;
            }

            #restartBtn {
                font-size: 16px;
                padding: 8px 16px;
            }
        }

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

            #catcher-game {
                width: 100vw;
                height: 40vh;
                padding: 10px;
            }

            #restartBtn {
                font-size: 14px;
                padding: 6px 12px;
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
        <div id="catcher-game">
            <canvas id="gameCanvas"></canvas>
            <div id="scoreBoard">
                <h2>Score: <span id="scoreDisplay">0</span></h2>
            </div>
            <div id="gameOver" class="hidden">
                <h1>Game Over</h1>
                <p>Your score: <span id="finalScoreDisplay"></span></p>
                <button id="restartBtn">Restart</button>
            </div>
        </div>
    </div>

    <footer>
        <a href="about.html" class="footer-link">about</a>
        <p>2024 © it.fun | All rights reserved</p>
    </footer>

    <script>
        const canvas = document.getElementById("gameCanvas");
        const ctx = canvas.getContext("2d");
        const scoreDisplay = document.getElementById("scoreDisplay");
        const finalScoreDisplay = document.getElementById("finalScoreDisplay");
        const gameOverDiv = document.getElementById("gameOver");
        const restartBtn = document.getElementById("restartBtn");

        canvas.width = 800;
        canvas.height = 600;

        let catcherWidth = 150;
        let catcherHeight = 20;
        let catcherX = canvas.width / 2 - catcherWidth / 2;
        let score = 0;
        let missedBlack = 0;
        let caughtRed = 0;
        let fallingItems = [];
        let gameInterval;
        let spawnInterval;
        let isGameOver = false;

        // Send the score to the server automatically when the game ends
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


        // Catcher position based on mouse movement
        canvas.addEventListener('mousemove', (event) => {
            const rect = canvas.getBoundingClientRect();
            const mouseX = event.clientX - rect.left;
            catcherX = mouseX - catcherWidth / 2;
        });

        // Draw the catcher
        function drawCatcher() {
            ctx.fillStyle = "blue";
            ctx.beginPath();
            ctx.moveTo(catcherX, canvas.height - catcherHeight);
            ctx.lineTo(catcherX + catcherWidth, canvas.height - catcherHeight);
            ctx.quadraticCurveTo(catcherX + catcherWidth, canvas.height, catcherX + catcherWidth / 2, canvas.height);
            ctx.quadraticCurveTo(catcherX, canvas.height, catcherX, canvas.height - catcherHeight);
            ctx.fill();
        }

        // Draw the falling item
        function drawFallingItem(item) {
            ctx.beginPath();
            ctx.arc(item.x, item.y, item.radius, 0, Math.PI * 2);
            ctx.fillStyle = item.color;
            ctx.fill();
        }

        // Update falling items position and check for collisions
        function updateFallingItems() {
            for (let i = fallingItems.length - 1; i >= 0; i--) {
                const item = fallingItems[i];
                item.y += item.speed;

                // Check for collision with the catcher
                if (
                    item.y + item.radius >= canvas.height - catcherHeight &&
                    item.x >= catcherX &&
                    item.x <= catcherX + catcherWidth
                ) {
                    checkCollision(item);
                }

                // Remove item if it goes off screen
                if (item.y + item.radius > canvas.height) {
                    if (item.color === "black") {
                        missedBlack++;
                    } else if (item.color === "red") {
                        caughtRed++;
                    }
                    fallingItems.splice(i, 1);
                } else {
                    drawFallingItem(item);
                }
            }
        }

        // Check collision result and update score
        function checkCollision(item) {
            if (item.color === "black") {
                score++;
            } else if (item.color === "red") {
                score -= 2;
                caughtRed++;
                if (caughtRed === 3) {
                    endGame(); // End game if 3 red circles are caught
                    return;
                }
            }

            fallingItems.splice(fallingItems.indexOf(item), 1);
            scoreDisplay.innerText = score; // Update score display
        }

        // End the game
        function endGame() {
    clearInterval(gameInterval);
    clearInterval(spawnInterval);
    isGameOver = true;
    finalScoreDisplay.innerText = score;
    gameOverDiv.classList.remove("hidden");
    
    saveScore();
  // Automatically submit score after game over
}

        // Restart the game
        // Restart the game
        restartBtn.addEventListener("click", () => {
            score = 0;
            missedBlack = 0;
            caughtRed = 0;
            fallingItems = [];
            isGameOver = false;
            gameOverDiv.classList.add("hidden");
            scoreDisplay.innerText = score;

            // Restart the game loop and intervals
            startGame();
        });


        // Start the game
        function startGame() {
            gameInterval = setInterval(() => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawCatcher();
                updateFallingItems();
                checkGameOver();
            }, 15);

            spawnInterval = setInterval(() => {
                if (!isGameOver) {
                    spawnFallingItem();
                }
            }, 1000);
        }

        // Check if the game is over (missed too many black circles)
        function checkGameOver() {
            if (missedBlack >= 3) {
                endGame();
            }
        }

        // Spawn a new falling item
        function spawnFallingItem() {
            const radius = Math.random() * 20 + 10;
            const x = Math.random() * (canvas.width - radius * 2) + radius;
            const color = Math.random() < 0.5 ? "black" : "red";
            fallingItems.push({ x, y: -radius, radius, color, speed: 10 });
        }

        // Start the game when the page is ready
        startGame();
    </script>
</body>
</html>
