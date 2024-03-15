<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["equipmentSelection"])){
    //Get newItem from dropdown form

    $newItem=$_POST['equipmentSelection'];
    $newItemDecoded=json_decode($newItem);

    //Unequip item from slot
    //get current inventory
    $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    switch (json_decode($newItem)->itemType){
      case EQUIPMENT_HEAD:
        $itemType='head';
        break;
      case EQUIPMENT_TORSO:
        $itemType='torso';
        break;
      case EQUIPMENT_LEGS:
        $itemType='legs';
        break;
      case EQUIPMENT_FEET:
        $itemType='feet';
        break;
    }
    if($playerInv[$itemType] != NULL){
      //player already has item equipped in this slot
    }
    //Decode Player Inventory into Object
    $playerInvDecoded = $playerInv;
    //Push new item to player inventory
    $playerInvDecoded[$itemType]= $newItemDecoded;

    //remove equipped item from inventory

    DropItemFromInventory($mysql, $newItem);

    //encode inventory and update DB
    $playerInvJson = json_encode($playerInvDecoded[$itemType]);

    //update JSON in DB
    $updateQuery = "UPDATE `inventory` SET $itemType = '$playerInvJson' WHERE `id` = '".$_SESSION['uid']."'";
    mysqli_query($mysql, $updateQuery) or die(mysqli_error($mysql));


    echo "You have equipped ".$newItemDecoded->name.".<br>";
    echo "<center><a href='inventory.php'><button>Back to Inventory.</button></a></center><br>";
    include("update_stats.php");
    

  }
  else{
    output("You have visited this page incorrectly.");
  }

}
include("footer.php");
?>