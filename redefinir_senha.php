<?php
	$input = "";
	if(isset($_GET["token"]))
	{
		require_once("conectar_service.php");
		$id = $service->call("empresa.verificar_token",array($_GET["token"]));
		if($id != 0)
			$input = "<input type='hidden' name='empresa' value='$id'>";
		else
		{
			$id = $service->call("empresa.verificar_token",array($_GET["token"]));
			if($id != 0)
				$input = "<input type='hidden' name='usuario' value='$id'>";
			else
				header("location: index.php");
		}
	}
	else
		header("location: index.php");

	if(isset($_POST["empresa"]))
	{
		$id = $service->call("empresa.redefinir_senha",array($_POST["empresa"],$_POST["senha"]));
		header("location: login.php");
	}
	elseif(isset($_POST["usuario"]))
	{
		$id = $service->call("usuario.redefinir_senha",array($_POST["usuario"],$_POST["senha"]));
		header("location: login.php");
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

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

</head>

<body>

	<div class="image-container set-full-height" style="background-image: url('imgs/tex_mex.jpg')">
	 	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">
		            <!--      Wizard container        -->
		            <div class="wizard-container" style="margin-top:50px">

		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    
							<div class="logo center" style="margin:20px">
				                    <img src="imgs/logo/escudo_corel.png" style="width: 80%;display: block;margin: 0 auto;">
				            </div>

							<form action="#" id="frm" method="post">
								<?php echo $input; ?>
		                    	<div class="wizard-header text-center">
		                        	<h3 class="wizard-title">Redefinição de senha</h3>
		                    	</div>

                            	<div class="row" style="margin-top:20px;">
									<div class="col-sm-1"></div>
									<div class="col-sm-10">
										<div class="form-group">
											<input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" maxlength="12" required>
										</div>
										<div class="form-group">
											<input type="password" class="form-control" name="senha1" id="senha1" placeholder="Redigite sua senha" maxlength="12" required>
										</div>
									</div>
									
								</div>
								<center>
									<div class="wizard-footer">
										<input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='concluir' value='Redefinir' />
										<div class="clearfix"></div>
									</div>
								</center>
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

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
    <script src="assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

    <script>
    	$("#frm").validate({
			rules: {
				senha: {
					minlength: 6
				},
				senha1: {
					minlength: 6,
					equalTo: "#senha"
				},
			},
			messages: {
				senha: {
					minlength: "Digite pelo menos 6 caracteres."
				},
				senha1: {
					minlength: "Digite pelo menos 6 caracteres.",
					equalTo: "As senhas não correspondem."
				}
			}
		});
    </script>

</html>
