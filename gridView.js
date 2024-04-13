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

class Character{
  constructor(pos = [0,0]){
    // Init/Construct Character Object
    this.x = pos[0];
    this.y=pos[1];
    console.log("Character spawned at "+this.x,this.y);
    // Generate random path
    this.waypoints = this.GenerateRandomPath();
    this.previousCell = [this.x,this.y];
    this.elem = document.createElement('div');

    //Character init char
    this.elem.classList.add('character');
    document.querySelector('.cell').appendChild(this.elem); // Place the character in the first cell


    // Set on route
    this.moveCharacterSequentially();

  }
  GenerateRandomPath() {
    const cell1 = [Math.random()*21,Math.random()*21];
    const cell2 = [Math.random()*21,Math.random()*21];
    const cell3 = [Math.random()*21,Math.random()*21];
    const cell4 = [Math.random()*21,Math.random()*21];
    const cell5 = [Math.random()*21,Math.random()*21];
    return [cell1, cell2, cell3, cell4,cell5];
  }
  moveCharacter(pos, targetPos) {
    /*charElem= charElem.getBoundingClientRect();
    const targetRect = targetCell.getBoundingClientRect();
    const cellWidth = targetRect.width;
    const cellHeight = targetRect.height;
    const characterSize = 20; // Adjust based on your character's size*/
    
    const dx = (targetPos[0]-pos[0])*20;
    const dy = (targetPos[1]-pos[1])*20;
    this.elem.style.transform = `translate(${dx}px, ${dy}px)`; // Move the character
    //console.log(charElem,targetRect);
  }
  // Function to sequentially move the character through the target cells
  moveCharacterSequentially() {
    let currentIndex = 0;
    let charObj = this;
    function moveToNextCell(targetCells) {
      if (!targetCells){targetCells=[[Math.random()*21,Math.random()*21],[Math.random()*21,Math.random()*21], [Math.random()*21,Math.random()*21], [Math.random()*21,Math.random()*21]]}
      if (currentIndex >= targetCells.length) {currentIndex=0;}
      if (currentIndex < targetCells.length) {
        //this.previousCell = targetCells[currentIndex];
        const currentTargetCell = targetCells[currentIndex];
        charObj.moveCharacter([charObj.x,charObj.y],currentTargetCell);

        // Wait for the animation to finish (you can adjust the delay as needed)
        setTimeout(moveToNextCell, 2000); // Wait for 2 seconds (adjust as desired)

        currentIndex++;
      }
    }

    // Start moving the character
    moveToNextCell(this.waypoints);
  }
}

function GetCellElemInGrid(x,y){
  var rowList = document.getElementById('grid1').children;
  //console.log(rowList[x].children[y]);
  return cellInRow = rowList[x].children[y];
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

//GENERATE GRID HTML
const generatedGrid = generateGrid(21, 21, '20px', pGridData);
// Insert the generated grid into the HTML
document.querySelector(".grid").innerHTML = generatedGrid;


//Create characters
char1 = new Character();
char2 = new Character();
char3 = new Character();
char4 = new Character();
char5 = new Character();
char6 = new Character();
char7 = new Character();
char8 = new Character();
char9 = new Character();
char10 = new Character();
char12 = new Character();
char13 = new Character();
char14 = new Character();
char15 = new Character();
char16 = new Character();
char17 = new Character();
char18 = new Character();
char19 = new Character();
