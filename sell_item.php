<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["sell"])){
    echo "Selling Item.";
  }
  else{
    output("You have visited this page incorrectly.");
  }

}


include("footer.php");
?>