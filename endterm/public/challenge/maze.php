<?php $pageTitle = 'Maze Challenge — Eventify'; include dirname(__DIR__, 2) . '/includes/header.php'; ?>

<section class="section">
  <div class="container">
    <h2>Mini Maze Challenge</h2>
    <p>Navigate from Start (green) to Finish (blue). Avoid touching the red walls or the game restarts!</p>
    
    <div style="margin: 20px 0;">
      <button id="restart-btn" class="btn">Restart Game</button>
      <span id="status" style="margin-left: 20px; font-weight: bold; color: #22d3ee;"></span>
    </div>
    
    <div id="maze-container" style="position: relative; display: inline-block; margin: 20px 0;">
      <div id="maze" style="display: grid; grid-template-columns: repeat(10, 40px); gap: 2px; background: #1f2937; padding: 10px; border-radius: 10px;"></div>
      <div id="player" style="position: absolute; width: 36px; height: 36px; background: #22d3ee; border-radius: 50%; transition: all 0.2s; z-index: 10;"></div>
    </div>
  </div>
</section>

<style>
.wall {
  width: 40px;
  height: 40px;
  background: #374151;
  border: 1px solid #4b5563;
}

.wall:hover {
  background: #ef4444 !important;
  cursor: not-allowed;
}

.path {
  width: 40px;
  height: 40px;
  background: #111827;
  border: 1px solid #1f2937;
}

.start {
  background: #10b981 !important;
}

.finish {
  background: #3b82f6 !important;
}

.finish.glow {
  animation: finishGlow 0.8s infinite;
  box-shadow: 0 0 20px #3b82f6;
}

@keyframes finishGlow {
  0%, 100% { 
    background: #3b82f6;
    box-shadow: 0 0 20px #3b82f6;
  }
  50% { 
    background: #60a5fa;
    box-shadow: 0 0 30px #60a5fa, 0 0 40px #60a5fa;
  }
}

.wall.touched {
  background: #ef4444 !important;
  animation: wallFlash 0.3s;
}

