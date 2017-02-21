<?php
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
			$dados = array();
			if($query)
			{
				$dados["id"] = $conexao->insert_id;
				$dados["access_token"] = sha1($senha.$email.$dados["id"]);
			}
			$conexao->close();
			return json_decode($dados);
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
			$token = "error";
			$query = $conexao->query("SELECT * FROM usuario WHERE id = $id AND senha = '$senha_antiga'");
			if($query->num_rows == 1)
			{
				$row = $query->fetch_assoc();
				$token = sha1($row["senha"].$row["email"].$row["id"]);
				$query = $conexao->query("UPDATE usuario SET senha = '$senha_nova' WHERE id = $id");
			}
			$conexao->close();
			return $token;
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
			$dados = array();
			if($query->num_rows == 1)
			{
				$row = $query->fetch_assoc();
				$dados["id"] = $row["id"];
				$dados["access_token"] = sha1($row["senha"].$row["email"].$row["id"]);
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_cupons($cidade,$delivery,$pagamento,$tipo_id)
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
			if($query->num_rows == 1)
			{
				$row = $query->fetch_assoc();
				$dados["detalhes"] = $row;
				$query = $conexao->query("SELECT tipo.nome FROM cupom_has_tipo INNER JOIN tipo ON (tipo.id = cupom_has_tipo.tipo_id)  WHERE cupom_has_tipo.cupom_id = $cupom_id");
				while($row = $query->fetch_assoc())
					$dados["tipos"][] = $row;
			}
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
?>