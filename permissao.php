<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	ob_start(); 
	session_start();
	if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != 0)
		header("location: admin/");
	elseif(isset($_SESSION["empresa_id"]) && $_SESSION["empresa_id"] != 0)
		header("location: empresa/");
?>