<?php
	session_start();
	if(!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "empresa")
		header("location: ../index.php");
?>