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

function DropItemFromInventory($mysql,$item){
  $item = json_decode($item);
  $getPlayerInvQuery = mysqli_query($mysql, "SELECT * FROM `inventory` WHERE `id`='" . $_SESSION['uid'] . "'") or die(mysqli_error($mysql));
  $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
  $playerInvDecoded = json_decode($playerInv['items'], true);

  $foundItem = null;
  foreach ($playerInvDecoded as $key => $i) {
    //echo var_dump($item)."<br><br><br>".var_dump($i)."<br><hr>";
    if ($i === (array)$item) {
        $foundItem = $i;
        unset($playerInvDecoded[$key]); // Remove the item from the array
        echo "Removed item from Inventory<br>";
        break; // Stop searching once found
    }
  }

  if ($foundItem == NULL){
      echo "Item not found.";
      return;
  }


  $playerInvJson = json_encode($playerInvDecoded);
  //update JSON in DB
  //$updatePlayerInvQuery = mysqli_query($mysql,"UPDATE `inventory` SET `items`=`items`+'".$newItemJson."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
  $updateQuery = "UPDATE `inventory` SET `items` = '$playerInvJson' WHERE `id` = '".$_SESSION['uid']."'";
  mysqli_query($mysql, $updateQuery) or die(mysqli_error($mysql));

}

echo "<br><a href='inventory.php'><button>See Inventory.</button></a>";

include("footer.php");
?>