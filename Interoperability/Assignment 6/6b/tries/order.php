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
			print_r(generateOrder($request, $data));
		break;
	}

	function generateOrder($request, $data) {

		if (preg_match("/^$/", $request[1])) {

			$orders = array();
			$random_Patty = array_rand($data["Patty"],1);
			$orders['Patty']= $random_Patty;
			$random_Bun = array_rand($data["Bun"],1);
			$orders['Bun']= $random_Bun;
			$random_SideDish = array_rand($data["SideDish"],1);
			$orders['SideDish']= $random_SideDish;
			$random_Drink = array_rand($data["Drink"],1);
			$orders['Drink']= $random_Drink;

			return json_encode($orders, JSON_PRETTY_PRINT);
			exit;
		}	

	}


?>