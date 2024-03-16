<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  //Character Graphics
  $characterASCII = <<<EOD
  EOD;

  //STATS DISPLAY
    ?>
  <center><div class="tooltip" style="border-bottom:none;">
      <?php 
      echo "<h1 style='margin:0;padding:0;'><i>";
      echo ucfirst($user['username']);
      echo "</i></h1>";
      echo "<h3 style='margin:0;padding:0;'>{$stats['attack']}{$attack_symbol} {$stats['defense']}{$defense_symbol} {$leaderboard['overall']}{$overall_symbol}</h3>" ?><hr>
    <span class="tooltiptext"><?php echo "Power$overall_symbol = ATK{$attack_symbol}+DEF{$defense_symbol}";?></span></div>
  </center>
  <?php

    //INVENTORY DISPLAY
    $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    if($playerInv['items'] == NULL){
        echo "<center><h1>Your inventory is empty.</h1><br>";
        echo "Buy some items in the market.</center>";
        //$playerInv['items'] = '{}';
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
    //Generate Equipment Display Screen
    $playerEquipmentDecoded['weapon']=json_decode($playerEquipmentDecoded['weapon']??'{}');
    $playerEquipmentDecoded['head']=json_decode($playerEquipmentDecoded['head']??'{}');
    $playerEquipmentDecoded['torso']=json_decode($playerEquipmentDecoded['torso']??'{}');
    $playerEquipmentDecoded['legs']=json_decode($playerEquipmentDecoded['legs']??'{}');
    $playerEquipmentDecoded['feet']=json_decode($playerEquipmentDecoded['feet']??'{}');
    ?>

    <center><h2>Equipment:</h2></center>
    <center>
    <table style='width:100%;background-color:rgba(0, 0, 0, 0.1);'>
        <?php 
        echo GenerateEquipmentSlotHTML($playerEquipmentDecoded['head'], EQUIPMENT_HEAD, $playerInvDecoded);
        echo GenerateEquipmentSlotHTML($playerEquipmentDecoded['torso'],EQUIPMENT_TORSO,$playerInvDecoded);
        echo GenerateEquipmentSlotHTML($playerEquipmentDecoded['legs'], EQUIPMENT_LEGS, $playerInvDecoded);
        echo GenerateEquipmentSlotHTML($playerEquipmentDecoded['feet'], EQUIPMENT_FEET, $playerInvDecoded);
        ?>
    </table>
    </center>
    <br>
    <br>
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