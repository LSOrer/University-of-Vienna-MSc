<?php
	header('Content-Type: text/xml');
	
    function getHandler($url, $arguments, $request){
       

                
                print getBurgerbunNodes("/orderitem_meta[@item_id=$request[2]]");


        echo $xmlfile;
		exit;

	}

?>