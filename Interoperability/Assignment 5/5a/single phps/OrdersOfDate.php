<?php
	ini_set("soap.wsdl_cache_enabled","0");
  	$client = new SoapClient('SOAP.wsdl',array('trace'=>1));

 	header('content-type: text/plain');

	$result = $client->getOrdersOfDate('2020-03-12');	


 
  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastRequest());
  print $doc->saveXML();
 
  $doc = new DOMDocument('1.0');
  $doc->formatOutput = true;
  $doc->loadXML($client->__getLastResponse());
  print $doc->saveXML();
?>