<?php
	session_start();
	if(isset($_SESSION["tipo"]))
	{
		if($_SESSION["tipo"] == "empresa")
			header("location: empresa/");
		elseif($_SESSION["tipo"] == "admin")
			header("location: admin/");
	}
?>