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

    $getPlayerFleetQuery = mysqli_query($mysql,"SELECT * FROM `fleet` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerFleet = mysqli_fetch_assoc($getPlayerFleetQuery);
    if($playerFleet['ships'] == NULL){
        echo "<center><h1>Your fleet is empty.</h1><br>";
        echo "Buy some items in the market.</center>";
        //$playerFleet['items'] = '{}';
        return;
    }
    $playerFleetDecoded = json_decode($playerFleet['ships'], true);
    echo "<p>",var_dump($playerFleetDecoded),"</p>";
  
  ?>

  <?php
}
//include("update_stats.php");
include("footer.php");
?>