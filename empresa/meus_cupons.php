<?php
    require_once("permissao.php");

    $page = basename(__FILE__, '.php');
?>
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

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />

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
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <img src="imgs/pizza-3.png" width="100px" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Batata frita com camarão à milanesa + coquinha bem grammde texto grande</p>
                                </div>
                            </div>
                        </div>
                        <div class="footer status">
                            <hr />
                            
                                <div class="pull-right" >
                                    <div class=""><button class=" btn btn-simple btn-warning"><i class="ti-pencil" style="font-size: 20px"></i></button></div>      
                                    <div class=""><button class="btn btn-simple btn-info"><i class="ti-reload" style="font-size: 20px"></i></button></div>
                                </div>
                                <div style="font-size: 20px;color: #007aff;">R$22,00</div><br><s style="color:coral">R$44,00</s>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <img src="imgs/pizza-3.png" width="100px" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Batata frita com camarão à milanesa + coquinha bem grammde texto grande</p>
                                </div>
                            </div>
                        </div>
                        <div class="footer status">
                            <hr />                            
                                <div class="pull-right">
                                    <button class=" btn btn-simple btn-warning"><i class="ti-pencil" style="font-size: 20px"></i></button> 
                                    <button class="btn btn-simple btn-info"><i class="ti-reload" style="font-size: 20px"></i></button>
                                </div>
                                <div style="font-size: 20px;color: #007aff;">R$22,00</div><br><s style="color:coral">R$44,00</s>
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


</html>
