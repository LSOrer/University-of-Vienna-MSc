<?php
	ini_set("soap.wsdl_cache_enabled","0");
  	$client = new SoapClient('SOAP.wsdl',array('trace'=>1));

 	header('content-type: text/plain');

	$result = $client->getRobotsAndCitys(array(new Object1(), new Object2()));
 
	class Object1{
		public $robot1 = "Joe";
		public $robot2 = "Sandra";
        public $robot3 = "Barney";
	}

	class Object2{
		public $city1 = "Wien";
		public $city2 = "Graz";
	}

  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastRequest());
  print $doc->saveXML();
 
  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastResponse());
  print $doc->saveXML();
?>