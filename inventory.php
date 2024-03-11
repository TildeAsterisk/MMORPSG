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
    foreach ($decoded_items as $item) {
        foreach($item as $property => $value){
            echo ucfirst($property).": $value<br>";
        }
        echo "<br>";
    }
    
}
include("footer.php");

?>