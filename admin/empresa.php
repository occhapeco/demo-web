<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    if(isset($_POST["bloquear"]))
    {
        $bool = $service->call('admin.bloquear_empresa', array($_POST["empresa_id"]));
        header("location: empresa.php");
    }
    if(isset($_POST["desbloquear"]))
    {
        $bool = $service->call('admin.desbloquear_empresa', array($_POST["empresa_id"]));
        header("location: empresa.php");
    }
?>
<html lang="pt">
<head>
	<meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
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
        <div class="col-lg-12">
            <div class="card">
				<div class="content table-responsive table-full-width">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>CNPJ/CPF</th>
								<th>Telefone</th>
								<th>Endereços</th>
								<th>Ação</th>
							</tr>
							<tbody>
								<?php
									$json_dados = $service->call('admin.select_empresas',array(0));
									$empresa = json_decode($json_dados);
									for($i=0;$i<count($empresa);$i++)
									{
										$json = $service->call('empresa.select_enderecos', array($empresa[$i]->id));
										$endereco = json_decode($json);
										$enderecos = "";
										for($j=0;$j<count($endereco);$j++)
										{
											if($j > 0)
												$enderecos .= " / ";
											$enderecos .= $endereco[$j]->bairro.", ".$endereco[$j]->rua.", ".$endereco[$j]->num.", ".$endereco[$j]->complemento.", ".$endereco[$j]->cep;
										}
								?>
								<tr>
									<td><?php echo $empresa[$i]->cnpj; ?></td>
									<td><?php echo $empresa[$i]->celular; ?></td>
									<td><?php echo $enderecos; ?></td>
								<?php
									if($empresa[$i]->estado == 0) 
									{
								?>
									<td>
										<form action="#" method="post">
											<input type="hidden" name="empresa_id" id="empresa_id" <?php echo "value='".$empresa[$i]->id."'"; ?>>
											<button class=" btn btn-primary btn-danger" name="bloquear" style="font-size: 16px"><i class="ti-lock"></i> Bloquear</button>
										</form>
									</td>
								<?php
									}
									else
									{
								?>
									<td>
										<form action="#" method="post">
											<input type="hidden" name="empresa_id" id="empresa_id" <?php echo "value='".$empresa[$i]->id."'"; ?>>
											<button class=" btn btn-primary btn-info" name="desbloquear" style="font-size: 16px"><i class="ti-lock"></i> Desbloquear</button>
										</form>
									</td>
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
				</div>
            </div>
		</div>
    </div>

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
	
</body>

</html>
