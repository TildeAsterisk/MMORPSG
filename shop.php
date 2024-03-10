<?php
session_start();
include_once("header.php");

//$_SESSION['uid'] = null;
if(!isset($_SESSION['uid'])){
  echo "You must be logged in to view this page!";
}
else{ 
  if(isset($_POST['train'])){
    //Set unit variables taken from form input
    $worker=(int)protect($mysql,$_POST['worker']);
    $farmer=(int)protect($mysql,$_POST['farmer']);
    $warrior=(int)protect($mysql,$_POST['warrior']);
    $defender=(int)protect($mysql,$_POST['defender']);
    //Calculate food needed to train those units
    $food_needed=(10*$worker) + (10*$farmer) + (10*$warrior)+ (10*$defender);

    if($worker < 0 || $farmer < 0 || $warrior <0 || $defender <0){
      output("Choose a valid number of units to train.");
    }
    elseif ($stats['food']<$food_needed){
      output("You don't have enough food to train those units.");
    }
    else{
      //Update unitdb with vars
      $unit['worker'] += $worker;
      $unit['farmer'] += $farmer;
      $unit['warrior'] += $warrior;
      $unit['defender'] += $defender;
      $update_unit=mysqli_query($mysql, "UPDATE `units` SET 
                                        `worker`='".$unit['worker']."',
                                        `farmer`='".$unit['farmer']."',
                                        `warrior`='".$unit['warrior']."',
                                        `defender`='".$unit['defender']."'
                                        WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
      //Subtract food_needed from food and update in gamedb
      $stats['food']-=$food_needed;
      $update_food=mysqli_query($mysql,"UPDATE `stats` SET `food`='".$stats['food']."'WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
      
      output("You have trained your units.");
      include("update_stats.php");
    }
  }
  elseif(isset($_POST["untrain"])){
    $worker=(int)protect($mysql,$_POST['worker']);
    $farmer=(int)protect($mysql,$_POST['farmer']);
    $warrior=(int)protect($mysql,$_POST['warrior']);
    $defender=(int)protect($mysql,$_POST['defender']);
    $food_gained=(8*$worker) + (8*$farmer) + (8*$warrior)+ (8*$defender);
    if($worker < 0 || $farmer < 0 || $warrior <0 || $defender <0){
      output("Choose a valid number of units to train.");
    }
    elseif ($worker<$unit['worker'] || $farmer<$unit['farmer'] || $warrior<$unit['warrior'] || $defender<$unit['defender']){
      output("You don't have that many units to untrain.");
    }
    else{
      $unit['worker'] -= $worker;
      $unit['farmer'] -= $farmer;
      $unit['warrior'] -= $warrior;
      $unit['defender'] -= $defender;
      $update_unit=mysqli_query($mysql, "UPDATE `units` SET 
                                        `worker`='".$unit['worker']."',
                                        `farmer`='".$unit['farmer']."',
                                        `warrior`='".$unit['warrior']."',
                                        `defender`='".$unit['defender']."'
                                        WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));

      $stats['food']+=$food_gained;
      $update_food=mysqli_query($mysql,"UPDATE `stats` SET `food`='".$stats['food']."'WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
      output("You have untrained your units.");
      include("update_stats.php");
    }
  }
  
  ?>
<!--center><h2 style="margin:0;padding:0;">Shop</h2></center><br-->
<h2 style="margin-top:0;">Build</h2>
<input type="submit" name="untrain" value="Set-up
Camp"  disabled="disabled"/>
<input type="submit" name="untrain" value="Build
Farm"   disabled="disabled"/>
<input type="submit" name="untrain" value="Build
Lumber Camp" disabled="disabled"/>
<input type="submit" name="untrain" value="Build
Market" disabled="disabled"/>
<br><br><hr>
<h2>Manage Units</h2>
You can train and untrain your units here.

<form action="shop.php" method="post">
<table cellpadding="5" cellspacing="5">
  <tr>
    <td><b>Unit Type</b></td>
    <td><b>Amount</b></td>
    <td><b>Unit Cost</b></td>
    <td><b>Train More</b></td>
  </tr>
  <tr>
    <td>Worker</td>
    <td><?php echo number_format($unit['worker']); ?></td>
    <td>10 &#9753;</td>
    <td><input type="text" name="worker"/></td>
  </tr>
  <tr>
    <td>Farmer</td>
    <td><?php echo number_format($unit['farmer']); ?></td>
    <td>10 &#9753;</td>
    <td><input type="text" name="farmer"/></td>
  </tr>
  <tr>
    <td>Warrior</td>
    <td><?php echo number_format($unit['warrior']); ?></td>
    <td>10 &#9753;</td>
    <td><input type="text" name="warrior"/></td>
  </tr>
  <tr>
    <td>Defender</td>
    <td><?php echo number_format($unit['defender']); ?></td>
    <td>10 &#9753;</td>
    <td><input type="text" name="defender"/></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="submit" name="train" value="Train"/></td>
  </tr>
</table>
</form>
<!--
<hr>
<form action="shop.php" method="post">
<table cellpadding="5" cellspacing="5">
  <tr>
    <td><b>Unit Type</b></td>
    <td><b>Amount</b></td>
    <td><b>Unit Cost</b></td>
    <td><b>Train More</b></td>
  </tr>
  <tr>
    <td>Worker</td>
    <td><?php echo number_format($unit['worker']); ?></td>
    <td>8 &#9753;</td>
    <td><input type="text" name="worker"/></td>
  </tr>
  <tr>
    <td>Farmer</td>
    <td><?php echo number_format($unit['farmer']); ?></td>
    <td>8 &#9753;</td>
    <td><input type="text" name="farmer"/></td>
  </tr>
  <tr>
    <td>Warrior</td>
    <td><?php echo number_format($unit['warrior']); ?></td>
    <td>8 &#9753;</td>
    <td><input type="text" name="warrior"/></td>
  </tr>
  <tr>
    <td>Defender</td>
    <td><?php echo number_format($unit['defender']); ?></td>
    <td>8 &#9753;</td>
    <td><input type="text" name="defender"/></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="submit" name="untrain" value="Untrain"/></td>
  </tr>
</table>
-->
</form>
  <?php
}
include("footer.php");
?>