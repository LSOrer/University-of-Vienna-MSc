<?php
	function handleREST($server,$get) {
   		$url = (array_key_exists('PATH_INFO',$server) ? $server['PATH_INFO'] : '/');
   		$method = $server['REQUEST_METHOD'];
   		
		parse_str(file_get_contents('php://input'),$contentargs);
   		$arguments = array_merge($get,$contentargs);
   		$accept = array_key_exists('HTTP_ACCEPT',$server) ? $server['HTTP_ACCEPT'] : '*/*';
   		$result = new StdClass;
   		$result->url = $url;
   		$result->method = $method;
   		$result->arguments = $arguments;
   		$result->accept = $accept;
   		return $result;
 	}

	 
?>
