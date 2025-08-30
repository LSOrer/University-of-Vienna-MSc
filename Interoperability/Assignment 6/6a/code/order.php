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

			$generateOrder = array();
			$orders = array();
			$random_Patty = array_rand($data["Patty"],1);
			$generateOrder['Patty']= $random_Patty;
			$random_Bun = array_rand($data["Bun"],1);
			$generateOrder['Bun']= $random_Bun;
			$random_Sauce = array_rand($data["Sauce"],1);
			$generateOrder['Sauce']= $random_Sauce;
			$random_Extra1 = array_rand($data["Extra1"],1);
			$generateOrder['Extra1']= $random_Extra1;
			$random_Extra2s = array_rand($data["Extra2"],1);
			$generateOrder['Extra2']= $random_Extra2s;
			$random_SideDish = array_rand($data["SideDish"],1);
			$generateOrder['SideDish']= $random_SideDish;
			$random_Drink = array_rand($data["Drink"],1);
			$generateOrder['Drink']= $random_Drink;
			$orders[0]= $generateOrder;

			return json_encode($orders, JSON_PRETTY_PRINT);
			exit;
		}	

	}


?>