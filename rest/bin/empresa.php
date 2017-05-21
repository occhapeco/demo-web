<?php
	class empresa
	{
		function insert($nome_usuario,$email,$senha,$razao_social,$nome_fantasia,$cnpj,$celular,$descricao,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
			//if(!validar_cnpj($cnpj))
				//if(!validar_cpf($cnpj))
					//return 0;
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = md5(sha1($senha));
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$cnpj = preg_replace('![*#\"´`]+!','',$cnpj);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);
			$descricao = preg_replace('![*#/\"´`]+!','',$descricao);
			$data_cadastro = date("Y-m-d");

			if(isset_email($email))
				return -1;

			$conexao = conectar();
			$query = $conexao->query("INSERT INTO empresa VALUES(NULL,'$nome_usuario','$email','$senha','$razao_social','$nome_fantasia','$cnpj','$celular','$descricao','$data_cadastro',0,-1)");
			if(!$query)
		    	return -2;
		    $dados = array();
		    $dados["id"] = $conexao->insert_id;
			$dados["access_token"] = sha1($senha.$email.$dados["id"]);
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
		    	return -3;
		    }
			$conexao->close();
			mandar_email($email,"Solicitação de cadastro enviada.","Caro $nome_usuario, <br>sua solicitação de cadastro foi enviada com sucesso. Assim que um dos nossos administradores analisarem seus dados, retornaremos a resposta. Obrigado por escolher o Clube de Ofertas!");
			return json_encode($dados);
		}

		function insert_endereco($empresa_id,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
		    $rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$cep = preg_replace('![*#/\"´`]+!','',$cep);
			$telefone = preg_replace('![*#/\"´`]+!','',$telefone);

			$conexao = conectar();
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

		    $conexao = conectar();
		    $query = $conexao->query("INSERT INTO cupom VALUES(NULL,$empresa_id,$endereco_id,'$imagem','$titulo','$regras','$descricao',$preco_normal,$preco_cupom,'$prazo',$quantidade,$pagamento,$delivery,-1,'".date("Y-m-d H:i")."')");
		    $cupom_id = 0;
		    if($query)
		    {
		    	$cupom_id = $conexao->insert_id;
		    	$tipo = json_decode($tipos);
		    	$tit = "Nova oferta para aprovar";
				$msg = "\"$titulo\" requisita aprovação para entrar em vigor no Clube de Ofertas. Acesse o <a href='http://clubedeofertas.net/admin/'>Painel admin</a>.";
				mandar_email("andrewsaxx@gmail.com",$tit,$msg);
				mandar_email("professortiton@gmail.com",$tit,$msg);
				mandar_email("wagner.titon@edu.sc.senai.br",$tit,$msg);
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

			$conexao = conectar();
			$query = $conexao->query("UPDATE empresa SET nome_usuario = '$nome_usuario', razao_social = '$razao_social', nome_fantasia = '$nome_fantasia', celular = '$celular',descricao = '$descricao' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = conectar();
			$query = $conexao->query("UPDATE empresa SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
			$conexao->close();
			return $query;
		}

		function redefinir_senha($id,$senha_nova)
		{
			$senha_nova = md5(sha1($senha_nova));
			$conexao = conectar();
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

			$conexao = conectar();
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

		    $conexao = conectar();
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
			$conexao = conectar();
			$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email' AND senha = '$senha'");
			$dados = array();
			if($query->num_rows == 1)
			{
				$row = $query->fetch_assoc();
				$dados["id"] = $row["id"];
				$dados["estado"] = $row["estado"];
				$dados["access_token"] = sha1($row["senha"].$row["email"].$row["id"]);
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_perfil($id)
		{
			$conexao = conectar();
			$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_endereco($id)
		{
			$conexao = conectar();
			$query = $conexao->query("SELECT endereco.bairro,endereco.rua,endereco.num,endereco.complemento,endereco.cep,cidade.id,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM endereco INNER JOIN cidade ON(cidade.id = endereco.cidade_id) WHERE endereco.id = $id");
			$dados = array();
			$row = $query->fetch_assoc();
			$dados = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_enderecos($empresa_id)
		{
			$conexao = conectar();
			$query = $conexao->query("SELECT endereco.id,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM endereco INNER JOIN cidade ON(cidade.id = endereco.cidade_id) WHERE endereco.empresa_id = $empresa_id");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_cupom($id)
		{
			$conexao = conectar();
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
			$conexao = conectar();
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
			$conexao = conectar();
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
			$conexao = conectar();
			$tokens = array();
			$oferta = "Valeu a pena?";
			$result = true;
			for($i=0;$i<count($usuarios);$i++)
			{
				$query = $conexao->query("UPDATE usuario_has_cupom SET estado = 1 WHERE id = ".$usuarios[$i]);
				$sub_query = $conexao->query("SELECT usuario.token FROM usuario INNER JOIN usuario_has_cupom ON (usuario.id = usuario_has_cupom.usuario_id) WHERE usuario_has_cupom.id = ".$usuarios[$i]." GROUP BY usuario_has_cupom.usuario_id");
				if($sub_query->num_rows > 0)
				{
					$row = $sub_query->fetch_assoc();
					$tokens[] = $row["token"];
				}
				if($i == 0)
				{
					$sub_query = $conexao->query("SELECT cupom.titulo FROM cupom INNER JOIN usuario_has_cupom ON (cupom.id = usuario_has_cupom.cupom_id) WHERE usuario_has_cupom.id = ".$usuarios[$i]." GROUP BY usuario_has_cupom.cupom_id");
					if($sub_query->num_rows > 0)
					{
						$row = $sub_query->fetch_assoc();
						$oferta = $row["titulo"];
					}
				}
			}
			if(count($tokens) > 0)
				$message_status = send_notification($tokens,"Avalie sua compra!",$oferta);
			$conexao->close();
			return $result;
		}

		function visualizar($empresa_id)
		{
			$conexao = conectar();
			$query = $conexao->query("UPDATE notificacao a JOIN cupom b ON(b.id=a.cupom_id) SET a.visualizado = 1 WHERE b.empresa_id = $empresa_id");
			$conexao->close();
			return $query;
		}

		function select_notificacoes($empresa_id)
		{
			$conexao = conectar();
			$query = $conexao->query("SELECT notificacao.tipo,notificacao.cupom_id FROM notificacao INNER JOIN cupom ON(cupom.id=notificacao.cupom_id) WHERE cupom.empresa_id = $empresa_id");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_nao_visualizadas($empresa_id)
		{
			$conexao = conectar();
			$query = $conexao->query("SELECT notificacao.id FROM notificacao INNER JOIN cupom ON(cupom.id=notificacao.cupom_id) WHERE cupom.empresa_id = $empresa_id AND notificacao.visualizado = 0");
			$num = $query->num_rows;
			$conexao->close();
			return $num;
		}

		function desativar_cupom($id)
		{
			$conexao = conectar();
			$query = $conexao->query("UPDATE cupom SET estado = -2 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function select_tarifa($empresa_id)
		{
			$conexao = conectar();
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
			$conexao = conectar();
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
?>