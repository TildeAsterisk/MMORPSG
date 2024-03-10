<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(!isset($_GET['id'])){
    output("You have visited this page incorrectly.");
  }
  else{
    $id=protect($mysql,$_GET['id']);
    $user_check=mysqli_query($mysql,"SELECT * FROM `user` WHERE `id`='".$id."'") or die(mysqli_error($mysql));
    if(mysqli_num_rows($user_check)== 0){
      output("There is no user with that ID.");
    }
    else{
      $s_user = mysqli_fetch_assoc($user_check);
      $stats_stats = mysqli_query($mysql,"SELECT * FROM `stats` WHERE `id`='".$id."'") or die(mysqli_error($mysql));
      $s_stats = mysqli_fetch_assoc($stats_stats);
      
      $units_units = mysqli_query($mysql,"SELECT * FROM `units` WHERE `id`='".$id."'") or die(mysqli_error($mysql));
      $s_units = mysqli_fetch_assoc($units_units);

      $stats_rank = mysqli_query($mysql,"SELECT * FROM `ranking` WHERE `id`='".$id."'") or die(mysqli_error($mysql));
      $s_rank = mysqli_fetch_assoc($stats_rank);
    ?>
    <center><h2>Visiting: <b><i><?php echo $s_user['username']; ?></i></b></h2></center>
    <br />
    <?php
    echo $s_user['username'];
      ?>
      <br /><br />
      <b>Power Level: <?php echo $s_rank['overall']; ?></b> 
      <br />
      <b>Gold: <?php echo $s_stats['currency']; ?></b> 
      <!--br />
      <b>Points: <?php echo number_format($s_stats['points']); ?></b-->
      <br />
      <br />
      <form action="battle.php" method="post">
      <?php
      $attacks_check = mysqli_query($mysql,"SELECT `id` FROM `logs` WHERE `attacker`='".$_SESSION['uid']."' AND `defender`='".$id."' AND `time`>'".(time() - 86400)."'") or die(mysqli_error($mysqli));
      ?>
      <i>Attacks on <?php echo $s_user['username']; ?> in the last 24 hours: (<?php echo mysqli_num_rows($attacks_check); ?>/5)</i><br />
      
      <?php
      if(mysqli_num_rows($attacks_check) < 5){
      ?>
      <table>
        <tr>
          <td>Send Warriors:</td>
          <td><input type="range" name="turns" min="0" max="10" value="1" step="1" oninput="this.nextElementSibling.value = this.value+' Unit(s)' " /><output>1 Unit(s)</output></td>
          <td></td>
        </tr>

        <!--tr>
          <td>Send Scouts:</td>
          <td><input type="range" name="turns" min="0" max="10" value="1" step="1" oninput="this.nextElementSibling.value = this.value+' Unit(s)' " disabled="disabled" /><output>1 Unit(s)</output></td>
          <td></td>
        </tr-->
      </table>

      

      <br>
      <input type="submit" name="trade" value="Trade
Units" disabled="disabled" />
<input type="submit" name="battle" value="Send
Attackers" />
<input type="submit" name="scout" value="Send
Scouts" disabled="disabled" />
      <!--input type="submit" name="food" value="Raid for Food" /-->
      <input type="hidden" name="id" value="<?php echo $id; ?>"/>

      <?php
      }
      ?>
      </form>
      <?php
  }
}
}
include("footer.php");
?>