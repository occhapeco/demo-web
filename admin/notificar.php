<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    $alert = "";
	
	if(isset($_POST["notificar"]))
	{
		if($service->call('admin.notificar_usuarios', array($_POST["title"],$_POST["body"])))
		{
			$alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Notificação enviada com sucesso!</b></span></div>';
		}
		else
		{
			$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Erro ao gerar notificações! Verifique os dados e tente novamente</b></span></div>';
		}
	}

?>
<html lang="pt">
<head>
	<meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x76" href="../imgs/logo/escudo_clube.png">
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

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

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
            <div class="col-lg-12">
                <div class="card">
					<form method="post" action="#">
						<div class="content">
							<div class="row">
								<div class="col-sm-6">
									<div class="col-sm-3">
										<label>Título:</label>
									</div>
									<div class="col-sm-9">
										<input name="title" type="text" class="form-control" placeholder="Nova empresa unindo-se a nós!" aria-required="true" aria-invalid="false" required>
									</div>
								</div>
                                <div class="col-sm-6">
                                    <div class="col-sm-3">
                                        <label>Corpo:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input name="body" type="text" class="form-control" placeholder="Grandes descontos e muitas delícias" aria-required="true" aria-invalid="false" required>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="footer status" style="padding-bottom:50px;">
							<hr />
							<div class="pull-right" style="margin-right:10px">
								<button type="submit" class="btn btn-primary btn-warning" name="notificar" style="font-size: 14px"><i class="ti-check"></i> Notificar</button>
							</div>
						</div>
					</form>
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

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="../assets/js/paper-dashboard.js"></script>

</html>
