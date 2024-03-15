<?php

$food_symbol="&#9753;";
$materials_symbol="&#8862;";
$currency_symbol="&#164;";
$attack_symbol= "&#9876;" ;//"&#128481;";
$defense_symbol="<b>&#128737;</b>";
$overall_symbol="&#9055;";
$energy_symbol="⚡";//"⚡";
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
function GenerateRandomItem() {
    // Random item name and description
    $itemNames = ["Sword of Valor", "Enchanted Amulet", "Dragonhide Boots", "Crystal Wand"];
    $itemDescriptions = [
        "A legendary sword forged by ancient blacksmiths.",
        "A mystical amulet that grants its wearer enhanced abilities.",
        "Sturdy boots made from the hide of a fire-breathing dragon.",
        "A magical wand that channels elemental energy."
    ];

    // Random properties (attack, defense, and price)
    $attack = rand(5, 20);
    $defense = rand(5, 20);
    $price = rand(10, 200);

    // Randomly select an item name and description
    $randomName = $itemNames[array_rand($itemNames)];
    $randomDescription = $itemDescriptions[array_rand($itemDescriptions)];

    $randomNewItem="{'name':'{$randomName}', 'description': '{$randomDescription}', 'price': '{$price}', 'attack': '{$attack}', 'defense': '{$defense}'}";
    //Replace single quotes with double to allow for json decode
    $randomNewItem=str_replace("'",'"', $randomNewItem);
    $randomNewItem=json_decode($randomNewItem);

    // Construct the item template
    $itemTemplate = <<<EOD
        <tr class="itemInShop">
            <td>
                <b>$randomName</b><br>
                <i>$randomDescription</i>
            </td>
            <td>
                $attack<b></b>⚔️<br>$defense<b></b>🛡️
            </td>
            <td>$price&#164;</td>
            <td>
                <form action="buy_item.php" method="post">
                    <input style="width:100%;" type="submit" name="buy" value="Buy!" />
                    <!-- Additional input fields -->
                    <input type="hidden" name="name"        value="$randomName">
                    <input type="hidden" name="description" value="$randomDescription">
                    <input type="hidden" name="price"       value="$price">
                    <input type="hidden" name="attack"      value="$attack">
                    <input type="hidden" name="defense"     value="$defense">
                </form>
            </td>
        </tr>
    EOD;
    //var_dump($randomNewItem);
    return [$randomNewItem,$itemTemplate];
}

function GenerateRandomEnemyName() {
    $adjectives = ["Fierce", "Sinister", "Vengeful", "Dreadful", "Malevolent","Fancy", "Sinister", "Vivacious", "Quirky", "Radiant", "Melancholic", "Surreal", "Zesty", "Ethereal", "Whimsical", "Resilient", "Inquisitive", "Serene", "Luminous", "Mysterious", "Exuberant", "Gloomy", "Captivating", "Dynamic", "Harmonious", "Eloquent", "Jubilant", "Nebulous", "Enchanting", "Audacious", "Tranquil", "Pensive", "Effervescent", "Candid", "Ephemeral", "Euphoric", "Sardonic", "Bewitched", "Placid", "Vibrant", "Tenacious", "Spirited", "Elusive", "Solemn", "Furtive", "Lively", "Enigmatic", "Soothing", "Zealous", "Wistful", "Chimerical", "Incandescent"];
    $nouns = ["Dragon", "Orc", "Serpent", "Wraith", "Goblin", "Troll", "Banshee", "Harpy", "Minotaur", "Wyvern", "Lich", "Cyclops", "Basilisk", "Chimera", "Succubus", "Zombie", "Ghoul", "Vampire", "Werewolf", "Manticore", "Kraken", "Siren", "Gargoyle", "Imp", "Ghost", "Skeleton", "Centaur", "Medusa", "Djinn", "Slime", "Specter", "Gnoll", "Harbinger", "Revenant", "Crawler", "Shadow", "Naga", "Elemental", "Griffon", "Banshee", "Lamia", "Cerberus", "Satyr", "Gorgon", "Bogeyman", "Chupacabra"];

    $randomAdjective = $adjectives[array_rand($adjectives)];
    $randomNoun = $nouns[array_rand($nouns)];

    $enemyName = $randomAdjective . " " . $randomNoun;
    return $enemyName;
}


function GenerateRandomEnemy($stats,$inventory){
    $stats = [  // Associative Array / Dictionary
        'name'    => $stats['name'] ?? GenerateRandomEnemyName(),
        'attack'    => $stats['attack'] ?? 10,
        'defense'   => $stats['defense'] ?? 10,
        'currency'  => $stats['currency'] ?? 10,
        'equipment' => [
            'weapon'    => $inventory['weapon'] ?? GenerateRandomitem()[0],
            'head'      => $inventory['head'] ??  GenerateRandomitem()[0],
            'torso'     => $inventory['torso'] ??  GenerateRandomitem()[0],
            'legs'      => $inventory['legs'] ??  GenerateRandomitem()[0],
            'feet'      => $inventory['feet'] ??  GenerateRandomitem()[0]
        ]
    ];
    return $stats;
}

define("EQUIPMENT_HEAD",  "Head Gear");
define("EQUIPMENT_TORSO", "Gear");
define("EQUIPMENT_LEGS",  "Bottoms");
define("EQUIPMENT_FEET",  "Footwear");
function GenerateEquipmentSlotHTML($item, $equipmentType){
    $itemEncoded=json_encode($item) ?? '{}';
    $escapedItem = htmlspecialchars($itemEncoded, ENT_QUOTES, 'UTF-8');

    if(!empty((array)$item)){
        //var_dump($item);
        $item_template = <<<EOD
        <tr>
            <td><b>{$item->name}</b></td>
            <td>{$item->attack}&#9876;</td>
            <td>{$item->defense}<b>&#128737;</b></td>
            <td rowspan='2'>{$item->price}&#164;</td>
            <td rowspan='2'>
                <form action="unequip_item.php" method="post">
                    <input style="width:100%;" type="submit" name="unequip" value="Unequip" />
                    <input type="hidden" name="item" value="$escapedItem" >
                </form>
            </td>
        </tr>
        <tr>
            <td colspan='3'><i>{$item->description}</i></td>
        </tr>
        <tr>
            <td colspan='5'><hr></td>
        </tr>
        EOD;
        return $item_template;
    }

    $emptySlotHTML=<<<EOD
    <tr>
            <td><b>{$equipmentType}</b></td>
            <td colspan='4'>
                <form action="equip_item" method="post">
                    <select name="equipmentSelection" style="width:100%;">
                        <option value="1">Aghjf Hat</option>
                        <option value="2">Helmet of hjksdfg</option>
                        <option value="3">Hood of hjshfj</option>
                    </select>
                    <!--input type="submit" name="equip" value="equip" /-->
                    <input type="hidden" name="item" value="$escapedItem" >
                </form>
            </td>
        </tr>
        <tr>
            <td colspan='5'><hr></td>
        </tr>
    EOD;
    return $emptySlotHTML;
}


