<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Market</h2></center>
    <br />

    <table id="jobsTable" style="width:100%;">
        <tr>
            <td>Item:</td>
            <td>Stats:</td>
            <td>Cost:</td
        </tr>

        <tr class="itemInShop">
            <td>
                <b>Item 1</b><br>
                <i>This is the description of the item.</i>
            </td>
            <td>
                10<?php echo $attack_symbol?>:10<?php echo $defense_symbol?>
            </td>
            <td>10<?php echo $currency_symbol?></td>
            <td><button style="width:100%;">Buy!</button></td>
        </tr>

        <tr class="itemInShop">
            <td>
                <b>Item 2</b><br>
                <i>This is the description of the item.</i>
            </td>
            <td>
                10<?php echo $attack_symbol?>:10<?php echo $defense_symbol?>
            </td>
            <td>10<?php echo $currency_symbol?></td>
            <td><button style="width:100%;">Buy!</button></td>
        </tr>

        
    </table>

    <?php
    // Generate item shop

}
include("footer.php");
?>