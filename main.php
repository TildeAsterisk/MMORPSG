<?php
session_start();
include_once("header.php");

// Check if player is logged in
//$_SESSION['uid'] = null;
if(!isset($_SESSION['uid'])){
  echo "You must be logged in to view this page!";
}
else{
  //Player is logged in, show main page
  ?>

  <!-- Main page HTML stuff-->
  <div id="controlpanel">
      <div id="GameTxtMsg1">Select Mode</div>
    </div>

    <canvas id="myCanvas"></canvas>

    <script type="text/javascript" src="CanvasGame.js"></script>

  <?php
}

include("footer.php");
?>