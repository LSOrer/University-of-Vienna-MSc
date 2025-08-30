<?php
header("Content-Type: application/json");
$duration = $_REQUEST["duration"];
sleep($duration);
exit();
?>