<?php
include_once("./functions.php");

$user_get = mysqli_query($mysql,"SELECT * FROM `user` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
$user=mysqli_fetch_assoc($user_get);

$stats_get=mysqli_query($mysql,"SELECT * FROM `stats` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
$stats=mysqli_fetch_assoc($stats_get);

$unit_get = mysqli_query($mysql,"SELECT * FROM `units` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
$unit=mysqli_fetch_assoc($unit_get);

$leaderboard_get=mysqli_query($mysql,"SELECT * FROM `ranking` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
$leaderboard=mysqli_fetch_assoc($leaderboard_get);

$inventory_get=mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
$inventory=mysqli_fetch_assoc($inventory_get);

//$weapon_get = mysqli_query($mysql,"SELECT * FROM `weapon` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
//$weapon=mysqli_fetch_assoc($weapon_get);

?>