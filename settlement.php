<?php 
const SETTLEMENT_TAG_NAME       = 'Name';
const SETTLEMENT_TAG_LOCATION   = "Location";
const SETTLEMENT_TAG_POPULATION = "Population";
const SETTLEMENT_TAG_JOBS       = "Jobs";
const SETTLEMENT_TAG_FOOD       = "Food";
const SETTLEMENT_TAG_MATERIALS  = "Materials";
class Settlement{
  public $data;
  
  function InitSettlement($mysql,
    $data = [
      SETTLEMENT_TAG_NAME        => "Settlement Name",
      SETTLEMENT_TAG_LOCATION    => "Local Area",
      SETTLEMENT_TAG_POPULATION  => 10,
      SETTLEMENT_TAG_JOBS        => [
        'Foraging'        => 1, //[JobName->NumWorkers]
        'Combat' => 0
      ],
      SETTLEMENT_TAG_FOOD        => 0,
      SETTLEMENT_TAG_MATERIALS   => 0 ])
  {
    $this->data = $data;
    //var_dump($data);
    $data=(object)$data;
    //Update SQL databse with new settlement
    $updateQuery="INSERT INTO `settlement` (`ownerid`, `name`,`population`,`food`,`materials`,`jobs`) VALUES (0,'$data->Name','$data->Population','$data->Food','$data->Materials',null)";
    var_dump($updateQuery);
    $sqlexec = mysqli_query($mysql, $updateQuery);
  }

  function GetTotalEmployed(){
    $totalEmployed = 0;
    foreach ($this->data[SETTLEMENT_TAG_JOBS] as $key => $value) {
      $totalEmployed+=$value[1];
    }
    return $totalEmployed;
  }

  function UpdateSettlement(){
    //Foragers generate 3 food and materials per day
    $numForaging=$this->data[SETTLEMENT_TAG_JOBS]['Foraging'];
    $foodIncome = $numForaging * 3;
    $matIncome = $numForaging * 3;
  }
  
  //Select number of pop. to assign jobs
  function AssignJobs($numPop, $jobName){
    $totalEmployed = $this->GetTotalEmployed();
    $totalUnemployed = $this->data[SETTLEMENT_TAG_POPULATION] - $totalEmployed;
    //check if num of pop is valid
    if($numPop > $this->data[SETTLEMENT_TAG_POPULATION]){
      echo "You don't even have that many people in your settlement.";
    }
    // Check if $numPop is greater than those unemployed
    if($numPop > $totalUnemployed){
      echo "You don't have that many people to assign roles to.";
    }

    $stlmntJobs = $this->data[SETTLEMENT_TAG_JOBS];
    $stlmntJobs[$jobName]->$numPop;
    echo "$numPop workers assigned to the role of $jobName";
  }
}

//SETTLEMENT UI FUNCTIONS
function SettlementJobBoardHTML($stlmnt){
  //var_dump(json_decode($stlmnt['data']->jobs));
  $stlmntJobs = json_decode($stlmnt['data']->jobs) ?? [];
  //Get list of jobs
  $jobsTableRowsHTMl = "";
  //var_dump($stlmntJobs);
  foreach($stlmntJobs as $job => $numWrkrs){
    //var_dump($numWrkrs);
    $jobsTableRowsHTMl .= <<<EOD
    <tr>
        <td>{$numWrkrs} {$job}</td>
        <form action="enroll_units.php" method="post">
        <td>
        <input style="width:100%;" type="range" name="numWorkers" value="$numWrkrs" min="0" max="{$stlmnt['data']->population}" oninput="rangeValue.innerText = this.value" />
        </td>
        <td><output id="rangeValue">{$numWrkrs}</output></td>
        <td>
        <input style="width:100%;" type="submit" name="buy" value="Enroll" />
        </td>
        </form>
        </tr>
    EOD;
  }

  $jobsTableHTML = <<<EOD
  <center><table id='inventoryTable'>
    <tr>
      <td>Roles:</td>
      <td></td>
    </tr>
    $jobsTableRowsHTMl
  </table></center>
  EOD;
  return $jobsTableHTML;
}


?>