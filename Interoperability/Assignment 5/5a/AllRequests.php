<?php
	ini_set("soap.wsdl_cache_enabled","0");
  	$client = new SoapClient('SOAP.wsdl',array('trace'=>1));
  	header('content-type: text/plain');

    $map = array(1 => 311, 2 => 254);   
   
    class Object1{
		public $robot1 = "Joe";
		public $robot2 = "Sandra";
        public $robot3 = "Barney";
	}

	class Object2{
		public $city1 = "Wien";
		public $city2 = "Graz";
	}

    #1  $result = $client->getNumberOfCustomersServedByJoe('Joe');	
    #2  $result = $client->getDeliverysInRange(array(670, 727));
	#3  $result = $client->getOrdersWithTomatos(array("+ tomato","+ tomato","+ tomato"));
	#4  $result = $client->getRobotTaskboard($map);
	#5  $result = $client->getNumberOfOrdersBetween(array('2021-02-13','2020-01-29'));
	#6  $result = $client->getBurgerbunItemsize(array(700, 700));
	#7  $result = $client->getRobotsAndCitys(array(new Object1(), new Object2()));
	#8  $result = $client->getAddressOfCustomer(25);
	#9  $result = $client->getOrdersWithWater(array("Water","Water","Water"));
	#10 $result = $client->getOrdersOfDate('2020-03-12');	

  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastRequest());
  print $doc->saveXML();
 
  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastResponse());
  print $doc->saveXML();
?>