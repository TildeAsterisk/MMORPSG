<?php
include("functions.php");
include("connection.php");
//Deletes entries from logs that are older than 24 hours or 86400s
mysqli_query($mysql,"DELETE FROM `logs` WHERE `time`<".(time()-86400)."'") or die(mysqli_error($mysql));

?>