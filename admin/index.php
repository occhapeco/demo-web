<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    if(isset($_POST["recusar"]))
    {
        $bool = $service->call('admin.recusar', array($_POST["cupom_id"]));
        header("location: index.php");
    }
    if(isset($_POST["aprovar"]))
    {
        $bool = $service->call('admin.aprovar', array($_POST["cupom_id"]));
        header("location: index.php");
    }

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
        $json_dados = $service->call('admin.select_cupons',array());
        $cupom = json_decode($json_dados);
        if(count($cupom) == 0)
            echo "<br><br><br><br><br><h2 class='text-center'>Sem ofertas para aprovar.</h2>";
        for($i=0;$i<count($cupom);$i++)
        {
            $str_tipos = "";
            for($j=0;$j<count($cupom[$i]->tipo);$j++)
            {
                if($j>0)
                    $str_tipos .= ", ";
                $str_tipos .= $cupom[$i]->tipo[$j]->nome;
            }

    ?>
    <div class="content">
        <div class="col-lg-12">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="icon-big icon-warning text-center">
                                <img src="http://olar.esy.es/<?php echo $cupom[$i]->caminho; ?>" class="img-responsive">
                            </div>
                        </div>
                        <div class="col-xs-9">
                            <div class="col-xs-12">
                                <h3 class="text-center" style="margin-top: -5px;color:#252422"><?php echo $cupom[$i]->titulo; ?></h3>
                            </div>
                            <div class="col-xs-12">
                                <label>Descrição:</label><label style="color:#252422"><?php echo $cupom[$i]->descricao; ?></label>
                            </div>
                            <div class="col-xs-12">
                                <label>Regras:</label><label style="color:#252422"><?php echo $cupom[$i]->regras; ?></label>
                            </div>
                            <div class="col-xs-12">
                                <label>Endereço:</label><label style="color:#252422"><?php echo $cupom[$i]->bairro.", ".$cupom[$i]->rua.", ".$cupom[$i]->num.", ".$cupom[$i]->complemento.", ".$cupom[$i]->cep;?></label>
                            </div>
                            <div class="col-xs-12">
                                <label>Prazo:</label><label style="color:#252422"><?php echo $cupom[$i]->prazo; ?></label>
                                <label>Valor:</label><label style="color:#252422">R$<?php echo $cupom[$i]->preco_cupom; ?></label>
                                <label>Quantidade:</label><label style="color:#252422"><?php echo $cupom[$i]->quantidade; ?></label>
                            </div>
                            <div class="col-xs-12">
                                <label>Tipos:</label><label style="color:#252422"><?php echo $str_tipos; ?></label>
                                <label>Empresa:</label><label style="color:#252422"><?php echo $cupom[$i]->nome_fantasia; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer status">
                    <hr style="padding-top:10px;">
                        <center>
                            <label>
                                <form action="#" method="post">
                                    <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                    <button type="submit" class="btn btn-primary btn-success" name="aprovar" style="font-size: 16px"><i class="ti-check"></i> Aprovar</button>
                                </form>
                            </label>
                            <label>
                                <form action="#" method="post">
                                    <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                    <button class=" btn btn-primary btn-danger" name="recusar" style="font-size: 16px"><i class="ti-close"></i> Recusar</button>
                                </form>
                            </label>
                            <label>
                                <form action="cad_cupom.php" method="get">
                                    <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                    <input type="hidden" name="empresa_id" id="empresa_id" <?php echo "value='".$cupom[$i]->empresa_id."'"; ?>>
                                    <button type="submit" class="btn btn-primary btn-warning" name="editar" style="font-size: 16px"><i class="ti-pencil"></i> Editar e aprovar</button>
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
