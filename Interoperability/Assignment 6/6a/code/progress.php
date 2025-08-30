<?php
	header('Content-Type: text/plain');
	include('rest_handle.php');
	$rest = handleREST($_SERVER,$_GET);
	$file = file_get_contents ('progress.json');
	$data = json_decode($file, true);
	$request = explode("/", $rest->url);
	$method = $rest->method;
	$arguments = $rest->arguments;

	switch($method) {
		case 'GET':
			print_r(getProgressUpdate($request, $data));
		break;
	}

	function getProgressUpdate($request, $data) {
		if (preg_match("/^$/", $request[1])) {
			return json_encode($data, JSON_PRETTY_PRINT);
			exit;
		}
		if (preg_match("/[1-7]/", $request[1])) {
			$val = intval($request[1]);
			return json_encode($data[$val], JSON_PRETTY_PRINT);
			exit;
		}
    	exit;	
	}
?>