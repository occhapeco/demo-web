<?php
	if(isset($_GET["id"]))
	{
		require_once("conectar_service.php");
		$json = $service->call("empresa.select_perfil",array($_GET["id"]));
		$empresa = json_decode($json);
		if(!isset($empresa->nome_usuario))
			header("location: index.php");
	}
	else
		header("location: index.php");
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
		        <div class="col-sm-12">
		            <!--      Wizard container        -->
		            <div class="wizard-container" style="margin-top:50px">

		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    
							<div class="logo center" style="margin:20px">
				                    <img src="imgs/logo/escudo_corel.png" style="width: 80%;display: block;margin: 0 auto;">
				            </div>

							<div class="wizard-header text-center">
	                        	<h2 class="wizard-title"><?php echo $empresa->nome_usuario.", seja bem-vindo ao Clube de Ofertas!"; ?></h2>
	                    	</div>

							<div class="wizard-header text-center">
	                        	<h3 class="wizard-title">O seu cadastro está sob análise dos nossos administradores e, portanto, ainda não é possível utilizar a ferramenta. Assim que obtivermos uma resposta, o notificaremos em seu email!</h3>
	                    	</div>

	                    	<div class="wizard-header text-center">
	                        	<h3 class="wizard-title">Atenciosamente, equipe Clube de Ofertas.</h3>
	                    	</div>

	                    	<center><a href="index.php" class="btn btn-primary btn-info" style="font-size: 16px;margin: 10px 0px 20px 0px;"><i class="ti-arrow-left"></i> Voltar</a></center>

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


</html>
