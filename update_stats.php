<?php
//Get player stats
// Default Stats
$attack = 5;
$defense = 5;


$getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
$playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
//decode player inv items JSON
$playerInvDecoded = [
    'items' => json_decode($playerInv['items'], true),
    'head'  => json_decode($playerInv['head'], true),
    'torso' => json_decode($playerInv['torso'], true),
    'legs'  => json_decode($playerInv['legs'], true),
    'feet'  => json_decode($playerInv['feet'], true)
];
$totalEquipmentATK=0;
$totalEquipmentDEF=0;
//Calculate stats based on each piece of equipped gear
foreach ($playerInvDecoded as $key => $value) {
    if ($key == 'items'){continue;} //skip items in inventory
    $totalEquipmentATK+=($value['attack'] ?? 0);
    $totalEquipmentDEF+=($value['defense'] ?? 0);
}
$attack+=$totalEquipmentATK;
$defense+=$totalEquipmentDEF;


//Calculate total attack and defense stats of all items in inventory 
/*foreach ($playerInvDecoded as $item) {
    foreach($item as $property => $value){
        if($property == "attack"){
            $totalInventoryAttack+=$value;
        }
        if($property == "defense"){
            $totalInventoryDefense+=$value;
        }
    }
} */

$update_stats = mysqli_query($mysql,"UPDATE `stats` SET 
                            `attack`='".$attack."',`defense`='".$defense."'
                            WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));

?>