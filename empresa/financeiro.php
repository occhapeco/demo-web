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
			<div class="container ">
				<div class="col-sm-11">
					<div class="panel-group" id="faqAccordion">
					
						<?php
							$json_dados = $service->call('empresa.select_tarifa', array($_SESSION["id"]));
							$tarifa = json_decode($json_dados);
							$total_venda = "";
							$total_comissao = "";
							$total_liquido = "";
							for($i = 0; $i<count($tarifa); $i++)
							{
								$status = "";
								if ($tarifa[$i]->estado == 1)
								{
									$status = "Pago";
								}
								if ($tarifa[$i]->estado == 0)
								{
									$status = "Em aberto";
								}
								
								for($j=0; $j<count($tarifa[$i]->cupom); $j++)
								{
									$total_venda += $tarifa[$i]->cupom[$j]->total;	
								}
						?>
									<div class="panel panel-default">
										<div <?php if ($i==count($tarifa)-1) {?> class="panel-heading accordion-toggle question-toggle" aria-expanded="true" <?php } else { ?> class="panel-heading accordion-toggle question-toggle collapsed" aria-expanded="false" <?php } ?>  data-toggle="collapse" data-parent="#faqAccordion" data-target="#question0">
											<h4 class="panel-title">
												<a href="#" class="ing"><?php echo $tarifa[$i]->data; ?> - R$ <?php echo $total_venda; ?> - <?php echo $status; ?></a>
											</h4>
										</div>
										<div id="question0" <?php if ($i==count($tarifa)-1) {?> class="panel-collapse collapse in" aria-expanded="true" <?php } else { ?> class="panel-collapse collapse" aria-expanded="false" <?php } ?>>
											<div class="panel-body">
												<div class="content table-responsive table-full-width">
													<table class="table table-striped">
														<thead>
															<tr>
																<th>Oferta</th>
																<th>Prazo</th>
																<th>Total de Cupons</th>
																<th>Cupons Vend.</th>
																<th>Total Vendas</th>
																<th>Comissão</th>
															</tr>
															<tbody>
																<?php
																	for($j=0; $j<count($tarifa[$i]->cupom); $j++)
																	{
																?>
																	<tr>
																		<td><?php echo $tarifa[$i]->cupom[$j]->titulo; ?>. De R$<?php echo $tarifa[$i]->cupom[$j]->preco_normal; ?> por R$ <?php echo $tarifa[$i]->cupom[$j]->preco_cupom; ?> </td>
																		<td><?php echo $tarifa[$i]->cupom[$j]->data_cadastro; ?> até <?php echo $tarifa[$i]->cupom[$j]->prazo; ?></td>
																		<td><center><?php echo $tarifa[$i]->cupom[$j]->total_cupons; ?></center></td>
																		<td><center><?php echo $tarifa[$i]->cupom[$j]->cupons; ?></center></td>
																		<td>R$ <?php echo $tarifa[$i]->cupom[$j]->total; ?></td>
																		<td>R$ <?php echo $tarifa[$i]->cupom[$j]->comissao; ?></td>
																	</tr>
																<?php
																		$total_comissao += $tarifa[$i]->cupom[$j]->comissao;
																		$total_liquido = $total_venda - $total_comissao;
																	}
																?>
															</tbody>
														</thead>
													</table>
													<div class="text-center" style="margin-right:10px">
														<label style="font-size:16px; color:#17A3B0">Total do mês: </label><label style="color:#252422; font-size:16px;">R$<?php echo $total_venda; ?></label>
														<label style="font-size:16px; color:#17A3B0">Total comissão: </label><label style="color:#252422; font-size:16px;">R$<?php echo $total_comissao; ?></label>
														<label style="font-size:16px; color:#17A3B0">Total líquido: </label><label style="color:#252422; font-size:16px;">R$<?php echo $total_liquido; ?></label>
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
