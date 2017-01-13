<?php
    require_once("permissao.php");
    require_once("../conectar_service.php");

    $page = basename(__FILE__, '.php');

    $alert = "";
	
	if(isset($_POST["cad_cidade"]))
	{
		if($service->call('admin.insert_cidade', array($_POST["nome_cidade"],$_POST["uf"])))
		{
			$alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Cidade cadastrada com sucesso!</b></span></div>';
		}
		else
		{
			$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Erro ao cadastrar cidade! Verifique os dados e tente novamente</b></span></div>';
		}
	}
	
	if(isset($_POST["bloq_cidade"]))
	{
		if($service->call('admin.desativar_cidade', array($_POST["cidade_id"])))
		{
			$alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Cidade desativada com sucesso!</b></span></div>';
		}
		else
		{
			$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Erro ao desativar cidade! Verifique os dados e tente novamente</b></span></div>';
		}	
	}
	
	if(isset($_POST["desbloquear"]))
	{
		if($service->call('admin.ativar_cidade', array($_POST["cidade_id"])))
		{
			$alert = '<div class="alert alert-success" style="margin: 10px 10px -20px 10px;"><span><b>Cidade ativada com sucesso!</b></span></div>';
		}
		else
		{
			$alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Erro ao ativar cidade! Verifique os dados e tente novamente</b></span></div>';
		}
	}

?>
<html lang="pt">
<head>
	<meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
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
        echo $alert;
    ?>

        <div class="content">
            <div class="col-lg-12">
                <div class="card">
					<form action="#" method="post">
						<div class="content">
							<div class="row">
								<div class="form-group">
									<div class="col-sm-3">
										<label>Informe o nome da cidade</label>
									</div>
									<div class="col-sm-9">
										<input name="nome_cidade" type="text" class="form-control" placeholder="Chapecó" aria-required="true" aria-invalid="false" required>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3">
										<label>Informe o estado desta cidade</label>
									</div>
									<div class="col-sm-9">
										<input name="uf" type="text" class="form-control" placeholder="SC" aria-required="true" aria-invalid="false" required>
									</div>
								</div>
							</div>
						</div>
						<div class="footer status" style="padding-bottom:50px;">
							<hr />
							<div class="pull-right" style="margin-right:10px">
								<button type="submit" class="btn btn-primary btn-warning" name="cad_cidade" style="font-size: 14px"><i class="ti-check"></i> Cadastrar</button>
							</div>
						</div>
					</form>
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
                                        <th>Cidade</th>
										<th>UF</th>
                                        <th>Ação</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                            $select = $service->call('admin.select_cidades', array());
                                            $cidade = json_decode($select);
                                            for($i = 0; $i<count($cidade); $i++)
                                            {
                                        ?>
                                        <tr>
                                            <td><?php echo $cidade[$i]->nome; ?></td>
											<td><?php echo $cidade[$i]->uf; ?></td>
										<?php
											if($cidade[$i]->estado == 0) 
											{
										?>
												<td><form action="#" method="post"><input type="hidden" name="cidade_id" id="cidade_id" <?php echo "value='".$cidade[$i]->id."'"; ?>><button type="submit" class="btn btn-primary btn-warning" name="bloq_cidade" style="font-size: 14px"><i class="ti-lock"></i> Bloquear</button></form></td>
                                        <?php
											}
											else
											{
										?>
												<td><form action="#" method="post"><input type="hidden" name="cidade_id" id="cidade_id" <?php echo "value='".$cidade[$i]->id."'"; ?>><button type="submit" class="btn btn-primary btn-info" name="desbloquear" style="font-size: 14px"><i class="ti-unlock"></i> Desbloquear</button></form></td>
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
