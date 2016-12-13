<?php
	require_once('lib/nusoap.php');

	$server = new soap_server;
	$server->configureWSDL('service','urn:service');
	$namespace = 'urn:service';
	$server->wsdl->schemaTargetNamespace = $namespace;

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

	function select_cidades()
	{
		$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
		$query = $conexao->query('SET CHARACTER SET utf8');
		$query = $conexao->query("SELECT * FROM cidade");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	$server->register('select_cidades', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Select de cidades cadastradas para abrangência.');

	function select_tipos()
	{
		$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
		$query = $conexao->query('SET CHARACTER SET utf8');
		$query = $conexao->query("SELECT * FROM tipo");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	$server->register('select_tipos', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Select de cidades cadastradas para abrangência.');

	function select_imagens()
	{
		$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
		$query = $conexao->query('SET CHARACTER SET utf8');
		$query = $conexao->query("SELECT * FROM imagem WHERE tipo = 1");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	$server->register('select_imagens', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Select de imagens.');

	class usuario
	{
		function insert($nome,$email,$senha,$celular,$genero,$nascimento)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);
			$data = new DateTime();
		    $data = $data->createFromFormat('d/m/Y',$nascimento);
		    $nascimento = $data->format("Y-m-d");
			$senha = md5(sha1($senha));

			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
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
			$celular = preg_replace('![*#/\"´`]+!','',$celular);

			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario SET nome = '$nome', celular = '$celular', genero = $genero, nascimento = '$nascimento' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
			$conexao->close();
			return $query;
		}

		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
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
			$str_tipo = "";
			$inner = "";
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
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.id,cupom.titulo,cupom.preco_normal,cupom.preco_cupom,cupom.prazo,cupom.quantidade,imagem.caminho,empresa.nome_fantasia FROM cupom $inner INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN empresa ON (cupom.empresa_id = empresa.id) INNER JOIN imagem ON (cupom.imagem_id = imagem.id) INNER JOIN cidade ON (endereco.cidade_id = cidade.id) WHERE cidade.id = $cidade $str_tipo $cond AND cupom.quantidade > 0 AND cupom.estado = 0");
			$dados = array();
			$i = 0;
			$max = $num + 5;
			while($row = $query->fetch_assoc())
			{
				if($i >= $num && $i < $max)
					$dados[$i] = $row;
				$data = new DateTime();
			    $data = $data->createFromFormat('Y-m-d H:i:s',$dados[$i]["prazo"]);
			    $dados[$i]["prazo"] = $data->format("d/m/Y H:i");
				$i++;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_detalhes_cupom($cupom_id)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.estado,cupom.regras,cupom.descricao,cupom.pagamento,cupom.delivery,imagem.caminho,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.telefone,endereco.latitude,endereco.longitude,empresa.nome_fantasia FROM cupom INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN imagem ON (imagem.id = cupom.imagem_id) INNER JOIN cidade ON(endereco.cidade_id = cidade.id) INNER JOIN empresa ON(empresa.id = cupom.empresa_id) WHERE cupom.id = $cupom_id");
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
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE cupom SET quantidade = quantidade - 1 WHERE id = $cupom_id AND quantidade > 0");
			if($query)
			{
				$query = $conexao->query("UPDATE cupom SET estado = 1 WHERE id = $cupom_id AND quantidade = 0 AND estado = 0");
				$query = $conexao->query("SELECT * FROM cupom WHERE id = $cupom_id");
				$row = $query->fetch_assoc();
				$data = date("Y-m-d H:i:s");
				$query = $conexao->query("INSERT INTO usuario_has_cupom VALUES(NULL,$cupom_id,$usuario_id,0,".$row["preco_normal"].",".$row["preco_cupom"].",'".$row["prazo"]."',".$row["pagamento"].",".$row["delivery"].",'$data',NULL,NULL,NULL,NULL)");
			}
			$conexao->close();
			return $query;
		}

		function select_perfil($id)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM usuario WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_historico($id)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT usuario_has_cupom.id,usuario_has_cupom.cupom_id,usuario_has_cupom.estado,usuario_has_cupom.preco_normal,usuario_has_cupom.preco_cupom,usuario_has_cupom.prazo,usuario_has_cupom.pagamento,usuario_has_cupom.delivery,usuario_has_cupom.data_resgate,cupom.titulo,cupom.regras,cupom.descricao,imagem.caminho,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.telefone,endereco.latitude,endereco.longitude,empresa.nome_fantasia FROM usuario_has_cupom INNER JOIN usuario ON(usuario_has_cupom.usuario_id = usuario.id) INNER JOIN cupom ON(cupom.id = usuario_has_cupom.cupom_id) INNER JOIN imagem ON (cupom.imagem_id = imagem.id) INNER JOIN endereco ON (endereco.id = cupom.endereco_id) INNER JOIN cidade ON(endereco.cidade_id = cidade.id) INNER JOIN empresa ON(empresa.id = cupom.empresa_id) WHERE usuario.id = $id");
			$dados = array();
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function avaliar($id,$produto,$atendimento,$ambiente,$comentarios)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE usuario_has_cupom SET produto=$produto,atendimento=$atendimento,ambiente=$ambiente,comentarios='$comentarios' WHERE id = $id");
			$conexao->close();
			return $query;
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
	$server->register('usuario.avaliar', array('id' => 'xsd:integer','produto' => 'xsd:integer','atendimento' => 'xsd:integer','ambiente' => 'xsd:integer','comentarios' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona histórico do usuario.');

	class empresa
	{
		function insert($nome_usuario,$email,$senha,$razao_social,$nome_fantasia,$cnpj,$celular,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
			if(!validar_cnpj($cnpj))
				return 0;
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$senha = md5(sha1($senha));
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$cnpj = preg_replace('![*#\"´`]+!','',$cnpj);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);
			$data_cadastro = date("Y-m-d");

			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("INSERT INTO empresa VALUES(NULL,'$nome_usuario','$email','$senha','$razao_social','$nome_fantasia','$cnpj','$celular','$data_cadastro',0)");
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
			return $empresa_id;
		}

		function insert_endereco($empresa_id,$rua,$num,$complemento,$cep,$bairro,$cidade_id,$latitude,$longitude,$telefone)
		{
		    $rua = preg_replace('![*#/\"´`]+!','',$rua);
		    $complemento = preg_replace('![*#/\"´`]+!','',$complemento);
		    $bairro = preg_replace('![*#/\"´`]+!','',$bairro);
			$cep = preg_replace('![*#/\"´`]+!','',$cep);
			$telefone = preg_replace('![*#/\"´`]+!','',$telefone);

			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("INSERT INTO endereco VALUES(NULL,$empresa_id,'$rua',$num,'$complemento','$cep','$bairro',$cidade_id,'$latitude','$longitude','$telefone')");
		    $id = 0;
		    if($query)
		    	$id = $conexao->insert_id;
			$conexao->close();
			return $id;
		}

		function insert_imagem($caminho)
		{
		    $caminho = preg_replace('![*#\"´`]+!','',$caminho);

		    $conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("INSERT INTO imagem VALUES(NULL,'$caminho',0)");
		    $imagem_id = 0;
		    if($query)
		    	$imagem_id = $conexao->insert_id;
			$conexao->close();
			return $imagem_id;
		}

		function insert_cupom($empresa_id,$endereco_id,$imagem_id,$titulo,$regras,$descricao,$preco_normal,$preco_cupom,$prazo,$quantidade,$pagamento,$delivery,$tipos)
		{
		    $titulo = preg_replace('![*#/\"´`]+!','',$titulo);
		    $regras = preg_replace('![*#/\"´`]+!','',$regras);
		    $descricao = preg_replace('![*#/\"´`]+!','',$descricao);
		    $data = new DateTime();
		    $data = $data->createFromFormat('d/m/Y H:i',$prazo);
		    $prazo = $data->format("Y-m-d H:i:s");

		    $conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("INSERT INTO cupom VALUES(NULL,$empresa_id,$endereco_id,$imagem_id,'$titulo','$regras','$descricao',$preco_normal,$preco_cupom,'$prazo',$quantidade,$pagamento,$delivery,-1)");
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

		function update_perfil($id,$nome_usuario,$razao_social,$nome_fantasia,$celular)
		{
			$nome_usuario = preg_replace('![*#/\"´`]+!','',$nome_usuario);
			$razao_social = preg_replace('![*#/\"´`]+!','',$razao_social);
			$nome_fantasia = preg_replace('![*#/\"´`]+!','',$nome_fantasia);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);

			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET nome_usuario = '$nome_usuario', razao_social = '$razao_social', nome_fantasia = '$nome_fantasia', celular = '$celular' WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_senha($id,$senha_antiga,$senha_nova)
		{
			$senha_antiga = md5(sha1($senha_antiga));
			$senha_nova = md5(sha1($senha_nova));
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE empresa SET senha = '$senha_nova' WHERE id = $id AND senha = '$senha_antiga'");
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

			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("UPDATE endereco SET rua='$rua',num='$num',complemento='$complemento',cep='$cep',bairro='$bairro',cidade_id=$cidade_id,latitude='$latitude',longitude='$longitude',telefone='$telefone',estado=-1 WHERE id = $id");
			$conexao->close();
			return $query;
		}

		function update_cupom($cupom_id,$endereco_id,$imagem_id,$titulo,$regras,$descricao,$preco_normal,$preco_cupom,$prazo,$quantidade,$pagamento,$delivery,$tipos)
		{
		    $titulo = preg_replace('![*#/\"´`]+!','',$titulo);
		    $regras = preg_replace('![*#/\"´`]+!','',$regras);
		    $descricao = preg_replace('![*#/\"´`]+!','',$descricao);
		    $data = new DateTime();
		    $data = $data->createFromFormat('d/m/Y H:i',$prazo);
		    $prazo = $data->format("Y-m-d H:i:s");

		    $conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
		    $query = $conexao->query("UPDATE cupom SET endereco_id=$endereco_id,imagem_id=$imagem_id,titulo='$titulo',regras='$regras',descricao='$descricao',preco_normal=$preco_normal,preco_cupom=$preco_cupom,prazo='$prazo',quantidade=$quantidade,pagamento=$pagamento,delivery=$delivery,estado=-1 WHERE id = $cupom_id");
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
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
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
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM empresa WHERE id = $id");
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_endereco($id)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
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
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
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
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.imagem_id,imagem.caminho,cupom.titulo,cupom.regras,cupom.descricao,cupom.prazo,cupom.preco_normal,cupom.preco_cupom,cupom.quantidade,cupom.delivery,cupom.pagamento,cupom.endereco_id,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM cupom INNER JOIN endereco ON(endereco.id = cupom.endereco_id) INNER JOIN cidade ON(cidade.id = cupom.endereco_id) INNER JOIN imagem ON(imagem.id = cupom.imagem_id) WHERE cupom.id = $id");
			$dados = $query->fetch_assoc();
			$query = $conexao->query("SELECT * FROM tipo INNER JOIN cupom_has_tipo ON(tipo.id = cupom_has_tipo.tipo_id) WHERE cupom_has_tipo.cupom_id = $id");
			$dados["tipo"] = array();
			while($row = $query->fetch_assoc())
				$dados["tipo"][] = $row;
			$conexao->close();
			$data = new DateTime();
		    $data = $data->createFromFormat('Y-m-d H:i:s',$dados["prazo"]);
		    $dados["prazo"] = $data->format("d/m/Y H:i");
			return json_encode($dados);
		}

		function select_cupons($id)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.id, cupom.titulo, cupom.descricao, cupom.preco_normal, cupom.preco_cupom, cupom.prazo, cupom.quantidade, cupom.delivery, cupom.estado, imagem.caminho FROM cupom INNER JOIN imagem ON(cupom.imagem_id = imagem.id) WHERE cupom.empresa_id = $id");
			$dados = array();
			$i = 0;
			while($row = $query->fetch_assoc())
			{
				$dados[$i] = $row;
				$sub_query = $conexao->query("SELECT tipo.nome,tipo.id FROM cupom_has_tipo INNER JOIN tipo ON (tipo.id = cupom_has_tipo.tipo_id)  WHERE cupom_has_tipo.cupom_id = $cupom_id");
				$dados[$i]["tipos"] = array();
				while($row = $query->fetch_assoc())
					$dados[$i]["tipos"][] = $row;
			}
			$conexao->close();
			return json_encode($dados);
		}

		function select_usuarios($cupum_id)
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT usuario_has_cupom.id,usuario.nome,usuario.celular,usuario_has_cupom.preco_cupom,usuario_has_cupom.estado FROM usuario_has_cupom INNER JOIN usuario ON(usuario.id = usuario_has_cupom.usuario_id) WHERE usuario_has_cupom.cupom_id = $cupum_id");
			while($row = $query->fetch_assoc())
				$dados[] = $row;
			$conexao->close();
			return json_encode($dados);
		}

		function dar_baixa($usuarios)
		{
			$usuarios = json_decode($usuarios);
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			for($i=0;$i<count($usuarios);$i++)
				$query = $conexao->query("UPDATE usuario_has_cupom SET estado = 1 WHERE id = ".$usuarios[$i]);
			$conexao->close();
			return $query;
		}
	}

	$server->register('empresa.insert', array('nome_usuario' => 'xsd:string','email' => 'xsd:string','senha' => 'xsd:string','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','cnpj' => 'xsd:string','celular' => 'xsd:string','rua' => 'xsd:string','num' => 'xsd:integer','complemento' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:string','longitude' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de empresa e endereço inicial.');
	$server->register('empresa.insert_endereco', array('empresa_id' => 'xsd:integer','rua' => 'xsd:string','num' => 'xsd:integer','complemento' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:string','longitude' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de endereço.');
	$server->register('empresa.insert_cupom', array('empresa_id' => 'xsd:integer','endereco_id' => 'xsd:integer','imagem_id' => 'xsd:string','titulo' => 'xsd:string','regras' => 'xsd:string','descricao' => 'xsd:string','preco_normal' => 'xsd:double','preco_cupom' => 'xsd:double','prazo' => 'xsd:string','quantidade' => 'xsd:integer','pagamento' => 'xsd:integer','delivery' => 'xsd:integer','tipos' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Cadastro de cupom.');
	$server->register('empresa.insert_imagem', array('caminho' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Cadastro de imagem.');
	$server->register('empresa.update_perfil', array('id' => 'xsd:integer','nome_usuario' => 'xsd:string','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','celular' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Alterar perfil de empresa.');
	$server->register('empresa.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar senha da empresa.');
	$server->register('empresa.update_endereco', array('id' => 'xsd:string','rua' => 'xsd:string','num' => 'xsd:string','complemento' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:string','longitude' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Alterar dados de um endereço.');
	$server->register('empresa.update_cupom', array('cupom_id' => 'xsd:integer','endereco_id' => 'xsd:integer','imagem_id' => 'xsd:string','titulo' => 'xsd:string','regras' => 'xsd:string','descricao' => 'xsd:string','preco_normal' => 'xsd:double','preco_cupom' => 'xsd:double','prazo' => 'xsd:string','quantidade' => 'xsd:integer','pagamento' => 'xsd:integer','delivery' => 'xsd:integer','tipos' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Alterar dados de um cupom.');
	$server->register('empresa.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realizar login da empresa.');
	$server->register('empresa.select_perfil', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de uma empresa.');
	$server->register('empresa.select_enderecos', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona endereços de uma empresa.');
	$server->register('empresa.select_endereco', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de um endereço.');
	$server->register('empresa.select_cupom', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de um cupom.');
	$server->register('empresa.select_cupons', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona todos os cupons e seus dados pela empresa.');
	$server->register('empresa.select_usuarios', array('cupom_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona os usuarios que resgatarem um cupom.');
	$server->register('empresa.dar_baixa', array('usuarios' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Dá baixa em resgates de usuarios.');

	class admin
	{
		function login($email,$senha)
		{
			$senha = md5(sha1($senha));
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT * FROM admin WHERE email = '$email' AND senha = '$senha'");
			if($query->num_rows == 0)
				return 0;
			$row = $query->fetch_assoc();
			$conexao->close();
			return json_encode($row);
		}

		function select_cupons()
		{
			$conexao = mysqli_connect("mysql.hostinger.com.br","u274667541_root","oieoie","u274667541_app");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("SELECT cupom.id,cupom.imagem_id,imagem.caminho,cupom.titulo,cupom.regras,cupom.descricao,cupom.prazo,cupom.preco_normal,cupom.preco_cupom,cupom.quantidade,cupom.delivery,cupom.pagamento,cupom.endereco_id,endereco.rua,endereco.num,endereco.complemento,endereco.cep,endereco.bairro,cidade.nome,cidade.uf,endereco.latitude,endereco.longitude,endereco.telefone FROM cupom INNER JOIN endereco ON(endereco.id = cupom.endereco_id) INNER JOIN cidade ON(cidade.id = endereco.cidade_id) INNER JOIN imagem ON(imagem.id = cupom.imagem_id) WHERE cupom.estado = -1");
			$dados = array();
			$i = 0;
			while($row = $query->fetch_assoc())
			{
				$dados[$i] = $row;
				$query = $conexao->query("SELECT * FROM tipo INNER JOIN cupom_has_tipo ON(tipo.id = cupom_has_tipo.tipo_id) WHERE cupom_has_tipo.cupom_id = ".$row["id"]);
				$dados[$i]["tipo"] = array();
				while($row = $query->fetch_assoc())
					$dados[$i]["tipo"][] = $row;
				$data = new DateTime();
			    $data = $data->createFromFormat('Y-m-d H:i:s',$dados[$i]["prazo"]);
			    $dados[$i]["prazo"] = $data->format("d/m/Y H:i");
			    $i++;
			}
			$conexao->close();
			return json_encode($dados);
		}
	}

	$server->register('admin.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realizar login do admin.');
	$server->register('admin.select_cupons', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecionar cupons que precisam de aprovação.');

	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);
?>