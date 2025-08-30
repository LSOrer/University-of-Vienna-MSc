<?php
	header('Content-Type: text/plain');
	include('rest_handle.php');
	$rest = handleREST($_SERVER,$_GET);
	$file = file_get_contents ('inventory.json');
	$data = json_decode($file, true);
	$request = explode("/", $rest->url);
	$method = $rest->method;
	$arguments = $rest->arguments;

	switch($method) {
		case 'GET':
			print_r(getInventory($request, $data));
		break;

		case 'PUT':
			updateInventory($request, $data, $arguments);
		break;
	}

	function getInventory($request, $data) {
		if (preg_match("/(\w)/", $request[1])) {
			if (array_key_exists(2, $request)){
				if (preg_match("/(\w)/", $request[2])) {	
				$output = $data[$request[1]][$request[2]];
				return json_encode($output, JSON_PRETTY_PRINT);
				exit;
				}
			}
			else {	
				$output = $data[$request[1]];
				return json_encode($output, JSON_PRETTY_PRINT);
				exit;
			}
		} 
		else {
			return json_encode($data, JSON_PRETTY_PRINT);
			exit;
		}	
}

	function updateInventory($request, $data, $arguments) {
		if (preg_match("/(\w+)/", $request[1])) {
			if (preg_match("/(\w+)/", $request[2])) {
				if(array_key_exists("count", $arguments)) {
					$data[$request[1]][$request[2]] = intval($arguments["count"]);
					$filewriter = fopen("inventory.json", "w+");
					fwrite($filewriter, json_encode($data, JSON_PRETTY_PRINT));
					fclose($filewriter);
				}
			}
		}
	}


?>