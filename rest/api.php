<?php
	header('Access-Control-Allow-Origin: *');
	error_reporting(E_ALL);
	ini_set("display_errors",0);

	require_once("bin/geral.php");
	require_once("bin/admin.php");
	require_once("bin/empresa.php");
	require_once("bin/usuario.php");

	$classe = null;
	$metodo = null;
	$admin = null;
	$empresa = null;
	$usuario = null;

	if(isset($_POST["access_token"]) && $_POST["access_token"] != null)
	{
		$admin = new admin();
		$empresa = new empresa();
		$usuario = new usuario();
		if($admin->verificar_token($_POST["access_token"]) || $empresa->verificar_token($_POST["access_token"]) || $usuario->verificar_token($_POST["access_token"]))
		{
			$metodo = $_POST["metodo"];
			if(isset($_POST["classe"]))
				$classe = $_POST["classe"];
		}
	}
	elseif($_POST["classe"] == "admin")
	{
		$admin = new admin();
		if($_POST["metodo"] == "login")
			echo $admin->login($_POST["email"],$_POST["senha"]);
	}
	elseif($_POST["classe"] == "empresa")
	{
		$empresa = new empresa();
		if($_POST["metodo"] == "login")
			echo $empresa->login($_POST["email"],$_POST["senha"]);

		if($_POST["metodo"] == "insert")
			echo $empresa->insert($_POST["nome_usuario"],$_POST["email"],$_POST["senha"],$_POST["razao_social"],$_POST["nome_fantasia"],$_POST["cnpj"],$_POST["celular"],$_POST["descricao"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]);
	}
	elseif($_POST["classe"] == "usuario")
	{
		$usuario = new usuario();
		if($_POST["metodo"] == "login")
			echo $usuario->login($_POST["email"],$_POST["senha"]);

		if($_POST["metodo"] == "select_cupons")
			echo $usuario->select_cupons($_POST["cidade_id"],$_POST["delivery"],$_POST["pagamento"],$_POST["tipo_id"]);

		if($_POST["metodo"] == "select_detalhes_cupom")
			echo $usuario->select_detalhes_cupom($_POST["cupom_id"]);

		if($_POST["metodo"] == "insert")
			echo $usuario->insert($_POST["nome"],$_POST["email"],$_POST["senha"],$_POST["celular"],$_POST["genero"],$_POST["nascimento"]);
	}
	else
	{
		if($_POST["metodo"] == "query")
			echo query($_POST["sql_query"]);

		if($_POST["metodo"] == "select_cidades")
			echo select_cidades();

		if($_POST["metodo"] == "select_tipos")
			echo select_tipos();

		if($_POST["metodo"] == "redefinir_senha")
			echo redefinir_senha($_POST["email"]);
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

		if($metodo == "select_usuarios")
			echo $admin->select_usuarios();

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
			echo $admin->dar_baixa_tarifa($_POST["dados"]);

		if($metodo == "notificar_usuarios")
			echo $admin->dar_baixa_tarifa($_POST["title"],$_POST["body"]);

		if($metodo == "verificar_token")
			echo $admin->verificar_token($_POST["access_token"]);
	}
	elseif($classe == "empresa")
	{
		if($metodo == "insert_endereco")
			echo $empresa->insert_endereco($_POST["empresa_id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]);

		if($metodo == "insert_cupom")
			echo $empresa->insert_cupom($_POST["empresa_id"],$_POST["endereco_id"],$_POST["imagem"],$_POST["titulo"],$_POST["regras"],$_POST["descricao"],$_POST["preco_normal"],$_POST["preco_cupom"],$_POST["prazo"],$_POST["quantidade"],$_POST["pagamento"],$_POST["delivery"],$_POST["tipos"]);

		if($metodo == "update_perfil")
			echo $empresa->update_perfil($_POST["id"],$_POST["nome_usuario"],$_POST["razao_social"],$_POST["nome_fantasia"],$_POST["celular"],$_POST["descricao"]);

		if($metodo == "update_senha")
			echo $empresa->update_senha($_POST["id"],$_POST["senha_antiga"],$_POST["senha_nova"]);

		if($metodo == "redefinir_senha")
			echo $empresa->redefinir_senha($_POST["id"],$_POST["senha_nova"]);

		if($metodo == "update_endereco")
			echo $empresa->update_endereco($_POST["id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]);

		if($metodo == "update_cupom")
			echo $empresa->update_cupom($_POST["id"],$_POST["endereco_id"],$_POST["imagem"],$_POST["titulo"],$_POST["regras"],$_POST["descricao"],$_POST["preco_normal"],$_POST["preco_cupom"],$_POST["prazo"],$_POST["quantidade"],$_POST["pagamento"],$_POST["delivery"],$_POST["tipos"]);

		if($metodo == "update_imagem")
			echo $empresa->update_imagem($_POST["id"]);

		if($metodo == "select_perfil")
			echo $empresa->select_perfil($_POST["id"]);

		if($metodo == "select_endereco")
			echo $empresa->select_endereco($_POST["id"]);

		if($metodo == "select_enderecos")
			echo $empresa->select_enderecos($_POST["empresa_id"]);

		if($metodo == "select_cupom")
			echo $empresa->select_cupom($_POST["id"]);

		if($metodo == "select_cupons")
			echo $empresa->select_cupons($_POST["id"]);

		if($metodo == "select_usuarios")
			echo $empresa->select_usuarios($_POST["cupum_id"]);

		if($metodo == "dar_baixa")
			echo $empresa->dar_baixa($_POST["usuarios"]);

		if($metodo == "visualizar")
			echo $empresa->visualizar($_POST["empresa_id"]);

		if($metodo == "select_notificacoes")
			echo $empresa->select_notificacoes($_POST["empresa_id"]);

		if($metodo == "select_nao_visualizadas")
			echo $empresa->select_nao_visualizadas($_POST["empresa_id"]);

		if($metodo == "desativar_cupom")
			echo $empresa->desativar_cupom($_POST["id"]);

		if($metodo == "select_tarifa")
			echo $empresa->select_tarifa($_POST["empresa_id"]);

		if($metodo == "verificar_token")
			echo $empresa->verificar_token($_POST["access_token"]);
	}
	elseif($classe == "usuario")
	{
		if($metodo == "update_perfil")
			echo $usuario->update_perfil($_POST["id"],$_POST["nome"],$_POST["celular"],$_POST["genero"],$_POST["nascimento"]);

		if($metodo == "update_senha")
			echo $usuario->update_senha($_POST["id"],$_POST["senha_antiga"],$_POST["senha_nova"]);

		if($metodo == "update_token")
			echo $usuario->update_token($_POST["id"],$_POST["token"]);

		if($metodo == "redefinir_senha")
			echo $usuario->redefinir_senha($_POST["id"],$_POST["senha_nova"]);

		if($metodo == "select_cupons")
			echo $usuario->select_cupons($_POST["cidade_id"],$_POST["delivery"],$_POST["pagamento"],$_POST["tipo_id"]);

		if($metodo == "select_detalhes_cupom")
			echo $usuario->select_detalhes_cupom($_POST["cupom_id"]);

		if($metodo == "pegar_cupom")
			echo $usuario->pegar_cupom($_POST["id"],$_POST["cupom_id"]);

		if($metodo == "select_perfil")
			echo $usuario->select_perfil($_POST["id"]);

		if($metodo == "select_historico")
			echo $usuario->select_historico($_POST["id"]);

		if($metodo == "avaliar")
			echo $usuario->avaliar($_POST["id"],$_POST["produto"],$_POST["atendimento"],$_POST["ambiente"],$_POST["comentarios"]);

		if($metodo == "verificar_token")
			echo $usuario->verificar_token($_POST["access_token"]);
	}

?>
