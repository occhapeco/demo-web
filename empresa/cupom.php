<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    $id_cupom = $_GET["id_cupom"];
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

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />

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
                $json_dados = $service->call('empresa.select_cupom', array($id_cupom));
                $cupom = json_decode($json_dados);
             ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="icon-big icon-warning text-center">
                                    <img src="../imgs/<?php echo $cupom->caminho; ?>" width="200px" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="numbers">
                                    <label style="color:#252422"><?php echo $cupom->titulo; ?></label>
                                    
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label>Validade:</label><label style="color:#252422"><?php echo $cupom->prazo; ?></label>
                            </div>
                            <div class="col-xs-6">
                                <label>Valor:</label><label style="color:#252422">R$ <?php echo $cupom->preco_cupom; ?></label>
                            </div>
                            
                            <div class="col-xs-6">
                                <label>Quantidade:</label><label style="color:#252422"><?php echo $cupom->quantidade; ?></label>
                            </div>
                            <div class="col-xs-12" style="margin-top:10px">
                                <div class="col-xs-6">
                                    <label>Descrição:</label><label style="color:#252422"><?php echo $cupom->descricao; ?></label>
                                </div>
                                <div class="col-xs-6">
                                    <label>Regras:</label><label style="color:#252422"><?php echo $cupom->regras; ?></label>
                                </div>
                            </div>
                            
                            <div class="col-xs-12" style="margin-left:15px">
                                <label>Endereço:</label><label style="color:#252422"><?php echo $cupom->bairro.", ".$cupom->rua.", ".$cupom->num.", ".$cupom->complemento.", ".$cupom->cep;?></label>
                            </div>
                        </div>
                    </div>
                    <div class="footer status" style="padding-bottom:50px;">
                        <hr />
                        
                            <div class="pull-right" >
                                <form action="cad_cupom.php" method="post" style="margin-left:250px;"><input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom->id."'"; ?>><button type="submit" class="btn btn-simple btn-warning" name="editar"><i class="ti-pencil" style="font-size: 20px"></i></button></form>     
                                <form action="#" method="post" style=" margin-left:300px; margin-top:-56"><input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom->id."'"; ?>><button class=" btn btn-simple btn-info"><i class="ti-reload" style="font-size: 20px"></i></button></form>
                            </div>
                    </div>
                    </div>
                </div>
            </div> 

        <div class="content">
            <?php
                $json_dados = $service->call('empresa.select_cupom', array($id_cupom));
                $cupom = json_decode($json_dados);
             ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="content">
                       <div class="content table-responsive table-full-width">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Celular</th>
                        <th>Valor</th>
                        <th>Dar Baixa</th>
                    </tr>
                    <tbody>
                        <?php
                            $select = $service->call('select_usuarios', array($id_cupom));
                            $usuario = json_decode($select);
                            for($i = 0; $i<count($usuario); $i++)
                            {
                        ?>
                        <tr>
                            <td><?php echo $usuario[$i]->nome; ?></td>
                            <td><?php echo $usuario[$i]->celular; ?></td>
                            <td><?php echo $usuario[$i]->preco_cupom; ?></td>
                            <?php
                            if($usuario[$i]->estado == 0)
                            {
                            ?>
                            <td><input type="checkbox" value="<?php echo $usuario[$i]->id; ?>"></td>
                            <?php
                            }
                            else
                            {
                            ?>
                            <td> - </td>
                            <?php
                                }
                            ?>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </thead>
            </table>
            <input type="submit" class="btn btn-finish btn-fill btn-info btn-wd" name="finish" value="Dar Baixa" style="display: inline-block;">
        </div>          
                    </div>
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
