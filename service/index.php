<?php
	require_once('lib/nusoap.php');

	$server = new soap_server;
	$server->configureWSDL('service','urn:service');
	$namespace = 'urn:service';
	$server->wsdl->schemaTargetNamespace = $namespace;

	function mandar_email($email,$assunto,$msg)
	{
		$email_sender = "no-reply@clubedeofertas.net";

		$headers = "MIME-Version: 1.1\n";
		$headers .= "Content-type: text/html; charset=UTF-8\n";
		$headers .= "From: Clube de Ofertas <$email_sender>\n";
		$headers .= "Return-Path: $email_sender\n";
		$headers .= "X-Priority: 1\n";
		$envio = mail($email,"Clube de Ofertas - ".$assunto,"<p>".$msg."</p><br><br><h3>Atenciosamente, equipe Clube de Ofertas.</h3>",$headers,"-r".$email_sender);
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
		$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
		$query = $conexao->query('SET CHARACTER SET utf8');
		$query = $conexao->query($sql_query);
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	$server->register('query', array('sql_query' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realiza uma query no banco.');

	function select_cidades()
	{
		$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
		$query = $conexao->query('SET CHARACTER SET utf8');
		$query = $conexao->query("SELECT * FROM cidade WHERE estado = 0");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	$server->register('select_cidades', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Select de cidades cadastradas para abrangência.');

	function select_tipos()
	{
		$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
		$query = $conexao->query('SET CHARACTER SET utf8');
		$query = $conexao->query("SELECT * FROM tipo");
		$dados = array();
		while($row = $query->fetch_assoc())
			$dados[] = $row;
		$conexao->close();
		return json_encode($dados);
	}

	$server->register('select_tipos', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Select de cidades cadastradas para abrangência.');

	function redefinir_senha($email)
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

	$server->register('redefinir_senha', array('email' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Gera token e envia email de redefinição de senha.');

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

	}

	$server->register('admin.insert_cidade', array('cidade' => 'xsd:string','uf' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastra uma nova cidade.');
	$server->register('admin.insert_tipo', array('nome' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastra um novo tipo de cupom.');
	$server->register('admin.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realiza login do admin.');
	$server->register('admin.select_cupons_avaliaveis', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona cupons que precisam de aprovação.');
	$server->register('admin.select_cupons', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona todos os cupons.');
	$server->register('admin.select_empresas', array('estado' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona empresas de acordo com o estado informado.');
	$server->register('admin.select_cidades', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona todas as cidades.');
	$server->register('admin.desativar_cidade', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Desativa uma cidade.');
	$server->register('admin.ativar_cidade', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Ativa uma cidade.');
	$server->register('admin.delete_tipo', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Deleta um tipo de cupom.');
	$server->register('admin.aprovar_cupom', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Aprova um cupom.');
	$server->register('admin.recusar_cupom', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Recusa um cupom.');
	$server->register('admin.aprovar_empresa', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Aprova uma empresa.');
	$server->register('admin.recusar_empresa', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Recusa uma empresa.');
	$server->register('admin.bloquear_empresa', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Bloqueia uma empresa por um número de dias.');
	$server->register('admin.desbloquear_empresa', array('id' => 'xsd:integer','dias' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Desloqueia uma empresa.');
	$server->register('admin.select_tarifa', array(), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona as tarifas das empresas.');
	$server->register('admin.dar_baixa_tarifa', array('empresas' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Dá baixa em tarifas de empresas.');

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
			for($i=0;$i<count($usuarios);$i++)
				$query = $conexao->query("UPDATE usuario_has_cupom SET estado = 1 WHERE id = ".$usuarios[$i]);
			$conexao->close();
			return $query;
		}

		function visualizar($empresa_id)
		{
			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("UPDATE notificacao SET visualizado = 1 WHERE empresa_id = $empresa_id");
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

	$server->register('empresa.insert', array('nome_usuario' => 'xsd:string','email' => 'xsd:string','senha' => 'xsd:string','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','cnpj' => 'xsd:string','celular' => 'xsd:string','descricao' => 'xsd:string','rua' => 'xsd:string','num' => 'xsd:integer','complemento' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:string','longitude' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de empresa e endereço inicial.');
	$server->register('empresa.insert_endereco', array('empresa_id' => 'xsd:integer','rua' => 'xsd:string','num' => 'xsd:integer','complemento' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:string','longitude' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Cadastro de endereço.');
	$server->register('empresa.insert_cupom', array('empresa_id' => 'xsd:integer','endereco_id' => 'xsd:integer','imagem' => 'xsd:string','titulo' => 'xsd:string','regras' => 'xsd:string','descricao' => 'xsd:string','preco_normal' => 'xsd:double','preco_cupom' => 'xsd:double','prazo' => 'xsd:string','quantidade' => 'xsd:integer','pagamento' => 'xsd:integer','delivery' => 'xsd:integer','tipos' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Cadastro de cupom.');
	$server->register('empresa.update_perfil', array('id' => 'xsd:integer','nome_usuario' => 'xsd:string','razao_social' => 'xsd:string','nome_fantasia' => 'xsd:string','celular' => 'xsd:string','descricao' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Alterar perfil de empresa.');
	$server->register('empresa.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar senha da empresa.');
	$server->register('empresa.redefinir_senha', array('id' => 'xsd:integer','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Redefinir senha da empresa.');
	$server->register('empresa.update_endereco', array('id' => 'xsd:string','rua' => 'xsd:string','num' => 'xsd:integer','complemento' => 'xsd:string','cep' => 'xsd:string','bairro' => 'xsd:string','cidade_id' => 'xsd:integer','latitude' => 'xsd:string','longitude' => 'xsd:string','telefone' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Alterar dados de um endereço.');
	$server->register('empresa.update_cupom', array('cupom_id' => 'xsd:integer','endereco_id' => 'xsd:integer','imagem' => 'xsd:string','titulo' => 'xsd:string','regras' => 'xsd:string','descricao' => 'xsd:string','preco_normal' => 'xsd:double','preco_cupom' => 'xsd:double','prazo' => 'xsd:string','quantidade' => 'xsd:integer','pagamento' => 'xsd:integer','delivery' => 'xsd:integer','tipos' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Alterar dados de um cupom.');
	$server->register('empresa.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realizar login da empresa.');
	$server->register('empresa.select_perfil', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de uma empresa.');
	$server->register('empresa.select_enderecos', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona endereços de uma empresa.');
	$server->register('empresa.select_endereco', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de um endereço.');
	$server->register('empresa.select_cupom', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de um cupom.');
	$server->register('empresa.select_cupons', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona todos os cupons e seus dados pela empresa.');
	$server->register('empresa.select_usuarios', array('cupom_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona os usuarios que resgatarem um cupom.');
	$server->register('empresa.dar_baixa', array('usuarios' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Dá baixa em resgates de usuarios.');
	$server->register('empresa.visualizar', array('empresa_id' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Visualiza todas as notificações.');
	$server->register('empresa.select_notificacoes', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecionar todas as notificações.');
	$server->register('empresa.select_nao_visualizadas', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Retorna numéro de notificações não visualizadas.');
	$server->register('empresa.desativar_cupom', array('id' => 'xsd:integer'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Desativa um cupom.');
	$server->register('empresa.select_tarifa', array('empresa_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecina o total a ser pago no mês por cupons.');
	$server->register('empresa.verificar_token', array('token' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Verifica token de acesso.');

	class usuario
	{
		function insert($nome,$email,$senha,$celular,$genero,$nascimento,$token)
		{
			$nome = preg_replace('![*#/\"´`]+!','',$nome);
			$email = preg_replace('![*#/\"´`]+!','',$email);
			$celular = preg_replace('![*#/\"´`]+!','',$celular);
			$senha = md5(sha1($senha));

			$conexao = mysqli_connect("clubedofertas.mysql.dbaas.com.br","clubedofertas","Reiv567123@","clubedofertas");
			$query = $conexao->query('SET CHARACTER SET utf8');
			$query = $conexao->query("INSERT INTO usuario VALUES(NULL,'$nome','$email','$senha','$celular',$genero,'$nascimento',0,'$token')");
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

	$server->register('usuario.insert', array('nome' => 'xsd:string','email' => 'xsd:string','senha' => 'xsd:string','celular' => 'xsd:string','genero' => 'xsd:integer','nascimento' => 'xsd:string','token' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Cadastro de usuário.');
	$server->register('usuario.update_perfil', array('id' => 'xsd:integer','nome' => 'xsd:string','celular' => 'xsd:string','genero' => 'xsd:integer','nascimento' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar perfil do usuário.');
	$server->register('usuario.update_senha', array('id' => 'xsd:integer','senha_antiga' => 'xsd:string','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Alterar senha do usuário.');
	$server->register('usuario.redefinir_senha', array('id' => 'xsd:integer','senha_nova' => 'xsd:string'), array('return' => 'xsd:boolean'),$namespace,false,'rpc','encoded','Redefinir senha do usuario.');
	$server->register('usuario.login', array('email' => 'xsd:string','senha' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Realizar login do usuário.');
	$server->register('usuario.select_cupons', array('usuario_id' => 'xsd:integer','cidade' => 'xsd:integer','delivery' => 'xsd:integer','pagamento' => 'xsd:integer','tipo_id' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecionar cupons com filtros e limite de 5. ');
	$server->register('usuario.select_detalhes_cupom', array('cupom_id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Selecionar detalhes de um cupom. ');
	$server->register('usuario.pegar_cupom', array('usuario_id' => 'xsd:integer','cupom_id' => 'xsd:integer'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Pegar cupom, baixa automaticamente');
	$server->register('usuario.select_perfil', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona dados de um usuario.');
	$server->register('usuario.select_historico', array('id' => 'xsd:integer'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona histórico do usuario.');
	$server->register('usuario.avaliar', array('id' => 'xsd:integer','produto' => 'xsd:integer','atendimento' => 'xsd:integer','ambiente' => 'xsd:integer','comentarios' => 'xsd:string'), array('return' => 'xsd:string'),$namespace,false,'rpc','encoded','Seleciona histórico do usuario.');
	$server->register('usuario.verificar_token', array('token' => 'xsd:string'), array('return' => 'xsd:integer'),$namespace,false,'rpc','encoded','Verifica token de acesso.');

	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);
?>