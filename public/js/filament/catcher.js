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
let missedBlack = 0; // Count of missed black circles
let caughtRed = 0; // Count of caught red circles
let fallingItems = [];
let gameInterval;
let spawnInterval;
let isGameOver = false;

const submitScoreBtn = document.getElementById("submitScoreBtn");

// Add event listener for submitting score
submitScoreBtn.addEventListener("click", () => {
    const username = document.getElementById("username").value;
    if (username) {
        const scoreEntry = {
            username,
            game: "Catcher Game",
            score,
            time: new Date().toLocaleString(), // Store the current time
        };

        // Save score to localStorage
        const scores = JSON.parse(localStorage.getItem("scores")) || [];
        scores.push(scoreEntry);
        localStorage.setItem("scores", JSON.stringify(scores));

        alert("Score submitted!");
    } else {
        alert("Please enter your name.");
    }
});


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
}

// Restart the game
restartBtn.addEventListener("click", () => {
    score = 0;
    missedBlack = 0;
    caughtRed = 0;
    fallingItems = [];
    isGameOver = false;
    gameOverDiv.classList.add("hidden");
    scoreDisplay.innerText = score;
    startGame();
});

// Start the game
function startGame() {
    gameInterval = setInterval(() => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawCatcher();
        updateFallingItems();
        checkGameOver();
    }, 15); // Update game every 20 ms

    spawnInterval = setInterval(() => {
        if (!isGameOver) {
            spawnFallingItem();
        }
    }, 1000); // Spawn items every 1 seconds
}

// Check if game over conditions are met
function checkGameOver() {
    if (missedBlack === 3) {
        endGame(); // End game if 3 black circles are missed
    }
}

// Spawn falling items (2/3 chance black)
function spawnFallingItem() {
    const radius = 15;
    const x = Math.random() * (canvas.width - radius * 2) + radius;
    const color = Math.random() < (2 / 3) ? "black" : "red"; // 2/3 chance for black
    const speed = 8; // Speed of falling items

    fallingItems.push({ x, y: 0, radius, color, speed });
}

// Start the game initially
startGame();
