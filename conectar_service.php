<?php
	require_once('lib/nusoap.php');

	ini_set("soap.wsdl_cache_enabled", "1");
	$service = new nusoap_client('http://clubedeofertas.net/service/index.php?wsdl', true);

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

	function img_resize($target,$newcopy,$ext,$w=720,$h=480)
	{
	    list($w_orig, $h_orig) = getimagesize($target);
	    $scale_ratio = $w_orig / $h_orig;
	    if (($w / $h) > $scale_ratio) {
	           $w = $h * $scale_ratio;
	    } else {
	           $h = $w / $scale_ratio;
	    }
	    $img = "";
	    $ext = strtolower($ext);
	    if($ext == "png"){ 
	      $img = imagecreatefrompng($target);
	    } else if($ext == "jpeg" || $ext == "jpg") { 
	      $img = imagecreatefromjpeg($target);
	    }
	    $tci = imagecreatetruecolor($w, $h);
	    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
	    imagejpeg($tci, $newcopy, 80);
	}

?>