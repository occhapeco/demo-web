<?php
    require_once("permissao.php");
    
    $page = basename(__FILE__, '.php');
    require_once("../conectar_service.php");

    $alert = "";
    
    $endereco_id = 0;
    $imagem_id = 0;
    $imagem_caminho = "";
    $imagem_tipo = 1;
    $titulo = "";
    $regras = "";
    $descricao = "";
    $preco_normal = "";
    $preco_cupom = "";
    $prazo = "";
    $quantidade = "";
    $pagamento = 0;
    $delivery = 0;
    $tipo = NULL;
    $operacao = '<input type="hidden" name="cadastrar">';

    if(isset($_GET["editar"]))
    {
        $cupom_id = $_GET["cupom_id"];
        $empresa_id = $_GET["empresa_id"];
        $json = $service->call('empresa.select_cupom', array($cupom_id));
        $cupom = json_decode($json);
        $endereco_id = $cupom->endereco_id;
        $imagem_id = $cupom->imagem_id;
        $imagem_tipo = $cupom->imagem_tipo;
        $imagem_caminho = $cupom->caminho;
        $titulo = $cupom->titulo;
        $regras = $cupom->regras;
        $descricao = $cupom->descricao;
        $preco_normal = $cupom->preco_normal;
        $preco_cupom = $cupom->preco_cupom;
        $prazo = $cupom->prazo;
        $quantidade = $cupom->quantidade;
        $pagamento = $cupom->pagamento;
        $delivery = $cupom->delivery;
        $tipo = $cupom->tipo;
        $operacao = '<input type="hidden" name="edit" value="'.$cupom_id.'">';
    }
    else
        header("location: index.php");

    if(isset($_POST["edit"]))
    {
        $imagem = $_POST["imagem_id"];

        if($_POST["imagem_id"] == "upload")
        {
            $servidor = 'olar.esy.es';
            $caminho_absoluto = '/public_html/';

            $con_id = ftp_connect($servidor) or die( 'Não conectou em: '.$servidor );
            ftp_login($con_id,'u274667541','batata');
            ftp_pasv($con_id, true);

            $arquivo = $_FILES['wizard-picture'];
            $extension = explode(".",$arquivo["name"]);
            $arquivo["name"] = 'cupom'.$_POST["edit"].'.'.$extension[1];

            ftp_delete($con_id,$caminho_absoluto.'cupom'.$_POST["edit"].'.png');
            ftp_delete($con_id,$caminho_absoluto.'cupom'.$_POST["edit"].'.jpg');
            ftp_put($con_id,$caminho_absoluto.$arquivo['name'], $arquivo['tmp_name'],FTP_BINARY);

            if(isset($_POST["trocar"]))
                $imagem = $_POST["trocar"];
            else
                $imagem = $service->call('empresa.insert_imagem',array($arquivo['name']));
        }

        $delivery = 0;
        if(isset($_POST["delivery"]))
            $delivery = 1;

        $pagamento = 0;
        if(isset($_POST["debito"]))
            $pagamento++;
        if(isset($_POST["credito"]))
            $pagamento += 2;

        $tipos = array();
        $json = $service->call("select_tipos",array());
        $tipo = json_decode($json);
        for($i=0;$i<count($tipo);$i++)
            if(isset($_POST[$tipo[$i]->id]))
                $tipos[] = $tipo[$i]->id;
        $insert = $service->call('empresa.update_cupom',array($_POST["edit"],$_POST["endereco_id"],$imagem,$_POST["titulo"],$_POST["regras"],$_POST["descricao"],$_POST["preco_normal"],$_POST["preco_cupom"],$_POST["prazo"],$_POST["quantidade"],$pagamento,$delivery,json_encode($tipos)));
        if($_POST["imagem_id"] != "upload" && isset($_POST["trocar"]) && $_POST["imagem_id"] != $_POST["trocar"])
        {
            $servidor = 'olar.esy.es';
            $caminho_absoluto = '/public_html/';

            $con_id = ftp_connect($servidor) or die( 'Não conectou em: '.$servidor );
            ftp_login($con_id,'u274667541','batata');
            ftp_pasv($con_id, true);
            
            ftp_delete($con_id,$caminho_absoluto.'cupom'.$_POST["edit"].'.png');
            ftp_delete($con_id,$caminho_absoluto.'cupom'.$_POST["edit"].'.jpg');
            $insert = $service->call('empresa.delete_imagem',array($_POST["trocar"]));
        }
        $insert = $service->call('admin.aprovar_cupom',array($_POST["edit"]));
        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
        else
            header("location: index.php");
    }
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Clube de Ofertas</title>

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
        label{
            margin-right:5px;
        }
        .icon{
            margin-top: -5px;
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
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <?php echo $operacao; ?>
                                <div class="wizard-navigation">
                                    <div class="progress-with-circle">
                                         <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 83.3333%;"></div>
                                    </div>
                                    <ul class="nav nav-pills">
                                        <li class="active" style="width: 33.3333%;">
                                            <a href="#about" data-toggle="tab" aria-expanded="true">
                                                <div class="icon-circle checked">
                                                    <i class="ti-info icon"></i>
                                                </div>
                                                Informações
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#account" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-settings icon"></i>
                                                </div>
                                                Opções
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#address" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-map icon"></i>
                                                </div>
                                                Imagem de fundo
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="about">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>Título <small>(obrigatório)</small></label>
                                                    <input name="titulo" type="text" class="form-control" placeholder="Promoção de picanha..." aria-required="true" aria-invalid="false" value="<?php echo $titulo; ?>" required autofocus><label id="titulo-error" class="error" for="titulo" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Número de cupons <small>(obrigatório)</small></label>
                                                    <input name="quantidade" type="number" class="form-control" placeholder="50" aria-required="true" aria-invalid="false" value="<?php echo $quantidade; ?>" required><label id="quatidade-error" class="error" for="quatidade" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Prazo <small>(obrigatório)</small></label>
                                                    <input name="prazo" id="prazo" type="text" class="form-control" placeholder="02/06/2017 20:00" aria-required="true" aria-invalid="false" value="<?php echo $prazo; ?>" required><label id="prazo-error" class="error" for="prazo" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Valor de cardápio <small>(obrigatório)</small></label>
                                                    <input name="preco_normal" id="preco_normal" type="number" class="form-control" placeholder="25,90" aria-required="true" aria-invalid="false" value="<?php echo $preco_normal; ?>" required><label id="preco_normal-error" class="error" for="preco_normal" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Valor promocional <small>(obrigatório)</small></label>
                                                    <input name="preco_cupom" id="preco_cupom" type="number" class="form-control" placeholder="20,90" aria-required="true" aria-invalid="false" value="<?php echo $preco_cupom; ?>" required><label id="preco_cupom-error" class="error" for="preco_cupom" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label>Desconto (%)</label>
                                                    <input id="desconto" type="text" class="form-control" placeholder="35%" aria-required="true" aria-invalid="false" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Descrição <small>(obrigatório)</small></label>
                                                    <textarea name="descricao" class="form-control" placeholder="Porção picanha ao molho de churrasco..." aria-required="true" aria-invalid="false" required><?php echo $descricao; ?></textarea><label id="descricao-error" class="error" for="descricao" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Regras <small>(obrigatório)</small></label>
                                                    <textarea name="regras" class="form-control" placeholder="Para realmente usar o cupom, deve-se levar um amigo até o estabelecimento..." aria-required="true" aria-invalid="false" required><?php echo $regras; ?></textarea><label id="regras-error" class="error" for="regras" style="display: none;"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <?php
                                            $json = $service->call("empresa.select_enderecos",array($empresa_id));
                                            $endereco = json_decode($json);
                                            for($i=0;$i<count($endereco);$i++)
                                            {
                                                $first = "checked";
                                                $class_first = 'class="choice active"';
                                                if($endereco[$i]->id != $endereco_id && $endereco_id != 0)
                                                {
                                                    $first = "";
                                                    $class_first = 'class="choice"';
                                                }
                                                elseif($i > 0)
                                                {
                                                    $first = "";
                                                    $class_first = 'class="choice"';
                                                }
                                                $str = "<p>".$endereco[$i]->rua." nº".$endereco[$i]->num.", ".$endereco[$i]->bairro.", ".$endereco[$i]->nome." - ".$endereco[$i]->uf."</p>";
                                        ?>
                                            <div class="col-sm-3" >
                                                <label <?php echo $class_first; ?> data-toggle="wizard-radio">
                                                    <input type="radio" name="endereco_id" <?php echo 'value="'.$endereco[$i]->id.'" '.$first; ?>>
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
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($delivery == 1) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="delivery" <?php if($delivery == 1) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-truck"></i>
                                                        <p>Delivery</p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($pagamento == 1 || $pagamento == 3) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="credito" <?php if($pagamento == 1  || $pagamento == 3) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-credit-card"></i>
                                                        <p>Cartão de crédito</p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($pagamento >= 2) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="debito" <?php if($pagamento >= 2) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-credit-card"></i>
                                                        <p>Cartão de débito</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <?php
                                            $json = $service->call("select_tipos",array());
                                            $tipos = json_decode($json);
                                            for($i=0;$i<count($tipos);$i++)
                                            {
                                                $first = "checked";
                                                $class_first = 'class="choice active"';
                                                $selected = false;
                                                if(count($tipo) > 0)
                                                {
                                                    for($j=0;$j<count($tipo);$j++)
                                                        if($tipo[$j]->tipo_id == $tipos[$i]->id)
                                                        {
                                                            $first = "";
                                                            $class_first = 'class="choice"';
                                                        }
                                                }
                                                elseif($i > 0)
                                                {
                                                    $first = "";
                                                    $class_first = 'class="choice"';
                                                }
                                                

                                                $str = "<p>".$tipos[$i]->nome."</p>";
                                        ?>
                                            <div class="col-sm-2">
                                                <label <?php echo $class_first; ?> data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="<?php echo $tipos[$i]->id; ?>" <?php echo $first; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <?php echo $str; ?>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="file" id="wizard-picture" name="wizard-picture" accept="image/x-png,image/jpeg">
                                                <label class="choice" data-toggle="wizard-radio"  onclick="$('#wizard-picture').click();">
                                                    <input type="radio" name="imagem_id" value="upload">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="" class="picture-src" id="wizardPicturePreview" title="">
                                                            <p style="margin-top: 40px;">Fazer upload</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                                if($imagem_tipo == 0)
                                                {
                                            ?>
                                            <div class="col-sm-3">
                                                <label class="choice active" data-toggle="wizard-radio">
                                                    <input type="hidden" name="trocar" <?php echo 'value="'.$imagem_id.'"'; ?>>
                                                    <input type="radio" name="imagem_id" <?php echo 'value="'.$imagem_id.'" checked'; ?>>
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img <?php echo 'src="http://olar.esy.es/'.$imagem_caminho.'"'; ?> class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                                }
                                                $json = $service->call("select_imagens",array());
                                                $imagem = json_decode($json);
                                                for($i=0;$i<count($imagem);$i++)
                                                {
                                                    $first = "checked";
                                                    $class_first = 'class="choice active"';
                                                    if($imagem_id > 0)
                                                    {
                                                        if($imagem[$i]->id != $imagem_id)
                                                        {
                                                            $first = "";
                                                            $class_first = 'class="choice"';
                                                        }
                                                    }
                                                    elseif($i > 0)
                                                    {
                                                        $first = "";
                                                        $class_first = 'class="choice"';
                                                    }
                                            ?>
                                            <div class="col-sm-3">
                                                <label <?php echo $class_first; ?> data-toggle="wizard-radio">
                                                    <input type="radio" name="imagem_id" <?php echo 'value="'.$imagem[$i]->id.'" '.$first; ?>>
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img <?php echo 'src="../imgs/'.$imagem[$i]->caminho.'" '; ?> class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type="button" class="btn btn-next btn-fill btn-info btn-wd disabled" name="next" value="Próximo" style="display: none;">
                                            <input type="submit" class="btn btn-finish btn-fill btn-info btn-wd" name="finish" value="Concluir" style="display: inline-block;">
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

    <script type="text/javascript">

        $("#wizard-picture").hide();

        jQuery(function($){
           $("#prazo").mask("99/99/9999 99:99");
        });

        setInterval(function (){
            if(document.getElementById("preco_normal").value.length != 0 && document.getElementById("preco_cupom").value.length != 0)
            {
                var desconto = ((document.getElementById("preco_normal").value-document.getElementById("preco_cupom").value) * 100)/document.getElementById("preco_normal").value;
                desconto = Math.round(desconto);
                document.getElementById("desconto").value = desconto+"%";
            }
        },10);

    </script>

</html>
