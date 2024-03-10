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
  <center><h2 style="margin:0;padding:0;"><i><?php echo ucfirst($user['username'])."</i> - ???"./*$leaderboard['overall'].*/$overall_symbol ?></h2></center><hr>
  <table cellpadding="3" cellspacing="5">
    <!--tr>
      <td>Username:</td>
      <td><i><?php echo $user['username'] ?></td>
    
      <td></td>
      <td></td>
      <td>Points:</td>
      <td><?php  echo $stats['points'] ?></td>
    </tr
    <tr>
      <td>Materials:</td>
      <td><?php  echo $stats['materials'].$materials_symbol ?></td>
      <td><?php  echo '+'.$stats['mat_production'].$materials_symbol.'/ut' ?></td>
      <td><div class="tooltip">?<span class="tooltiptext">Materials<?php echo $materials_symbol;?>, Gained from (lumberjacks/miners? coming soon).</span></div></td>
    </tr-->
    <tr>
    <td>Experience:</td>
      <td><?php  echo $stats['experience']."xp" ?></td>
      <td></td>
      <td><div class="tooltip">?<span class="tooltiptext">Experience<?php echo $currency_symbol;?>, Gained from Jobs.</span></div></td>
    </tr>
    <tr>
    <td>Currency:</td>
      <td><?php  echo $stats['currency'].$currency_symbol ?></td>
      <td><?php  echo '+'.$stats['income'].$currency_symbol.'/ut' ?></td>
      <td><div class="tooltip">?<span class="tooltiptext">Currency<?php echo $currency_symbol;?>, Gained from workers.</span></div></td>
    </tr>
    <!--tr>
      <td>Food:</td>
      <td><?php  echo $stats['food'].$food_symbol ?></td>
      <td><?php  echo '+'.$stats['farming'].$food_symbol.'/ut' ?></td>
      <td><div class="tooltip">?<span class="tooltiptext">Food<?php echo $food_symbol;?>, Gained from farmers.</span></div></td>
    </tr-->
    <tr>
      <td>Attack:</td>
      <td><?php  echo $stats['attack'].$attack_symbol ?></td>
      <td></td>
      <td><div class="tooltip">?<span class="tooltiptext">Attack<?php echo $attack_symbol;?>, Gained from warriors.</span></div></td>
    </tr>
    <tr>
      <td>Defense:</td>
      <td><?php  echo $stats['defense'].$defense_symbol ?></td>
      <td></td>
      <td><div class="tooltip">?<span class="tooltiptext">Defense<?php echo $defense_symbol;?>, Gained from defenders.</span></div></td>
    </tr>
    
  </table>
<!--/pre-->
  <?php

}

include("footer.php");
?>