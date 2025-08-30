<?php
header("Content-Type: application/json");

$sketch = $_REQUEST["sketch"];

if ($sketch == 'Mouse') {
	$sketchPic = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3b/mouse_sketch.jpg';
}
    elseif ($sketch == 'Cat') {
	$sketchPic = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3b/cat_sketch.png';
    }
        elseif ($sketch == 'Dog') {
            $sketchPic = 'https://wwwlab.cs.univie.ac.at/~a1250600/wt21/3b/dog_sketch.png';
            }
else 
    $sketchPic = 'undefined';

echo json_encode(array("sketchPic" => $sketchPic), JSON_PRETTY_PRINT);

?>