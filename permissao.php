<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	ob_start(); 
	session_start();
	if(isset($_SESSION["tipo"]))
	{
		if($_SESSION["tipo"] == "empresa")
			header("location: empresa/");
		elseif($_SESSION["tipo"] == "admin")
			header("location: admin/");
	}
?>