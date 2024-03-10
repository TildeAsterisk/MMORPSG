<table cellpadding="2" cellspacing="2">
        <tr>
            <td width="50px"><b>Rank</b></td>
            <td width="142.0px"><b>Username</b></td>
            <td width="80px"><b>Power<br>Level</b></td>
            <td width="80px"><b>Shmoneys</b></td>
            <!--td width="200px"><b>Points</b></td-->
        </tr>
        <?php
        $get_users = mysqli_query($mysql,"SELECT `id`,`rank` FROM `ranking` WHERE `rank`>'0' ORDER BY `rank` ASC") or die(mysqli_error($mysql));
        while($row = mysqli_fetch_assoc($get_users)){
            echo "<tr>";
            echo "<td>" . $row['rank'] . "</td>";
            $get_user = mysqli_query($mysql,"SELECT `username` FROM `user` WHERE `id`='".$row['id']."'") or die(mysqli_error($mysql));
            $rank_name = mysqli_fetch_assoc($get_user);
            echo "<td><a href=stats.php?id=".$row['id']."'>" . $rank_name['username'] . "</a></td>";

            $get_power = mysqli_query($mysql,"SELECT `overall` FROM `ranking` WHERE `id`='".$row['id']."'") or die(mysqli_error($mysql));
            $rank_power = mysqli_fetch_assoc($get_power);
            //var_dump($rank_gold);
            echo "<td>" . $rank_power['overall'] .$overall_symbol. "</td>";
            
            $get_gold = mysqli_query($mysql,"SELECT `currency` FROM `stats` WHERE `id`='".$row['id']."'") or die(mysqli_error($mysql));
            $rank_gold = mysqli_fetch_assoc($get_gold);
            echo "<td>" . number_format($rank_gold['currency']) . $currency_symbol."</td>";
            echo "</tr>";
            
        }
        ?>
    </table>