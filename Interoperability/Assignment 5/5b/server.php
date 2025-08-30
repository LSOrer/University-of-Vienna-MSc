<?php
	include('rest_handle.php');
	include('get_handle.php');
	#include('delete_handle.php');
	#include('post_handle.php');
	#include('put_handle.php');
	include('rest_get.php');
	#include('rest_delete.php');
	#include('rest_post.php');
	#include('rest_put.php');
	$rest = handleREST($_SERVER,$_GET);
	$request = explode("/", $rest->url);
	$arguments = $rest->arguments;
	$method = $rest->method;
	$url = $rest->url;

	switch($method){
		case 'GET':
			getHandler($url, $arguments, $request);
		break;
		#case 'DELETE':
		#	deleteHandler($arguments, $request);
		#break;
		#case 'POST':
		#	postHandler($arguments, $request);
		#break;
		#case 'PUT':
		#	putHandler($arguments, $request);
		#break;

	}

?>