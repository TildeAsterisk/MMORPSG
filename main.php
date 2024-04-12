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
    
    <div class="grid" id="grid1">
      <!-- Generated grid cells will be inserted here -->
    </div>
    
  </div>

  <!-- Embed the PHP data into a JavaScript variable -->
  <script>
    //GET Player Grid DATA from SQL DB
    var pGridData = <?php 
    $getPGridDataQuery= mysqli_query($mysql,"SELECT `grid-data` FROM `settlement` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $pGridData = mysqli_fetch_assoc($getPGridDataQuery);
    echo json_encode($pGridData);
    ?>;
  </script>

  <script src="gridView.js"></script>
  <?php
}
//include("update_stats.php");
include("footer.php");
?>