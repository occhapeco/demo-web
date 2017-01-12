<?php
	require_once("permissao.php");
	require_once("conectar_service.php");
	
	$alert = "";

	if (isset($_POST["concluir"]))
	{
		$json = $service->call('empresa.login', array($_POST["email"],$_POST["senha"]));
		echo "<br><br>";
		var_dump($json);
		$empresa = json_decode($json);
		if(!$json)
		{
			$json = $service->call('admin.login', array($_POST["email"],$_POST["senha"]));
			if(!$json)
			{
				$alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Email ou senha não correspondem!</b> Digite novamente.</span></div>';
			}
			else
			{
				session_start();
				$admin = json_decode($json);
				$_SESSION["id"] = $admin->id;
				$_SESSION["tipo"] = "admin";
				header("location: admin/");
			}
		}
		elseif($empresa->estado == 0 && $empresa->dias_bloqueio == 0)
		{
			session_start();
			$_SESSION["id"] = $empresa->id;
			$_SESSION["tipo"] = "empresa";
			header("location: empresa/");
		}
		elseif($empresa->estado == -1)
			header("location: aprovacao.php?id=".$empresa->id);
		elseif($empresa->dias_bloqueio > 0)
			header("location: bloqueio.php?id=".$empresa->id);
	}	
?>
<!doctype html>
<html lang="pt">
<head>
	<meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x76" href="imgs/logo/escudo_clube.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Clube de Ofertas</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
	
	<style type="text/css">
		i{
			margin-top:-5px;
		}

	</style>

</head>

<body>

	<div class="image-container set-full-height" style="background-image: url('imgs/tex_mex.jpg')">
	 	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">

		        <div class="col-sm-6 col-sm-offset-3">
					<?php echo $alert; ?>
		            <!--      Wizard container        -->
		            <div class="wizard-container" style="margin-top:50px;">

		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    <form action="#" id="frm" method="post">
		                    	<input type="hidden" name="latitude" id="latitude">
		                    	<input type="hidden" name="longitude" id="longitude">
		                    	<center>
									<div class="logo" style="margin-top:20px">
						                <a href="index.php" class="simple-text">
						                    <img src="imgs/logo/escudo_corel.png" height="77px" width="350px">
						                </a>
						            </div>
								</center>
		                    	<div class="wizard-header text-center">
		                        	<h3 class="wizard-title">Realizar login</h3>
		                    	</div>

                            	<div class="row" style="margin-top:20px;">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="form-group">
											<label>Email <small>(obrigatório)</small></label>
											<input type="email" class="form-control" name="email" id="email" placeholder="informe um email" maxlength="40" required>
										</div>
										<div class="form-group">
											<label>Senha <small>(obrigatório)</small></label>
											<input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" maxlength="12" required>
										</div>
									</div>
									<div class="col-sm-1"></div>
									<div class="col-sm-12 text-center"><a href="cad_empresa.php">Não possui cadastro? Clique aqui!</a></div>
								</div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='concluir' value='Concluir' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div><!-- end row -->
		</div> <!--  big container -->

	    
	</div>

</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
    <script src="assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

</html>
