<?php
header("Content-Type: application/json");

$color = $_REQUEST["color"];

echo json_encode(array("shoppingList" => "Put the color ".$color." on the shopping list"), JSON_PRETTY_PRINT);
?>