<?php
    require_once("permissao.php");
    
    $page = basename(__FILE__, '.php');
    require_once("../conectar_service.php");

    $alert = "";
    
    $endereco_id = "";
    $titulo = "";
    $regras = "";
    $descricao = "";
    $preco_normal = "";
    $preco_cupom = "";
    $quantidade = "";
    $prioridade = 0;
    $pagamento = 0;
    $delivery = 0;
    $tipo = NULL;
    $operacao = '<input type="hidden" name="cadastrar">';

    if(isset($_POST["cadastrar"]))
    {
        $delivery = 0;
        if(isset($_POST["delivery"]))
            $delivery = 1;

        $pagamento = 0;
        if(isset($_POST["debito"]))
            $pagamento++;
        if(isset($_POST["credito"]))
            $pagamento += 2;

        $tipos = array();
        $i = 0;
        $json = $service->call("select_tipos",array());
        $tipo = json_decode($json);
        for($i=0;$i<count($tipo);$i++)
            if(isset($_POST[$tipo[$i]->id]))
            {
                $tipos[$i] = $tipo[$i]->id;
                $i++;
            }
        $tipos = json_encode($tipos);

        $insert = $service->call('empresa.insert_cupom',array($_SESSION["id"],$_POST["endereco_id"],$_POST["titulo"],$_POST["regras"],$_POST["descricao"],$_POST["preco_normal"],$_POST["preco_cupom"],$_POST["prazo"],$_POST["quantidade"],$pagamento,$delivery,$tipos));
        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
        else
            header("location: meus_enderecos.php");
    }
?>
<!doctype html>
<html lang="pt">
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
    ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="orange" id="wizardProfile">
                            <form action="#" method="POST">
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
                                            <a href="#endereco" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-direction-alt icon"></i>
                                                </div>
                                                Endereço
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
                                            <a href="#tipos" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-bookmark icon"></i>
                                                </div>
                                                Categorias
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
                                                    <input name="titulo" type="text" class="form-control" placeholder="Promoção de picanha..." aria-required="true" aria-invalid="false" required autofocus><label id="titulo-error" class="error" for="titulo" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Número de cupons <small>(obrigatório)</small></label>
                                                    <input name="quantidade" type="number" class="form-control" placeholder="50" aria-required="true" aria-invalid="false" required><label id="quatidade-error" class="error" for="quatidade" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Prazo <small>(obrigatório)</small></label>
                                                    <input name="prazo" id="prazo" type="text" class="form-control" placeholder="02/06/2017 20:00" aria-required="true" aria-invalid="false" required><label id="prazo-error" class="error" for="prazo" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Valor de cardápio <small>(obrigatório)</small></label>
                                                    <input name="preco_normal" id="preco_normal" type="number" class="form-control" placeholder="25,90" aria-required="true" aria-invalid="false" required><label id="preco_normal-error" class="error" for="preco_normal" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Valor promocional <small>(obrigatório)</small></label>
                                                    <input name="preco_cupom" id="preco_cupom" type="number" class="form-control" placeholder="20,90" aria-required="true" aria-invalid="false" required><label id="preco_cupom-error" class="error" for="preco_cupom" style="display: none;"></label>
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
                                                    <textarea name="descricao" class="form-control" placeholder="Porção picanha ao molho de churrasco..." aria-required="true" aria-invalid="false" required></textarea><label id="descricao-error" class="error" for="descricao" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Regras <small>(obrigatório)</small></label>
                                                    <textarea name="regras" class="form-control" placeholder="Para realmente usar o cupom, deve-se levar um amigo até o estabelecimento..." aria-required="true" aria-invalid="false" required></textarea><label id="regras-error" class="error" for="regras" style="display: none;"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="endereco">
                                        <div class="row">
                                        <?php
                                            $json = $service->call("empresa.select_enderecos",array($_SESSION["id"]));
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
                                    <div class="tab-pane" id="tipos">
                                        <div class="row">
                                        <?php
                                            $json = $service->call("select_tipos",array());
                                            $tipo = json_decode($json);
                                            for($i=0;$i<count($tipo);$i++)
                                            {
                                                $first = "checked";
                                                $class_first = 'class="choice active"';
                                                $selected = false;
                                                if(count($tipo) > 0)
                                                {
                                                    for($j=0;$j<count($tipo);$j++)
                                                        if($tipo[$i]->id == $tipo[$j]->id)
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
                                                

                                                $str = "<p>".$tipo[$i]->nome."</p>";
                                        ?>
                                            <div class="col-sm-2">
                                                <label <?php echo $class_first; ?> data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="<?php echo $tipo[$i]->id; ?>" <?php echo $first; ?>>
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
                                                <label class="choice <?php if($pagamento == 1) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="credito" <?php if($pagamento == 1) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-credit-card"></i>
                                                        <p>Cartão de crédito</p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($pagamento == 2) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="debito" <?php if($pagamento == 2) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-credit-card"></i>
                                                        <p>Cartão de débito</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="upload">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="" class="picture-src" id="wizardPicturePreview" title="">
                                                            <input type="file" id="wizard-picture" accept="image/x-png,image/gif,image/jpeg">
                                                            <p style="margin-top: 40px;">Fazer upload</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice active" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/breakfast-1.jpg" checked>
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/breakfast-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/breakfast-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/breakfast-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/breakfast-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/breakfast-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/breakfast-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/breakfast-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/breakfast-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/breakfast-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/breakfast-6.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/breakfast-6.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/drink-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/drink-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/drink-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/drink-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/drink-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/drink-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/drink-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/drink-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/drink-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/drink-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meals-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meals-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meals-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meals-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meals-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meals-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meat-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meat-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meat-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meat-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meat-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meat-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meat-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meat-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meat-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meat-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/meat-6.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/meat-6.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/seafood-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/seafood-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/seafood-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/seafood-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/seafood-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/seafood-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/seafood-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/seafood-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/snack-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/snack-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/snack-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/snack-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/snack-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/snack-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/snack-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/snack-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="../imgs/snack-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="../imgs/snack-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
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
