<?php
  	include('rest_handle.php');
  	$rest = handleREST($_SERVER,$_GET);
	$header = getallheaders();
  	
	function writeToLog($writeString) {
		$CPEElog = fopen("cpee.log", "a+");
		fwrite($CPEElog, print_r($writeString, true));
		fclose($CPEElog);
	}

	if ($rest->method=="POST") {
		writeToLog(">> NEW MESSAGE HEADER << at " . date('Y-m-d H:i:s', time()) . "\n");
		writeToLog($header);
		writeToLog(">> REST BODY << \n");
		writeToLog($rest);
		writeToLog("\n");
		posthandler($rest, $header);
	}

	function posthandler($rest, $header) {

		if (array_key_exists("CPEE-CALLBACK", $header)) {
			writeToLog("CPEE-CALLBACK\n");
			createCallBack($rest, $header);
		}

		if (array_key_exists("Content-ID", $header) && $header["Content-ID"] == "producing") {
			writeToLog("PRODUCING PROGRESS\n");
			productionUpdates($rest);
		}

		if (array_key_exists("Content-ID", $header) && $header["Content-ID"] == "PommesW") {
			writeToLog("NEW ORDER\n");
			newOrderReceived();
		}
		
	}
	
	function createCallBack($rest, $header) {
		header("CPEE-CALLBACK: true");
		$url = $header["CPEE-CALLBACK"];
		$RESTargs = $rest->arguments;
		$pid = $RESTargs["pid"];
		$cpeeFile = file_get_contents("cpee.json");
		$cpeeData = json_decode($cpeeFile, true);
		$cpeeData[$pid] = $url;
		$jCPEEdata = json_encode($cpeeData, JSON_PRETTY_PRINT);
		file_put_contents("cpee.json", $jCPEEdata); 
	}

	function productionUpdates($rest) {
		$RESTargs = $rest->arguments;
		$ARGkey = key($RESTargs);
		$jARGkey = json_decode($ARGkey, true);
		$progress = $jARGkey["progress"];
		$progressArray = array("progress" => $progress);
		$contentData = json_encode($progressArray, JSON_FORCE_OBJECT);
		$cpeeFile = file_get_contents("cpee.json");	
		$cpeeData = json_decode($cpeeFile, true);
		$pid = $jARGkey["pid"];
		$url = ($cpeeData[$pid]."/");
		
		$opts = array('http' =>
			array(
				'method'  => 'PUT',
				'header'  => 'Content-type: application/json',
				'content' => $contentData
			)
		);

		$context = stream_context_create($opts);
		$result = file_get_contents($url, false, $context);

		writeToLog("PROGRESS\n");
		writeToLog($opts);
		writeToLog("\n");
		writeToLog("RESPONSE HEADER\n");
		writeToLog($http_response_header);
		writeToLog("\n");	

		if($progress == "END") {
			unset($url);
			$jCPEEdata = json_encode($cpeeData, JSON_PRETTY_PRINT);
			file_put_contents("cpee.json", $jCPEEdata); 
		}
	}


	function newOrderReceived() {
		
		$xml = file_get_contents("process.xml");
		
		$eol = "\r\n";
		$mime_boundary=md5(time()); 
		$data = '';
		$data .= '--' . $mime_boundary . $eol;
		$data .= 'Content-Disposition: form-data; name="xml"; filename="process.xml"' . $eol;
		$data .= 'Content-Type: text/xml' . $eol;
		$data .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
		$data .= chunk_split(base64_encode($xml)) . $eol; 
		$data .= "--" . $mime_boundary . "--" . $eol . $eol;
	 
		$opts = array('http' => 
			array(
			   'method' => 'POST',
			   'header' => 'Content-Type: multipart/form-data; boundary=' . $mime_boundary . $eol,
			   'content' => $data
			)	
		);
	 
		header('content-type: text/xml');
		$context = stream_context_create($opts);
		$result = json_decode(file_get_contents('https://cpee.org/flow/start/', false, $context));

		writeToLog("Starting process instance \n");
		writeToLog($opts);
		writeToLog("\n");
		writeToLog("Response Header from https://cpee.org/flow/start/'");
		writeToLog("\n");
		writeToLog($http_response_header);
		writeToLog("\n");
		writeToLog("REST from https://cpee.org/flow/start/'");
		writeToLog($rest);

		$opts = array('http' =>
		array(
			'method'  => 'PUT',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query( 
				array(
					 'value' => 'running'
				 )
			 )
		)
		);
		
		$instance = $result->{'CPEE-INSTANCE'};
		$context = stream_context_create($opts); 
		$result = file_get_contents("https://cpee.org/flow/engine/$instance/properties/state/", false, $context);
		
		writeToLog("<opts> Send to CPEE \n");
		writeToLog($opts);
		writeToLog("\n");	
		writeToLog("<instance> Send to CPEE  \n");
		writeToLog($instance);
		writeToLog("\n");	
		writeToLog("<context> Send to CPEE  \n");
		writeToLog($context);
		writeToLog("\n");	
		writeToLog("<result> Send to CPEE  \n");
		writeToLog($result);
		writeToLog("\n");	
		writeToLog("<rest> Send to CPEE  \n");
		writeToLog($rest);
	}

?>
