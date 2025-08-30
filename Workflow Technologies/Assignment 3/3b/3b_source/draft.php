<?php
header("Content-Type: application/json");

$sketch = $_REQUEST["sketch"];

if ($sketch == 'Mouse') {
	$draft = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3b/mouse_3D.png';
}
    elseif ($sketch == 'Cat') {
	$draft = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3b/cat_3D.png';
    }
        elseif ($sketch == 'Dog') {
            $draft = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3b/dog_3D.png';
            }
else 
    $draft = 'undefined';

echo json_encode(array("draft" => $draft), JSON_PRETTY_PRINT);

?>