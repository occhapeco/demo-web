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
			<div class="col-sm-12">
				<label>Pesquisa</label>
				<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1" style="background-color: #eee;border: 1px solid #ccc;border-radius: 4px;"><i class="ti-search"></i></span>
				  <input id="filtro" type="text" class="form-control" placeholder="Busca Rápida. Digite o que procura!">
				</div>
			</div>
			
            <?php
                $json_dados = $service->call('admin.select_cupons', array());
                $cupom = json_decode($json_dados);
                $estado = "";
				$nome_emp = "";
				$desconto = "";
                for($i = 0; $i<count($cupom); $i++)
                {
					$preco_cupom = $cupom[$i]->preco_cupom;
					$preco_normal = $cupom[$i]->preco_normal;
					$desconto = (($preco_normal - $preco_cupom)*100)/$preco_normal;
					$json_dados = $service->call('empresa.select_perfil',array($cupom[$i]->empresa_id));
					$empresa = json_decode($json_dados);
					$nome_emp = $empresa->razao_social;
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
                    if($i%2 == 0)
                        echo '<div class="col-sm-12">';
                 ?>
                <div class="col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="content">
							<div class="bloco">
								<div class="row">
									<div class="col-sm-12">
										<b><p style="color:red; font-size:18px"><?php echo round($desconto) ?>% Off</p></b>
									</div>
									<div class="col-sm-4">
										<div class="icon-big icon-warning text-center">
											<img src="../imgs/<?php echo $cupom[$i]->imagem; ?>" width="130px" class="img-responsive">
										</div>
									</div>
									<div class="col-sm-8">
										<div class="numbers">
											<p style="font-size:18px;"><?php echo $cupom[$i]->titulo ?></p>
											<p style="color: #aaa"><?php echo $nome_emp ?></p>
											<p style="color: #aaa"><?php echo $cupom[$i]->descricao ?></p>
											<p style="color: #aaa">Válido de <?php echo $cupom[$i]->data_cadastro ?> até <?php echo $cupom[$i]->prazo ?></p>
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
												if($estado == "Ativo") 
												{ 
											?>
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
                </div>
                <?php
                    if($i%2 != 0)
                        echo '</div>';
                  }
                ?>            
        </div>
</div>

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
