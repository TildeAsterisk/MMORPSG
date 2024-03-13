<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
    ?>
    <center><h2>Jobs</h2></center>
    <br />

    <table id="jobsTable" style="width:100%;">
        <tr>
            <td>Description:</td>
            <td>Reward:</td>
            <td>Requirements:</td>
            <td>Action:</td>
        </tr>

        <?php
function generate_random_job($pAttack, $pDefense) {
    // Define lists of possible job names, descriptions, and rewards
    $job_names = ["Basic Job", "Advanced Job", "Special Job", "Secret Job"];
    $job_descriptions = [
        "Get some money.",
        "Defeat the dragon.",
        "Retrieve the lost artifact.",
        "Solve the mystery.",
        "Do some real work."
    ];
    $job_rewards = [
        "+1 Common Item",
        "+1 Medium Item",
        "+1 Rare Item"
    ];

    // Randomly select a name, description, and reward
    $random_name = $job_names[array_rand($job_names)];
    $random_description = $job_descriptions[array_rand($job_descriptions)];
    $random_reward = $job_rewards[array_rand($job_rewards)];
    $random_energyCost = rand(1, 10);
    $random_attack =  rand(1, round($pAttack*1.5));
    $random_defense = rand(1,round($pDefense*1.5));
    $random_moneyReward = rand(10,50);
    $random_xpReward = rand(1,100);


    // Create the job HTML template
    $job_template = <<<HTML
        <tr class="TemplateJob">
            <td><b>$random_name</b><br><i>$random_description</i></td>
            <td>
                +??&#164;<br>
                +50xp<br>
                <i>$random_reward</i>
            </td>
            <td>
                Energy: $random_energyCost<b></b>⚡<br>
                $random_attack&#9876;
                $random_defense<b>&#128737;</b>
            </td>
            <td>
                <form action="solojob.php" method="post">
                    <button>Go!</button>
                    <input type="hidden" name="name" value="$random_name">
                    <input type="hidden" name="description" value="$random_description">
                    <input type="hidden" name="rewards" value="$random_reward">
                    <input type="hidden" name="attack"      value="$random_attack">
                    <input type="hidden" name="defense"     value="$random_defense">
                    <input type="hidden" name="energyCost"     value="$random_energyCost">
                    <input type="hidden" name="moneyReward"     value="$random_moneyReward">
                    <input type="hidden" name="experienceReward"     value="$random_xpReward">
                </form>
            </td>
        </tr>
    HTML;

    return $job_template;
}

//Display a number of randomly generated items
for ($i = 0; $i <= 4; $i++) {
    echo generate_random_job($stats['attack'],$stats['defense']);
}

?>

        

    </table>

    <?php
    //include("leaderboard.php");
}
include("footer.php");
?>