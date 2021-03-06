<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');
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
				'metodo' => 'select_enderecos',
				'empresa_id' => $_SESSION["empresa_id"]
			);
		
            $json_dados = call($data);
            $endereco = json_decode($json_dados);
            for($i = 0; $i<count($endereco); $i++)
            {
             ?>
             <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div>
                                    <label>Estado:</label><label style="color:#252422"><?php echo $endereco[$i]->uf ?></label><br>
                                    <label>Cidade:</label><label style="color:#252422"><?php echo $endereco[$i]->nome ?></label><br>
                                    <label>Bairro:</label><label style="color:#252422"><?php echo $endereco[$i]->bairro ?></label><br>
                                    <label>Rua:</label><label style="color:#252422"><?php echo $endereco[$i]->rua ?></label><br>
                                    <label>CEP:</label><label style="color:#252422"><?php echo $endereco[$i]->cep ?></label>
                                    <label>Número:</label><label style="color:#252422"><?php echo $endereco[$i]->num ?></label><br>
                                    <label>Complemento:</label><label style="color:#252422"><?php echo $endereco[$i]->complemento ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="footer status" style="height:6px;">
                            <hr />                            
                                <div class="pull-right">
                                    <form action="cad_endereco.php" method="post" style="margin-left:250px;"><input type="hidden" name="id_end" id="id_end" <?php echo "value='".$endereco[$i]->id."'"; ?>><button type="submit" class="btn btn-primary btn-info" name="editar"><i class="ti-pencil" style="font-size: 14px"></i> Editar</button></form>
                                </div>
                                
                        </div><br><br>
                    </div>
                </div>
            </div>
            <?php
            }
        ?>
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
