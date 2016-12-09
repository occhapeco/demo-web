<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');
?>
<html lang="pt">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Paper Dashboard by Creative Tim</title>

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
    ?>

        <div class="content">
            <?php
            $json_dados = $service->call('empresa.select_cupons', array($_SESSION["id"]));
            $cupom = json_decode($json_dados);
            for($i = 0; $i<count($cupom); $i++)
            {
             ?>
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <img src="../imgs/<?php echo $cupom[$i]->caminho ?>" width="100px" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p><?php echo $cupom[$i]->titulo ?></p>
                                    <p style="color: #aaa"><?php echo $cupom[$i]->descricao ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer status">
                            <hr />
                                <div class="pull-right" >
                                    <form action="cupom.php" method="get" style="margin-left:150px;">
                                        <input type="hidden" name="id_cupom" id="id_cupom" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                        <button type="submit" class="btn btn-primary btn-warning" name="finish">Detalhes</button>
                                    </form>
                                    <form action="cad_cupom.php" method="post" style="margin-left:250px;margin-top:-56">
                                        <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                        <button type="submit" class="btn btn-simple btn-warning" name="editar"><i class="ti-pencil" style="font-size: 20px"></i></button>
                                    </form>     
                                    <form action="cad_cupom.php" method="post" style=" margin-left:300px; margin-top:-56">
                                        <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                        <button class=" btn btn-simple btn-info" name="editar"><i class="ti-reload" style="font-size: 20px"></i></button>
                                    </form>
                                </div>
                                <div style="font-size: 20px;color: #007aff;">R$<?php echo $cupom[$i]->preco_cupom ?></div> <s style="color:coral">R$<?php echo $cupom[$i]->preco_normal ?></s>
                        </div>
                    </div>
                </div>
            </div>
            <?php
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

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="../assets/js/paper-dashboard.js"></script>

</html>
