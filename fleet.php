<?php
session_start();
include_once("header.php");
include("settlement.php");

// Check if player is logged in
//$_SESSION['uid'] = null;
if(!isset($_SESSION['uid'])){
  echo "You must be logged in to view this page!";
}
else{
  //Player is logged in, show main page

    $getPlayerFleetQuery = mysqli_query($mysql,"SELECT * FROM `fleet` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerFleet = mysqli_fetch_assoc($getPlayerFleetQuery);
    if($playerFleet['ships'] == NULL){
        echo "<center><h1>Your fleet is empty.</h1><br>";
        echo "Buy some items in the market.</center>";
        //$playerFleet['items'] = '{}';
        return;
    }
    $playerFleetDecoded = json_decode($playerFleet['ships'], true);
    ?>
    <center><h2>Fleet Command</h2></center>
    <br />
    <?php
    echo "<div class='image-container'>";
    // Iterate over each item and format the template
    foreach ($playerFleetDecoded as $key => $item) {
        $itemEncoded=json_encode($item);
        $escapedItem = htmlspecialchars($itemEncoded, ENT_QUOTES, 'UTF-8');

        // Define the item template
        $item_template = <<<EOD
        <div class="tooltip-nodec">
            <img src="https://file.aiquickdraw.com/m/1726866541_403dbd46ee61439f8a694513ab4f96e9.png" alt="Ship Image" style="--animation-order:{$key};">
            <span class="tooltiptext">
            <b>{$item['name']}</b><br>
            {$item['attack']}$attack_symbol
            {$item['defense']}$defense_symbol
            {$item['price']}$
            <br>
            <!--form action="drop_item.php" method="post">
                <input style="width:100%;" type="submit" name="drop" value="Drop" />
                <input type="hidden" name="item" value="$escapedItem" >
            </form-->
                <!--form action="sell_item.php" method="post">
                <input style="width:100%;" type="submit" name="sell" value="Equip" />
            </form-->
            <i>{$item['description']}</i>
            </span>
        </div>
        EOD;

        //$formatted_template = strtr($item_template, $item); //THIS IS UNNECESSARY AND CAUSED ERROR!!! 
        echo $item_template;
    }
    
    /*echo "<center><table id='inventoryTable'>";
    // Iterate over each item and format the template
    foreach ($playerFleetDecoded as $item) {
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

        //$formatted_template = strtr($item_template, $item); //THIS IS UNNECESSARY AND CAUSED ERROR!!! 
        echo $item_template;
    }
    echo "</table></center>";
    */
    //echo "<br><br><br><p>",var_dump($playerFleetDecoded),"</p>";
  
  ?>

  <?php
}
//include("update_stats.php");
include("footer.php");
?>