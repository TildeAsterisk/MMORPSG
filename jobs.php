<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Jobs</h2></center>
    <br />

    <table>
        <tr>
            <td>Description:</td>
            <td>Reward:</td>
            <td>Requirements:</td>
            <td>Action:</td>
        </tr>

        <tr class="TemplateJob">
            <td>This is a job.</td>
            <td>
                100<?php echo $stats['currency'].$currency_symbol ?><br>
                Item
            </td>
            <td>
                Level 1<br>
                Ammo: 50
            </td>
            <td>
                <button>Go!</button>
            </td>
        </tr>
        

    </table>

    <?php
    //include("leaderboard.php");
}
include("footer.php");
?>