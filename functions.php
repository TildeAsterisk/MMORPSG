<?php

$food_symbol="&#9753;";
$materials_symbol="&#8862;";
$currency_symbol="&#164;";
$attack_symbol= "&#9876;" ;//"&#128481;";
$defense_symbol="<b>&#128737;</b>";
$overall_symbol="&#9055;";
$energy_symbol="⚡";
$experience_symbol="xp";
$level_symbol="📶";

function protect ($mysqlc,$string){
    return mysqli_real_escape_string($mysqlc,strip_tags(addslashes($string)));
}

function output ($string){
    echo "<div id='output'>" . $string . "</div>";
}

function CalculateOverallLevel($mysql){
    $rank = array();
    $get_attack = mysqli_query($mysql,"SELECT `id`,`attack` FROM `stats` ORDER BY `attack` DESC") or die(mysqli_error($mysql));
    $i = 1;
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
}

function UpdateGlobalRankingStats($mysql){
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
}

?>