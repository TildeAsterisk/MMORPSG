<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["battle"])){
    $turns = 1;
    //$turns=protect($mysql,1);
    $id = (int)protect($mysql,$_POST['id']);
    $user_check = mysqli_query($mysql,"SELECT * FROM `stats` WHERE `id`='".$id."'") or die(mysqli_error($mysql));
    if(mysqli_num_rows($user_check) == 0){
        output("There is no user with that ID!");
    }elseif($turns < 1 || $turns > 10){
        output("You must attack with 1-10 turns!");
    }
    /*elseif($turns > $stats['turns']){
        output("You do not have enough turns!");
    }*/
    elseif($id == $_SESSION['uid']){
        output("You cannot attack yourself!");
    }else{
        //Fetch enemy stats from db
        $enemy_stats = mysqli_fetch_assoc($user_check);
        //Attack Effect is = some factor * attack
        $attack_effect = $turns * $stats['attack'];
        $defense_effect = $enemy_stats['defense'];

        $miniStatsProfile=<<<EOD
        <table style='width:100%;text-align:center;'>
        <tr>
            <td>
                <b>{$user['username']}</b>
            </td>
            <td rowspan='2'>Vs.</td>
            <td>
                <b>{$_POST['enemyName']}</b>
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

        echo "<br><br>Your dealt " . number_format($attack_effect) . " damage!<br>";
        echo "The enemy dealt " . number_format($defense_effect) . " damage!<br><br>";
        if($attack_effect > $defense_effect){
            $ratio = ($attack_effect - $defense_effect)/$attack_effect * $turns;
            $ratio = min($ratio,1);
            $gold_stolen = (int)floor($ratio/2 * $enemy_stats['currency']);

            echo "You won the battle! You stole " . $gold_stolen . " gold!";
            echo "<br>you defeated <b><i>{$_POST['enemyName']}</i></b><br>";
            echo "<center><h3>You won the battle!</h3></center>";

            //Update subtract stolen gold from enemies current gold and update db
            $battle1 = mysqli_query($mysql,"UPDATE `stats` SET `currency`=`currency`-'".$gold_stolen."' WHERE `id`='".$id."'") or die(mysqli_error($mysql));
            //$battle2 = mysqli_query($mysql,"UPDATE `stats` SET `points`=`points`+'".$gold_stolen."',`turns`=`turns`-'".$turns."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
            //Add gold stolen to user points and update db
            $battle2 = mysqli_query($mysql,"UPDATE `stats` SET `currency`=`currency`+'".$gold_stolen."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
            $stats['currency'] += $gold_stolen;
            //Enter battle log into db
            $battle3 = mysqli_query($mysql,"INSERT INTO `logs` (`attacker`,`defender`,`attacker_damage`,`defender_damage`,`currency`,`food`,`time`) 
                                    VALUES ('".$_SESSION['uid']."','".$id."','".$attack_effect."','".$defense_effect."','".$gold_stolen."','0','".time()."')") or die(mysqli_error($mysql));
            //$stats['turns'] -= $turns;
        }else{
            echo "<br><b><i>{$_POST['enemyName']}</b></i>'s defenses were too strong...<br>";
            echo "<center><h3>You lost the battle.</h3></center>";
        }
    }
  }
  else{
    output("You have visited this page incorrectly.");
  }

}
include("footer.php");
?>