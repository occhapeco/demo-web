<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	session_start();
	if(!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "admin")
		header("location: ../login.php");
?>