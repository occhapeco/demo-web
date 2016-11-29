<?php
    $page = basename(__FILE__, '.php');
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Paper Dashboard by Creative Tim</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

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
                            <form action="#" method="GET" novalidate="novalidate">
                        <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->

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
                                                    <input name="titulo" type="text" class="form-control" placeholder="Promoção de picanha..." aria-required="true" aria-invalid="false" autofocus required><label id="titulo-error" class="error" for="titulo" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Prioridade <small>(obrigatório)</small></label>
                                                    <input name="prioridade" type="number" class="form-control" placeholder="MUDAR" aria-required="true" aria-invalid="false" required><label id="prioridade-error" class="error" for="prioridade" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Valor de cardápio <small>(obrigatório)</small></label>
                                                    <input name="preco_normal" type="number" class="form-control" placeholder="25,90" aria-required="true" aria-invalid="false" required><label id="preco_normal-error" class="error" for="preco_normal" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Valor promocional <small>(obrigatório)</small></label>
                                                    <input name="preco_cupom" type="number" class="form-control" placeholder="20,90" aria-required="true" aria-invalid="false" required><label id="preco_cupom-error" class="error" for="preco_cupom" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Número de cupons <small>(obrigatório)</small></label>
                                                    <input name="quatidade" type="number" class="form-control" placeholder="50" aria-required="true" aria-invalid="false" required><label id="quatidade-error" class="error" for="quatidade" style="display: none;"></label>
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
                                    <div class="tab-pane" id="account">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="delivery">
                                                        <div class="card card-checkboxes card-hover-effect">
                                                            <i class="ti-truck"></i>
                                                            <p>Delivery</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="credito">
                                                        <div class="card card-checkboxes card-hover-effect">
                                                            <i class="ti-credit-card"></i>
                                                            <p>Cartão de crédito</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="debito">
                                                        <div class="card card-checkboxes card-hover-effect">
                                                            <i class="ti-credit-card"></i>
                                                            <p>Cartão de débito</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="upload">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="" class="picture-src" id="wizardPicturePreview" title="">
                                                            <input type="file" id="wizard-picture" accept="image/x-png,image/gif,image/jpeg">
                                                            <p style="margin-top: 40px;">Fazer upload</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice active" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/breakfast-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/breakfast-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/breakfast-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/breakfast-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/breakfast-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/breakfast-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/breakfast-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/breakfast-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/breakfast-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/breakfast-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/breakfast-6.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/breakfast-6.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/drink-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/drink-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/drink-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/drink-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/drink-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/drink-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/drink-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/drink-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/drink-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/drink-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meals-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meals-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meals-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meals-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meals-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meals-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meat-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meat-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meat-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meat-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meat-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meat-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meat-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meat-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meat-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meat-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/meat-6.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/meat-6.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/seafood-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/seafood-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/seafood-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/seafood-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/seafood-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/seafood-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/seafood-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/seafood-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/snack-1.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/snack-1.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/snack-2.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/snack-2.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/snack-3.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/snack-3.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/snack-4.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/snack-4.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input type="radio" name="img" value="imgs/snack-5.jpg">
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="imgs/snack-5.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </div>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/js/demo.js"></script>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

    <script>
        function gambiarra_radio()
        {

        }
    </script>

</html>
