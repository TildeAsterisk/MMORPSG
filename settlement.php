<?php 

class Settlement{
  //Set constants
  public $data;
  
  function InitSettlement($data = [
    'Name'        => "Settlement Name",
    'Location'    => "Local Area",
    'Population'  => 0,
    'Food'        => 0,
    'Materials'   => 0])
  {
    $this->data = $data;
    /*
    self::$data=$data;
    echo "Settlement Initialized.<br>";
    echo "\$data: ",var_dump(self::$data);
    */
  }
}


?>