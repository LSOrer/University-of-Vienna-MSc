<?php
	$querydata = http_build_query(
   		array(
     			'count' => '998'
   		)
 	);

 	$pack = array('http' =>
   	array(
     		'method' => 'PUT',
     		'header' =>
       		"Content-type: application/x-www-form-urlencoded\r\n" .
       		"accept: application/json\r\n",
     		'content' => $querydata
   		)
 	);
 
	header('content-type: text/plain');
 	$context = stream_context_create($pack);
 	$result = file_get_contents('http://wwwlab.cs.univie.ac.at/~a1250600/correlation/inventory.php/Sauce/ketchup',false,$context);

 	print_r($result);
	echo("Successfully updated new inventory amount!");
?>
