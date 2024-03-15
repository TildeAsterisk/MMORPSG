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

        <?php


//Display a number of randomly generated items
for ($i = 0; $i <= 4; $i++) {
    echo GenerateRandomItem()[1];
}

?>

    </table>

    <?php
    // Generate item shop

}
include("footer.php");
?>