<?php
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: no-reply@clubeofertas.com\r\n";
	$headers .= "Return-Path: no-reply@clubeofertas.com\r\n";
	$envio = mail("andrewsaxx@gmail.com","Clube de Ofertas - ","<br><br>Atenciosamente, equipe Clube de Ofertas.",$headers);
	if(!envio)
		echo "Deu ruim";
	else
		echo "Deu boa";
?>