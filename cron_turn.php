<?php
include("functions.php");
include("connection.php");

//Runs every 30 mins
$get_users=mysqli_query($mysql,"SELECT * FROM `stats`") or die(mysqli_error($mysql));
while($user = mysqli_fetch_assoc($get_users)){
  $update = mysqli_query($mysql,"UPDATE `stats` SET 
  `currency`=`currency`+'".$user['income']."',
  `food`=`food`+'".$user['farming']."'") or die(mysqli_error($mysql));
  //`turns`=`turns`+'5' WHERE `id`='".$user['id']."'"

}

//include("cron_logs.php");
//Deletes entries from logs that are older than 24 hours or 86400s
mysqli_query($mysql,"DELETE FROM `logs` WHERE `time`<'".(time()-86400)."'") or die(mysqli_error($mysql));

//include("cron_rankings.php");
// Rankings update every period time
//Update Rankings, global leaderboard
$get_attack = mysqli_query($mysql,"SELECT `id`,`attack` FROM `stats` ORDER BY `attack` DESC") or die(mysqli_error($mysql));
$i = 1;
$rank = array();
while($attack = mysqli_fetch_assoc($get_attack)){
    $rank[$attack['id']] = $attack['attack'];
    mysqli_query($mysql,"UPDATE `ranking` SET `attack`='".$i."' WHERE `id`='".$attack['id']."'") or die(mysqli_error($mysql));
    $i++;
}

$get_defense = mysqli_query($mysql,"SELECT `id`,`defense` FROM `stats` ORDER BY `defense` DESC") or die(mysqli_error($mysql));
$i = 1;
while($defense = mysqli_fetch_assoc($get_defense)){
    $rank[$defense['id']] += $defense['defense'];
    mysqli_query($mysql,"UPDATE `ranking` SET `defense`='".$i."' WHERE `id`='".$defense['id']."'") or die(mysqli_error($mysql));
    $i++;
    //Set overall power level for each ranked user
    mysqli_query($mysql,"UPDATE `ranking` SET `overall`='".$rank[$defense['id']]."' WHERE `id`='".$defense['id']."'") or die(mysqli_error($mysql));
}

asort($rank);
$rank2 = array_reverse($rank,true);
$i = 1;
//for each ranked user set overall to new rank
foreach($rank2 as $key => $val){
    mysqli_query($mysql,"UPDATE `ranking` SET `rank`='".$i."' WHERE `id`='".$key."'") or die(mysqli_error($mysql));
    $i++;
}



?>