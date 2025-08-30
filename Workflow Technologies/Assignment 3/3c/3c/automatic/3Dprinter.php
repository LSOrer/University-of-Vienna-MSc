<?php
header("Content-Type: application/json");

$draft = $_REQUEST["draft"];

echo json_encode(array("print" => "Now printing ".$draft." on 3D Printer"), JSON_PRETTY_PRINT);
?>