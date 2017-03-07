<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');
    $alert = "";
	
	if(isset($_POST["baixa"]))
    {
        $json = $service->call('admin.select_tarifa', array());
        $tarifa = json_decode($json);
        $dados = array();
        for($i=0;$i<count($tarifa);$i++)
        	if(isset($_POST[$tarifa[$i]->data]))
			{
				$dados["data"] = $tarifa[$i]->data_baixa;
				for($j=0;$j<count($tarifa[$i]->empresa);$j++)
				{
					if(isset($_POST[$tarifa[$i]->empresa[$j]->id]))
						$dados["empresa"][] = $tarifa[$i]->empresa[$j]->id;
				}
				break;
			}

        $json = $service->call('admin.dar_baixa_tarifa', array(json_encode($dados)));

        if($json)
            $alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Baixa realizada com sucesso!</b></span></div>';
        else
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
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
    </style>
</head>
<body>

<div class="wrapper">
	<?php 
        require_once("sidenav.php");
        require_once("topnav.php");
        echo $alert;
    ?>
		<div class="content">
			<div class="container ">
				<div class="col-sm-11">
					<div class="panel-group" id="faqAccordion">
					
						<?php
							$json_dados = $service->call('admin.select_tarifa', array());
							$tarifa = json_decode($json_dados);
							for($i = 0; $i<count($tarifa); $i++)
							{
								$total_venda = 0;
								$total_comissao = 0;
								$comissao_areceber = 0;
								$comissao_recebida = 0;
								
								for($j=0; $j<count($tarifa[$i]->empresa); $j++)
								{
									$total_venda += $tarifa[$i]->empresa[$j]->total_venda;
									$total_comissao += $tarifa[$i]->empresa[$j]->comissao;
								}

								$total_venda = number_format($total_venda, 2, '.', '');
								$total_comissao = number_format($total_comissao, 2, '.', '');	
							?>
									<div class="panel panel-default">
										<div <?php if ($i==count($tarifa)-1) {?> class="panel-heading accordion-toggle question-toggle" aria-expanded="true" <?php } else { ?> class="panel-heading accordion-toggle question-toggle collapsed" aria-expanded="false" <?php } ?>  data-toggle="collapse" data-parent="#faqAccordion" data-target="#question<?php echo $i ?>">
											<h4 class="panel-title">
												<a href="#" class="ing"><?php echo $tarifa[$i]->data; ?> - R$ <?php echo $total_comissao; ?></a>
											</h4>
										</div>
										<div id="question<?php echo $i ?>" <?php if ($i==count($tarifa)-1) {?> class="panel-collapse collapse in" aria-expanded="true" <?php } else { ?> class="panel-collapse collapse" aria-expanded="false" <?php } ?>>
											<div class="panel-body">
												<div class="content table-responsive table-full-width">
													<form action="#" method="post">
														<input type="hidden" name="<?php echo $tarifa[$i]->data; ?>" value="<?php echo $tarifa[$i]->data_baixa; ?>">
														<input type="submit" class="btn btn-finish btn-fill btn-info btn-wd" name="baixa" value="Dar Baixa" style="display: inline-block; margin-left:10px;">
														<table class="table table-striped">
															<thead>
																<tr>
																	<th><center>Marcar</center></th>
																	<th>Empresa</th>
																	<th><center>Telefone</center></th>
																	<th>Total Vendas</th>
																	<th>Comissão</th>
																	<th>Situação</th>
																</tr>
																<tbody>
																	<?php
																		for($j=0; $j<count($tarifa[$i]->empresa); $j++)
																		{
																			$select = $service->call('empresa.select_perfil', array($tarifa[$i]->empresa[$j]->id));
																			$empresa = json_decode($select);
																			
																			$status = "";
																			if ($tarifa[$i]->empresa[$j]->estado == 1)
																			{
																				$status = "Pago";
																				$comissao_recebida += $tarifa[$i]->empresa[$j]->comissao;
																			}
																			if ($tarifa[$i]->empresa[$j]->estado == 0)
																			{
																				$status = "A receber";
																				$comissao_areceber += $tarifa[$i]->empresa[$j]->comissao;
																			}
																	?>
																		<tr>
																			<td><center>
																			<?php
																				if($status == "A receber")
																				{
																			?>
																			<input type="checkbox" name="<?php echo $tarifa[$i]->empresa[$j]->id; ?>"></center>
																			<?php
																				}
																				else
																				{
																			?>
																			<center>-</center>
																			<?php
																				}
																			?>
																			</td>
																			<td><?php echo $empresa->razao_social; ?></td>
																			<td><center><?php echo $tarifa[$i]->empresa[$j]->celular; ?></center></td>
																			<td>R$ <?php echo number_format( $tarifa[$i]->empresa[$j]->valor , 2, '.', ''); ?></td>
																			<td>R$ <?php echo number_format( $tarifa[$i]->empresa[$j]->comissao , 2, '.', ''); ?></td>
																			<td><p <?php if ($tarifa[$i]->empresa[$j]->estado == 0) {?> style="color:red" <?php } else {?> style="color:green" <?php } ?>><?php echo $status ?></p></td>
																		</tr>
																	<?php
																			$total_venda += $tarifa[$i]->empresa[$j]->valor;
																		}
																	?>
																</tbody>
															</thead>
														</table>
													</form>
													<div class="text-center" style="margin-right:10px">
														<label style="font-size:16px; color:#17A3B0;">Total comissão: </label><label style="color:#252422; font-size:16px;">R$<?php echo $total_comissao; ?></label>
														<label style="font-size:16px; color:#17A3B0;">Total já recebido: </label><label style="color:#252422; font-size:16px;">R$<?php echo number_format( $comissao_recebida , 2, '.', ''); ?></label>
														<label style="font-size:16px; color:#17A3B0;">Total a receber: </label><label style="color:#252422; font-size:16px;">R$<?php echo number_format( $comissao_areceber , 2, '.', ''); ?></label>
														<label style="font-size:16px; color:#17A3B0;">Total de vendas: </label><label style="color:#252422; font-size:16px;">R$<?php echo $total_venda; ?></label>
													</div>
												</div> 
											</div>
										</div>
									</div>
							<?php
							}
							?>
					</div>
					<!--/panel-group-->
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

</html>
