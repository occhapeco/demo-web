<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $alert="";

    $page = basename(__FILE__, '.php');

    if(isset($_GET["aprovar"]))
    {
        $alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Oferta enviada para aprovação!</b></span></div>';
    }

    if(isset($_POST["cancelar"]))
    {
        $json_dados = $service->call('empresa.desativar_cupom', array($_POST["cupom_id"]));
        $cancelar = json_decode($json_dados);
        if ($cancelar == 1)
        {
            $alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Cupom desativado com sucesso!</b></span></div>';
        }
        if ($cancelar == 0)
        {
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Não foi possível desativar este cupom</b></span></div>';
        }
    }
?>
<html lang="pt">
<head>
	<meta charset="utf-8" />
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
    ?>

        <div class="content">
            <?php
                $json_dados = $service->call('admin.select_cupons', array());
                $cupom = json_decode($json_dados);
                $estado = "";
                for($i = 0; $i<count($cupom); $i++)
                {
                    if ($cupom[$i]->estado == -1)
                    {
                        $estado = "Enviado para aprovação";
                    }
                    if($cupom[$i]->estado == -2)
                    {
                        $estado = "Inativo";
                    }
                    if($cupom[$i]->estado == 0)
                    {
                        $estado = "Ativo";
                    }
                 ?>
                <div class="col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-warning text-center">
                                        <img src="../imgs/<?php echo $cupom[$i]->imagem; ?>" width="100px" class="img-responsive">
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p><?php echo $cupom[$i]->titulo ?></p>
                                        <p style="color: #aaa"><?php echo $cupom[$i]->descricao ?></p>
                                        <p style="color: #aaa"><?php echo $estado ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="footer status">
                                <hr />
                                    <div class="pull-right" >
                                        <form action="detalhes.php" method="get" style="margin-left:150px;margin-top:15">
                                            <input type="hidden" name="id_cupom" id="id_cupom" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                            <button type="submit" class="btn btn-primary btn-warning" name="finish">Detalhes</button>
                                        </form>
                                        <?php
                                         if($estado == "Enviado para aprovação")
                                         {
                                        ?>
                                        <form action="cad_cupom.php" method="get" style="margin-left:250px;margin-top:-52">
                                            <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                            <button type="submit" class="btn btn-primary btn-info" name="editar" style="font-size: 14px"><i class="ti-pencil"></i> Editar</button>
                                        </form>   
                                        <?php
                                            }
                                        ?>
                                        <?php if($estado == "Inativo") { ?>
                                            <form action="cad_cupom.php" method="get" style=" margin-left:250px; margin-top:-52">
                                                <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                                <button type="submit" class=" btn btn-primary btn-info" name="editar" style="font-size:14px"><i class="ti-reload"></i> Reativar</button>
                                            </form>
                                        <?php } ?>
                                        <?php if($estado == "Ativo") { ?>
                                            <form action="#" method="post" style=" margin-left:250px; margin-top:-52">
                                                <input type="hidden" name="cupom_id" id="cupom_id" <?php echo "value='".$cupom[$i]->id."'"; ?>>
                                                <button type="submit" class=" btn btn-primary btn-danger" name="cancelar" style="font-size:14px"><i class="ti-close"></i> Desativar</button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                    <div style="font-size: 20px;color: #007aff;">R$<?php echo $cupom[$i]->preco_cupom ?></div><br> <s style="color:coral">R$<?php echo $cupom[$i]->preco_normal ?></s>
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
