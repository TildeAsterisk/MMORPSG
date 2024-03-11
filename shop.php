<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Market</h2></center>
    <br />

    <table id="jobsTable" style="width:100%;">
        <tr>
            <td>Item:</td>
            <td>Stats:</td>
            <td>Cost:</td
        </tr>
        
        <tr class="itemInShop">
            <td>
                <b>Item 1</b><br>
                <i>This is the most basic test item.</i>
            </td>
            <td>
                10<?php echo $attack_symbol?>:10<?php echo $defense_symbol?>
            </td>
            <td>10<?php echo $currency_symbol?></td>
            <td>
                <!--form action="buyitem.php" method="post">
                <input style="width:100%;" type="submit" name="buy" value="Buy!" />
                </form-->
                <button style="width:100%;" onclick="">Buy!</button>
            </td>
        </tr>

        <?php
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
    $price = rand(50, 200);

    // Randomly select an item name and description
    $randomName = $itemNames[array_rand($itemNames)];
    $randomDescription = $itemDescriptions[array_rand($itemDescriptions)];

    $randomNewItem="{'name': '{$randomName}', 'description': '{$randomDescription}', 'price': '{$price}', 'attack': '{$attack}', 'defense': '{$defense}'}";

    // Construct the item template
    $itemTemplate = <<<EOD
        <tr class="itemInShop">
            <td>
                <b>$randomName</b><br>
                <i>$randomDescription</i>
            </td>
            <td>
                $attack\⚔️:$defense\🛡️
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

    return $itemTemplate;
}

//Display a number of randomly generated items
for ($i = 0; $i <= 5; $i++) {
    echo GenerateRandomItem();
}

?>

    </table>

    <?php
    // Generate item shop

}
include("footer.php");
?>