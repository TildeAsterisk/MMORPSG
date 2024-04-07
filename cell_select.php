<?php
session_start();
include("header.php");
if(!isset($_SESSION['uid'])){
    echo "You must be logged in to view this page!";
}else{
  if(isset($_POST["cell-data"])){
    $cellDataArray = explode(",",$_POST['cell-data']);
    $cellSelected=[
      /*'data'        => $cellDataArray,*/
      'x'           => $cellDataArray[0],
      'y'           => $cellDataArray[1]
    ];

    echo "You have selected the cell...<br>";

    //get existing grid data
    $getPGridDataQuery= mysqli_query($mysql,"SELECT `grid-data` FROM `settlement` WHERE `id`='".$_SESSION['uid']."'") or die(mysqli_error($mysql));
    $pGridData = mysqli_fetch_assoc($getPGridDataQuery)["grid-data"];
    //generate gridData object
    $gridData = (array)json_decode($pGridData) ?? [];

    //Find selected cell data
    $selectedCellData = $gridData["$cellSelected[x],$cellSelected[y]"] ?? [];

    //if doesn't already have data
    if(!$selectedCellData){
      //Add new cell data
      $gridData["$cellSelected[x],$cellSelected[y]"] = [
        "style" => "background-color: green;",
        "cellType" => "CT-Farm"
      ];
      $gridDataEncoded = json_encode($gridData);
      //update grid cell data to SQL DB
      $updateGridDataQuery = "UPDATE `settlement` SET `grid-data`='$gridDataEncoded' WHERE `id`='".$_SESSION['uid']."'";
      mysqli_query($mysql,$updateGridDataQuery) or die(mysqli_error($mysql));
      echo "Updated cell X:$cellSelected[x],Y:$cellSelected[y].";
    }
    else{
      //Cell already filled
      echo "<center><h2>".$selectedCellData->cellType."</h2></center>";
      echo "Co-oridinates: X:$cellSelected[x],Y:$cellSelected[y]<br>";
      echo "Style: ".$selectedCellData->style??"None.";
      echo "<br><br>Full Selected Cell Data:<br>";
      var_dump($selectedCellData);
      echo "<br><br>";
      echo "Interact with this building. <br>";
    }

  }
  else{
    output("You have visited this page incorrectly.");
  }

}
include("footer.php");
?>