<?php
header("Content-Type: application/json");

$pic = $_REQUEST["draft"];

echo json_encode(array("gcode" => hash('ripemd160',$pic)), JSON_PRETTY_PRINT);
?>