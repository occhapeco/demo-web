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
    $operacao = '<input type="hidden" name="cadastrar">';

    if(isset($_POST["cadastrar"]))
    {
        $insert = $service->call('empresa.insert_endereco',array($_SESSION["id"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]));
        echo $insert;
        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Endereço inválido!</b> Reveja seus dados.</span></div>';
        else
            header("location: meus_enderecos.php");
    }

    //Post enviado de outra página para esta, onde serão carregados os dados e exibidos nos campos
    if(isset($_GET["editar"]))
    {
        $id_end = $_GET["id_end"];
        $editar = $service->call('empresa.select_endereco', array($id_end));
        $endereco = json_decode($editar);
        $rua = $endereco->rua;
        $num = $endereco->num;
        $complemento = $endereco->complemento;
        $cep = $endereco->cep;
        $bairro = $endereco->bairro;
        $cidade = $endereco->nome;
        $cidade_id = $endereco->id;
        $telefone = $endereco->telefone;
        $operacao = '<input type="hidden" name="edit" value="'.$id_end.'">';
    }

    //Post enviado desta página para confirmar a edição
    if(isset($_POST["edit"]))
    {
        if($service->call('empresa.update_endereco', array($_POST["edit"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"])))
            header("location: meus_enderecos.php");
        else
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Endereço inválido!</b> Reveja seus dados.</span></div>';
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
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

    <style type="text/css">
        i{
            margin-top:-4px;
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
            <div class="container-fluid">
                <div class="row">
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="orange" id="wizardProfile">
                            <form action="#" id="frm" method="POST">
                                <input type="hidden" name="latitude" id="latitude" value="e">
                                <input type="hidden" name="longitude" id="longitude" value="e">
                                <?php echo $operacao; ?>
                                <div class="wizard-navigation">
                                    <div class="progress-with-circle">
                                         <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 83.3333%;"></div>
                                    </div>
                                    <ul class="nav nav-pills">
                                        <li class="active" style="width: 33.3333%;">
                                            <a href="#about" data-toggle="tab" aria-expanded="true">
                                                <div class="icon-circle checked">
                                                    <i class="ti-settings icon"></i>
                                                </div>
                                                Cidades disponíveis
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#account" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-info icon"></i>
                                                </div>
                                                Informações
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="about">
                                        <div class="row">
                                        <?php
                                            $json = $service->call("select_cidades",array());
                                            $cidade = json_decode($json);
                                            for($i=0;$i<count($cidade);$i++)
                                            {
                                                $first = "checked";
                                                $class_first = 'class="choice active"';
                                                if(isset($cidade_id))
                                                {
                                                    if($cidade[$i]->id != $cidade_id)
                                                    {
                                                        $first = "";
                                                        $class_first = 'class="choice"';
                                                    }
                                                    else
                                                        echo '<input type="hidden" name="cidade" id="cidade" value="'.$cidade[$i]->nome.'"><input type="hidden" name="uf" id="uf" value="'.$cidade[$i]->uf.'">';
                                                }
                                                elseif($i > 0)
                                                {
                                                    $first = "";
                                                    $class_first = 'class="choice"';
                                                }
                                                else
                                                    echo '<input type="hidden" name="cidade" id="cidade" value="'.$cidade[0]->nome.'"><input type="hidden" name="uf" id="uf" value="'.$cidade[0]->uf.'">';
                                                $str = "<p>".$cidade[$i]->nome." - ".$cidade[$i]->uf."</p>";
                                                $str2 = "onclick='trocar(`".$cidade[$i]->nome."`,`".$cidade[$i]->uf."`)'";
                                        ?>
                                            <div class="col-sm-3" >
                                                <label <?php echo $class_first; ?> data-toggle="wizard-radio" <?php echo $str2; ?>>
                                                    <input type="radio" name="cidade_id" <?php echo 'value="'.$cidade[$i]->id.'" '.$first; ?>>
                                                    <div class="card card-radioss card-hover-effect">
                                                    <?php echo $str; ?>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="account">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Bairro <small>(obrigatório)</small></label>
                                                    <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Centro" maxlength="30" required value="<?php echo $bairro; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Rua <small>(obrigatório)</small></label>
                                                    <input type="text" class="form-control" name="rua" id="rua" placeholder="Avenida Paulista" maxlength="60" required value="<?php echo $rua; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>CEP <small>(obrigatório)</small></label>
                                                    <input type="text" class="form-control" name="cep" id="cep" placeholder="89.567-231" maxlength="10" required value="<?php echo $cep; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Número <small>(obrigatório)</small></label>
                                                    <input type="number" class="form-control" name="num" id="num" maxlength="
                                                    5" placeholder="242" required value="<?php echo $num; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Complemento</label>
                                                    <input type="text" class="form-control" name="complemento" id="complemento" maxlength="20" placeholder="Próx. à escola" value="<?php echo $complemento; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Telefone do estabelecimento </label>
                                                    <input type="text" class="form-control" name="telefone" id="telefone" maxlength="14" placeholder="Informe o telefone do estabelecimento" value="<?php echo $telefone; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type="button" class="btn btn-next btn-fill btn-info btn-wd disabled" name="next" value="Próximo" style="display: none;">
                                            <a onclick="codeAddress();" class='btn btn-finish btn-fill btn-warning btn-wd' name='concluir'>Concluir</a>
                                        </div>

                                        <div class="pull-left">
                                            <input type="button" class="btn btn-previous btn-default btn-wd" name="previous" value="Anterior">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
     </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="../assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="../assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="../assets/js/paper-dashboard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
    <script src="../assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.validate.min.js" type="text/javascript"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWPAIE9_AASg6Ijgoh0lVOZZ_VWvw6fg&libraries=places&callback=geoco" async defer></script>  

    <script type="text/javascript">
        var geocoder ;

        function geoco(){
            geocoder = new google.maps.Geocoder();
        }

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

        function trocar(cidade,uf)
        {
            document.getElementById('cidade').value = cidade;
            document.getElementById('uf').value = uf;
        }

        $("#frm").validate({
            rules: {
                senha: {
                    minlength: 6
                },
                senha1: {
                    minlength: 6,
                    equalTo: "#senha"
                },
            },
            messages: {
                senha: {
                    minlength: "Digite pelo menos 6 caracteres."
                },
                senha1: {
                    minlength: "Digite pelo menos 6 caracteres.",
                    equalTo: "As senhas não correspondem."
                }
            }
        });

        jQuery(function($){
           $("#celular").mask("(99)99999-9999");
           $("#telefone").mask("(99)99999-9999");
           $("#cnpj").mask("99.999.999/9999-99");
           $("#cep").mask("99.999-999");
        });

    </script>
</html>
