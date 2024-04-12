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
function moveCharacter(pos, targetPos) {
  /*charElem= charElem.getBoundingClientRect();
  const targetRect = targetCell.getBoundingClientRect();
  const cellWidth = targetRect.width;
  const cellHeight = targetRect.height;
  const characterSize = 20; // Adjust based on your character's size*/
  const dx = (targetPos[0]-pos[0])*20;
  const dy = (targetPos[1]-pos[1])*20;
  console.log("Moved to "+targetPos);

  character.style.transform = `translate(${dx}px, ${dy}px)`; // Move the character
  //console.log(charElem,targetRect);
}

function GetCellElemInGrid(x,y){
  var rowList = document.getElementById('grid1').children;
  //console.log(rowList[x].children[y]);
  return cellInRow = rowList[x].children[y];
}


// Example usage:
const cell1 =[0,0];// Target cell
const cell2 = [Math.random()*21,Math.random()*21];
const cell3 = [Math.random()*21,Math.random()*21];
const cell4 = [Math.random()*21,Math.random()*21];
const targetCells = [cell1, cell2, cell3, cell4];

// Function to sequentially move the character through the target cells
function moveCharacterSequentially() {
  let currentIndex = 0;

  function moveToNextCell() {
    if (currentIndex >= targetCells.length) {currentIndex=0;}
    if (currentIndex < targetCells.length) {
      const currentTargetCell = targetCells[currentIndex];
      moveCharacter(cell1,currentTargetCell);

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

//moveCharacter(cell1,cell2);
