<?php
header('Content-Type: text/plain');

	function generateData(){
	
		$beef = array('amount' => 50);
		$pork = array('amount' => 50);
		$chicken = array('amount' => 30);
		$fisch = array('amount' => 20);
		$veggie = array('amount' => 40);
		$vegan = array('amount' => 30);
		$lamb = array('amount' => 20);
	$patty = array('beef' => $beef, 'pork' => $pork, 'chicken' => $chicken, 'fish' => $fisch, 'veggie' => $veggie, 'vegan' => $vegan, 'lamb' => $lamb);

		$cbun = array('amount' => 100);
		$sbun = array('amount' => 80);
		$gfbun = array('amount' => 30);	
		$wbun = array('amount' => 40);
		$vbun = array('amount' => 30);
		$softbun = array('amount' => 30);
		$bigbun = array('amount' => 50);
	$bun = array('classicBun' => $cbun, 'sesameBun' => $sbun, 'glutenfreeBun' => $gfbun, 'wholewheatBun' => $wbun, 'veganBun' => $vbun, 'softBun' => $softbun, 'bigBun' => $bigbun);

		$frenfri = array('amount' => 400);
		$belgfri = array('amount' => 300);
		$wedges = array('amount' => 400);
		$dollarchips = array('amount' => 200);
		$curly = array('amount' => 200);
		$bakedPotato = array('amount' => 100);
		$mashedPotato = array('amount' => 100);
	$sidedish = array('frenchFries' => $frenfri, 'belgianFries' => $belgfri, 'wedges' => $wedges, 'dollarChips' => $dollarchips, 'curlyFries' => $curly, 'bakedPotatos' => $bakedPotato, 'mashedPotatos' => $mashedPotato);
	
		$cola = array('amount' => 999);
		$sprite = array('amount' => 999);
		$fanta = array('amount' => 999);
		$still = array('amount' => 999);
		$sparkling = array('amount' => 999);
		$makava = array('amount' => 999);
		$icetea = array('amount' => 999);
	$drink = array('cocaCola' => $cola, 'sprite' => $sprite, 'fanta' => $fanta, 'stillWater' => $still, 'sparklingWater' => $sparkling, 'makava' => $makava, 'iceTea' => $icetea);

	$inventory = array("Patty" => $patty, "Bun" => $bun, "SideDish" => $sidedish, "Drink" => $drink);


		$order = array();
		$random_Patty = array_rand($inventory["Patty"],1);
    	$order['Patty']= $random_Patty;
		
		$random_Bun = array_rand($inventory["Bun"],1);
		$order['Bun']= $random_Bun;
		
		$random_SideDish= array_rand($inventory["SideDish"],1);
   		$order['SideDish']= $random_SideDish;
		
		$random_Drink = array_rand($inventory["Drink"],1);
		$order['Drink']= $random_Drink;

	

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
	fwrite($file, json_encode($order, JSON_PRETTY_PRINT));
	fclose($file);

	echo "Successfully generated inventory, order and progress";
}

generateData();

?>