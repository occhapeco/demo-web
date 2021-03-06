<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");
    
    $page = basename(__FILE__, '.php');

    $alert="";
	
	$data = array(
            'access_token' => $_SESSION["empresa_token"],
			'classe' => 'empresa',
	        'metodo' => 'select_perfil',
	        'id' => $_SESSION["empresa_id"]
		);
	$editar = call($data);
	$perfil = json_decode($editar);
	
	$nome_usuario = $perfil->nome_usuario;
    $razao_social = $perfil->razao_social;	
    $nome_fantasia = $perfil->nome_fantasia;
    $celular = $perfil->celular;
	$descricao = $perfil->descricao;

    //Post enviado desta página para confirmar a edição
    if(isset($_POST["editar_perfil"]))
    {
		$data = array(
            'access_token' => $_SESSION["empresa_token"],
			'classe' => 'empresa',
	        'metodo' => 'update_perfil',
	        'id' => $_SESSION["empresa_id"],
			'nome_usuario' => $_POST["nome_usuario"],
			'razao_social' => $_POST["razao_social"],
			'nome_fantasia' => $_POST["nome_fantasia"],
			'celular' => $_POST["celular"],
			'descricao' => $_POST["descricao"]
		);
       if (call($data))
       {
   	        $alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Perfil alterado com sucesso!</b></span></div>';
       }
       else
       {
       		$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
       }
    }

    if(isset($_POST["editar_senha"]))
    {
    	if($_POST["nova_senha"] == $_POST["nova_senha1"])
    	{	
			$data = array(
				'access_token' => $_SESSION["empresa_token"],
				'classe' => 'empresa',
				'metodo' => 'update_senha',
				'id' => $_SESSION["empresa_id"],
				'senha_antiga' => $_POST["senha_atual"],
				'senha_nova' => $_POST["nova_senha"]
			);
	        if (call($data))
	        {
	            $alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Senha alterada com sucesso!</b></span></div>';
	        }
	       else
	       {
	       		$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
	       }
    	}
    	else
    	{
    		$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Senhas não conferem!</b> Reveja seus dados.</span></div>';
    	}
    }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Clube de Ofertas</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="96x76" href="../imgs/logo/escudo_clube.png">

    <style type="text/css">
        label{
            margin-right:5px;
        }
    </style>
</head>
<body>

<div class="wrapper">
	<?php 
        require_once("sidenav.php");
        require_once("topnav.php");
        echo $alert;
    ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Editar Perfil</h4>
                            </div>
                            <div class="content">
                                <form action="#" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Razão Social</label>
                                                    <input type="text" name="razao_social" id="razao_social" maxlength="20" class="form-control border-input" value="<?php echo $razao_social; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome Fantasia</label>
                                                    <input type="text" name="nome_fantasia" id="nome_fantasia" maxlength="20" class="form-control border-input" value="<?php echo $nome_fantasia; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome de usuário</label>
                                                    <input type="text" name="nome_usuario" id="nome_usuario" maxlength="40" class="form-control border-input" value="<?php echo $nome_usuario; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Celular</label>
                                                    <input type="text" name="celular" id="celular" maxlength="14" class="form-control border-input" value="<?php echo $celular; ?>">
                                                </div>
                                            </div>
                                        </div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Descrição <small>(obrigatório)</small></label>
												<textarea class="form-control border-input" name="descricao" id="descricao" required><?php echo $descricao; ?></textarea>
											</div>
										</div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd" name="editar_perfil">Concluir</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Editar Senha</h4>
                            </div>
                            <div class="content">
                                <form action="#" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Senha atual</label>
                                                    <input type="password" class="form-control border-input" name="senha_atual" id="senha_atual" maxlength="12" placeholder="Informe a sua senha atual">
                                                </div> 
                                            </div>
                                            <div class="col-md-4">                                          
                                                <div class="form-group">
                                                    <label>Nova senha</label>
                                                    <input type="password" class="form-control border-input" name="nova_senha" id="nova_senha" maxlength="12" placeholder="Informe a sua nova senha">
                                                </div>
                                            </div>
                                           	<div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Repita a nova senha</label>
                                                    <input type="password" class="form-control border-input" name="nova_senha1" id="nova_senha1" maxlength="12" placeholder="Repita a nova senha">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd" name="editar_senha">Concluir</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


</body>

    <!--   Core JS Files   -->
    <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->

	<!--  Charts Plugin -->
	<script src="../assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="../assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="../assets/js/demo.js"></script>


</html>
