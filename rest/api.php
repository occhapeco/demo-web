<?php
	$classe = null;
	$metodo = null;
	$admin = null;
	$empresa = null;
	$usuario = null;

	if($_POST["metodo"] == "login")
	{
		if($_POST["classe"] == "admin")
		{
			$admin = new admin();
			echo $admin->login($_POST["email"],$_POST["senha"]);
		}
		elseif($_POST["classe"] == "empresa")
		{
			$empresa = new empresa();
			echo $empresa->login($_POST["email"],$_POST["senha"]);
		}
		elseif($_POST["classe"] == "usuario")
		{
			$usuario = new usuario();
			echo $usuario->login($_POST["email"],$_POST["senha"]);
		}
	}

	if(isset($_POST["token"]))
	{
		$admin = new admin();
		$empresa = new empresa();
		$usuario = new usuario();
		if($admin->verificar_token($_POST["token"]) || $empresa->verificar_token($_POST["token"]) || $usuario->verificar_token($_POST["token"]))
		{
			$metodo = $_POST["metodo"];
			if(isset($_POST["classe"]))
				$classe = $_POST["classe"];
		}
	}

	if($classe == "admin")
	{
		if($metodo == "insert_cidade")
			echo $admin->insert_cidade($_POST["cidade"],$_POST["uf"]);

		if($metodo == "insert_tipo")
			echo $admin->insert_tipo($_POST["nome"]);

		if($metodo == "select_cupons_avaliaveis")
			echo $admin->select_cupons_avaliaveis();

		if($metodo == "select_cupons")
			echo $admin->select_cupons();

		if($metodo == "select_empresas")
			echo $admin->select_empresas($_POST["estado"]);

		if($metodo == "select_cidades")
			echo $admin->select_cidades();

		if($metodo == "desativar_cidade")
			echo $admin->desativar_cidade($_POST["id"]);

		if($metodo == "ativar_cidade")
			echo $admin->ativar_cidade($_POST["id"]);

		if($metodo == "delete_tipo")
			echo $admin->delete_tipo($_POST["id"]);

		if($metodo == "aprovar_cupom")
			echo $admin->aprovar_cupom($_POST["id"]);

		if($metodo == "recusar_cupom")
			echo $admin->recusar_cupom($_POST["id"]);

		if($metodo == "aprovar_empresa")
			echo $admin->aprovar_empresa($_POST["id"]);

		if($metodo == "recusar_empresa")
			echo $admin->recusar_empresa($_POST["id"]);

		if($metodo == "bloquear_empresa")
			echo $admin->bloquear_empresa($_POST["id"]);

		if($metodo == "desbloquear_empresa")
			echo $admin->desbloquear_empresa($_POST["id"]);

		if($metodo == "select_tarifa")
			echo $admin->select_tarifa();

		if($metodo == "dar_baixa_tarifa")
			echo $admin->dar_baixa_tarifa($_POST["id"],$_POST["data"]);

		if($metodo == "notificar_usuarios")
			echo $admin->dar_baixa_tarifa($_POST["title"],$_POST["body"]);
	}
	elseif($classe == "empresa")
	{
		if($metodo == "insert")
			echo $admin->insert($_POST["nome_usuario"],$_POST["email"],$_POST["senha"],$_POST["razao_social"],$_POST["nome_fantasia"],$_POST["cnpj"],$_POST["celular"],$_POST["descricao"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]);

		if($metodo == "insert_endereco")
			echo $admin->insert_endereco($_POST["empresa_id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]);
	}
	elseif($classe == "usuario")
	{
		if($metodo == "insert")
			echo $usuario->insert($_POST["nome"],$_POST["email"],$_POST["senha"],$_POST["celular"],$_POST["genero"],$_POST["nascimento"],$_POST["token_celular"]);
		
		if($metodo == "update_perfil")
			echo $usuario->update_perfil($_POST["id"],$_POST["nome"],$_POST["celular"],$_POST["genero"],$_POST["nascimento"]);

		if($metodo == "update_senha")
			echo $usuario->update_senha($_POST["id"],$_POST["senha_antiga"],$_POST["senha_nova"]);

		if($metodo == "update_token")
			echo $usuario->update_token($_POST["id"],$_POST["token"]);

		if($metodo == "refefinir_senha")
			echo $usuario->refefinir_senha($_POST["id"],$_POST["senha"]);

		if($metodo == "select_cupons")
			echo $usuario->select_cupons($_POST["usuario_id"],$_POST["cidade_id"],$_POST["delivery"],$_POST["pagamento"],$_POST["tipo_id"]);

		if($metodo == "select_detalhes_cupom")
			echo $usuario->select_detalhes_cupom($_POST["cupom_id"]);

		if($metodo == "pegar_cupom")
			echo $usuario->pegar_cupom($_POST["usuario_id"],$_POST["cupom_id"]);

		if($metodo == "select_perfil")
			echo $usuario->select_perfil($_POST["id"]);

		if($metodo == "select_historico")
			echo $usuario->select_historico($_POST["id"]);

		if($metodo == "avaliar")
			echo $usuario->avaliar($_POST["id"],$_POST["produto"],$_POST["atendimento"],$_POST["ambiente"],$_POST["comentarios"]);
	}
	else
	{

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
		$envio = mail($email,"Clube de Ofertas - ".$assunto,"<h4>".$msg."</h4><br><br><h3>Atenciosamente, equipe Clube de Ofertas.</h3>",$headers,"-r".$email_sender);
		if(!envio)
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
		$query = $conexao->query($sql_query);
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}


	function select_cidades()
	{
		$query = $conexao->query("SELECT * FROM cidade WHERE estado = 0");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}


	function select_tipos()
	{
		$query = $conexao->query("SELECT * FROM tipo");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	function esqueci_senha($email)
	{
		$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
		$query = $conexao->query('SET CHARACTER SET utf8');
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

	class admin
	{
		function insert_cidade($cidade,$uf)
		{
			$cidade = preg_replace('![*#/\"´`]+!','',$cidade);
			$uf = preg_replace('![*#/\"´`]+!','',$uf);

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("INSERT INTO cidade VALUES(NULL,'$cidade','$uf',0)");
			$id = 0;
			if($query)
		    	$id = $conexao->insert_id;
			$conexao->close();
			return $id;
		}

		function insert_tipo($nome)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("INSERT INTO tipo VALUES(NULL,'$nome')");
			$id = 0;
			if($query)
		    	$id = $conexao->insert_id;
			$conexao->close();
			return $id;
		}

		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM admin WHERE email = '$email' AND senha = '$senha'");
			if($query->num_rows == 0)
				return 0;
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_cupons_avaliaveis()
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.id,cupom.imagem,cupom.empresa_id,cupom.titulo,cupom.regras,cupom.descricao,cupom.prazo,cupom.preco_normal,cupom.preco_cupom,cupom.quantidade,cupom.delivery,cupom.pagamento,cupom.endereco_id,empresa.nome_fantasia,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM cupom INNER JOIN endereco ON(endereco.id = cupom.endereco_id) INNER JOIN cidade ON(cidade.id = endereco.cidade_id) INNER JOIN empresa ON(cupom.empresa_id = empresa.id) WHERE cupom.estado = -1");
			$dados = array();
			$i = 0;
			while($row = $query->fetch_assoc())
			{
				$dados[$i] = $row;
				$sub_query = $conexao->query("SELECT * FROM tipo INNER JOIN cupom_has_tipo ON(tipo.id = cupom_has_tipo.tipo_id) WHERE cupom_has_tipo.cupom_id = ".$row["id"]);
				$dados[$i]["tipo"] = array();
				while($row = $sub_query->fetch_assoc())
					$dados[$i]["tipo"][] = $row;
			    $dados[$i]["prazo"] = converter_data($dados[$i]["prazo"],false);
			    $i++;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_cupons()
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.estado,cupom.id,cupom.imagem,cupom.empresa_id,cupom.titulo,cupom.regras,cupom.descricao,cupom.prazo,cupom.preco_normal,cupom.preco_cupom,cupom.quantidade,cupom.delivery,cupom.pagamento,cupom.endereco_id,cupom.data_cadastro,empresa.nome_fantasia,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM cupom INNER JOIN endereco ON(endereco.id = cupom.endereco_id) INNER JOIN cidade ON(cidade.id = endereco.cidade_id) INNER JOIN empresa ON(cupom.empresa_id = empresa.id) ORDER BY cupom.estado DESC");
			$dados = array();
			$i = 0;
			while($row = $query->fetch_assoc())
			{
				$dados[$i] = $row;
				$sub_query = $conexao->query("SELECT * FROM tipo INNER JOIN cupom_has_tipo ON(tipo.id = cupom_has_tipo.tipo_id) WHERE cupom_has_tipo.cupom_id = ".$row["id"]);
				$dados[$i]["tipo"] = array();
				while($row = $sub_query->fetch_assoc())
					$dados[$i]["tipo"][] = $row;
			    $dados[$i]["prazo"] = converter_data($dados[$i]["prazo"],false);
			    $dados[$i]["data_cadastro"] = converter_data($dados[$i]["data_cadastro"],false);
			    $i++;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_empresas($estado)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			if($estado == 0)
				$estado = $estado." OR estado = -2";
			$query = $conexao->query("SELECT * FROM empresa WHERE estado = $estado");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_cidades()
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM cidade");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function desativar_cidade($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cidade.id FROM cidade INNER JOIN endereco ON(endereco.cidade_id = cidade.id) INNER JOIN cupom ON(cupom.endereco_id = endereco.id) WHERE cidade.id = $id AND cupom.estado = 0");
			$resultado = false;
			if($query->num_rows == 0)
			{
				$resultado = true;
				$query = $conexao->query("UPDATE cidade SET estado = -1 WHERE id = $id");
			}
			$conexao->close();
			return $resultado;
		}

		function ativar_cidade($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE cidade SET estado = 0 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function delete_tipo($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT id FROM cupom_has_tipo WHERE tipo_id = $id");
			$resultado = false;
			if($query->num_rows == 0)
			{
				$resultado = true;
				$query = $conexao->query("DELETE FROM tipo WHERE id = $id");
			}
			$conexao->close();
			return $resultado;
		}

		function aprovar_cupom($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE cupom SET estado = 0 WHERE id = $id");
			$sub_query = $conexao->query("INSERT INTO notificacao VALUES(NULL,$id,1,0)");
			$conexao->close();
			return $query;
		}

		function recusar_cupom($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE cupom SET estado = -2 WHERE id = $id");
			$sub_query = $conexao->query("INSERT INTO notificacao VALUES(NULL,$id,0,0)");
			$conexao->close();
			return $query;
		}

		function aprovar_empresa($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET estado = 0 WHERE id = $id");
			if($query)
			{
				$sub_query = $conexao->query("SELECT email,nome_usuario FROM empresa WHERE id = $id");
				$row = $sub_query->fetch_assoc();
				mandar_email($row["email"],"Cadastro aprovado!","Caro ".$row["nome_usuario"].", <br>seja bem-vindo ao Clube de Ofertas! Após analisarmos seus dados, o seu cadastro foi aprovado. Comece hoje mesmo a publicar ofertas e aumente seu número dos seus cliente clicando <a href='http://clubedeofertas.net/login.php'>aqui</a>!");
			}
			$conexao->close();
			return $query;
		}

		function recusar_empresa($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT email,nome_usuario FROM empresa WHERE id = $id");
			$row = $query->fetch_assoc();
			mandar_email($row["email"],"Cadastro recusado!","Caro ".$row["nome_usuario"].", <br>após analisarmos seus dados, o seu cadastro foi negado devido a algumas anormalidades em seus dados. Caso ainda queira participar do Clube de Ofertas, afetue seu cadastro novamente clicando <a href='http://clubedeofertas.net/cad_empresa.php'>aqui</a>.");
			$query = $conexao->query("DELETE FROM endereco WHERE empresa_id = $id");
			$query = $conexao->query("DELETE FROM empresa WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function bloquear_empresa($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET estado = -2 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function desbloquear_empresa($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET estado = 0 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function select_tarifa()
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT data_cadastro FROM empresa WHERE data_cadastro = (SELECT MIN(data_cadastro) FROM empresa)");
			$row = $query->fetch_assoc();
			$date = explode("-",$row["data_cadastro"]);
			$date1 = new DateTime($date[0]."-".$date[1]);
			$date2 = date("Y-m");
			$dados = array();
			$i = 0;
			while($date1->format("Y-m") <= $date2)
			{
				$nome = "";
				switch($date1->format("m")) 
				{
			        case "01":    $nome = "Janeiro";     break;
			        case "02":    $nome = "Fevereiro";   break;
			        case "03":    $nome = "Março";       break;
			        case "04":    $nome = "Abril";       break;
			        case "05":    $nome = "Maio";        break;
			        case "06":    $nome = "Junho";       break;
			        case "07":    $nome = "Julho";       break;
			        case "08":    $nome = "Agosto";      break;
			        case "09":    $nome = "Setembro";    break;
			        case "10":    $nome = "Outubro";     break;
			        case "11":    $nome = "Novembro";    break;
			        case "12":    $nome = "Dezembro";    break; 
				}
				$nome .= "/".$date1->format("Y");
				$dados[$i]["data"] = $nome;
				$dados[$i]["data_baixa"] = $date1->format("Y-m-00");

				$query = $conexao->query("SELECT empresa.id,empresa.celular,SUM(usuario_has_cupom.preco_cupom) AS valor,(SELECT COUNT(tarifa.id) FROM tarifa WHERE tarifa.empresa_id = empresa.id) AS estado FROM empresa INNER JOIN cupom ON (empresa.id = cupom.empresa_id) INNER JOIN usuario_has_cupom ON (cupom.id = usuario_has_cupom.cupom_id) WHERE (usuario_has_cupom.estado = 1 OR usuario_has_cupom.estado = 2) AND MONTH(cupom.prazo) = ".$date1->format("m")." AND YEAR(cupom.prazo) = ".$date1->format("Y")." GROUP BY empresa.id");
				$j = 0;
				while($row = $query->fetch_assoc())
				{
					$dados[$i]["empresa"][$j] = $row;
					$dados[$i]["empresa"][$j]["comissao"] = $row["valor"] * 0.06;
					$j++;
				}
				$i++;
				$date1->modify("+1 month");
			}
			$conexao->close();
			return json_encode($dados);
		}

		function dar_baixa_tarifa($empresas)
		{
			$empresas = json_decode($empresas);
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			for($i=0;$i<count($empresas->empresa);$i++)
			{
				$sub_query = $conexao->query("SELECT id FROM tarifa WHERE empresa_id = ".$empresas->empresa[$i]." AND data = '".$empresas->data."'");
				if($sub_query->num_rows == 0)
					$query = $conexao->query("INSERT INTO tarifa VALUES(NULL,".$empresas->empresa[$i].",'".$empresas->data."')");
			}
			$conexao->close();
			return $query;
		}

		function notificar_usuarios($title,$body)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT token FROM usuario");
			$tokens = array();
			while($row = $query->fetch_assoc())
				$tokens[] = $row["token"];
			if(count($tokens) > 0)
				$resultado = json_decode(send_notification($tokens,$title,$body));
			$conexao->close();
			return $resultado->success;
		}

	}

	class empresa
	{
		function insert($nome_usuario,$email,$senha,$razao_social,$nome_fantasia,$cnpj,$celular,$descricao,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
			if(!validar_cnpj($cnpj))
				if(!validar_cpf($cnpj))
					return 0;
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = md5(sha1($senha));
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$cnpj = preg_replace('![*#\"´`]+!','',$cnpj);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);
			$descricao = preg_replace('![*#/\"´`]+!','',$descricao);
			$data_cadastro = date("Y-m-d");

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("INSERT INTO empresa VALUES(NULL,'$nome_usuario','$email','$senha','$razao_social','$nome_fantasia','$cnpj','$celular','$descricao','$data_cadastro',0,-1)");
			if(!$query)
		    	return -1;
		    $empresa_id = $conexao->insert_id;
		    $rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$cep = preg_replace('![*#/\"´`]+!','',$cep);
			$telefone = preg_replace('![*#/\"´`]+!','',$telefone);

		    $query = $conexao->query("INSERT INTO endereco VALUES(NULL,$empresa_id,'$rua',$num,'$complemento','$cep','$bairro',$cidade_id,'$latitude','$longitude','$telefone')");
		    if(!$query)
		    {
		    	$sub_query = $conexao->query("DELETE FROM empresa WHERE id = $empresa_id");
		    	return -2;
		    }
			$conexao->close();
			mandar_email($email,"Solicitação de cadastro enviada.","Caro $nome_usuario, <br>sua solicitação de cadastro foi enviada com sucesso. Assim que um dos nossos administradores analisarem seus dados, retornaremos a resposta. Obrigado por escolher o Clube de Ofertas!");
			return $empresa_id;
		}

		function insert_endereco($empresa_id,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
		    $rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$cep = preg_replace('![*#/\"´`]+!','',$cep);
			$telefone = preg_replace('![*#/\"´`]+!','',$telefone);

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("INSERT INTO endereco VALUES(NULL,$empresa_id,'$rua',$num,'$complemento','$cep','$bairro',$cidade_id,'$latitude','$longitude','$telefone')");
		    $id = 0;
		    if($query)
		    	$id = $conexao->insert_id;
			$conexao->close();
			return $id;
		}

		function insert_cupom($empresa_id,$endereco_id,$imagem,$titulo,$regras,$descricao,$preco_normal,$preco_cupom,$prazo,$quantidade,$pagamento,$delivery,$tipos)
		{
		    $titulo = preg_replace('![*#/\"´`]+!','',$titulo);
		    $regras = preg_replace('![*#/\"´`]+!','',$regras);
		    $descricao = preg_replace('![*#/\"´`]+!','',$descricao);
		    $prazo = converter_data($prazo,true);

		    $conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("INSERT INTO cupom VALUES(NULL,$empresa_id,$endereco_id,'$imagem','$titulo','$regras','$descricao',$preco_normal,$preco_cupom,'$prazo',$quantidade,$pagamento,$delivery,-1,'".date("Y-m-d H:i")."')");
		    $cupom_id = 0;
		    if($query)
		    {
		    	$cupom_id = $conexao->insert_id;
		    	$tipo = json_decode($tipos);
		    	for($i=0;$i<count($tipo);$i++)
		    		$query = $conexao->query("INSERT INTO cupom_has_tipo VALUES(NULL,".$tipo[$i].",$cupom_id)");
		    }
			$conexao->close();
			return $cupom_id;
		}

		function update_perfil($id,$nome_usuario,$razao_social,$nome_fantasia,$celular,$descricao)
		{
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$descricao = preg_replace('![*#/\"´`]+!','',$descricao);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET nome_usuario = '$nome_usuario', razao_social = '$razao_social', nome_fantasia = '$nome_fantasia', celular = '$celular',descricao = '$descricao' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
			$conexao->close();
			return $query;
		}

		function redefinir_senha($id,$senha_nova)
		{
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET senha = '$senha_nova' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_endereco($id,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
			$rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$cep = preg_replace('![*#/\"´`]+!','',$cep);
			$telefone = preg_replace('![*#/\"´`]+!','',$telefone);

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("UPDATE endereco SET rua='$rua',num=$num,complemento='$complemento',cep='$cep',bairro='$bairro',cidade_id=$cidade_id,latitude='$latitude',longitude='$longitude',telefone='$telefone' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_cupom($cupom_id,$endereco_id,$imagem,$titulo,$regras,$descricao,$preco_normal,$preco_cupom,$prazo,$quantidade,$pagamento,$delivery,$tipos)
		{
		    $titulo = preg_replace('![*#/\"´`]+!','',$titulo);
		    $regras = preg_replace('![*#/\"´`]+!','',$regras);
		    $descricao = preg_replace('![*#/\"´`]+!','',$descricao);
		    $prazo = converter_data($prazo,true);

		    $conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("UPDATE cupom SET endereco_id=$endereco_id,imagem='$imagem',titulo='$titulo',regras='$regras',descricao='$descricao',preco_normal=$preco_normal,preco_cupom=$preco_cupom,prazo='$prazo',quantidade=$quantidade,pagamento=$pagamento,delivery=$delivery,estado=-1 WHERE id = $cupom_id");
		    if($query)
		    {
		    	$tipo = json_decode($tipos);
		    	$sub_query = $conexao->query("DELETE FROM cupom_has_tipo WHERE cupom_id=$cupom_id");
		    	for($i=0;$i<count($tipo);$i++)
		    		$sub_query = $conexao->query("INSERT INTO cupom_has_tipo VALUES(NULL,".$tipo[$i].",$cupom_id)");
		    }
			$conexao->close();
			return $query;
		}

		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email' AND senha = '$senha'");
			if($query->num_rows == 0)
				return 0;
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_perfil($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_endereco($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT endereco.bairro,endereco.rua,endereco.num,endereco.complemento,endereco.cep,cidade.id,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM endereco INNER JOIN cidade ON(cidade.id = endereco.cidade_id) WHERE endereco.id = $id");
			$dados = array();
			$row = $query->fetch_assoc();
			$dados = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_enderecos($empresa_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT endereco.id,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM endereco INNER JOIN cidade ON(cidade.id = endereco.cidade_id) WHERE endereco.empresa_id = $empresa_id");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_cupom($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.imagem,cupom.titulo,cupom.regras,cupom.descricao,cupom.prazo,cupom.preco_normal,cupom.preco_cupom,cupom.quantidade,cupom.delivery,cupom.pagamento,cupom.endereco_id,cupom.estado,cupom.data_cadastro,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM cupom INNER JOIN endereco ON(endereco.id = cupom.endereco_id) INNER JOIN cidade ON(cidade.id = endereco.cidade_id) WHERE cupom.id = $id");
			$dados = $query->fetch_assoc();
			$query = $conexao->query("SELECT * FROM tipo INNER JOIN cupom_has_tipo ON(tipo.id = cupom_has_tipo.tipo_id) WHERE cupom_has_tipo.cupom_id = $id");
			$dados["tipo"] = array();
			while($row = $query->fetch_assoc())
				$dados["tipo"][] = $row;
			$conexao->close();
		    $dados["prazo"] = converter_data($dados["prazo"],false);
			$dados["data_cadastro"] = converter_data($dados["data_cadastro"],false);
			return json_encode($dados);
		}

		function select_cupons($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM cupom WHERE empresa_id = $id ORDER BY estado DESC");
			$dados = array();
			$i = 0;
			while($row = $query->fetch_assoc())
			{
				$dados[$i] = $row;
				$dados[$i]["prazo"] = converter_data($dados[$i]["prazo"],false);
				$dados[$i]["data_cadastro"] = converter_data($dados[$i]["data_cadastro"],false);
				$sub_query = $conexao->query("SELECT tipo.nome,tipo.id FROM cupom_has_tipo INNER JOIN tipo ON (tipo.id = cupom_has_tipo.tipo_id)  WHERE cupom_has_tipo.cupom_id = ".$row["id"]);
				$dados[$i]["tipos"] = array();
				while($row = $sub_query->fetch_assoc())
					$dados[$i]["tipos"][] = $row;
				$i++;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_usuarios($cupum_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT usuario_has_cupom.id,usuario.nome,usuario.celular,usuario_has_cupom.preco_cupom,usuario_has_cupom.estado FROM usuario_has_cupom INNER JOIN usuario ON(usuario.id = usuario_has_cupom.usuario_id) WHERE usuario_has_cupom.cupom_id = $cupum_id ORDER BY usuario_has_cupom.estado DESC ");
			$dados = array();
			while($row = $query->fetch_assoc())
			{
				$celular = $row["celular"];
				$celular[strlen($celular)-1] = "X";
				$row["celular"] = $celular;
				$dados[] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function dar_baixa($usuarios)
		{
			$usuarios = json_decode($usuarios);
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$tokens = array();
			$oferta = "Desconto gigante!";
			for($i=0;$i<count($usuarios);$i++)
			{
				$query = $conexao->query("UPDATE usuario_has_cupom SET estado = 1 WHERE id = ".$usuarios[$i]);
				if($query)
				{
					$query = $conexao->query("SELECT usuario.token FROM usuario INNER JOIN usuario_has_cupom ON (usuario.id = usuario_has_cupom.usuario_id) WHERE usuario_has_cupom.id = ".$usuarios[$i]." GROUP BY usuario_has_cupom.usuario_id");
					$row = $query->fetch_assoc();
					$tokens[] = $row["token"];
				}
				if($i == 0)
				{
					$query = $conexao->query("SELECT cupom.titulo FROM cupopm INNER JOIN usuario_has_cupom ON (cupom.id = usuario_has_cupom.cupom_id) WHERE usuario_has_cupom.id = ".$usuarios[$i]." GROUP BY usuario_has_cupom.cupom_id");
					$row = $query->fetch_assoc();
					$oferta = $row["titulo"];
				}
			}
			if(count($tokens) > 0)
				$message_status = send_notification($tokens,"Avalie sua compra!",$oferta);
			$conexao->close();
			return $query;
		}

		function visualizar($empresa_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE notificacao a JOIN cupom b ON(b.id=a.cupom_id) SET a.visualizado = 1 WHERE b.empresa_id = $empresa_id");
			$conexao->close();
			return $query;
		}

		function select_notificacoes($empresa_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT notificacao.tipo,notificacao.cupom_id FROM notificacao INNER JOIN cupom ON(cupom.id=notificacao.cupom_id) WHERE cupom.empresa_id = $empresa_id");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_nao_visualizadas($empresa_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT notificacao.id FROM notificacao INNER JOIN cupom ON(cupom.id=notificacao.cupom_id) WHERE cupom.empresa_id = $empresa_id AND notificacao.visualizado = 0");
			$num = $query->num_rows;
			$conexao->close();
			return $num;
		}

		function desativar_cupom($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE cupom SET estado = -2 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function select_tarifa($empresa_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT data_cadastro FROM empresa WHERE id = $empresa_id");
			$row = $query->fetch_assoc();
			$date = explode("-",$row["data_cadastro"]);
			$date1 = new DateTime($date[0]."-".$date[1]);
			$date2 = date("Y-m");
			$dados = array();
			$i = 0;
			while($date1->format("Y-m") <= $date2)
			{
				$nome = "";
				switch($date1->format("m")) 
				{
			        case "01":    $nome = "Janeiro";     break;
			        case "02":    $nome = "Fevereiro";   break;
			        case "03":    $nome = "Março";       break;
			        case "04":    $nome = "Abril";       break;
			        case "05":    $nome = "Maio";        break;
			        case "06":    $nome = "Junho";       break;
			        case "07":    $nome = "Julho";       break;
			        case "08":    $nome = "Agosto";      break;
			        case "09":    $nome = "Setembro";    break;
			        case "10":    $nome = "Outubro";     break;
			        case "11":    $nome = "Novembro";    break;
			        case "12":    $nome = "Dezembro";    break; 
				}
				$nome .= "/".$date1->format("Y");
				$dados[$i]["data"] = $nome;
				$dados[$i]["estado"] = 0;
				$query = $conexao->query("SELECT * FROM tarifa WHERE empresa_id = $empresa_id AND data = '".$date1->format("Y-m-00")."'");
				if($query->num_rows > 0)
					$dados[$i]["estado"] = 1;

				$query = $conexao->query("SELECT cupom.id,cupom.titulo,cupom.prazo,cupom.data_cadastro,cupom.preco_normal,cupom.preco_cupom,SUM(usuario_has_cupom.preco_cupom) AS total,COUNT(usuario_has_cupom.id) AS cupons FROM usuario_has_cupom INNER JOIN cupom ON (cupom.id = usuario_has_cupom.cupom_id) WHERE cupom.empresa_id = $empresa_id AND MONTH(cupom.prazo) = ".$date1->format("m")." AND YEAR(cupom.prazo) = ".$date1->format("Y")." AND (usuario_has_cupom.estado = 1 OR usuario_has_cupom.estado = 2) GROUP BY cupom.id");
				$j = 0;
				while($row = $query->fetch_assoc())
				{
					$dados[$i]["cupom"][$j] = $row;
					$dados[$i]["cupom"][$j]["prazo"] = converter_data($dados[$i]["cupom"][$j]["prazo"],false);
					$dados[$i]["cupom"][$j]["data_cadastro"] = converter_data($dados[$i]["cupom"][$j]["data_cadastro"],false);
					$dados[$i]["cupom"][$j]["comissao"] = $dados[$i]["cupom"][$j]["total"]*0.06;
					$sub_query = $conexao->query("SELECT COUNT(id) AS cupons FROM usuario_has_cupom WHERE cupom_id = ".$row["id"]);
					$sub_row = $sub_query->fetch_assoc();
					$dados[$i]["cupom"][$j]["total_cupons"] = $sub_row["cupons"];
					$j++;
				}

				$i++;
				$date1->modify("+1 month");
			}
			$conexao->close();
			return json_encode($dados);
		}

		function verificar_token($token)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa");
			$id = 0;
			while($row = $query->fetch_assoc())
				if(sha1($row["senha"].$row["email"].$row["id"]) == $token)
				{
					$id = $row["id"];
					break;
				}
			$conexao->close();
			return $id;
		}

	}

	class usuario
	{
		function insert($nome,$email,$senha,$celular,$genero,$nascimento)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);
			$senha = md5(sha1($senha));

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("INSERT INTO usuario VALUES(NULL,'$nome','$email','$senha','$celular',$genero,'$nascimento',0,'')");
			$id = 0;
			if($query)
		    	return $conexao->insert_id;
			$conexao->close();
			return $id;
		}

		function update_perfil($id,$nome,$celular,$genero,$nascimento)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario SET nome = '$nome', celular = '$celular', genero = $genero, nascimento = '$nascimento' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
			$conexao->close();
			return $query;
		}

		function update_token($id,$token)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario SET token = '$token' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function redefinir_senha($id,$senha_nova)
		{
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario SET senha = '$senha_nova' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'");
			if($query->num_rows > 1 || $query->num_rows == 0)
				return 0;
			$dados = array();
			$row = $query->fetch_assoc();
			$conexao->close();
			return $row["id"];
		}

		function select_cupons($usuario_id,$cidade,$delivery,$pagamento,$tipo_id)
		{
			$tipo_id = json_decode($tipo_id);
			$str_tipo = "";
			$inner = "";
			$data = date("Y-m-d H:i:s");

			for($i=0;$i<count($tipo_id);$i++)
			{
				if($i != 0)
					$str_tipo .= "AND";
				$str_tipo .= " cupom_has_tipo.tipo_id = ".$tipo_id[$i]." ";
			}
			if($str_tipo != "")
				$inner = "INNER JOIN cupom_has_tipo ON (cupom.id = cupom_has_tipo.cupom_id)";
			$cond = "";
			if($pagamento > 0)
				$cond .= " AND cupom.pagamento = ".$pagamento;
			if($delivery > 0)
				$cond .= " AND cupom.delivery = ".$delivery;

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.id,cupom.titulo,cupom.preco_normal,cupom.preco_cupom,cupom.prazo,cupom.quantidade,cupom.imagem,empresa.nome_fantasia FROM cupom $inner INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN empresa ON (cupom.empresa_id = empresa.id) INNER JOIN cidade ON (endereco.cidade_id = cidade.id) WHERE cidade.id = $cidade $str_tipo $cond AND cupom.quantidade > 0 AND cupom.estado = 0 AND cupom.prazo > '$data'");
			$dados = array();
			$i = 0;
			while($row = $query->fetch_assoc())
			{
				$dados[$i] = $row;
			    $dados[$i]["prazo"] = converter_data($dados[$i]["prazo"],false);
				$i++;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_detalhes_cupom($cupom_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.estado,cupom.regras,cupom.descricao,cupom.pagamento,cupom.delivery,cupom.imagem,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.telefone,endereco.latitude,endereco.longitude,empresa.nome_fantasia FROM cupom INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN cidade ON(endereco.cidade_id = cidade.id) INNER JOIN empresa ON(empresa.id = cupom.empresa_id) WHERE cupom.id = $cupom_id");
			$dados = array();
			$row = $query->fetch_assoc();
			$dados["detalhes"] = $row;
			$query = $conexao->query("SELECT tipo.nome FROM cupom_has_tipo INNER JOIN tipo ON (tipo.id = cupom_has_tipo.tipo_id)  WHERE cupom_has_tipo.cupom_id = $cupom_id");
			while($row = $query->fetch_assoc())
				$dados["tipos"][] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function pegar_cupom($usuario_id,$cupom_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT id FROM usuario_has_cupom WHERE usuario_id = $usuario_id AND cupom_id = $cupom_id");
			$resultado = 0;
			if($query->num_rows == 0)
			{
				$query = $conexao->query("UPDATE cupom SET quantidade = quantidade - 1 WHERE id = $cupom_id AND quantidade > 0");
				if($query)
				{
					$query = $conexao->query("UPDATE cupom SET estado = 1 WHERE id = $cupom_id AND quantidade = 0 AND estado = 0");
					$query = $conexao->query("SELECT * FROM cupom WHERE id = $cupom_id");
					$row = $query->fetch_assoc();
					$data = date("Y-m-d H:i:s");
					$query = $conexao->query("INSERT INTO usuario_has_cupom VALUES(NULL,$cupom_id,$usuario_id,0,".$row["preco_normal"].",".$row["preco_cupom"].",'".$row["prazo"]."',".$row["pagamento"].",".$row["delivery"].",'$data',NULL,NULL,NULL,NULL)");
					$resultado = 1;
				}
			}
			$conexao->close();
			return $resultado;
		}

		function select_perfil($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM usuario WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_historico($id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT usuario_has_cupom.id,usuario_has_cupom.cupom_id,usuario_has_cupom.estado,usuario_has_cupom.preco_normal,usuario_has_cupom.preco_cupom,usuario_has_cupom.prazo,usuario_has_cupom.pagamento,usuario_has_cupom.delivery,usuario_has_cupom.data_resgate,cupom.titulo,cupom.regras,cupom.descricao,cupom.imagem,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.telefone,endereco.latitude,endereco.longitude,empresa.nome_fantasia FROM usuario_has_cupom INNER JOIN usuario ON(usuario_has_cupom.usuario_id = usuario.id) INNER JOIN cupom ON(cupom.id = usuario_has_cupom.cupom_id) INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN cidade ON(endereco.cidade_id = cidade.id) INNER JOIN empresa ON(empresa.id = cupom.empresa_id) WHERE usuario.id = $id ORDER BY data_resgate DESC");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function avaliar($id,$produto,$atendimento,$ambiente,$comentarios)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario_has_cupom SET produto=$produto,atendimento=$atendimento,ambiente=$ambiente,comentarios='$comentarios',estado=2 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function verificar_token($token)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM usuario");
			$id = 0;
			while($row = $query->fetch_assoc())
				if(sha1($row["senha"].$row["email"].$row["id"]) == $token)
				{
					$id = $row["id"];
					break;
				}
			$conexao->close();
			return $id;
		}

	}
	
	if($conexao != null)
		$conexao->close();
?>