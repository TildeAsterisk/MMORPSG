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
function GenerateRandomItem($itemType = null) {
    //Select random item type
    $itemTypes = [ /*null ,*/ EQUIPMENT_HEAD, EQUIPMENT_TORSO, EQUIPMENT_LEGS, EQUIPMENT_FEET];
    if($itemType == null){
        $randomItemType = $itemTypes[array_rand($itemTypes)];
    }
    else{
        $randomItemType = $itemType;
    }

    $adjectives = ["Fierce", "Sinister", "Vengeful", "Dreadful", "Malevolent","Fancy", "Sinister", "Vivacious", "Quirky", "Radiant", "Melancholic", "Surreal", "Zesty", "Ethereal", "Whimsical", "Resilient", "Inquisitive", "Serene", "Luminous", "Mysterious", "Exuberant", "Gloomy", "Captivating", "Dynamic", "Harmonious", "Eloquent", "Jubilant", "Nebulous", "Enchanting", "Audacious", "Tranquil", "Pensive", "Effervescent", "Candid", "Ephemeral", "Euphoric", "Sardonic", "Bewitched", "Placid", "Vibrant", "Tenacious", "Spirited", "Elusive", "Solemn", "Furtive", "Lively", "Enigmatic", "Soothing", "Zealous", "Wistful", "Chimerical", "Incandescent"];
    $materials = ["Iron","Wood","Bronze","Gold","Steel","Stone", "Crystal", "Serpent's Fang","Ivory","Silk","Leather","Cloth","Iron","Wood","Bronze","Gold","Steel","Stone","Crystal","Serpent’s Fang","Ivory","Silk","Leather","Cloth","Obsidian","Mithril","Adamantium","Diamond","Emerald","Ruby","Sapphire","Topaz","Amber","Pearl","Quartz","Velvet","Velvet","Linen","Wool","Fur","Dragonhide","Titanium","Platinum","Obsidian","Bone","Copper","Silver","Plastic","Rubber","Carbon Fiber","Kevlar","Graphene","Scale","Fabric","Alloy","Diamond","Hide","Essence"];
    
    $equipmentNames = [
        EQUIPMENT_WEAPON    => ["Blade","Axe","Dagger","Staff","Bow","Sword","Mace","Spear","Wand","Crossbow","Chakram","Sickle","Whip","Shuriken","Boomerang","Sling","Harpoon","Cudgel","Halberd","Trident","Flail","Rapier","Morning Star","Warhammer","Javelin","Nunchaku","Scythe","Katar","Bolas","Kusarigama","Tessen","Chigiriki","Kama","Naginata","Tanto","Glaive","Khopesh","Estoc","Falchion","Claymore","Zweihander","Katana","Cutlass","Rondel","Tomahawk","War Fan","Quarterstaff","Sai","Kris"],
        EQUIPMENT_HEAD      => ["hat","helm","cowboy hat","hood","mask","tiara","crown","cap","visor","headband","beanie","beret","bonnet","balaclava","coif","circlet","veil","turban","fez","tricorn","toque","miter","snood","visor","headdress","bandana","scarf","headscarf","headwrap","headpiece","diadem","coronet","tiara","wimple","chapeau","tam","bowler","top hat","fedora","sombrero","panama hat","boater","derby","pork pie hat","newsboy cap","flat cap","baseball cap","snapback","bucket hat","beanie","beret","visor","balaclava","cowl","hood","mask","veil","turban","scarf","headscarf","headwrap","headpiece","tiara","diadem","cap","helmet","coif","circlet","visor","headdress","bandana","snood","visor","headband","beanie","beret","bonnet","balaclava","coif","circlet","veil","turban","fez","tricorn","toque","miter","visor","headdress","bandana","scarf","headscarf","headwrap","headpiece","diadem","coronet","tiara","wimple","chapeau","tam","bowler","top hat","fedora","sombrero","panama hat","boater","derby","pork pie hat","newsboy cap","flat cap","baseball cap","snapback","bucket hat","beanie","beret","visor","balaclava","cowl","hood","mask","veil","turban","scarf","headscarf","headwrap","headpiece","tiara","diadem","cap","helmet","coif","circlet","visor","headdress","bandana","snood","visor","headband","beanie","beret","bonnet","balaclava","coif","circlet","veil","turban","fez","tricorn","toque","miter","visor","headdress","bandana","scarf","headscarf","headwrap","headpiece","diadem","coronet","tiara","wimple","chapeau","tam","bowler","top hat","fedora","sombrero","panama hat","boater","derby","pork pie hat","newsboy cap","flat cap","baseball cap","snapback","bucket hat","beanie","beret","visor","balaclava","cowl","hood","mask","veil","turban","scarf","headscarf","headwrap","headpiece","tiara","diadem","cap","helmet","coif","circlet","visor","headdress","bandana","snood","visor","headband","beanie","beret","bonnet","balaclava","coif","circlet","veil","turban","fez","tricorn","toque","miter","visor","headdress","bandana","scarf","headscarf","headwrap","headpiece","diadem","coronet","tiara","wimple","chapeau","tam","bowler","top hat","fedora","sombrero","panama hat","boater","derby","pork pie hat","newsboy cap","flat cap","baseball cap","snapback","bucket hat","beanie","beret","visor","balaclava","cowl","hood","mask","veil","turban","scarf","headscarf","headwrap","headpiece","tiara","diadem","cap","helmet","coif","circlet","visor","headdress","bandana","snood","visor","headband","beanie","beret","bonnet","balaclava","coif","circlet","veil","turban","fez","tricorn","toque","miter","visor","headdress","bandana","scarf","headscarf","headwrap","headpiece","diadem","coronet","tiara","wimple","chapeau","tam","bowler","top hat","fedora","sombrero","panama hat","boater","derby","pork pie hat","newsboy cap","flat cap","baseball cap","snapback","bucket hat","beanie","beret","visor","balaclava","cowl","hood","mask","veil","turban","scarf","headscarf","headwrap","headpiece","tiara","diadem","cap","helmet","coif","circlet","visor","headdress","bandana","snood","visor","headband","beanie","beret","bonnet","balaclava"],
        EQUIPMENT_TORSO     => ["Shirt","Tunic","Vest","Chestplate","Breastplate","Hauberk","Cuirass","Tabard","Doublet","Jerkin","Gambeson","Leather Armor","Plate Mail","Chainmail","Scale Mail","Ringmail","Bulletproof Vest","Flak Jacket","Shoulder Pads","Pauldrons","Spaulders","Arm Bracers","Elbow Guards","Armored Gauntlets","Tassets","Faulds","Loincloth","Hip Guards","Thigh Plates","Greaves","Cuisses","Knee Guards","Shin Guards","Sabatons"],
        EQUIPMENT_LEGS      => ["Greaves","Cuisses","Knee Guards","Shin Guards","Sabatons","Shorts","Pants","Leggings","Tights","Jeans","Cargo Pants","Joggers","Capris","Sweatpants","Overalls","Skirt","Kilt","Trousers","Chinos","Culottes","Harem Pants","Palazzo Pants","Bell-bottoms","Hot Pants","Bermuda Shorts","Board Shorts","Cycling Shorts","Track Pants","Snow Pants","Gaiters","Garters","Leg Warmers","Thigh-high Stockings","Knee-high Socks","Ankle Socks","Compression Socks"],
        EQUIPMENT_FEET      => ["Boots","Shoes","Sandals","Slippers","Sneakers","High Heels","Steel-Toed Boots","Combat Boots","Hiking Boots","Work Boots","Snow Boots","Rain Boots","Flip-Flops","Moccasins","Espadrilles","Waders","Clogs","Loafers","Oxfords","Platform Shoes","Thigh-High Boots","Ankle Boots","Wellington Boots","Gaiters","Sabatons"]
    ];
    
    switch ($randomItemType){
        case EQUIPMENT_WEAPON:
            //random weapon names
            $randomName = $equipmentNames[EQUIPMENT_WEAPON][array_rand($equipmentNames[EQUIPMENT_WEAPON])];
            break;
        case EQUIPMENT_HEAD:
            $randomName = $equipmentNames[EQUIPMENT_HEAD][array_rand($equipmentNames[EQUIPMENT_HEAD])];
            break;
        case EQUIPMENT_TORSO:
            //random weapon names
            $randomName = $equipmentNames[EQUIPMENT_TORSO][array_rand($equipmentNames[EQUIPMENT_TORSO])];
            break;
        case EQUIPMENT_LEGS:
            //random weapon names
            $randomName = $equipmentNames[EQUIPMENT_LEGS][array_rand($equipmentNames[EQUIPMENT_LEGS])];
            break;
        case EQUIPMENT_FEET:
            //random weapon names
            $randomName = $equipmentNames[EQUIPMENT_FEET][array_rand($equipmentNames[EQUIPMENT_FEET])];
            break;
        default:
            //unknown itemt ype
            $randomName = "Non-Equipment Item";
            break;
    }

    //Add Adjectives and descriptor to name
    $randomAdjective = $adjectives[array_rand($adjectives)];
    $randomMaterial = $materials[array_rand($materials)];
    //Capitalize all
    $randomAdjective = ucfirst($randomAdjective);
    $randomMaterial  = ucfirst($randomMaterial);
    $randomName      = ucfirst($randomName);
    //Combine to make full item name
    /*Combination examples:
        - Enchanted Loafers of Obsidian
        - Enchanted Obsidian Loafers
    */
    $fullNameCombos = ["$randomAdjective $randomName of $randomMaterial", "$randomAdjective $randomMaterial $randomName"];
    $fullItemName = $fullNameCombos[array_rand($fullNameCombos)];

    // Random item description
    $itemDescriptions = [
        //"A legendary $randomName forged by ancient blacksmiths.",
        //"A $randomAdjective $randomName that grants its wearer enhanced abilities.",
        "A $randomAdjective $randomName crafted out of $randomMaterial.<br><b>[$randomItemType]</b>",
        "This $randomName is named the `$randomAdjective` by its creator who made out of $randomMaterial.<br><b>[$randomItemType]</b>",
        "The $randomMaterial $randomName has a small written marking on it reading <i>`$randomAdjective`</i>.<br><b>[$randomItemType]</b>",
        //"A $randomAdjective $randomName that channels elemental energy."
    ];
    // Randomly select an item description
    $randomDescription = $itemDescriptions[array_rand($itemDescriptions)];

    // Random properties (attack, defense, and price)
    $attack = rand(5, 20);
    $defense = rand(5, 20);
    $price = rand(10, 200);


    $randomNewItem="{'name':'{$fullItemName}', 'description': '{$randomDescription}', 'price': '{$price}', 'attack': '{$attack}', 'defense': '{$defense}', 'itemType': '{$randomItemType}'}";
    //Replace single quotes with double to allow for json decode
    $randomNewItem=str_replace("'",'"', $randomNewItem);
    //var_dump($randomNewItem);
    //$randomNewItem=json_decode($randomNewItem);

    // Construct the item template
    $itemTemplate = <<<EOD
        <tr class="itemInShop">
            <td>
                <b>$fullItemName</b><br>
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
                    <input type="hidden" name="name"        value="$fullItemName">
                    <input type="hidden" name="description" value="$randomDescription">
                    <input type="hidden" name="price"       value="$price">
                    <input type="hidden" name="attack"      value="$attack">
                    <input type="hidden" name="defense"     value="$defense">
                    <input type="hidden" name="itemType"     value="$randomItemType">
                </form>
            </td>
        </tr>
    EOD;
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
            'weapon'    => $inventory['weapon'] ?? GenerateRandomitem(EQUIPMENT_WEAPON)[0],
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
define("EQUIPMENT_WEAPON",  "Weapon");
function GenerateEquipmentSlotHTML($item, $equipmentType, $inventory){
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
                    <input type="hidden" name="itemType" value="$equipmentType" >
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

    $equipDropdownOptionsHTML="";
    //var_dump($inventory);
    //$itemTypes = [ /*null ,*/ EQUIPMENT_HEAD, EQUIPMENT_TORSO, EQUIPMENT_LEGS, EQUIPMENT_FEET];
    //Look for equippable items in inventory
    foreach ($inventory as $key => $value) {
        //if(empty((array)$value)){continue;}
        $itemType = $value['itemType'] ;
        $itemName = $value['name'] ;
        //var_dump((object)$value);
        $encodedValue = htmlspecialchars(json_encode((object)$value,true), ENT_QUOTES, 'UTF-8');
        if($itemType == $equipmentType){
            $equipDropdownOptionsHTML .= "<option name='{$itemType}' value='{$encodedValue}'>{$itemName}</option>";
        }
    }

    $emptySlotHTML=<<<EOD
    <tr>
    <form action="equip_item.php" method="post">
            <td><b>{$equipmentType}</b></td>
            <td colspan='4'>
                <select name="equipmentSelection" onchange="this.form.submit()" style="width:100%;">
                    "<option value='None'>None</option>"
                    $equipDropdownOptionsHTML
                </select>
                <input type="hidden" name="item" value="$escapedItem" >
            </td>
        </form>
        </tr>
        <tr>
            <td colspan='5'><hr></td>
        </tr>
    EOD;
    return $emptySlotHTML;
}

function DropItemFromInventory($mysql,$itemStr){
    $itemStr = json_decode($itemStr);
    $getPlayerInvQuery = mysqli_query($mysql, "SELECT * FROM `inventory` WHERE `id`='" . $_SESSION['uid'] . "'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    $playerInvDecoded = json_decode($playerInv['items'], true);
  
    $foundItem = null;
    foreach ($playerInvDecoded as $key => $i) {
      //echo var_dump($item)."<br><br><br>".var_dump($i)."<br><hr>";
      if ($i === (array)$itemStr) {
          $foundItem = $i;
          unset($playerInvDecoded[$key]); // Remove the item from the array
          //echo "Removed item from Inventory<br>";
          break; // Stop searching once found
      }
    }
  
    if ($foundItem == NULL){
        echo "Item not found.";
        return;
    }
  
  
    $playerInvJson = json_encode($playerInvDecoded);
    //update JSON in DB
    //$updatePlayerInvQuery = mysqli_query($mysql,"UPDATE `inventory` SET `items`=`items`+'".$newItemJson."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $updateQuery = "UPDATE `inventory` SET `items` = '$playerInvJson' WHERE `id` = '".$_SESSION['uid']."'";
    mysqli_query($mysql, $updateQuery) or die(mysqli_error($mysql));
  
  }

function AddItemToInventory($mysql, $itemStr){
    $newItemObj=json_decode($itemStr);
    //get current inventory
    $getPlayerInvQuery = mysqli_query($mysql,"SELECT * FROM `inventory` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $playerInv = mysqli_fetch_assoc($getPlayerInvQuery);
    $playerInv['items'] = $playerInv['items'] ?? '{}';
    $playerInvItemsObject=json_decode($playerInv['items']);

    //if inventory is at capacity
    if (sizeof((array)$playerInvItemsObject) >= $playerInv['capacity']) {
      echo "Your inventory is full.";
      
      return false;
    }
    if($playerInv == NULL){
      $playerInv='{}';
    }
    //Get full player items as object
    $playerInvItemsObject = json_decode($playerInv['items'], true);
    array_push($playerInvItemsObject, $newItemObj);
    $playerInvJson = json_encode($playerInvItemsObject);
    //update JSON in DB
    //$updatePlayerInvQuery = mysqli_query($mysql,"UPDATE `inventory` SET `items`=`items`+'".$newItemJson."' WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $updateQuery = "UPDATE `inventory` SET `items` = '$playerInvJson' WHERE `id` = '".$_SESSION['uid']."'";
    mysqli_query($mysql, $updateQuery) or die(mysqli_error($mysql));
    return true;
}
