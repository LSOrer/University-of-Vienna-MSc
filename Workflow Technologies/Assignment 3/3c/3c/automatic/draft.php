<?php
header("Content-Type: application/json");

$sketch = $_REQUEST["sketch"];

if ($sketch == 'Mouse') {
	$draft = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3c/images/mouse_3D.jpg';
}
    elseif ($sketch == 'Cat') {
	$draft = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3c/images/cat_3D.jpg';
    }
        elseif ($sketch == 'Dog') {
            $draft = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3c/images/dog_3D.jpg';
            }
else 
    $draft = 'undefined';

echo json_encode(array("draft" => $draft), JSON_PRETTY_PRINT);

?>