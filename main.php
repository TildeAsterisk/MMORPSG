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
Army Units:
* Train Units
* Send units to fight others
* Play battle simulation

To Do:
* Message Inbox
* Player Logs
* Inventory (Compact)
</pre>

  <?php
}
//include("update_stats.php");
include("footer.php");
?>