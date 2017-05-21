<?php
	function conectar()
	{
		$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
		$query = $conexao->query('SET CHARACTER SET utf8');
		return $conexao;
	}

	function send_notification($tokens,$title,$body)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
	    $priority="high";
	    $notification= array('title' => $title,'body' => $body);

	    $fields = array(
	         'registration_ids' => $tokens,
	         'notification' => $notification

	        );


	    $headers = array(
	        'Authorization:key= AAAAvKZuaiQ:APA91bFGzTkMCKQbmi9klRGWMEI2I90Mzxlu_XjbOB4Oc6vF8lihCKK5q79sQmXuWtsgLw5nweShSddJDavn2w4RQraPF_UWaqEKjvgRabM2BwnxGa6-E-piJSmwSnxzwnoLpH8S-e_Q9hWnctPGzAUiv7CrLNBjtA',
	        'Content-Type: application/json'
	        );

	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, $url);
	   curl_setopt($ch, CURLOPT_POST, true);
	   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	   $result = curl_exec($ch);           
	   echo curl_error($ch);
	   if ($result === FALSE) {
	       die('Curl failed: ' . curl_error($ch));
	   }
	   curl_close($ch);
	   return $result;
	}

	function mandar_email($email,$assunto,$msg)
	{
		$email_sender = "no-reply@clubedeofertas.net";

		$headers = "MIME-Version: 1.1\n";
		$headers .= "Content-type: text/html; charset=UTF-8\n";
		$headers .= "From: Clube de Ofertas <$email_sender>\n";
		$headers .= "Return-Path: $email_sender\n";
		$headers .= "X-Priority: 1\n";
		$envio = mail($email,$assunto,"<div style='font-size: 18px;'>".$msg."<br><br><h3>Atenciosamente, equipe Clube de Ofertas.</h3></div>",$headers,"-r".$email_sender);
		if(!$envio)
			return false;
		else
			return true;
	}

	function converter_data($data,$tipo)
	{
		if($tipo)
		{
			$array = explode(" ",$data);
			$data = explode("/",$array[0]);
			return $data[2]."-".$data[1]."-".$data[0]." ".$array[1].":00";
		}
		else
		{
			$array = explode(" ",$data);
			$data = explode("-",$array[0]);
			$hora = explode(":",$array[1]);
			return $data[2]."/".$data[1]."/".$data[0]." ".$hora[0].":".$hora[1];
		}
	}

	function validar_cpf($cpf)
	{
		$d1 = 0;
		$d2 = 0;
  		$cpf = preg_replace("/[^0-9]/", "", $cpf);
	  	$ignore_list = array(
		    '00000000000',
		    '01234567890',
		    '11111111111',
		    '22222222222',
		    '33333333333',
		    '44444444444',
		    '55555555555',
		    '66666666666',
		    '77777777777',
		    '88888888888',
		    '99999999999'
	  	);
  		if(strlen($cpf) != 11 || in_array($cpf, $ignore_list))
      		return false;
  		else
  		{
    		for($i = 0; $i < 9; $i++)
      			$d1 += $cpf[$i] * (10 - $i);
    
	    	$r1 = $d1 % 11;
	    	$d1 = ($r1 > 1) ? (11 - $r1) : 0;
	    	for($i = 0; $i < 9; $i++)
	      		$d2 += $cpf[$i] * (11 - $i);
	    
	    	$r2 = ($d2 + ($d1 * 2)) % 11;
	    	$d2 = ($r2 > 1) ? (11 - $r2) : 0;
	    	return (substr($cpf, -2) == $d1 . $d2) ? true : false;
  		}
	}

	function validar_cnpj($cnpj)
	{
		$cnpj = preg_replace('![^0-9]+!','',$cnpj);
		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;
		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
	}

	function query($sql_query)
	{
		$conexao = conectar();
		$query = $conexao->query($sql_query);
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	function select_cidades()
	{
		$conexao = conectar();
		$query = $conexao->query("SELECT * FROM cidade WHERE estado = 0");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	function select_tipos()
	{
		$conexao = conectar();
		$query = $conexao->query("SELECT * FROM tipo");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	function redefinir_senha($email)
	{
		$conexao = conectar();
		$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email'");
		$token = "";
		$resultado = false;
		if($query->num_rows == 1)
		{
			$row = $query->fetch_assoc();
			$token = sha1($row["senha"].$row["email"].$row["id"]);
		}
		else
		{
			$query = $conexao->query("SELECT * FROM usuario WHERE email = '$email'");
			if($query->num_rows == 1)
			{
				$row = $query->fetch_assoc();
				$token = sha1($row["senha"].$row["email"].$row["id"]);
			}
		}
		if($token != "")
		{
			$resultado = true;
			$nome = "";
			if(isset($row["nome_usuario"]))
				$nome = $row["nome_usuario"];
			else
				$nome = $row["nome"];

			mandar_email($row["email"],"Redefinição de senha.","Caro ".$nome.", <br>foi requisitado a redefinição de sua senha no Clube de Ofertas. Para tal, clique <a href='http://clubedeofertas.net/redefinir_senha.php?token=$token'>aqui</a>.");
		}

		$conexao->close();
		return $resultado;
	}

	function isset_email($email)
	{
		$result = false;
		$conexao = conectar();

		$query = $conexao->query("SELECT * FROM usuario WHERE email = '$email'");
		if($query && $query->num_rows > 0)
			$result = true;
		
		if(!$result)
		{
			$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email'");
			if($query && $query->num_rows > 0)
				$result = true;
		}

		if(!$result)
		{
			$query = $conexao->query("SELECT * FROM admin WHERE email = '$email'");
			if($query && $query->num_rows > 0)
				$result = true;
		}
		
		$conexao->close();
		return $result;
	}
?>