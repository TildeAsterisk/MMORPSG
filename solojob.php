<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{

  if ($stats['energy'] < $_POST['energyCost']){
    echo "You don't have enough energy for this job.";
    echo "<br>Wait a while for your energy to regenerate.";
    return;
  }

  //Init job and enemy_stats
  //Generate enemy stats based on job
  $enemy_stats = [  // Associative Array / Dictionary
    'attack' => $_POST['attack'],
    'defense' => $_POST['defense'],
    'currency' => $_POST['moneyReward']
  ];
  $newRandomEnemy=GenerateRandomEnemy($enemy_stats,null);

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
        <b>{$newRandomEnemy['name']}</b>
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
  
  //Generate the battle 
  $weaponTxt = $inventory['weapon']??"bare hands";

  //YOUR TURN
  $damageDealt   = $attack_effect-$defense_effect;
  if($damageDealt < 0){$damageDealt=0;}
  $damageBlocked = $attack_effect - $damageDealt;
  $blockedPercentage=round(($damageBlocked/$attack_effect)*100);
  $values = array_values($newRandomEnemy['equipment']);
  $randomEnemyEquipment = $values[array_rand($values)];
  
  echo "<hr>";
  echo "You prepare to hit <b>{$newRandomEnemy['name']}</b> with your <b>{$weaponTxt}</b><br>";
  //echo "[Calculate the chance to hit...]<br>";
  echo "Your hit lands on <b>{$newRandomEnemy['name']}</b> with a force of <b>{$attack_effect}</b>.<br>";
  echo "Their <b>{$randomEnemyEquipment->name}</b> soaked up <b>{$blockedPercentage}%</b> of the damage.<br>";
  echo "You dealt <b>{$damageDealt}</b> damage to the {$newRandomEnemy['name']}.<br>";

  $attack_effect = $enemy_stats['attack'];
  $defense_effect = $stats['defense'];
  $damageDealt   = $attack_effect-$defense_effect;
  if($damageDealt < 0){$damageDealt=0;}
  $damageBlocked = $attack_effect - $damageDealt;
  $blockedPercentage=round(($damageBlocked/$attack_effect)*100);
  $playerEquipment=[
    'weapon'    => $inventory['weapon'] ??  '{}',
    'head'      => $inventory['head'] ??    '{}',
    'torso'     => $inventory['torso'] ??   '{}',
    'legs'      => $inventory['legs'] ??    '{}',
    'feet'      => $inventory['feet'] ??    '{}'
  ];
  $values = array_values($playerEquipment);
  $randomPlayerEquipment = $values[array_rand($values)];
  $randomPlayerEquipmentTxt = json_decode($randomPlayerEquipment)->name ?? "bare skin";
  //Enemies turn
  $weaponTxt = $newRandomEnemy['equipment']['weapon']->name ?? "bare hands";
  echo "<hr>";
  echo "<b>{$newRandomEnemy['name']}</b> prepares to hit you with their <b>{$weaponTxt}</b><br>";
  //echo "[Calculate the chance to hit...]<br>";
  echo "<b>{$newRandomEnemy['name']}</b> strikes you with a force of <b>{$attack_effect}</b>.<br>";
  echo "Your <b>{$randomPlayerEquipmentTxt}</b> soaked up <b>{$blockedPercentage}%</b> of the damage.<br>";
  echo "<b>{$newRandomEnemy['name']}</b> dealt <b>{$damageDealt}</b> damage to you.<br>";

  $attack_effect = $stats['attack'];
  $defense_effect = $enemy_stats['defense'];
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