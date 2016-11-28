<!doctype html>
<html lang="en">
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
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
        Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
        Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
    -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    Nome
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="dashboard.html">
                        <i class="ti-pie-chart"></i>
                        <p>Novo Cupom</p>
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">
                        <i class="ti-panel"></i>
                        <p>Meus Cupons</p>
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">
                        <i class="ti-panel"></i>
                        <p>Estatísticas</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">Cupom</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-panel"></i>
                                <p>Estatisticas</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <p class="notification">5</p>
                                    <p>Notificações</p>
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i class="ti-settings"></i>
                                <p>Configurações</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="orange" id="wizardProfile">
                            <form action="" method="" novalidate="novalidate">
                        <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->

                                <div class="wizard-header text-center">
                                    <h3 class="wizard-title">Criar novo cupom</h3>
                                </div>

                                <div class="wizard-navigation">
                                    <div class="progress-with-circle">
                                         <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 83.3333%;"></div>
                                    </div>
                                    <ul class="nav nav-pills">
                                        <li class="active" style="width: 33.3333%;">
                                            <a href="#about" data-toggle="tab" aria-expanded="true">
                                                <div class="icon-circle checked">
                                                    <i class="ti-user"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#account" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-settings"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#address" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-map"></i>
                                                </div>
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
                                                    <input name="titulo" type="text" class="form-control" placeholder="Promoção de picanha..." aria-required="true" aria-invalid="false"><label id="titulo-error" class="error" for="titulo" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Prioridade <small>(obrigatório)</small></label>
                                                    <input name="prioridade" type="number" class="form-control" placeholder="MUDAR" aria-required="true" aria-invalid="false"><label id="prioridade-error" class="error" for="prioridade" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Valor de cardápio <small>(obrigatório)</small></label>
                                                    <input name="preco_normal" type="number" class="form-control" placeholder="25,90" aria-required="true" aria-invalid="false"><label id="preco_normal-error" class="error" for="preco_normal" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Valor promocional <small>(obrigatório)</small></label>
                                                    <input name="preco_cupom" type="number" class="form-control" placeholder="20,90" aria-required="true" aria-invalid="false"><label id="preco_cupom-error" class="error" for="preco_cupom" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Número de cupons <small>(obrigatório)</small></label>
                                                    <input name="quatidade" type="number" class="form-control" placeholder="50" aria-required="true" aria-invalid="false"><label id="quatidade-error" class="error" for="quatidade" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Descrição <small>(obrigatório)</small></label>
                                                    <textarea name="descricao" class="form-control" placeholder="Porção picanha ao molho de churrasco..." aria-required="true" aria-invalid="false"></textarea><label id="descricao-error" class="error" for="descricao" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Regras <small>(obrigatório)</small></label>
                                                    <textarea name="descricao" class="form-control" placeholder="Para realmente usar o cupom, deve-se levar um amigo até o estabelecimento..." aria-required="true" aria-invalid="false"></textarea><label id="descricao-error" class="error" for="descricao" style="display: none;"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="account">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-3">
                                                    <div class="choice active" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="local">
                                                        <div class="card card-checkboxes card-hover-effect">
                                                            <i class="ti-location-pin"></i>
                                                            <p>Retirada no local</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="delivery">
                                                        <div class="card card-checkboxes card-hover-effect">
                                                            <i class="ti-truck"></i>
                                                            <p>Delivery</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="credito">
                                                        <div class="card card-checkboxes card-hover-effect">
                                                            <i class="ti-credit-card"></i>
                                                            <p>Cartão de crédito</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
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
                                            <div class="col-sm-12" style="margin-left: 0px;margin-right: 15px">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="assets/img/default-avatar.jpg" class="picture-src" id="wizardPicturePreview" title="">
                                                        <input type="file" id="wizard-picture">
                                                    </div>
                                                    <h6>Fazer upload de imagem</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-footer">
                                    <div class="pull-right">
                                        <input type="button" class="btn btn-next btn-fill btn-info btn-wd disabled" name="next" value="Próximo" style="display: none;">
                                        <input type="button" class="btn btn-finish btn-fill btn-info btn-wd" name="finish" value="Concluir" style="display: inline-block;">
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


</html>
