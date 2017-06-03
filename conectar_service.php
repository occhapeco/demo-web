<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);

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