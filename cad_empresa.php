<?php
	require_once("conectar_service.php");

	$alert = "";

	if (isset($_POST["rua"]))
	{
		$insert = $service->call('empresa.insert', array($_POST["nome_usuario"],$_POST["email"],$_POST["senha"],$_POST["razao_social"],$_POST["nome_fantasia"],$_POST["cnpj"],$_POST["celular"],$_POST["descricao"],$_POST["rua"],$_POST["num"],$_POST["complemento"],$_POST["cep"],$_POST["bairro"],$_POST["cidade_id"],$_POST["latitude"],$_POST["longitude"],$_POST["telefone"]));
		if($insert == 0)
			$alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>CNPJ inválido!</b> Digite novamente.</span></div>';
		elseif($insert == -1)
			$alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Email ou CNPJ já cadastrados!</b> Reveja seus dados.</span></div>';
		elseif($insert == -2)
			$alert = '<div class="alert alert-danger" style="margin-top: 10px;margin-bottom:-40px;"><span><b>Endereço inválido!</b> Reveja seus dados.</span></div>';
		else
			header("location: aprovacao.php?id=$insert");
	}
?>
<!doctype html>
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
					<?php echo $alert; ?>
		            <!--      Wizard container        -->
		            <div class="wizard-container" style="margin-top:50px">

		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    <form action="#" id="frm" method="post">
		                    	<input type="hidden" name="latitude" id="latitude" value="e">
		                    	<input type="hidden" name="longitude" id="longitude" value="e">

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
												Informações
											</a>
										</li>
			                            <li>
											<a href="#account" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-settings"></i>
												</div>
												Cidade
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
											<div class="col-sm-6">
												<div class="form-group">
													<label>Razão Social/Nome <small>(obrigatório)</small></label>
													<input type="text" class="form-control" name="razao_social" id="razao_social" placeholder="Digite a razão social" maxlength="20" required>
												</div>
												<div class="form-group">
													<label>Nome Fantasia <small></small></label>
													<input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" placeholder="Digite o nome fantasia" maxlength="20">
												</div>
												<div class="form-group">
													<label>CNPJ/CPF <small>(obrigatório)</small></label>
													<input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="Informe seu CNPJ" maxlength="18" required>
												</div>
												<div class="form-group">
													<label>Telefone pessoal <small>(obrigatório)</small></label>
													<input type="text" class="form-control" name="celular" id="celular" placeholder="Informe um telefone pessoal para contato" maxlength="14" required>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Nome de usuário <small>(obrigatório)</small></label>
													<input type="text" class="form-control" name="nome_usuario" id="nome_usuario" placeholder="Informe o nome de usuário" maxlength="40" required>
												</div>
												<div class="form-group">
													<label>Email <small>(obrigatório)</small></label>
													<input type="email" class="form-control" name="email" id="email" placeholder="informe um email" maxlength="40" required>
												</div>
												<div class="form-group">
													<label>Senha <small>(obrigatório)</small></label>
													<input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" maxlength="12" required>
												</div>
												<div class="form-group">
													<label>Digite a senha novamente <small>(obrigatório)</small></label>
													<input name="senha1" id="senha1" type="password" class="form-control" placeholder="Digite novamente sua senha" maxlength="12" required>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label>Descrição <small>(obrigatório)</small></label>
													<textarea class="form-control" name="descricao" id="descricao" placeholder="Insira aqui uma breve descrição da sua empresa, produtos e serviços prestados."  required></textarea>
												</div>
											</div>
										</div>
		                            </div>
		                            <div class="tab-pane" id="account">
		                                <div class="row">
										<?php
											$json = $service->call("select_cidades",array());
											$cidade = json_decode($json);
											for($i=0;$i<count($cidade);$i++)
											{
												$first = "checked";
												$class_first = 'class="choice active"';
												if($i > 0)
												{
													$first = "";
													$class_first = 'class="choice"';
												}
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
											echo '<input type="hidden" name="cidade" id="cidade" value="'.$cidade[0]->nome.'"><input type="hidden" name="uf" id="uf" value="'.$cidade[0]->uf.'">'
										?>
										</div>
		                            </div>
		                            <div class="tab-pane" id="address">
		                                <div class="row">
		                                    <div class="col-sm-12">
		                                    </div>
											<div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>Bairro <small>(obrigatório)</small></label>
		                                            <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Centro" maxlength="30" required>
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                    	<div class="form-group">
		                                            <label>Rua <small>(obrigatório)</small></label>
		                                            <input type="text" class="form-control" name="rua" id="rua" placeholder="Avenida Paulista" maxlength="60" required>
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                    	<div class="form-group">
		                                            <label>CEP <small>(obrigatório)</small></label>
		                                            <input type="text" class="form-control" name="cep" id="cep" placeholder="89.567-231" maxlength="10" required>
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                        <div class="form-group">
		                                            <label>Número <small>(obrigatório)</small></label>
		                                            <input type="number" class="form-control" name="num" id="num" maxlength="
		                                            5" placeholder="242" required>
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                    	<div class="form-group">
		                                            <label>Complemento</label>
		                                            <input type="text" class="form-control" name="complemento" id="complemento" maxlength="20" placeholder="Próx. à escola">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-6">
		                                    	<div class="form-group">
		                                            <label>Telefone do estabelecimento </label>
		                                            <input type="text" class="form-control" name="telefone" id="telefone" maxlength="14" placeholder="Informe o telefone do estabelecimento">
		                                        </div>
		                                    </div>
										</div>
		                            </div>
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Próximo' />
		                                <a onclick="codeAddress();" class='btn btn-finish btn-fill btn-warning btn-wd' name='concluir'>Concluir</a>
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

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
    <script src="assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

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
		   $("#cep").mask("99.999-999");
		});

    </script>

</html>
