<?php
session_start();
include_once("header.php");
include("settlement.php");

// Check if player is logged in
//$_SESSION['uid'] = null;
if(!isset($_SESSION['uid'])){
  echo "You must be logged in to view this page!";
}
else{
  //Player is logged in, show main page
  ?>
  <link href="gridStyle.css" type="text/css" rel="stylesheet" />
  
  <div class="wrapper">
    <div class="grid">
      <!-- Generated grid cells will be inserted here -->
    </div>
  </div>

  <script src="gridView.js"></script>


  <?php
  // Get PlayerHome data in JSON
  /*
  $pHomeGridData=[];
  $pHomeGridData['10,10'] = 'background-color: blue;';
  // Use data to draw grid
  $result = GenerateGrid(21, 21, '20px', $pHomeGridData);
  echo $result;
  */
  ?>

  </div>
  
<script>
  //INIT CELLS
  const cells = document.querySelectorAll('.cell');
  cells.forEach(cell => {
    // Add event listeners to each cell
    cell.addEventListener('click', () => {
        const cellId = cell.getAttribute('cell-id');
        const x = event.target.getAttribute('data-x');
        const y = event.target.getAttribute('data-y');
        console.log(`Cell ${cellId} clicked at position (x: ${x}, y: ${y})`);
        // You can perform any other actions here based on the cell ID

        //DRAW CELLS
    });
  });
</script>

<?php

}
//include("update_stats.php");
include("footer.php");
?>