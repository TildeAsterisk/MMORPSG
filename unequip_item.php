<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["unequip"])){
    $newItem=$_POST['itemType'];

    //Unequip item from slot
    //get current inventory
    $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    switch ($_POST['itemType']){
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
    if($playerInv[$itemType] == NULL){
      $playerInv[$itemType]='{}';
    }
    $playerInvDecoded = json_decode($playerInv[$itemType], true);
    
    $currentlyEquipped = $playerInvDecoded;
    //remove item from array
    $playerInvDecoded = new stdClass();

    $playerInvJson = json_encode($playerInvDecoded);
    //update JSON in DB
    //Shouls add item to inventory
    $newItem=json_decode($_POST['item']);
    AddItemToInventory($mysql,$_POST['item']);


    $updateQuery = "UPDATE `inventory` SET $itemType = '$playerInvJson' WHERE `id` = '".$_SESSION['uid']."'";
    mysqli_query($mysql, $updateQuery) or die(mysqli_error($mysql));


    echo "You have unequipped ".$currentlyEquipped['name'].".<br>";
    echo "<center><a href='inventory.php'><button>Back to Inventory.</button></a></center><br>";
    include("update_stats.php");
    

  }
  else{
    output("You have visited this page incorrectly.");
  }

}
include("footer.php");
?>