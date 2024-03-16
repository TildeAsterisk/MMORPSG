<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["buy"])){
    $newItem=[
      'name'        => $_POST['name'],
      'description' => $_POST['description'],
      'price'       => $_POST['price'],
      'attack'      => $_POST['attack'],
      'defense'     => $_POST['defense'],
      'itemType'     => $_POST['itemType']
    ];


    if ($stats['currency'] < $newItem['price']){
      echo "You can't afford that, sorry.";
      return;
    }

    //Add to inventory
    $addedToInv = AddItemToInventory($mysql,json_encode($newItem));
    if($addedToInv){
      //Subtract cost of item
      $energycostquery = mysqli_query($mysql,"UPDATE `stats` SET `currency`=`currency`-'".$newItem['price']."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));



      echo "You have purchased ".$newItem['name'].".<br>";
      echo "<a href='shop.php'><button>Back to Market.</button></a><br>";
      echo "<a href='character_sheet.php'><button>See in Inventory.</button></a>";
      include("update_stats.php");
    }

  }
  else{
    output("You have visited this page incorrectly.");
  }

}
include("footer.php");
?>