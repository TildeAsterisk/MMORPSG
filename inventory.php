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
    $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    if($playerInv['items'] == NULL){
        echo "Your inventory is empty.<br>";
        return;
    }
    $playerInvDecoded = json_decode($playerInv['items'], true);

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
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan='3'><i>{$item['description']}</i></td>
            <td>{$item['price']}$currency_symbol</td>
            <td>
                <form action="drop_item.php" method="post">
                    <input style="width:100%;" type="submit" name="drop" value="Drop" />
                    <input type="hidden" name="item" value="$escapedItem" >
                </form>
                <!--form action="sell_item.php" method="post">
                    <input style="width:100%;" type="submit" name="sell" value="Sell" />
                </form-->
            </td>
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