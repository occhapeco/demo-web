<?php
	require_once('lib/nusoap.php');

	$server = new soap_server;
	$server->configureWSDL('service','urn:service');
	$namespace = 'urn:service';
	$server->wsdl->schemaTargetNamespace = $namespace;

	function validar_cnpj($cnpj)
	{
		$cnpj = preg_replace('![^0-9/]+!','',$cnpj);
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

	class usuario
	{
		function insert($nome,$email,$senha,$celular,$genero,$nascimento)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$celular = preg_replace("![^0-9]+!",'',$celular);
			$nascimento = preg_replace('![^0-9/]+!','',$nascimento);
			$senha = md5(sha1($senha));

			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("INSERT INTO usuario VALUES(NULL,'$nome','$email','$senha','$celular',$genero,'$nascimento',0)");
			$id = 0;
			if($query)
		    	return $conexao->insert_id;
			$conexao->close();
			return $id;
		}

		function update_perfil($id,$nome,$celular,$genero,$nascimento)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$celular = preg_replace("![^0-9]+!",'',$celular);
			$nascimento = preg_replace('![^0-9/]+!','',$nascimento);

			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("UPDATE usuario SET nome = '$nome', celular = '$celular', genero = $genero, nascimento = '$nascimento' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("UPDATE usuario SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
			$conexao->close();
			return $query;
		}

		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'");
			if($query->num_rows > 1 || $query->num_rows == 0)
				return 0;
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_cupons($usuario_id,$cidade,$delivery,$pagamento,$tipo_id,$num)
		{
			$tipo_id = json_decode($tipo_id);
			for($i=0;$i<sizeof($tipo_id);$i++)
			{
				if($i != 0)
					$str_tipo .= "AND"
				$str_tipo .= " cupom_has_tipo.tipo_id = ".$tipo_id[$i]." ";
			}
			$cond = "";
			if($pagamento > 0)
				$cond .= " AND cupom.pagamento = ".$pagamento;
			if($delivery > 0)
				$cond .= " AND cupom.delivery = ".$delivery;
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT cupom.id,cupom.titulo,cupom.preco_normal,cupom.preco_cupom,cupom.prazo,cupom.quantidade,empresa.nome_fantasia FROM cupom INNER JOIN cupom_has_tipo ON (cupom.id = cupom_has_tipo.cupom_id) INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN empresa ON (cupom.empresa_id = empresa.id) INNER JOIN cidade ON (endereco.cidade_id = cidade.id) WHERE $str_tipo AND cidade.id = $cidade $cond AND cupom.quantidade > 0 AND cupom.estado = 0 ORDER BY cupom.prioridade DESC");
			$dados = array();
			$i = 0
			$max = $num + 5;
			while($row = $query->fetch_assoc())
			{
				$sub_query = $conexao->query("SELECT * FROM cupom_has_tipo WHERE estado <> 0 AND usuario_id = $usuario_id AND cupom_id = ".$row["id"]);
				if($i > $num && $i < $max && $sub_query->num_rows() == 0)
					$dados[$i] = $row;
				$i++;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_detalhes_cupom($cupom_id)
		{
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT cupom.regras,cupom.descricao,cupom.pagamento,cupom.delivery,endereco.rua,endereco.num,endereco.complemento,endereco.bairro,endereco.latitude,endereco.longitude FROM cupom INNER JOIN endereco ON (endereco.id = cupom.endereco_id)  WHERE cupom.id = $cupom_id");
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
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("UPDATE cupom SET quantidade = quantidade - 1 WHERE id = $cupom_id AND quantidade > 0");
			if($query)
			{
				$query = $conexao->query("UPDATE cupom SET estado = 1 WHERE id = $cupom_id AND quantidade = 0 AND estado = 0");
				$query = $conexao->query("SELECT * FROM cupom WHERE id = $cupom_id");
				$row = $query->fetch_assoc();
				$query = $conexao->query("INSERT INTO usuario_has_cupom VALUES(NULL,$cupom_id,$usuario_id,0,".$row["preco_cupom"].",'".$row["prazo"]."',".$row["pagamento"].",".$row["delivery"].")");
			}
			$conexao->close();
			return false;
		}

		function select_perfil($id)
		{
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT * FROM usuario WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_historico($id)
		{
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT * FROM usuario_has_cupom INNER JOIN usuario ON(cupom.usuario_id = usuario.id) WHERE usuario.id = $id");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}
	}

	$server->register('usuario.insert', array('nome' => 'xsd:string','email' => 'xsd:string','senha' => 'xsd:string','celular' => 'xsd:string','genero' => 'xsd:integer','nascimento' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de usuário.');
	$server->register('usuario.update_perfil', array('id' => 'xsd:integer','nome' => 'xsd:string','celular' => 'xsd:string','genero' => 'xsd:integer','nascimento' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar perfil do usuário.');
	$server->register('usuario.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar senha do usuário.');
	$server->register('usuario.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realizar login do usuário.');
	$server->register('usuario.select_cupons', array('usuario_id' => 'xsd:integer','cidade' => 'xsd:integer','delivery' => 'xsd:integer','pagamento' => 'xsd:integer','tipo_id' => 'xsd:string','num' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecionar cupons com filtros e limite de 5. ');
	$server->register('usuario.select_detalhes_cupom', array('cupom_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecionar detalhes de um cupom. ');
	$server->register('usuario.pegar_cupom', array('usuario_id' => 'xsd:integer','cupom_id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Pegar cupom, baixa automaticamente');
	$server->register('usuario.select_perfil', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de um usuario.');
	$server->register('usuario.select_historico', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona histórico do usuario.');

	class empresa
	{
		function insert($nome_usuario,$email,$senha,$razao_social,$nome_fantasia,$cnpj,$celular,$rua,$num,$complemento,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
			if(!validar_cnpj($cnpj))
				return 0;
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = md5(sha1($senha));
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$cnpj = preg_replace('![^0-9]+!','',$cnpj);
			$celular = preg_replace("![^0-9]+!",'',$celular);

			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("INSERT INTO empresa VALUES(NULL,'$nome_usuario','$email','$senha','$razao_social',$genero,'$nome_fantasia','$cnpj','$celular',0)");
			if(!$query)
		    	return -1;
		    $empresa_id = $conexao->insert_id;
		    $rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$telefone = preg_replace('![^0-9]+!','',$telefone);
		    $query = $conexao->query("INSERT INTO endereco VALUES(NULL,$empresa_id,'$rua',$num,'$complemento','$bairro',$cidade_id,$latitude,$longitude,'$telefone')");
		    if(!$query)
		    {
		    	$query = $conexao->query("DELETE FROM usuario WHERE id = $empresa_id)");
		    	return -2;
		    }
			$conexao->close();
			return $empresa_id;
		}

		function insert_endereco($empresa_id,$rua,$num,$complemento,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
		    $rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$telefone = preg_replace('![^0-9]+!','',$telefone);
		    $query = $conexao->query("INSERT INTO endereco VALUES(NULL,$empresa_id,'$rua',$num,'$complemento','$bairro',$cidade_id,$latitude,$longitude,'$telefone')");
		    $empresa_id = 0;
		    if($query)
		    	$empresa_id = $conexao->insert_id;
			$conexao->close();
			return $empresa_id;
		}

		function update_perfil($id,$nome_usuario,$razao_social,$nome_fantasia,$celular)
		{
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$celular = preg_replace('![^0-9]+!','',$celular);

			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("UPDATE empresa SET nome_usuario = '$nome_usuario', razao_social = '$razao_social', nome_fantasia = '$nome_fantasia', celular = '$celular' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("UPDATE empresa SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
			$conexao->close();
			return $query;
		}

		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT * FROM empresa WHERE email = '$email' AND senha = '$senha'");
			if($query->num_rows > 1 || $query->num_rows == 0)
				return 0;
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function select_perfil($id)
		{
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_enderecos($id)
		{
			$conexao = mysqli_connect("localhost","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query("SELECT endereco.rua,endereco.num,endereco.complemento,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM endereco INNER JOIN cidade ON(cidade.id = endereco.cidade_id) WHERE endereco.empresa_id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}
	}

	$server->register('empresa.insert', array('nome_usuario' => 'xsd:string','email' => 'xsd:string','senha' => 'xsd:string','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','cnpj' => 'xsd:string','celular' => 'xsd:string','rua' => 'xsd:string','num' => 'xsd:string','complemento' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:double','longitude' => 'xsd:double','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de empresa e endereço inicial.');
	$server->register('empresa.insert_empresa', array('empresa_id' => 'xsd:string','rua' => 'xsd:string','num' => 'xsd:string','complemento' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:double','longitude' => 'xsd:double','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de endereço.');
	$server->register('empresa.update_perfil', array('id' => 'xsd:integer','nome_usuario' => 'xsd:string','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','celular' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Alterar perfil de empresa.');
	$server->register('empresa.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar senha da empresa.');
	$server->register('empresa.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realizar login da empresa.');
	$server->register('empresa.select_perfil', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de uma empresa.');
	$server->register('empresa.select_enderecos', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona endereços de uma empresa.');

	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);
?>