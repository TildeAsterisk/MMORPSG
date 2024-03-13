<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["drop"])){
    DropItemFromInventory($mysql,$_POST['item']);

    header('Location: //inventory.php');
    exit();
    
    
  }
  else{
    output("You have visited this page incorrectly.");
  }

}

function DropItemFromInventory($mysql,$item){
  $item = json_decode($item);
  $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
  $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
  $playerInvDecoded = json_decode($playerInv['items'], true);
  unset($playerInvDecoded[$item]);
  $playerInvJson = json_encode($playerInvDecoded);
  //update JSON in DB
  //$updatePlayerInvQuery = mysqli_query($mysql,"UPDATE `inventory` SET `items`=`items`+'".$newItemJson."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
  $updateQuery = "UPDATE `inventory` SET `items` = '$playerInvJson' WHERE `id` = '".$_SESSION['uid']."'";
  mysqli_query($mysql, $updateQuery) or die(mysqli_error($mysql));
  echo "Item removed from inventory!";
}


include("footer.php");
?>