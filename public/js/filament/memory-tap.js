document.addEventListener('DOMContentLoaded', () => {
    const colorButtons = document.querySelectorAll('.button');
    const startButton = document.getElementById('start-button');
    const messageElement = document.getElementById('message');
    const gameOverSection = document.getElementById('gameOverSection');
    const finalScoreDisplay = document.getElementById('finalScoreDisplay');
    const submitScoreBtn = document.getElementById("submitScoreBtn");
    const restartBtn = document.getElementById("restartBtn");

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
            startButton.style.display = 'block';
            return;
        }
        if (playerSequence.length === gameSequence.length) {
            setTimeout(nextLevel, 1000);
        }
    }

    function saveScore() {
        const username = document.getElementById("username").value; // Get the username from the input
        const game = 'Memory Tap'; // Current game
        const score = level; // Use the actual score here
        const time = new Date().toLocaleTimeString();

        // Save the score to localStorage
        const scores = JSON.parse(localStorage.getItem('scores')) || [];
        scores.push({ username, game, score, time });
        localStorage.setItem('scores', JSON.stringify(scores));
        level = 0; // Reset level for next game
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
        if (!gameStarted) {
            messageElement.textContent = 'Good luck!';
            startButton.style.display = 'none';
            gameStarted = true;
            gameOver = false;
            gameOverSection.classList.add('hidden'); // Hide game over section
            nextLevel();
        }
    });

    // Add event listener for the submit score button
    submitScoreBtn.addEventListener("click", () => {
        const username = document.getElementById("username").value;
        if (username) {
            saveScore(); // Save the score
            alert("Score submitted!");
            // Reset the game for a new round
            level = 0;
            gameSequence = [];
            playerSequence = [];
            gameStarted = false;
            gameOver = false;
            startButton.style.display = 'block'; // Show start button again
            gameOverSection.classList.add('hidden'); // Hide game over section
            messageElement.textContent = ''; // Clear message
        } else {
            alert("Please enter your name.");
        }
    });

    // Restart button functionality
    restartBtn.addEventListener("click", () => {
        level = 0;
        gameSequence = [];
        playerSequence = [];
        gameStarted = false;
        gameOver = false;
        startButton.style.display = 'block'; // Show start button again
        gameOverSection.classList.add('hidden'); // Hide game over section
        messageElement.textContent = ''; // Clear message
    });
});
