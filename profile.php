<?php
session_start();
include_once("header.php");

//$_SESSION['uid'] = null;
if(!isset($_SESSION['uid'])){
  echo "You must be logged in to view this page!";
}
else{
  ?>
  <!--pre-->
  <center><h2 style="margin:0;padding:0;"><i><?php echo ucfirst($user['username'])."</i> - ".$leaderboard['overall'].$overall_symbol ?></h2><hr>
  <table cellpadding="3" cellspacing="5" style="width:50%;">
    <tr>
    <td style="border-bottom: 1px dotted grey;">Experience:</td>
      <td><?php  echo $stats['experience']."xp" ?></td>
      <td></td>
      <td ><div class="tooltip">?<span class="tooltiptext">Experience<?php echo $currency_symbol;?>, Gained from Jobs.</span></div></td>
    </tr>
    <tr>
    <td style="border-bottom: 1px dotted grey;">Currency:</td>
      <td><?php  echo $stats['currency'].$currency_symbol ?></td>
      <td></td>
      <td><div class="tooltip">?<span class="tooltiptext">Currency<?php echo $currency_symbol;?>, Gained from workers.</span></div></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px dotted grey;">Attack:</td>
      <td><?php  echo $stats['attack'].$attack_symbol ?></td>
      <td></td>
      <td><div class="tooltip">?<span class="tooltiptext">Attack<?php echo $attack_symbol;?>, Gained from warriors.</span></div></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px dotted grey;">Defense:</td>
      <td><?php  echo $stats['defense'].$defense_symbol ?></td>
      <td></td>
      <td><div class="tooltip">?<span class="tooltiptext">Defense<?php echo $defense_symbol;?>, Gained from defenders.</span></div></td>
    </tr>
    
  </table>
  </center>
<!--/pre-->
  <?php

}

include("footer.php");
?>