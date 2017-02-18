<?php
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
				if($row["token"] != "")
					$tokens[] = $row["token"];
			if(count($tokens) > 0)
				$resultado = json_decode(send_notification($tokens,$title,$body));
			$conexao->close();
			return $resultado->success;
		}

		function verificar_token($token)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM admin");
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