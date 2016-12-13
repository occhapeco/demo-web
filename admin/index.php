<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    $alert = "";

    if(isset($_POST["finish"]))
    {
        $json = $service->call('empresa.select_usuarios', array($id_cupom));
        $usuario_has_cupom = json_decode($json);
        $usuarios = array();
        for($i=0;$i<count($usuario_has_cupom);$i++)
            if(isset($_POST[$usuario_has_cupom[$i]->id]))
                $usuarios[] = $usuario_has_cupom[$i]->id;
        $json = $service->call('empresa.dar_baixa', array(json_encode($usuarios)));
        if($json)
            $alert = '<div class="alert alert-info" style="margin: 10px 10px -20px 10px;"><span><b>Baixa realizada com sucesso!</b></span></div>';
        else
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
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
        echo $alert;
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
                                <img src="../imgs/<?php echo $cupom[$i]->caminho; ?>" class="img-responsive">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer status" style="padding-bottom:50px;">
                    <hr />
                    
                        <div class="pull-right" >
                            <form action="cad_cupom.php" method="get" style="margin-left:250px;"><input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>><button type="submit" class="btn btn-simple btn-warning" name="editar"><i class="ti-pencil" style="font-size: 20px"></i></button></form>     
                            <form action="#" method="post" style=" margin-left:300px; margin-top:-56"><input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>><button class=" btn btn-simple btn-info"><i class="ti-reload" style="font-size: 20px"></i></button></form>
                        </div>
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
