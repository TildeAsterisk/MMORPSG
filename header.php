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
        <?php 
        if(isset($_SESSION['uid'])){
          include("safe.php");
          //echo "Logged in.";
          //echo $stats['points'];
        ?>

          <h1 style="position:absolute;padding:0;margin:0;">~* MMO RPG</h1>

          <div id="miniProfile">
            <a href="profile.php" class="tooltip">
            <?php echo "<center><b><i><u>".$user['username']."</u></i></b></center>"; ?>
            <center>   
            <?php echo $currency_symbol."<b>".$stats['currency']."</b>"; ?>
            <?php echo $food_symbol."<b>".$stats['energy']."</b>"; ?>   
            <?php echo $materials_symbol."<b>".$stats['experience']."</b>"; ?><br>
            </center>
            <span class="tooltiptext"><?php echo $food_symbol?>=Food,<?php echo $materials_symbol?>=Materials,<?php echo $currency_symbol?>=Currency</span>
            </a>
          </div>

          <br><br><br><hr>
          <div id="navbar">
            <a href="main.php">Home</a>
            <!--a href="profile.php">Profile</a-->
            <a href="inventory.php">Inventory</a>
            <a href="jobs.php">Jobs</a>
            <a href="rankings.php">Fight</a>
            <a href="shop.php">Market</a>
            <a href="logout.php">Log-Out</a>
          </div>
          <hr>

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
      
      <div id="content">