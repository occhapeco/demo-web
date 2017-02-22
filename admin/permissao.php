<?php
	error_reporting(E_ALL);
	ini_set("display_errors",0);
	session_start();
	if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0)
		header("location: ../login.php");
?>