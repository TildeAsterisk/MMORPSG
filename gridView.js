function generateGrid(rows, cols, size, gridData) {
  // Initialize wrapper and grid divs string to store the grid
  //let grid = '<div class="wrapper"> <div class="grid">\n';
  let grid = '';
  // Counter for cell IDs
  let cellId = 1;

  // Loop through each row
  for (let i = 0; i < rows; i++) {
      grid += '  <div class="row">\n';
      // Loop through each cell in the row
      for (let j = 0; j < cols; j++) {
          // Get grid data
          let pCellData = '';
          let inputForm = `<form action="cell_select.php" method="post" ><input class="submitNoStyle" style="position:absolute;width:100%;height:100%;padding:0;margin:0;" type="submit" name="cellButton" value="" /><input type="hidden" name="cell-data" value="${i},${j}" ></form>`;
          if(typeof gridData === 'object'){
            pCellData = gridData[`${i},${j}`] || {};
            currentCellType = pCellData.cellType || "cell";
            currentCellStyle = pCellData.style || "";
          }
          // Add a unique data ID to each cell
          grid += `<div class="${currentCellType}" style="${currentCellStyle}width:${size};height:${size};"> ${inputForm}</div>\n`;
          cellId++; // Increment the cell ID
      }
      grid += '  </div>\n';
  }
  // Close wrapper and grid div
  //grid += '</div></div>\n';

  return grid;
}


//GET GRID DATA FROM SQL
if (!pGridData){pGridData={};}
//Process GRID data
// FROM: {grid-data: "{\"8, 7\": \"background-color: green;\"}"}
// TO  : {10,10: "background-color:blue;"}
pGridData=JSON.parse(pGridData['grid-data']);

//SET HOME BASE CELL
pGridData["10,10"]={
  cellType:"CT-Centre"
};
//Add pGridData
//console.log(pGridData);

//GENERATE GRID HTML
const generatedGrid = generateGrid(21, 21, '20px', pGridData);
// Insert the generated grid into the HTML
document.querySelector(".grid").innerHTML = generatedGrid;


//Character Movement
const character = document.createElement('div');
character.classList.add('character');
document.querySelector('.cell').appendChild(character); // Place the character in the first cell

// Function to move the character
function moveCharacter(targetCell) {
  const targetRect = targetCell.getBoundingClientRect();
  const cellWidth = targetRect.width;
  const cellHeight = targetRect.height;
  const characterSize = 20; // Adjust based on your character's size

  const centerX = targetRect.left + cellWidth / 2 - characterSize / 2;
  const centerY = targetRect.top + cellHeight / 2 - characterSize / 2;

  character.style.transform = `translate(${centerX}px, ${centerY}px)`; // Move the character
}

// Example usage:
const cell1 = document.querySelector('.cell'); // Source cell
const cell2 = document.querySelector('.row:nth-child(1) .cell'); // Target cell
const cell3 = document.querySelector('.row:nth-child(11) .cell'); // Target cell
const cell4 = document.querySelector('.row:nth-child(21) .cell'); // Target cell
const targetCells = [cell1, cell2, cell3, cell4];

// Function to sequentially move the character through the target cells
function moveCharacterSequentially() {
  let currentIndex = 0;

  function moveToNextCell() {
    if (currentIndex >= targetCells.length) {currentIndex=0;}
    if (currentIndex < targetCells.length) {
      const currentTargetCell = targetCells[currentIndex];
      moveCharacter(currentTargetCell);

      // Wait for the animation to finish (you can adjust the delay as needed)
      setTimeout(moveToNextCell, 2000); // Wait for 2 seconds (adjust as desired)

      currentIndex++;
    }
  }

  // Start moving the character
  moveToNextCell();
}

// Call the function to begin sequential movement
moveCharacterSequentially();
