<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    if($playerInv['items'] == NULL){
        echo "Your inventory is empty.<br>";
        return;
    }
    $playerInvDecoded = json_decode($playerInv['items'], true);
    $playerEquipmentDecoded = [
        'weapon'    =>  $playerInv['weapon'],
        'head'      =>  $playerInv['head'],
        'torso'     =>  $playerInv['torso'],
        'legs'      =>  $playerInv['legs'],
        'feet'      =>  $playerInv['feet'],
    ];
    ?>

    <center><h2>Equipment:</h2></center>
    <br />
    <?php
    //Generate Equipment Display Screen
    /*
    var_dump($playerEquipmentDecoded['feet']);
    echo "Head:  {$playerEquipmentDecoded['head']}<br>";
    echo "Torso: {$playerEquipmentDecoded['torso']}<br>";
    echo "Legs:  {$playerEquipmentDecoded['legs']}<br>";
    echo "Feet:  {$playerEquipmentDecoded['feet']}<br>";
    */
    $playerEquipmentDecoded['weapon']=json_decode($playerEquipmentDecoded['weapon']??'{}');
    $playerEquipmentDecoded['head']=json_decode($playerEquipmentDecoded['head']??'{}');
    $playerEquipmentDecoded['torso']=json_decode($playerEquipmentDecoded['torso']??'{}');
    $playerEquipmentDecoded['legs']=json_decode($playerEquipmentDecoded['legs']??'{}');
    $playerEquipmentDecoded['feet']=json_decode($playerEquipmentDecoded['feet']??'{}');
    echo "<center><table id='inventoryTable'>";
    foreach ($playerEquipmentDecoded as $key => $item) {
        $itemExists = ($item->name ?? null);
        if(!$itemExists){continue;}

        $itemEncoded=json_encode($item);
        $escapedItem = htmlspecialchars($itemEncoded, ENT_QUOTES, 'UTF-8');
        // Define the item template
        $item_template = <<<EOD
        <tr>
            <td><b>{$item->name}</b></td>
            <td>{$item->attack}$attack_symbol</td>
            <td>{$item->defense}$defense_symbol</td>
            <td rowspan='2'>{$item->price}$currency_symbol</td>
            <td rowspan='2'>
                <form action="" method="post">
                    <input style="width:100%;" type="submit" name="unequip" value="Unequip" />
                    <input type="hidden" name="item" value="$escapedItem" >
                </form>
            </td>
        </tr>
        <tr>
            <td colspan='3'><i>{$item->description}</i></td>
        </tr>
        <tr>
            <td colspan='5'><hr></td>
        </tr>
        EOD;
        
        echo $item_template;                
    }
    echo "</table></center>";
    
    
    ?>


    <center><h2>Inventory</h2></center>
    <br />

    <?php
    echo "<center><table id='inventoryTable'>";
    
    // Iterate over each item and format the template
    foreach ($playerInvDecoded as $item) {
        $itemEncoded=json_encode($item);
        $escapedItem = htmlspecialchars($itemEncoded, ENT_QUOTES, 'UTF-8');

        // Define the item template
        $item_template = <<<EOD
        <tr>
            <td><b>{$item['name']}</b></td>
            <td>{$item['attack']}$attack_symbol</td>
            <td>{$item['defense']}$defense_symbol</td>
            <td rowspan='2'>{$item['price']}$currency_symbol</td>
            <td rowspan='2'>
                <form action="drop_item.php" method="post">
                    <input style="width:100%;" type="submit" name="drop" value="Drop" />
                    <input type="hidden" name="item" value="$escapedItem" >
                </form>
                <!--form action="sell_item.php" method="post">
                    <input style="width:100%;" type="submit" name="sell" value="Equip" />
                </form-->
            </td>
        </tr>
        <tr>
            <td colspan='3'><i>{$item['description']}</i></td>
        </tr>
        <tr>
            <td colspan='5'><hr></td>
        </tr>
        EOD;

        //THIS IS UNNECESSARY AND CAUSED ERROR!!! //$formatted_template = strtr($item_template, $item);
        echo $item_template;
    }
    echo "</table></center>";
    

    

}
include("update_stats.php");

include("footer.php");

?>