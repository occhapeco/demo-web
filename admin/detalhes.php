<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    if(isset($_POST["id_cupom"]))
        $id_cupom = $_POST["id_cupom"];
    else
        header('location: cupom.php');

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
                    'access_token' => $_SESSION["admin_token"],
                    'classe' => 'empresa',
                    'metodo' => 'select_cupom',
                    'id' => $id_cupom
                );
                $json_dados = call($data);
                $cupom = json_decode($json_dados);
                $str_tipos = "";
                $estado = "";
                if ($cupom->estado == -1)
                {
                    $estado = "Enviado para aprovação";
                }
                if($cupom->estado == -2)
                {
                    $estado = "Inativo";
                }
                if($cupom->estado == 0)
                {
                    $estado = "Ativo";
                }

                for($i=0;$i<count($cupom->tipo);$i++)
                {
                    if($i>0)
                        $str_tipos .= ", ";
                    $str_tipos .= $cupom->tipo[$i]->nome;
                }
             ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="icon-big icon-warning text-center">
                                    <img src="../imgs/<?php echo $cupom->imagem; ?>" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-9">
                                <div class="col-xs-12">
                                    <h3 class="text-center" style="margin-top: -5px;color:#252422"><?php echo $cupom->titulo; ?></h3>
                                </div>
                                <div class="col-xs-12">
                                    <label>Descrição:</label><label style="color:#252422"><?php echo $cupom->descricao; ?></label>
                                </div>
                                <div class="col-xs-12">
                                    <label>Regras:</label><label style="color:#252422"><?php echo $cupom->regras; ?></label>
                                </div>
                                <div class="col-xs-12">
                                    <label>Endereço:</label><label style="color:#252422"><?php echo $cupom->bairro.", ".$cupom->rua.", ".$cupom->num.", ".$cupom->complemento.", ".$cupom->cep;?></label>
                                </div>
                                <div class="col-xs-12">
									<label>Data de incio:</label><label style="color:#252422"><?php echo $cupom->data_cadastro; ?></label>
                                    <label>Data final:</label><label style="color:#252422"><?php echo $cupom->prazo; ?></label>
								</div>
								<div class="col-xs-12">
                                    <label>Valor de cardápio:</label><label style="color:#252422">R$ <?php echo $cupom->preco_normal; ?></label>
                                    <label>Valor de oferta:</label><label style="color:#252422">R$ <?php echo $cupom->preco_cupom; ?></label>
                                </div>
                                <div class="col-xs-12">
									<label>Quantidade:</label><label style="color:#252422"><?php echo $cupom->quantidade; ?></label>
                                    <label>Tipos:</label><label style="color:#252422"><?php echo $str_tipos; ?></label>
                                    <label>Estado:</label><label style="color:#252422"><?php echo $estado; ?></label>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                    </div>
                    </div>
                </div>
            </div> 

        <div class="content">
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
                                        <th>Estado</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                            $data = array(
                                                'access_token' => $_SESSION["admin_token"],
                                                'classe' => 'empresa',
                                                'metodo' => 'select_usuarios',
                                                'cupum_id' => $id_cupom
                                            );
                                            $json_dados = call($data);
                                            $usuario = json_decode($json_dados);
                                            $total_concluidos = 0;
                                            $total = 0;
                                            for($i = 0; $i<count($usuario); $i++)
                                            {
                                                $total += $usuario[$i]->preco_cupom;
                                        ?>
                                        <tr>
                                            <td><?php echo $usuario[$i]->nome; ?></td>
                                            <td><?php echo $usuario[$i]->celular; ?></td>
                                            <td>R$<?php echo $usuario[$i]->preco_cupom; ?></td>
                                        <?php
                                            if($usuario[$i]->estado == 0)
                                            {
                                        ?>
                                            <td>Não concluído</td>
                                        <?php
                                            }
                                            else
                                            {
                                                $total_concluidos += $usuario[$i]->preco_cupom;
                                        ?>
                                            <td>Concluído</td>
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
                            <label>Total: </label><label style="color:#252422">R$<?php echo $total; ?></label>
                            <label>Total concluídos: </label><label style="color:#252422">R$<?php echo $total_concluidos; ?></label>
                        </div>          
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

</html>
