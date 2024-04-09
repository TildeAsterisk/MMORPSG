<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}
else{
  if(isset($_POST["cell-data"])){
    $cellDataArray = explode(",",$_POST['cell-data']);
    $cellSelected=[
      /*'data'        => $cellDataArray,*/
      'x'           => $cellDataArray[0],
      'y'           => $cellDataArray[1]
    ];

    //echo "You have selected the cell...<br>";

    //get existing grid data
    $getPGridDataQuery= mysqli_query($mysql,"SELECT `grid-data` FROM `settlement` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $pGridData = mysqli_fetch_assoc($getPGridDataQuery)["grid-data"];
    //generate gridData object
    $gridData = (array)json_decode($pGridData) ?? [];

    //Find selected cell data
    $selectedCellData = $gridData["$cellSelected[x],$cellSelected[y]"] ?? [];

    //if doesn't already have data
    if(!$selectedCellData){
      //if Build selected get celltype to build
      if(isset($_POST['buildButton'])){
        //Player has clicked build button, get cellType
        switch($_POST["cellTypes"]){
          case "Wall":
            //Add new cell data
            $gridData["$cellSelected[x],$cellSelected[y]"] = [
              "cellType" => "CT-Wall"
            ];
            break;
          case "Farm":
            //Add new cell data
            $gridData["$cellSelected[x],$cellSelected[y]"] = [
              "cellType" => "CT-Farm"
            ];
            break;
          case "Barracks":
            //Add new cell data
            $gridData["$cellSelected[x],$cellSelected[y]"] = [
              "cellType" => "CT-Barracks"
            ];
            break;
          case "Turret":
            //Add new cell data
            $gridData["$cellSelected[x],$cellSelected[y]"] = [
              "cellType" => "CT-Turret"
            ];
            break;
          default:
            //Add new cell data
            $gridData["$cellSelected[x],$cellSelected[y]"] = [
              "cellType" => "cell"
            ];
            break;
        }
        //var_dump($_POST);
        //update grid cell data to SQL DB
        $gridDataEncoded = json_encode($gridData);
        $updateGridDataQuery = "UPDATE `settlement` SET `grid-data`='$gridDataEncoded' WHERE `id`='".$_SESSION['uid']."'";
        mysqli_query($mysql,$updateGridDataQuery) or die(mysqli_error($mysql));
        echo "Updated cell X:$cellSelected[x],Y:$cellSelected[y].";
        
      }

      $emptyCellActionsHTML = <<<EOD
      <form method="post"> 
        <label for="cellTypes">Choose a plot type to build:</label>
        <select name="cellTypes" id="cellTypes">
          <option value="Wall">Wall</option>
          <option value="Farm">Farm</option>
          <option value="Barracks">Barracks</option>
          <option value="Turret">Turret</option>
        </select>
        <input type="submit" name="buildButton" value="Build"/><br>
        <input type="submit" name="refresh" value="Refresh"/> 
        <!--input type="submit" name="backButton" value="Back To Base Grid"/-->
        <input type="hidden" name="cell-data" value="{$_POST["cell-data"]}" /> 
      </form> 
      EOD;
      echo $emptyCellActionsHTML;

    }
    else{
      //Cell already filled
      echo "<center><h2>".$selectedCellData->cellType."</h2></center>";
      echo "Co-oridinates: X:$cellSelected[x],Y:$cellSelected[y]<br>";
      echo "<br>Full Selected Cell Data:<br>";
      var_dump($selectedCellData);
      echo "<br><br>";
      echo "<button disabled='true'>Upgrade</button><button disabled='true'>Destroy</button> <br>";
    }

  }
  else{
    //output("You have visited this page incorrectly.");
    //no cell data found
    //must have selected something...
  }

}
include("footer.php");
?>