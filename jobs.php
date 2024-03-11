<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Jobs</h2></center>
    <br />

    <table id="jobsTable">
        <tr>
            <td>Description:</td>
            <td>Reward:</td>
            <td>Requirements:</td>
            <td>Action:</td>
        </tr>

        <tr class="TemplateJob">
            <td><b>Basic Job</b><br><i>Get some money.</i></td>
            <td>
                +20<?php echo $currency_symbol ?><br>
                +50<?php echo $experience_symbol ?><br>
                <i>
                +1 Common Item
                </i>
            </td>
            <td>
                Level 1<br>
                Energy: 1<?php echo $energy_symbol?><br>
                <i>
                Ammo: 50
                </i>
            </td>
            <td>
                <form action="solojob.php" method="post">
                    <button>Go!</button>
                </form>
            </td>
        </tr>

        <tr class="AdvancedJob">
            <td><b>Advanced Job</b><br><i>Do some real work.</i></td>
            <td>
                +100<?php echo $currency_symbol ?><br>
                +500<?php echo $experience_symbol ?><br>
                <i>
                +1 Common Item<br>
                +1 Rare Item
                </i>
            </td>
            <td>
                Level 3<br>
                Energy: 5<?php echo $energy_symbol?><br>
                <i>
                Ammo: 100
                </i>
            </td>
            <td>
                <form action="solojob.php" method="post">
                    <button>Go!</button>
                </form>
            </td>
        </tr>
        

    </table>

    <?php
    //include("leaderboard.php");
}
include("footer.php");
?>