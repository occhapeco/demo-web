<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://localhost/service/index.php?wsdl', true);

	error_reporting(E_ALL);
	ini_set("display_errors",0);

?>