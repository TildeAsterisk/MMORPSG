<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    //UpdateGlobalRankingStats($mysql);
    ?>
    <center><h2>Battle Players</h2>
    <br />
    <?php
    include("leaderboard.php");
    ?>
    </center>
    <?php
}
include("footer.php");
?>