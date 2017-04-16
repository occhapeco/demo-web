<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://clubedeofertas.net/service/index.php?wsdl', true);

	error_reporting(E_ALL);
	ini_set("display_errors",1);

	function call($data)
	{
		$postdata = http_build_query($data);

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);

		$context  = stream_context_create($opts);

		return file_get_contents("http://clubedeofertas.net/rest/api.php", false, $context);
	}

	

?>