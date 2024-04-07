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
  style:"background-color:blue;",
  cellType:"CT-Centre"
};
//Add pGridData
//console.log(pGridData);

//GENERATE GRID HTML
const generatedGrid = generateGrid(21, 21, '20px', pGridData);
// Insert the generated grid into the HTML
document.querySelector(".grid").innerHTML = generatedGrid;

//INIT CELLS
const cells = document.querySelectorAll('.cell');
/*cells.forEach(cell => {
  // Add event listeners to each cell
  cell.addEventListener('click', () => {
      const cellId = cell.getAttribute('cell-id');
      const x = event.target.getAttribute('data-x');
      const y = event.target.getAttribute('data-y');
      console.log(`Cell ${cellId} clicked at position (x: ${x}, y: ${y})`);
      // You can perform any other actions here based on the cell ID

      //DRAW CELLS
  });
});*/