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
        .tab-pane{
            margin-top:20px;
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
            $json_dados = $service->call('empresa.select_cupons', array($_SESSION["empresa_id"]));
            $cupom = json_decode($json_dados);
            $estado = "";
			      $desconto = "";
            $em_aprovacao = "";
            $inativos = "";
            $ativos = "";
            for($i = 0; $i<count($cupom); $i++) {
    					$preco_cupom = $cupom[$i]->preco_cupom;
    					$preco_normal = $cupom[$i]->preco_normal;
    					$desconto = (($preco_normal - $preco_cupom)*100)/$preco_normal;
              if ($cupom[$i]->estado == -1) {
                $estado = "Enviado para aprovação";
    						$em_aprovacao .= '<div class="col-md-6 col-sm-6 bloco">
    						<div class="card">
    							<div class="content">
    								<div class="row">
    									<div class="col-sm-12">
    										<b><p style="color:red; font-size:18px">'. round($desconto) .'% Off</p></b>
    									</div>
    									<div class="col-sm-4">
    										<div class="icon-big icon-warning text-center">
    											<img src="../imgs/'. $cupom[$i]->imagem.'" width="130px" class="img-responsive">
    										</div>
    									</div>
    									<div class="col-sm-8">
    										<div class="numbers">
    											<p style="font-size:18px;">'. $cupom[$i]->titulo .'</p>
    											<p style="color: #aaa">'. $cupom[$i]->descricao .'</p>
    											<p style="color: #aaa">Válido de '. $cupom[$i]->data_cadastro .' até '. $cupom[$i]->prazo .'</p>
    											<p style="color: #aaa">'. $estado .'</p>
    										</div>
    									</div>
    								</div>
    								<div class="footer status">
    									<hr />
    										<div class="pull-right" >
    											<form action="cupom.php" method="post" style="margin-left:150px;margin-top:15">
    												<input type="hidden" name="id_cupom" id="id_cupom" value='.$cupom[$i]->id.'>
    												<button type="submit" class="btn btn-primary btn-warning" name="finish">Detalhes</button>
    											</form>
    											<form action="cad_cupom.php" method="post" style="margin-left:250px;margin-top:-52">
    												<input type="hidden" name="cupom_id" id="cupom_id" value='.$cupom[$i]->id.'>
    												<button type="submit" class="btn btn-primary btn-info" name="editar" style="font-size: 14px"><i class="ti-pencil"></i> Editar</button>
    											</form>
    											</div>
    										<div style="font-size: 20px;color: #007aff;">R$'. $cupom[$i]->preco_cupom .'</div><br><s style="color:coral">R$'. $cupom[$i]->preco_normal .'</s>
    								</div>
    							</div>
    						</div>
    					</div>';
                    }
                    if($cupom[$i]->estado == -2)
                    {
                        $estado = "Inativo";
						$inativos .= '<div class="col-md-6 col-sm-6 bloco">
						<div class="card">
							<div class="content">
								<div class="row">
									<div class="col-sm-12">
										<b><p style="color:red; font-size:18px">'. round($desconto) .'% Off</p></b>
									</div>
									<div class="col-sm-4">
										<div class="icon-big icon-warning text-center">
											<img src="../imgs/'. $cupom[$i]->imagem.'" width="130px" class="img-responsive">
										</div>
									</div>
									<div class="col-sm-8">
										<div class="numbers">
											<p style="font-size:18px;">'. $cupom[$i]->titulo .'</p>
											<p style="color: #aaa">'. $cupom[$i]->descricao .'</p>
											<p style="color: #aaa">Válido de '. $cupom[$i]->data_cadastro .' até '. $cupom[$i]->prazo .'</p>
											<p style="color: #aaa">'. $estado .'</p>
										</div>
									</div>
								</div>
								<div class="footer status">
									<hr />
										<div class="pull-right" >
											<form action="cupom.php" method="post" style="margin-left:150px;margin-top:15">
												<input type="hidden" name="id_cupom" id="id_cupom" value='.$cupom[$i]->id.'>
												<button type="submit" class="btn btn-primary btn-warning" name="finish">Detalhes</button>
											</form>
											<form action="cad_cupom.php" method="post" style=" margin-left:250px; margin-top:-52">
												<input type="hidden" name="cupom_id" id="cupom_id" value='.$cupom[$i]->id.'>
												<button type="submit" class=" btn btn-primary btn-info" name="reutilizar" style="font-size:14px"><i class="ti-reload"></i> Reutilizar</button>
											</form>
											</div>
										<div style="font-size: 20px;color: #007aff;">R$'. $cupom[$i]->preco_cupom .'</div><br><s style="color:coral">R$'. $cupom[$i]->preco_normal .'</s>
								</div>
							</div>
						</div>
					</div>';
					}
                    if($cupom[$i]->estado == 0)
                    {
                        $estado = "Ativo";
						$ativos .= '<div class="col-md-6 col-sm-6 bloco">
						<div class="card">
							<div class="content">
								<div class="row">
									<div class="col-sm-12">
										<b><p style="color:red; font-size:18px">'. round($desconto) .'% Off</p></b>
									</div>
									<div class="col-sm-4">
										<div class="icon-big icon-warning text-center">
											<img src="../imgs/'. $cupom[$i]->imagem.'" width="130px" class="img-responsive">
										</div>
									</div>
									<div class="col-sm-8">
										<div class="numbers">
											<p style="font-size:18px;">'. $cupom[$i]->titulo .'</p>
											<p style="color: #aaa">'. $cupom[$i]->descricao .'</p>
											<p style="color: #aaa">Válido de '. $cupom[$i]->data_cadastro .' até '. $cupom[$i]->prazo .'</p>
											<p style="color: #aaa">'. $estado .'</p>
										</div>
									</div>
								</div>
								<div class="footer status">
									<hr />
										<div class="pull-right" >
											<form action="cupom.php" method="post" style="margin-left:150px;margin-top:15">
												<input type="hidden" name="id_cupom" id="id_cupom" value='.$cupom[$i]->id.'>
												<button type="submit" class="btn btn-primary btn-warning" name="finish">Detalhes</button>
											</form>
											<form action="#" method="post" style=" margin-left:250px; margin-top:-52">
												<input type="hidden" name="cupom_id" id="cupom_id" value='.$cupom[$i]->id.';>
												<button type="submit" class=" btn btn-primary btn-danger" name="cancelar" style="font-size:14px"><i class="ti-close"></i> Desativar</button>
											</form>
											</div>
										<div style="font-size: 20px;color: #007aff;">R$'. $cupom[$i]->preco_cupom .'</div><br><s style="color:coral">R$'. $cupom[$i]->preco_normal .'</s>
								</div>
							</div>
						</div>
					</div>';
					}
        }
                ?>
				<div class="col-sm-12">
					<label>Pesquisa</label>
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1" style="background-color: #eee;border: 1px solid #ccc;border-radius: 4px;"><i class="ti-search"></i></span>
					  <input id="filtro" type="text" class="form-control" placeholder="Busca Rápida. Digite o que procura!">
					</div>
				</div>
				<ul class="nav nav-tabs" style="margin-left: 20px;">
				  <li class="active"><a data-toggle="pill" href="#home" style="color: #797979;">Ativos</a></li>
				  <li><a data-toggle="pill" href="#menu1" style="color: #797979;">Inativos</a></li>
				  <li><a data-toggle="pill" href="#menu2" style="color: #797979;">Em Aprovação</a></li>
				</ul>
				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<?php
                            if($ativos != "")
                                echo $ativos;
                            else
                                echo "<br><br><h3 class='text-center'>Sem cupons ativos.</h3>";
						?>
					</div>
					<div id="menu1" class="tab-pane fade">
						<?php
                            if($inativos != "")
                                echo $inativos;
                            else
                                echo "<br><br><h3 class='text-center'>Sem cupons inativos.</h3>";
						?>
					</div>
					<div id="menu2" class="tab-pane fade">
					<?php
                        if($em_aprovacao != "")
                            echo $em_aprovacao;
                        else
                            echo "<br><br><h3 class='text-center'>Sem cupons para aprovação.</h3>";
					?>
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


    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="../assets/js/paper-dashboard.js"></script>

    <script>
        $(function(){

          $("#filtro").keyup(function(){
            var texto = $(this).val();

            $(".bloco").each(function(){
              var resultado = $(this).text().toUpperCase().indexOf(' '+texto.toUpperCase());

              if(resultado < 0) {
                $(this).fadeOut();
              }else {
                $(this).fadeIn();
              }
            });

          });

        });
    </script>

</html>
