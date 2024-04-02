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
  <canvas id="myCanvas"></canvas>
  <style>#myCanvas {margin:-8px;} #content {width:100%;}</style>
  <script>
    var canvas = document.getElementById("myCanvas");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight*0.8;
    canvas.style.backgroundColor = "brown";
    var ctx = canvas.getContext("2d");

    ctx.fillStyle = "black";
    ctx.fillRect(10, 10, 250, 250);
  </script>
  <?php
  /*
  //Find settlement insql db
  $getPlayerStlmntQuery = mysqli_query($mysql,"SELECT * FROM `settlement` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
  $pSettlement = [ 'data' => (object)mysqli_fetch_assoc($getPlayerStlmntQuery)];
  if($pSettlement ==null){
    //Init Settlement Obj
    $pSettlement = new Settlement();
    $pSettlement->InitSettlement($mysql);
  }
  echo "<center><b>Total Population: {$pSettlement['data']->population}</b><br>";
  echo SettlementJobBoardHTMl($pSettlement),"<br>";
  //display income for food, resources
  echo "Income:<br>+1 {$food_symbol}/day<br>+1 {$materials_symbol}/day<br>";
  echo "<br>Buildings:";
  echo "</center>";
  */

}
//include("update_stats.php");
include("footer.php");
?>