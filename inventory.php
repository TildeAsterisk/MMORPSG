<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Inventory</h2></center>
    <br />
    
    <?php

    $get_inventory = mysqli_query($mysql,"SELECT `items` FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $inv_items = mysqli_fetch_assoc($get_inventory);
    //echo implode($inv_items);
    $decoded_items=json_decode(implode($inv_items),true);
    if($decoded_items == NULL){
        $decoded_items=[['name'=>'Starting Item']];
    }
    foreach ($decoded_items as $item) {
        
        foreach($item as $property => $value){
            echo ucfirst($property).": $value<br>";
        }
        echo "<br>";
    }

    $itemTemplate = <<<EOD
        <div style="display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;" class="grid-container">
              <div class="grid-item">
                  <h3>$name</h3>
                  <p>Price: $price/p>
                  <p>Attack: $attack</p>
                  <p>Defense: $defense</p>
                  <p>Description: A legendary sword forged by ancient blacksmiths.</p>
              </div>
          </div>
        EOD;
    ?>

    <?php
}
include("footer.php");

?>