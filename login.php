<?php
	require_once("permissao.php");
	require_once("conectar_service.php");

	$alert = "";

	if (isset($_POST["concluir"]))
	{
		$data = array(
	        'classe' => 'empresa',
	        'metodo' => 'login',
	        'email' => $_POST['email'],
	        'senha' => $_POST['senha']
	    );

		$json = call($data);
		$empresa = json_decode($json);
		if(!isset($empresa->id))
		{
			$data['classe'] = 'admin';
			$json = call($data);
			$admin = json_decode($json);
			if(!isset($admin->id))
			{
				$alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Email ou senha não correspondem!</b> Digite novamente.</span></div>';
			}
			else
			{
				session_start();
				$_SESSION["admin_id"] = $admin->id;
				$_SESSION["admin_token"] = $admin->access_token;
				header("location: admin/");
			}
		}
		elseif($empresa->estado == 0)
		{
			session_start();
			$_SESSION["empresa_id"] = $empresa->id;
			$_SESSION["empresa_token"] = $empresa->access_token;
			header("location: empresa/");
		}
		elseif($empresa->estado == -1)
			header("location: aprovacao.php?token=".$empresa->access_token);
		elseif($empresa->estado == -2)
			header("location: bloqueio.php?token=".$empresa->access_token);
	}

	if(isset($_POST["esqueci_senha"]))
	{
		$data = array(
			'metodo' => 'redefinir_senha',
			'email' => $_POST["email2"]
		);
		if(call($data))
			$alert = '<div class="alert alert-info" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Enviamos um email para a redefinição da sua senha!</b></span></div>';
		else
			$alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Não encontramos seu email em nosso sistema!</b></span></div>';
	}
?>
<!doctype html>
<html lang="pt">
<head>
	<meta charset="utf-8" />
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

	<!-- Modal -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<style type="text/css">
		i{
			margin-top:-5px;
		}

	</style>

	<link rel="icon" type="image/png" sizes="96x76" href="../imgs/logo/escudo_clube.png">
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
		                    <form action="#" id="frm" method="post" style="margin-left: 20px;margin-right: 20px;">
		                    	<input type="hidden" name="latitude" id="latitude">
		                    	<input type="hidden" name="longitude" id="longitude">
		                    	<center>
									<div class="logo" style="margin-top:20px">
						                <a href="index.php" class="simple-text">
						                    <img src="imgs/logo/escudo_corel.png" height="77px" width="350px" class="img-responsive">
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
											<input type="email" class="form-control" name="email" id="email" placeholder="Digite seu email" maxlength="40" required>
										</div>
										<div class="form-group">
											<label>Senha <small>(obrigatório)</small></label>
											<input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" maxlength="12" required>
										</div>
									</div>

								</div>
								<center>
									<div class="wizard-footer">
										<input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='concluir' value='Entrar' />
										<div class="clearfix"></div>
									</div>
								</center>
							</form><br>
							<div class="col-sm-1"></div>
							<div class="col-sm-12">
								<div class="col-sm-12 text-center"><a href="cad_empresa.php">Não possui cadastro? Clique aqui!</a></div><br><br>
								<div class="col-sm-12 text-center"><a data-toggle="modal" href="#myModal">Esqueceu sua senha?</a></div>
							</div><br><br><br><br>

		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div><!-- end row -->
		</div> <!--  big container -->


	</div>

	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
		<form action="#" method="post">
	      <div class="modal-content">
	        <div class="modal-header" style="background-color:#F3BB45;">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Esqueceu sua senha?</h4>
	        </div>
	        <div class="modal-body">
	          <p>Informe o seu email no campo a baixo e lhe enviaremos um email para a redefinição de sua senha.</p>
			  <div class="form-group">
				 <input type="email" class="form-control" name="email2" id="email2" placeholder="Informe seu email aqui" required>
			  </div>
			</div>
	        <div class="modal-footer">
				<input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='esqueci_senha' value='Enviar' />
	        </div>
	      </div>
		</form>

    </div>
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
