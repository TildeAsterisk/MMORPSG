<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  //Init job and enemy_stats
  //Generate enemy stats based on job
  $enemy_stats = [  // Associative Array / Dictionary
    'attack' => $_POST['attack'],
    'defense' => $_POST['defense'],
    'currency' => $_POST['moneyReward']
  ];
  $turns=1;//energy modifier?
  $job_energycost=$_POST['energyCost'];
  $job_experiencegained=$_POST['experienceReward'];
  //Subtract energy cost of job
  $energycostquery = mysqli_query($mysql,"UPDATE `stats` SET `energy`=`energy`-'".$job_energycost."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));

  //Attack Effect is = some factor * attack
  $attack_effect = $stats['attack'];
  $defense_effect = $enemy_stats['defense'];
  
  $miniStatsProfile=<<<EOD
  <table style='width:100%;text-align:center;'>
  <tr>
      <td>
        <b>{$user['username']}</b>
      </td>
      <td rowspan='2'>Vs.</td>
      <td>
        <b>Enemy</b>
      </td>
    </tr>
    <tr>
      <td>
        {$stats['attack']}$attack_symbol {$stats['defense']}$defense_symbol
      </td>
      <td>
        {$enemy_stats['attack']}$attack_symbol {$enemy_stats['defense']}$defense_symbol
      </td>
    </tr>
  </table>
  EOD;
  
  echo "You prepare for battle.<br><br>";
  echo $miniStatsProfile;
  /*echo "Your Stats: ATK:{$stats['attack']} DEF:{$stats['defense']}";
  echo "<br><br>You evaluate the enemies defenses...<br>";
  echo "Enemy Stats: ATK:{$enemy_stats['attack']} DEF:{$enemy_stats['defense']}";*/
  if($attack_effect > $defense_effect){
      $ratio = ($attack_effect - $defense_effect)/$attack_effect * $turns;
      $ratio = min($ratio,1);
      $gold_stolen = (int)floor($ratio/2 * $enemy_stats['currency']);
      echo "<br>You defeated the enemy!<br> You stole " . $gold_stolen . " gold!";

      echo "<br><br>You completed the Job.<br>";
      echo "<center><h3>Completed the Job successfully!</h3></center>";

      //Add gained experience
      $battle1 = mysqli_query($mysql,"UPDATE `stats` SET `experience`=`experience`+'".$job_experiencegained."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));

      //Add gold stolen to user points and update db
      $battle2 = mysqli_query($mysql,"UPDATE `stats` SET `currency`=`currency`+'".$gold_stolen."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
      $stats['currency'] += $gold_stolen;
      
      //Enter battle log into db
      $battle3 = mysqli_query($mysql,"INSERT INTO `logs` (`attacker`,`defender`,`attacker_damage`,`defender_damage`,`currency`,`food`,`time`) 
                              VALUES ('".$_SESSION['uid']."','"."0"."','".$attack_effect."','".$defense_effect."','".$gold_stolen."','0','".time()."')") or die(mysqli_error($mysql));
      //$stats['turns'] -= $turns;
  }else{
    echo "<br><br>The enemies defenses were too strong...<br>";
    echo "<center><h3>You failed the Job.</h3></center>";
    //MONEY/ENERGY penalty?
  }

  echo "<center><a href='jobs.php'><button>Do another Job.</button></a><center>";

}
include("footer.php");
?>