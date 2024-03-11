<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  //Init job and enemy_stats
  //Generate enemy stats based on job
  $enemy_stats = [  // Associative Array / Dictionary
    'attack' => 10,
    'defense' => 10,
    'currency' => 20
  ];
  $turns=1;//energy modifier?
  $job_energycost=1;
  $job_experiencegained=50;
  //Subtract energy cost of job
  $energycostquery = mysqli_query($mysql,"UPDATE `stats` SET `energy`=`energy`-'".$job_energycost."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));

  //Attack Effect is = some factor * attack
  $attack_effect = $turns * 0.1 * $stats['attack'];
  $defense_effect = $enemy_stats['defense'];
  
  echo "You send your warriors into battle!<br><br>";
  echo "Your warriors dealt " . number_format($attack_effect) . " damage!<br>";
  echo "The enemy's defenders dealt " . number_format($defense_effect) . " damage!<br><br>";
  if($attack_effect > $defense_effect){
      $ratio = ($attack_effect - $defense_effect)/$attack_effect * $turns;
      $ratio = min($ratio,1);
      $gold_stolen = (int)floor($ratio/2 * $enemy_stats['currency']);
      echo "You won the battle! You stole " . $gold_stolen . " gold!";
      //Update subtract stolen gold from enemies current gold and update db
      //$battle1 = mysqli_query($mysql,"UPDATE `stats` SET `currency`=`currency`-'".$gold_stolen."' WHERE `id`='".$id."'") or die(mysqli_error($mysql));
      //$battle2 = mysqli_query($mysql,"UPDATE `stats` SET `points`=`points`+'".$gold_stolen."',`turns`=`turns`-'".$turns."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
      
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
      echo "You lost the battle!";
      //MONEY/ENERGY penalty?
  }

}
include("footer.php");
?>