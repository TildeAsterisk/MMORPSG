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
    $playerInvDecoded = json_decode($playerInv['items'], true);

    echo "<table id='inventoryTable'>";
    // Iterate over each item and format the template
    foreach ($playerInvDecoded as $item) {
        $itemEncoded=json_encode($item);
        // Define the item template
        $item_template = <<<EOD
            <tr>
                <td><b>{$item['name']}</b></td>
                <td>{$item['attack']}$attack_symbol</td>
                <td>{$item['defense']}$defense_symbol</td>
            </tr>
            <tr>
                <td colspan='3'><i>{$item['description']}</i></td>
                <td>{$item['price']}$currency_symbol</td>
                <td>
                    <form action="drop_item.php" method="post">
                        <input style="width:100%;" type="submit" name="drop" value="Drop" />
                        <!-- Additional input fields -->
                        <input type="hidden" name="item" value="{$itemEncoded}" />
                    </form>
                    <form action="sell_item.php" method="post">
                        <input style="width:100%;" type="submit" name="sell" value="sell" />
                        <!-- Additional input fields -->
                        <input type="hidden" name="item" value="{$itemEncoded}" />
                    </form>
                </td>
            </tr>
            <tr>
            <td colspan='5'><hr></td>
            </tr>
        EOD;
        $formatted_template = strtr($item_template, $item);
        echo $formatted_template;
    }
    echo "</table>";

}
include("footer.php");

?>