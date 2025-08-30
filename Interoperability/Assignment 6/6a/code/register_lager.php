<?php
	$querydata = http_build_query(
		array(
			'url' => 'http://wwwlab.cs.univie.ac.at/~a1250600/correlation/inventory.php'
		)
	);
	
	$pack = array('http' =>
	array(
		'method' => 'PUT',
		'header' => 'Content-type: application/x-www-form-urlencoded',
		"Content-type: application/x-www-form-urlencoded\r\n" .
		"accept: text/plain\r\n",
		'content' => $querydata
		)
	);
	
	header('content-type: text/plain');
	$context = stream_context_create($pack);
	$result = file_get_contents('http://donatello.cs.univie.ac.at/tools_lehre/interop/2021/correlation_phase1/index.php/a01250600/lager', false, $context);
	
	print_r($result);

?>