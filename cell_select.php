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
    
    //generate gridData object with new cell data added
    $gridData = [];
    $gridData["$cellSelected[x],$cellSelected[y]"] = "background-color: green;";
    $gridDataEncoded = json_encode($gridData);

    //update grid cell data to SQL DB
    $updateGridDataQuery = "UPDATE `settlement` SET `grid-data`='$gridDataEncoded' WHERE `id`='".$_SESSION['uid']."'";
    mysqli_query($mysql,$updateGridDataQuery) or die(mysqli_error($mysql));

    echo "Updated cell X:$cellSelected[x],Y:$cellSelected[y].";
    
  }
  else{
    output("You have visited this page incorrectly.");
  }

}
include("footer.php");
?>