<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}
else{
  if(isset($_POST["drop"])){
    DropItemFromInventory($mysql,$_POST['item']);
    //echo "Removing item:<br>{$_POST['item']}<br><br>From inv:<br>";
    //echo $inventory['items']."<br>";

    //header('Location: inventory.php');
    //exit();
    
    
  }
  else{
    output("You have visited this page incorrectly.");
  }

}



echo "<br><a href='character_sheet.php'><button>See Inventory.</button></a>";

include("footer.php");
?>