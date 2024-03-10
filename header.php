<?php
include_once("functions.php");
//connect();
include_once("connection.php");

//$GLOBALS['mysql'] = connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>~* MMORTS</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" type="image/x-icon" href="tabIcon.ico">
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script-->
</head>
<body>
  <?php include("ASCII_Gallery.php"); ?>
<!--iframe id="ASCII_Gallery" src="ASCII_Gallery.html" frameborder="0" style="display: none;"></iframe-->

  <!--div id="header"><h5 style="margin:5px 10px;"><a style="text-decoration:none;" href="index.php">~* MMORTS</a></h5></div-->
    <div id="container">
      <div id="navigation"><div id="nav_div">
        <?php 
        if(isset($_SESSION['uid'])){
          include("safe.php");
          //echo "Logged in.";
          //echo $stats['points'];
        ?>
  <a href="main.php" class="tooltip">
  <?php echo "<center><b><i><u>".$user['username']."</u></i></b></center>"; ?>
  <center>
  <?php echo $food_symbol."<b>".$stats['food']."</b>"; ?>   
  <?php echo $materials_symbol."<b>".$stats['materials']."</b>"; ?>   
  <?php echo $currency_symbol."<b>".$stats['currency']."</b>"; ?><br>
  </center>
  <span class="tooltiptext"><?php echo $food_symbol?>=Food,<?php echo $materials_symbol?>=Materials,<?php echo $currency_symbol?>=Currency</span>
  </a><hr>

          &raquo; <a href="profile.php">Your Stats</a><br />
          &raquo; <a href="shop.php">Command</a><br />
          <!--&raquo; <a href="inventory.php">Inventory</a><br /-->
          <!--&raquo; <a href="units.php">Your Units</a><br /-->
          &raquo; <a href="rankings.php">Battle Players</a><br />
          &raquo; <a href="logout.php">Log-Out</a>
        <?php
        }
        else{
          ?>
          <form action="login.php" method="post">
          Username:<input style="width:95%;" type="text" name="username"/><br />
          Password:<input style="width:95%;" type="password" name="password"/><br /><br/>
          <input type="submit" name="login" value="Log-in"/>
          </form>
          <?php
        }
      ?>
      </div></div>
      <div id="content">