<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Battle Players</h2></center>
    <br />
    <?php
    include("leaderboard.php");
}
include("footer.php");
?>