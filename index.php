<?php
session_start();
include("header.php");
    
    ?>
    <style>
    #loginHeaderDiv{display:none;}
    </style>
    <div id="loginHomepage">
    <center><h1>~* MMO RPG</h1></center>
    <form action="login.php" method="post" style="width:100%;">
    <center>
        Username:<input type="text" name="username"/><br>
        Password:<input type="password" name="password"/><br>
        <input style="margin:10px;" type="submit" name="login" value="Log-in"/>
        <button onclick="window.location.href = 'register.php';" type="button">Register</button>
    </center>
    </form>
    </div>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <center><h2>Rankings</h2>
    <br>
    <?php
    include("leaderboard.php");
    ?>
    </center>
    <?php

include("footer.php");
?>