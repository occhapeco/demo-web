<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://noxgames.com.br/service/index.php?wsdl', true);

?>