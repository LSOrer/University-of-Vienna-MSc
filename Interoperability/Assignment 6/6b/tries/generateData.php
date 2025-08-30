<?php
header('Content-Type: text/plain');

	function generateData(){

	$patty = array('beef' => 50, 'pork' => 50, 'chicken' => 50, 'fish' => 50, 'veggie' => 50, 'vegan' => 50, 'lamb' => 50);
	$bun = array('classic bun' => 100, 'sesame bun' => 30, 'glutenfree bun' => 30, 'wholewheat bun' => 30);
	$sauce  = array('ketchup' => 999, 'mayo' => 999, 'raunch' => 999, 'smokey' => 999, 'BBQ' => 999, 'mustard' => 999, 'tatar' => 999);
	$extra1 = array('tomatos' => 500, 'onion' => 500, 'lettuce' => 500, 'cheese' => 300, 'bacon' => 300, 'pickles' => 300, 'cucumber' => 200);
	$extra2 = array('tomatos' => 500, 'onion' => 500, 'lettuce' => 500, 'cheese' => 300, 'bacon' => 300, 'pickles' => 300, 'cucumber' => 200);
	$sidedish = array('french frites' => 999, 'belgian fries' => 999, 'wedges' => 999, 'dollar chips' => 999);
	$drink = array('coca cola' => 999, 'sprite' => 999, 'fanta' => 999, 'still water' => 999, 'sparkling water' => 999);

	$inventory = array("Patty" => $patty, "Bun" => $bun, "Sauce" => $sauce , "Extra1" => $extra1, "Extra2" => $extra2, "SideDish" => $sidedish, "Drink" => $drink);

	$order = array();
	
	for($i = 0; $i < 2; $i++){
		$order = array();
		$random_Patty = array_rand($inventory["Patty"],1);
    	$order['Patty']= $random_Patty;
		$random_Bun = array_rand($inventory["Bun"],1);
    	$order['Bun']= $random_Bun;
		$random_Sauce = array_rand($inventory["Sauce"],1);
    	$order['Sauce']= $random_Sauce;
    	$random_Extra1 = array_rand($inventory["Extra1"],1);
   		$order['Extra1']= $random_Extra1;
		$random_Extra2s = array_rand($inventory["Extra2"],1);
   		$order['Extra2']= $random_Extra2s;
		$random_SideDish = array_rand($inventory["SideDish"],1);
   		$order['SideDish']= $random_SideDish;
		$random_Drink = array_rand($inventory["Drink"],1);
   		$order['Drink']= $random_Drink;
		$orders[0]= $order;
	}

	$step1 = array("progress" => "Patty on grill", "percentage" => 20);
	$step2 = array("progress" => "Bun sliced", "percentage" => 30);
	$step3 = array("progress" => "Sauce on bun", "percentage" => 40);
	$step4 = array("progress" => "Extra1 added", "percentage" => 50);
	$step5 = array("progress" => "Extra2 added", "percentage" => 60);
	$step6 = array("progress" => "SideDish & drink prepared", "percentage" => 80);
	$step7 = array("progress" => "Menu finished", "percentage" => 100);

	$progress = array(1 => $step1, 2 => $step2, 3 => $step3, 4 => $step4, 5 => $step5, 6 => $step6, 7 => $step7);

	
	$file = fopen("inventory.json", "w");
	fwrite($file, json_encode($inventory, JSON_PRETTY_PRINT));
	fclose($file);

	$file = fopen("progress.json", "w");
	fwrite($file, json_encode($progress, JSON_PRETTY_PRINT));
	fclose($file);

	$file = fopen("order.json", "w");
	fwrite($file, json_encode($orders, JSON_PRETTY_PRINT));
	fclose($file);

	echo "Successfully generated inventory, order and progress";
}

generateData();

?>