@keyframes wallFlash {
  0%, 100% { background: #ef4444; }
  50% { background: #dc2626; }
}

#notification {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #1f2937;
  color: #22d3ee;
  padding: 30px 50px;
  border-radius: 10px;
  border: 2px solid #22d3ee;
  display: none;
  z-index: 1000;
  font-size: 28px;
  font-weight: bold;
  animation: successPulse 0.5s;
  box-shadow: 0 0 30px rgba(34, 211, 238, 0.5);
}

@keyframes successPulse {
  0% { 
    transform: translate(-50%, -50%) scale(0.8);
    opacity: 0;
  }
  50% {
    transform: translate(-50%, -50%) scale(1.1);
  }
  100% { 
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
  }
}
</style>

<div id="notification">🎉 Congratulations! You completed the maze!</div>

<script>
// Simple maze game
const mazeSize = 10;
let playerPos = { row: 0, col: 0 };
let gameWon = false;
let gameOver = false;
let currentMaze = null;

// Multiple predefined maze layouts for variety
const mazeLayouts = [
  // Maze 1 - Original
  [
    [0,1,0,0,0,1,0,0,0,0],
    [0,1,0,1,0,1,0,1,1,0],
    [0,0,0,1,0,0,0,0,1,0],
    [1,1,0,1,1,1,1,0,1,0],
    [0,0,0,0,0,0,1,0,0,0],
    [0,1,1,1,1,0,1,1,1,0],
    [0,0,0,0,0,0,0,0,1,0],
    [0,1,1,1,0,1,1,0,1,0],
    [0,0,0,0,0,1,0,0,0,0],
    [1,1,1,1,1,1,0,1,1,0]
  ],
  // Maze 2 - Different pattern
  [
    [0,0,0,1,0,0,0,1,0,0],
    [1,1,0,1,0,1,0,1,0,1],
    [0,1,0,0,0,1,0,0,0,1],
    [0,1,1,1,0,1,1,1,0,1],
    [0,0,0,1,0,0,0,1,0,0],
    [1,1,0,1,1,1,0,1,1,1],
    [0,0,0,0,0,0,0,0,0,1],
    [1,1,1,1,0,1,1,1,0,1],
    [0,0,0,0,0,1,0,0,0,0],
    [1,1,1,1,1,1,0,1,1,0]
  ],
  // Maze 3 - Another variation
  [
    [0,1,0,0,0,0,1,0,0,0],
    [0,1,0,1,1,0,1,0,1,0],
    [0,0,0,1,0,0,0,0,1,0],
    [1,1,1,1,0,1,1,1,1,0],
    [0,0,0,0,0,0,0,0,1,0],
    [0,1,1,1,1,1,0,0,0,0],
    [0,0,0,0,0,1,1,1,1,0],
    [1,1,0,1,0,0,0,0,1,0],
    [0,0,0,1,1,1,0,0,0,0],
    [1,1,1,1,1,1,0,1,1,0]
  ],
  // Maze 4 - More complex
  [
    [0,0,1,0,0,1,0,0,0,0],
    [1,0,1,0,1,1,0,1,1,0],
    [0,0,0,0,0,0,0,0,1,0],
    [0,1,1,1,0,1,1,0,1,0],
    [0,0,0,1,0,0,1,0,0,0],
    [1,1,0,1,1,0,1,1,1,0],
    [0,0,0,0,0,0,0,0,1,0],
    [0,1,1,1,1,0,1,0,1,0],
    [0,0,0,0,0,0,1,0,0,0],
    [1,1,1,1,1,1,1,0,1,0]
  ]
];

// Generate a random maze layout
function getRandomMaze() {
  const baseMaze = JSON.parse(JSON.stringify(mazeLayouts[Math.floor(Math.random() * mazeLayouts.length)]));
  
  // Simple randomization: randomly change a few walls (max 5 changes)
  for (let i = 0; i < 5; i++) {
    const row = Math.floor(Math.random() * (mazeSize - 2)) + 1; // Avoid start/finish rows
    const col = Math.floor(Math.random() * (mazeSize - 2)) + 1; // Avoid start/finish cols
    
    // Only change if it's not blocking start or finish
    if (!(row === 0 && col === 0) && !(row === mazeSize - 1 && col === mazeSize - 1)) {
      baseMaze[row][col] = Math.random() > 0.7 ? 1 : 0; // 30% chance to add wall
    }
  }
  
  // Ensure finish is always accessible
  baseMaze[mazeSize - 1][mazeSize - 1] = 0;
  baseMaze[0][0] = 0;
  
  return baseMaze;
}

function createMaze() {
  // Generate new random maze
  currentMaze = getRandomMaze();
  
  const maze = document.getElementById('maze');
  maze.innerHTML = '';
  
  for (let row = 0; row < mazeSize; row++) {
    for (let col = 0; col < mazeSize; col++) {
      const cell = document.createElement('div');
      
      if (currentMaze[row][col] === 1) {
        cell.className = 'wall';
        // Add mouseover event to detect wall touches
        cell.addEventListener('mouseenter', () => {
          if (!gameWon && !gameOver) {
            touchWall(cell);
          }
        });
      } else {
        cell.className = 'path';
        if (row === 0 && col === 0) {
          cell.className = 'start';
        } else if (row === mazeSize - 1 && col === mazeSize - 1) {
          cell.className = 'finish';
          cell.id = 'finish-cell';
        }
      }
      
      maze.appendChild(cell);
    }
  }
  
  updatePlayerPosition();
}

function updatePlayerPosition() {
  const player = document.getElementById('player');
  const x = playerPos.col * 42 + 12;
  const y = playerPos.row * 42 + 12;
  player.style.left = x + 'px';
  player.style.top = y + 'px';
  
  // Check if reached finish
  if (playerPos.row === mazeSize - 1 && playerPos.col === mazeSize - 1 && !gameWon) {
    gameWon = true;
    gameOver = true;
    highlightFinish();
    showNotification();
  }
}

function highlightFinish() {
  const finishCell = document.getElementById('finish-cell');
  if (finishCell) {
    finishCell.classList.add('glow');
    // Use Scriptaculous pulsate effect if available
    if (typeof Effect !== 'undefined') {
      new Effect.Pulsate(finishCell, { duration: 1.5, pulses: 5 });
    }
  }
}

function touchWall(wallElement) {
  if (gameWon || gameOver) return;
  
  gameOver = true;
  wallElement.classList.add('touched');
  
  // Update status
  const status = document.getElementById('status');
  status.textContent = '❌ Touched wall! Restarting...';
  status.style.color = '#ef4444';
  
  // Auto-restart after delay
  setTimeout(() => {
    restartGame();
  }, 500);
}

function showNotification() {
  const notification = document.getElementById('notification');
  notification.textContent = '🎉 Congratulations! You completed the maze!';
  notification.style.display = 'block';
  notification.style.opacity = '1';
  
  // Use Scriptaculous appear effect if available
  if (typeof Effect !== 'undefined') {
    new Effect.Appear(notification, { duration: 0.6 });
    // Fade out after delay
    setTimeout(() => {
      new Effect.Fade(notification, { duration: 0.5 });
    }, 3000);
  } else {
    // Fallback animation
    setTimeout(() => {
      notification.style.opacity = '0';
      notification.style.transition = 'opacity 0.5s';
      setTimeout(() => {
        notification.style.display = 'none';
      }, 500);
    }, 3000);
  }
}

function movePlayer(direction) {
  if (gameWon || gameOver) return;
  
  let newRow = playerPos.row;
  let newCol = playerPos.col;
  
  switch(direction) {
    case 'up': newRow--; break;
    case 'down': newRow++; break;
    case 'left': newCol--; break;
    case 'right': newCol++; break;
  }
  
  // Check boundaries
  if (newRow < 0 || newRow >= mazeSize || newCol < 0 || newCol >= mazeSize) {
    return;
  }
  
  // Check if wall - if touching wall, restart
  if (currentMaze[newRow][newCol] === 1) {
    gameOver = true;
    const status = document.getElementById('status');
    status.textContent = '❌ Hit wall! Restarting...';
    status.style.color = '#ef4444';
    
    setTimeout(() => {
      restartGame();
    }, 500);
    return;
  }
  
  playerPos.row = newRow;
  playerPos.col = newCol;
  updatePlayerPosition();
}

function restartGame() {
  // Full reset
  playerPos = { row: 0, col: 0 };
  gameWon = false;
  gameOver = false;
  
  // Clear status
  const status = document.getElementById('status');
  status.textContent = '';
  
  // Hide notification
  const notification = document.getElementById('notification');
  notification.style.display = 'none';
  notification.style.opacity = '1';
  
  // Generate new maze and recreate
  createMaze();
}

// Keyboard controls
document.addEventListener('keydown', (e) => {
  switch(e.key) {
    case 'ArrowUp': movePlayer('up'); break;
    case 'ArrowDown': movePlayer('down'); break;
    case 'ArrowLeft': movePlayer('left'); break;
    case 'ArrowRight': movePlayer('right'); break;
  }
});

// Restart button - fully reset everything
document.getElementById('restart-btn').addEventListener('click', () => {
  restartGame();
});

// Initialize maze on page load
createMaze();
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
