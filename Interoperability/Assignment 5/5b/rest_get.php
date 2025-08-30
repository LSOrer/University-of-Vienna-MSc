<?php

		function getCustomerDataNodes($query) {
			$document = new DOMdocument();
			$document->Load('./result1.xml');
			$xpath = new DOMXPath($document);
			$outcome = $xpath->query($query);
			$document = new DOMdocument('1.0', 'UTF-8');
			$names = $document->createElement('names');
			foreach ($outcome as $value) {
				$names->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($names);
			$document->formatOutput = true;	
			return $document->saveXML();
			}

		function getOrderDataNodes($query) {
			$document = new DOMdocument();
			$document->Load('./result2.xml');
			$xpath = new DOMXPath($document);
			$outcome = $xpath->query($query);
			$document = new DOMdocument('1.0', 'UTF-8');
			$names = $document->createElement('names');
			foreach ($outcome as $value) {
				$names->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($names);
			$document->formatOutput = true;	
			return $document->saveXML();
			}

		function getBurgerbunNodes($query) {
			$document = new DOMdocument();
			$document->Load('./result3.xml');
			$xpath = new DOMXPath($document);
			$outcome = $xpath->query($query);
			$document = new DOMdocument('1.0', 'UTF-8');
			$names = $document->createElement('names');
			foreach ($outcome as $value) {
				$names->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($names);
			$document->formatOutput = true;	
			return $document->saveXML();
			}

		function getRobotSandraNodes($query) {
			$document = new DOMdocument();
			$document->Load('./result4.xml');
			$xpath = new DOMXPath($document);
			$outcome = $xpath->query($query);
			$document = new DOMdocument('1.0', 'UTF-8');
			$names = $document->createElement('names');
			foreach ($outcome as $value) {
				$names->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($names);
			$document->formatOutput = true;	
			return $document->saveXML();
			}

		function getNumberOfCustomersServedByJoe($robotName) {
			$numberOfElements=0;
			$document = new DOMdocument();
			$document->Load('./result1.xml');
			$xpath = new DOMXPath($document);
			$query = "//robots[rname/text()='$robotName']";
			$outcome = $xpath->query($query);
          		foreach ($outcome as $node) {
              			$numberOfElements++;
          		}
          		return $numberOfElements;
		}

		function getDeliverysInRange($intArray) {
			$intArray = $intArray->int;
			$document = new DOMdocument();
			$document->Load('./result4.xml');
			$xpath = new DOMXPath($document);
			$query = "/robot_sandra/robot_taskboard/delivery_info/delivery[@delivery_id > $intArray[0] and @delivery_id < $intArray[1]]/ancestor::delivery_info/delivery";
			$outcome = $xpath->query($query);
         		$document = new DOMdocument('1.0', 'UTF-8');
			$delivery = $document->createElement('deliverys');
			foreach ($outcome as $value) {
				$delivery->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($delivery);
			$document->formatOutput = true;		
			$xmlObject = simplexml_load_string($document->saveXML());
			return json_encode($xmlObject, JSON_PRETTY_PRINT);
		}

		function getOrdersWithTomatos($stringArray) {
			$stringArray = $stringArray->string;
			$document = new DOMdocument();
			$document->Load('./result2.xml');
			$xpath = new DOMXPath($document);
			$query = "//Orderdetails/OrderItems[Item1/text()='$stringArray[0]' or Item2/text()='$stringArray[1]' or Item3/text()='$stringArray[2]']/parent::Orderdetails";
			$outcome = $xpath->query($query);
         		$document = new DOMdocument('1.0', 'UTF-8');
			$tomatos = $document->createElement('tomatos');
			foreach ($outcome as $value) {
				$tomatos->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($tomatos);
			$document->formatOutput = true;		
			$xmlObject = simplexml_load_string($document->saveXML());
			return json_encode($xmlObject, JSON_PRETTY_PRINT);
		}

		function getRobotTaskboard($map) {
			$mapitem = $map->item;
			$mapvalue = $mapitem[0]->value;
			$newxml = new SimpleXMLElement(file_get_contents('./result4.xml'));
			$query = $newxml->xpath("/robot_sandra/descendant::robot_taskboard[robot_info[@robot_id=$mapvalue]]/robot_info");
			$namespace = "";

			$robot_taskboard = Array();
			foreach ($query as $entry){
			  $robot = new StdClass();
			  $robot->rname = new SoapVar($entry->rname, XSD_STRING, NULL, $namespace, 'rname', $namespace);
			  $robot->rtype = new SoapVar($entry->rtype, XSD_STRING, NULL, $namespace, 'rtype', $namespace);
			  $robot->rfunction = new SoapVar($entry->rfunction, XSD_STRING, NULL, $namespace, 'rfunction', $namespace);
			  array_push($robot_taskboard, new SoapVar($robot, SOAP_ENC_OBJECT, NULL, $namespace, 'robot_info', $namespace));
			}
	  		
			$result = new StdClass();
			$result->robot_taskboard=new SoapVar($robot_taskboard, SOAP_ENC_OBJECT, NULL, $namespace, 'robot_info', $namespace);
	  
			print_r($result);
			return $result;	
		}

		function getNumberOfOrdersBetween($datesArray) {
			$datesArray = $datesArray->string;
			$numberOfElements=0;
			$firstDate = substr($datesArray[0],5,2);
			$secondDate = substr($datesArray[1],5,2);
			$document = new DOMdocument();
			$document->Load('./result2.xml');
			$xpath = new DOMXPath($document);
			$query = "//order_date[number(substring(text(),6,2))=$firstDate or number(substring(text(),6,2)) = $secondDate]";
			$outcome = $xpath->query($query);
          		foreach ($outcome as $node) {
              			$numberOfElements++;
          		}
          		return $numberOfElements;
		}

		function getOrdersOfDate($ddate) {
			$targetDate = str_replace("-", "",$ddate);
			$newxml = new SimpleXMLElement(file_get_contents('./result4.xml'));
			$query = $newxml->xpath("//delivery[./descendant::ddate[number(translate(./text(),'-','')) < $targetDate]]/ancestor::delivery_info/delivery");
			$namespace = "";

			$ordersOfDate = Array();
			foreach ($query as $entry){
			  $delivery = new StdClass();
			  $delivery->ddate = new SoapVar($entry->ddate, XSD_STRING, NULL, $namespace, 'ddate', $namespace);
			  $delivery->vendor = new SoapVar($entry->vendor, XSD_STRING, NULL, $namespace, 'vendor', $namespace);
			  $delivery->damount = new SoapVar($entry->damount, XSD_STRING, NULL, $namespace, 'damount', $namespace);
			  array_push($ordersOfDate, new SoapVar($delivery, SOAP_ENC_OBJECT, NULL, $namespace, 'delivery', $namespace));
			}
	  		
			$result = new StdClass();
			$result->ordersOfDate=new SoapVar($ordersOfDate, SOAP_ENC_OBJECT, NULL, $namespace, 'delivery', $namespace);
	  
			print_r($result);
			return $result;	
		}

		function getBurgerbunItemsize($intArray) {
			$intArray = $intArray->int;
			$document = new DOMdocument();
			$document->Load('./result3.xml');
			$xpath = new DOMXPath($document);
			$query = "//orderitem_meta[@item_id > $intArray[0]]/itname |//orderitem_meta[@item_id > $intArray[1]]/itsize";
			$outcome = $xpath->query($query);
         		$document = new DOMdocument('1.0', 'UTF-8');
			$burgerbun = $document->createElement('burgerbun');
			foreach ($outcome as $value) {
				$burgerbun->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($burgerbun);
			$document->formatOutput = true;		
			$xmlObject = simplexml_load_string($document->saveXML());
			return json_encode($xmlObject, JSON_PRETTY_PRINT);
		}

		function getRobotsAndCitys($objects) {
			$firstObject = $objects->Struct[0];
			$secondObject = $objects->Struct[1];
			$document = new DOMdocument();
			$document->Load('./result1.xml');
			$xpath = new DOMXPath($document);
			$query = "//robots[rname/text()='$firstObject->robot3'] |//Address[City/text()='$secondObject->city1']";
			$outcome = $xpath->query($query);
         		$document = new DOMdocument('1.0', 'UTF-8');
			$botsAndcCitys = $document->createElement('botsAndcCitys');
			foreach ($outcome as $value) {
				$botsAndcCitys->appendChild($document->importNode($value,true));
			}	
			$document->appendChild($botsAndcCitys);
			$document->formatOutput = true;		
			$xmlObject = simplexml_load_string($document->saveXML());
			return json_encode($xmlObject, JSON_PRETTY_PRINT);
		}

		function getAddressOfCustomer($id) {
			$newxml = new SimpleXMLElement(file_get_contents('./result1.xml'));
			$query1 = $newxml->xpath("/customer_data/customer_details[@customer_id=$id]/address/Address");
			$query2 = $newxml->xpath("/customer_data/customer_details[@customer_id=$id]/address/Address/Street");
			$namespace = "";

			$customer_data = Array();
			foreach ($query1 as $entry1){
			  $address = new StdClass();
			  $address->City = new SoapVar($entry1->City, XSD_STRING, NULL, $namespace, 'City', $namespace);
			  $address->Country = new SoapVar($entry1->Country, XSD_STRING, NULL, $namespace, 'Country', $namespace);
			  array_push($customer_data, new SoapVar($address, SOAP_ENC_OBJECT, NULL, $namespace, 'Address', $namespace));
			}
	  		  
			foreach ($query2 as $entry2){
			  $address->Street = new SoapVar($entry2->Street, XSD_STRING, NULL, $namespace, 'Street', $namespace);
			  $address->Number = new SoapVar($entry2->Number, XSD_STRING, NULL, $namespace, 'Number', $namespace);
			  $address->Additional = new SoapVar($entry2->Additional, XSD_STRING, NULL, $namespace, 'Additional', $namespace);
			  array_push($customer_data);
			}

			$result = new StdClass();
			$result->customer_data=new SoapVar($customer_data, SOAP_ENC_OBJECT, NULL, $namespace, 'Address', $namespace);
	  
			print_r($result);
			return $result;	

		}

		function getOrdersWithWater($stringArray) {
			$stringArray = $stringArray->string;
			$newxml = new SimpleXMLElement(file_get_contents('./result2.xml'));
			$query = $newxml->xpath("//Orderdetails/OrderItems[Item1/text()='$stringArray[0]' or Item2/text()='$stringArray[1]' or Item3/text()='$stringArray[2]']/ancestor::Orderdetails/OrderItems");
			$namespace = "";

			$ordersWithWater = Array();
			foreach ($query as $entry){
			  $water = new StdClass();
			  $water->Item1 = new SoapVar($entry->Item1, XSD_STRING, NULL, $namespace, 'Item1', $namespace);
			  $water->Item2 = new SoapVar($entry->Item2, XSD_STRING, NULL, $namespace, 'Item2', $namespace);
			  $water->Item3 = new SoapVar($entry->Item3, XSD_STRING, NULL, $namespace, 'Item3', $namespace);
			  array_push($ordersWithWater, new SoapVar($water, SOAP_ENC_OBJECT, NULL, $namespace, 'water', $namespace));
			}
	  		
			$result = new StdClass();
			$result->ordersWithWater=new SoapVar($ordersWithWater, SOAP_ENC_OBJECT, NULL, $namespace, 'water', $namespace);
	  
			print_r($result);
			return $result;	
		}

?>