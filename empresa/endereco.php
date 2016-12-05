<?php
    require_once("permissao.php");

    $page = basename(__FILE__, '.php');
    require_once("../conectar_service.php");

    $alert = "";
    
    $rua = "";
    $num = "";
    $complemento = "";
    $cep = "";
    $bairro = "";
    $cidade = "";
    $telefone = "";
    $btn = '<button type="submit" class="btn btn-info btn-fill btn-wd" name="cadastrar" id="cadastrar">Concluir</button>';

    if(isset($_POST["cadastrar"]))
    {
        $insert = $service->call('empresa.insert_endereco',array($_SESSION["id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]));

        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>CNPJ inválido!</b> Digite novamente.</span></div>';
        elseif($insert == -1)
            $alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Email ou CNPJ já cadastrados!</b> Reveja seus dados.</span></div>';
        elseif($insert == -2)
            $alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Endereço inválido!</b> Reveja seus dados.</span></div>';
    }

    //Post enviado de outra página para esta, onde serão carregados os dados e exibidos nos campos
    if(isset($_POST["editar"]))
    {
        $id_end = $_POST["id"];
        $editar = $service->call('empresa.select_enderecos', array($id_end));
        $endereco = json_decode($editar);
        $rua = $endereco[0]->rua;
        $num = $endereco[0]->num;
        $complemento = $endereco[0]->complemento;
        $cep = $endereco[0]->cep;
        $bairro = $endereco[0]->bairro;
        $cidade = $endereco[0]->cidade;
        $telefone = $endereco[0]->telefone;
        $btn = '<button type="submit" class="btn btn-info btn-fill btn-wd" name="edit" id="edit">Concluir</button>';
    }

    //Post enviado desta página para confirmar a edição
    if(isset($_POST["edit"]))
    {
        //TÁ ERRADO
        $update = $service->call('empresa.update_perfil', array($_SESSION["id"],$_POST["nome_usuario"],$_POST["razao_social"],$_POST["nome_fantasia"],$_POST["celular"],))
    }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Paper Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />

    <!-- Links para selects -->
    <link rel="stylesheet" href="../dist/css/bootstrap-select.css">
    <script src="../dist/js/bootstrap-select.js"></script>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <?php 
        echo $alert;
        require_once("sidenav.php");
        require_once("topnav.php");
    ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="content">
                                <form action="#" id="frm" method="post">
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cidade</label>
                                                <div class="container">
                                                    <select id="endereco" name="cidade" class="bootstrap-select border-input" data-live-search="true" title="Selecione uma cidade...">
                                                    <?php
                                                      $json_dados = $service->call('select_cidades', array());
                                                      $cidades = json_decode($json_dados);
                                                      for($i = 0; $i<count($cidades); $i++)
                                                      {
                                                        echo '<option value=' . $cidades[$i]->id . '>' . $cidades[$i]->nome . '</option>';
                                                      }
                                                    ?>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bairro</label>
                                                <input type="text" class="form-control border-input" id="bairro" name="bairro" placeholder="Centro" maxlength="30" required value="<?php echo $bairro; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Rua</label>
                                                <input type="text" class="form-control border-input" id="rua" name="rua" placeholder="Avenida Paulista" maxlength="60" required value="<?php echo $rua; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>CEP</label>
                                                <input type="number" class="form-control border-input" id="cep" name="cep" placeholder="87856123" maxlength="8" required value="<?php echo $cep; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Número</label>
                                                <input type="number" class="form-control border-input" name="num" id="num" placeholder="224" maxlength="5" required value="<?php echo $num; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Complemento</label>
                                                <input type="text" class="form-control border-input" name="complemento" id="complemento" placeholder="Próx. à escola" maxlength="20" required value="<?php echo $complemento; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Telefone</label>
                                                <input type="number" class="form-control border-input" name="telefone" id="telefone" placeholder="049 3322 2233" maxlength="11" required value="<?php echo $telefone; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <?php echo $btn; ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
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
	<script src="../assets/js/bootstrap-checkbox-radio.js"></script>

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

    <script type="text/javascript">
        var geocoder;

        function codeAddress() {
        var address = document.getElementById( 'cidade' ).value+', '+document.getElementById( 'uf' ).value+ ', '+ document.getElementById( 'rua' ).value+' '+ document.getElementById( 'num' ).value;
          geocoder.geocode( { 'address' : address }, function( results, status ) {
            if( status == google.maps.GeocoderStatus.OK ) {
                document.getElementById( 'latitude' ).value = results[0].geometry.location.lat();
                document.getElementById( 'longitude' ).value = results[0].geometry.location.lng();
                document.getElementById('frm').submit();
            } else {
                alert( 'Não podemos encontrar sua localização corretamente, por favor, reveja os dados.');
            }
        } );
      }
    </script>
</html>
