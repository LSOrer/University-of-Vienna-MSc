<?php
header("Content-Type: application/json");
$colorLeft = rand(50, 2000);
echo json_encode(array("colorLeft" => $colorLeft), JSON_PRETTY_PRINT);
?>