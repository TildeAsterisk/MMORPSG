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
<center><h1>Control Center</h1></center>
<pre>
Settlements:
  Stats: Location, Conditions, Population, Food, Resources
  - Activities:
    * List of current jobs (foragers, builders, attackers)
  - Expeditions
</pre>
  <?php
  include("settlement.php");
  //Init Settlement Obj
  $pSettlement = new Settlement();
  $pSettlement->InitSettlement();
  /*echo "<hr>Settlement Initialized.<br>";
  echo "\$data: ",var_dump($pSettlement->data),"<hr>";
  */
  
  

}
//include("update_stats.php");
include("footer.php");
?>