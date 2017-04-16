<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

	$data = array(
		'access_token' => $_SESSION["empresa_token"],
		'classe' => 'empresa',
		'metodo' => 'visualizar',
		'empresa_id' => $_SESSION["empresa_id"]
	);
    $json_dados = call($data);
?>
<html lang="pt">
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
    ?>

        <div class="content">
         <?php
			 $data = array(
				'access_token' => $_SESSION["empresa_token"],
				'classe' => 'empresa',
				'metodo' => 'select_notificacoes',
				'empresa_id' => $_SESSION["empresa_id"]
			);
            $json_dados = call($data);
            $notificacoes = json_decode($json_dados);
            if(count($notificacoes) == 0)
            {
            ?>
                <h3>Você não possui notificações.</h3>
            <?php
            }
            else{
                for($i = 0; $i<count($notificacoes); $i++)
                {
					$data = array(
						'access_token' => $_SESSION["empresa_token"],
						'classe' => 'empresa',
						'metodo' => 'select_cupom',
						'id' => $notificacoes[$i]->cupom_id
					);
                    $json_dados = call($data);
                    $cupom = json_decode($json_dados);
                 ?>
                 <div class="col-lg-12">
                    <a href="cupom.php?id_cupom=<?php echo $notificacoes[$i]->cupom_id; ?>">
                        <div class="card">
                            <div class="content">
                                    <div class="row">
                                        <?php 
                                            if($notificacoes[$i]->tipo == 1)
                                            {
                                        ?>
                                            <label>&nbsp&nbsp A oferta <?php echo $cupom->titulo ?> foi aprovada. </label><br>
                                        <?php
                                            }
                                            elseif($notificacoes[$i]->tipo == 0)
                                            {
                                        ?>
                                            <label>&nbsp&nbsp A oferta <?php echo $cupom->titulo ?> foi recusada. </label><br>
                                        <?php
                                            }
                                        ?>
                                    </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                }
            }
            ?>
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
