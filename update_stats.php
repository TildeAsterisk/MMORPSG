<?php
//Get player stats
$attack = 0;
$defense = 0;
//decode player inv items JSON
$playerInvDecoded = json_decode($inventory['items'], true);
//Calculate total attack and defense stats of all items in inventory
$totalInventoryAttack=0;
$totalInventoryDefense=0;
foreach ($playerInvDecoded as $item) {
    foreach($item as $property => $value){
        if($property == "attack"){
            $totalInventoryAttack+=$value;
        }
        if($property == "defense"){
            $totalInventoryDefense+=$value;
        }
    }
}

$attack+=$totalInventoryAttack;
$defense+=$totalInventoryDefense;


$update_stats = mysqli_query($mysql,"UPDATE `stats` SET 
                            `attack`='".$attack."',`defense`='".$defense."'
                            WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));

?>