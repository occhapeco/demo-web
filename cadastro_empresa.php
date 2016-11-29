<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />
	<title>Paper Bootstrap Wizard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="assets/css/demo.css" rel="stylesheet" />

	<!-- Fonts and Icons -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="assets/css/themify-icons.css" rel="stylesheet">
	
	<style type="text/css">
		i{
			margin-top:-5px;
		}

	</style>
</head>

<body>
	<div class="image-container set-full-height" style="background-image: url('imgs/tex_mex.jpg')">
	 	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">

		            <!--      Wizard container        -->
		            <div class="wizard-container" style="margin-top:50px">

		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    <form action="" method="">
		                <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->

		                    	<div class="wizard-header text-center">
		                        	<h3 class="wizard-title">Cadastre-se</h3>
		                    	</div>

								<div class="wizard-navigation">
									<div class="progress-with-circle">
									     <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
									</div>
									<ul>
			                            <li>
											<a href="#about" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-user"></i>
												</div>
												Institucional
											</a>
										</li>
			                            <li>
											<a href="#account" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-settings"></i>
												</div>
												Usuário
											</a>
										</li>
			                            <li>
											<a href="#address" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-map"></i>
												</div>
												Endereço
											</a>
										</li>
			                        </ul>
								</div>
		                        <div class="tab-content">
		                            <div class="tab-pane" id="about">
		                            	<div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<div class="form-group">
													<label>Razão Social <small>(obrigatório)</small></label>
													<input name="firstname" type="text" class="form-control" name="razao_social" id="razao_social" placeholder="Digite a razão social">
												</div>
												<div class="form-group">
													<label>Nome Fantasia <small>(obrigatório)</small></label>
													<input name="lastname" type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" placeholder="Digite o nome fantasia">
												</div>
												<div class="form-group">
													<label>CNPJ <small>(obrigatório)</small></label>
													<input name="number" type="number" class="form-control" name="cnpj" id="cnpj" placeholder="Informe seu CNPJ" required>
												</div>
												<div class="form-group">
													<label>Telefone <small>(obrigatório)</small></label>
													<input name="number" type="number" class="form-control" name="celular" id="celular" placeholder="Informe um telefone para contato" required>
												</div>
											</div>
										</div>
		                            </div>
		                            <div class="tab-pane" id="account">
		                                <div class="row">
											<div class="col-sm-10 col-sm-offset-1">
												<div class="form-group">
													<label>Nome de usuário <small>(obrigatório)</small></label>
													<input name="firstname" type="text" class="form-control" name="nome_usuario" id="nome_usuario" placeholder="Informe o nome que usar">
												</div>
												<div class="form-group">
													<label>Email <small>(obrigatório)</small></label>
													<input name="lastname" type="email" class="form-control" name="email" id="email" placeholder="informe um email">
												</div>
												<div class="form-group">
													<label>Senha <small>(obrigatório)</small></label>
													<input name="email" type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha">
												</div>
												<div class="form-group">
													<label>Digite a senha novamente <small>(obrigatório)</small></label>
													<input name="senha1" id="senha1" type="password" class="form-control" placeholder="Digite novamente sua senha">
												</div>
											</div>
										</div>
		                            </div>
		                            <div class="tab-pane" id="address">
		                                <div class="row">
		                                    <div class="col-sm-12">
		                                    </div>
		                                    <div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>País</label>
		                                            <input type="text" class="form-control" name="pais" id="pais" placeholder="Brasil">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>Estado</label>
		                                            <input type="text" class="form-control" name="uf" id="uf" placeholder="São Paulo">
		                                        </div>
		                                    </div>
											<div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>Cidade</label>
		                                            <input type="text" class="form-control" name="cidade" id="cidade" placeholder="São Paulo">
		                                        </div>
		                                    </div>
											<div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>Bairro</label>
		                                            <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Centro">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-12">
		                                    	<div class="form-group">
		                                            <label>Rua</label>
		                                            <input type="text" class="form-control" name="rua" id="rua" placeholder="Avenida Paulista">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>Número</label>
		                                            <input type="number" class="form-control" name="num" id="num" placeholder="242">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                    	<div class="form-group">
		                                            <label>Complemento</label>
		                                            <input type="text" class="form-control" name="rua" id="rua" placeholder="Próx. à escola">
		                                        </div>
		                                    </div>
										</div>
		                            </div>
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Próximo' />
		                                <input type='button' class='btn btn-finish btn-fill btn-warning btn-wd' name='finish' value='Concluir' />
		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Voltar' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div><!-- end row -->
		</div> <!--  big container -->

	    
	</div>

</body>

	<!--   Core JS Files   -->
	<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

</html>
