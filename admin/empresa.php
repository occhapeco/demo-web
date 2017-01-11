<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    if(isset($_POST["recusar"]))
    {
        $bool = $service->call('admin.recusar_cupom', array($_POST["cupom_id"]));
        header("location: index.php");
    }
    if(isset($_POST["aprovar"]))
    {
        $bool = $service->call('admin.aprovar_cupom', array($_POST["cupom_id"]));
        header("location: index.php");
    }

?>
<html lang="pt">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x76" href="imgs/logo/escudo_clube.png">
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
        $json_dados = $service->call('admin.select_empresas',array(0));
        $empresa = json_decode($json_dados);
        for($i=0;$i<count($empresa);$i++)
        {
			$endereco = $service->call('empresa.select_enderecos', array($_SESSION["id"]));
    ?>
    <div class="content">
        <div class="col-lg-12">
            <div class="card">
                <div class="content">
                    <div class="row">
                            <div class="col-xs-12">
                                <h3 class="text-center" style="margin-top: -5px;color:#252422"><?php echo $empresa[$i]->razao_social; ?></h3>
                            </div>
                            <div class="col-xs-12">
                                <label>CNPJ/CPF:</label><label style="color:#252422"><?php echo $empresa[$i]->cnpj; ?></label>
                            </div>
                            <div class="col-xs-12">
                                <label>Telefone:</label><label style="color:#252422"><?php echo $empresa[$i]->celular; ?></label>
                            </div>
                            <div class="col-xs-12">
                                <label>Endereço:</label><label style="color:#252422"><?php echo $endereco[0]->bairro.", ".$endereco[0]->rua.", ".$endereco[0]->num.", ".$endereco[0]->complemento.", ".$endereco[0]->cep;?></label>
                            </div>
                    </div>
                </div>
                <div class="footer status">
                    <hr style="padding-top:10px;">
                        <center>
                            <label>
                                <form action="#" method="post">
                                    <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                    <button class=" btn btn-primary btn-danger" name="bloquear" style="font-size: 16px"><i class="ti-lock"></i> Bloquear</button>
                                </form>
                            </label>
                        </center>
                </div>
                </div>
            </div>
        </div>
    <?php
        }
    ?>
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

</html>
