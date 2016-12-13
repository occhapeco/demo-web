<?php
	session_start();
	if(!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "admin")
		header("location: ../login.php");
?>