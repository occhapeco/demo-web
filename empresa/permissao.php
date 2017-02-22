<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	session_start();
	if(!isset($_SESSION["empresa_id"]) || $_SESSION["empresa_id"] == 0)
		header("location: ../login.php");
?>