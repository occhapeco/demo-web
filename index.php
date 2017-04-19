<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!--  App Title  -->
	<title>Clube de Ofertas</title>
	<!--  App Description  -->
	<meta name="description" content="Clube de Ofertas"/>
	<meta charset="utf-8">
	<meta name="author" content="pixelhint.com">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="css/owl.transitions.css"/>
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css"/>
	<link rel="stylesheet" type="text/css" href="css/animate.css"/>
	<link rel="stylesheet" type="text/css" href="css/main.css"/>

	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/ajaxchimp.js"></script>
	<script type="text/javascript" src="js/scrollTo.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="js/wow.js"></script>
	<script type="text/javascript" src="js/parallax.js"></script>
	<script type="text/javascript" src="js/nicescroll.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	
	<!--  Header Section  -->
	<header>
		<div class="container">
			<div class="logo pull-left animated wow fadeInLeft">
				<a href="#hero" class="app_link"> <img src="img/logo.png" height="45px" title=""></a>
			</div>

			
			<nav class="pull-left">
				<ul class="list-unstyled">
					<li class="animated wow fadeInLeft" data-wow-delay="0s"><a href="#about">Sobre</a></li>
					<li class="animated wow fadeInLeft" data-wow-delay=".1s"><a href="#app_features">Como Funciona</a></li>
					<li class="animated wow fadeInLeft" data-wow-delay=".2s"><a href="#testimonials">Contato</a></li>
					<li class="animated wow fadeInRight" data-wow-delay=".2s" ><a class="oi" onclick="cad_empresa()" href="" >Cadastro Empresa</a></li>
					<li class="animated wow fadeInRight" style="margin-left: 5px;"  data-wow-delay=".2s"><a onclick="login()" href="" style="padding: 10px 10px;background: white; color:#337ab7;" >Login</a></li>
				</ul>
			</nav>



			<span class="burger_icon">Menu</span>
		</div>
	</header>
	<!--  End Header Section  -->






	<!--  Hero Section  -->
	<section class="hero" id="hero">
		<div class="container">
			<div class="caption">
				<h1 class="text-uppercase  animated wow fadeInLeft">Está com fome?</h1>
				<p class="text-lowercase  animated wow fadeInLeft">Venha participar do melhor clube de ofertas da sua cidade</p>

				<a href="http://itunes.apple.com" class="app_store_btn text-uppercase animated wow fadeInLeft">
					<i class="iphone_icon"></i>
					<span>Iphone App</span>
				</a>

				<a href="http://play.google.com/store/apps/details?id=br.com.clubedeofertas" class="app_store_btn text-uppercase animated wow fadeInLeft">
					<i class="android_icon"></i>
					<span>Android App</span>
				</a>
			</div>			
		</div>
	</section>
	<!--  End Hero Section  -->


	<!--  About Section  -->
	<section class="about" id="about">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center animated wow fadeInLeft">
					<div class="iphone">
						<img src="img/iphone.png" alt="" titl="">
					</div>
				</div>
				<div class="col-md-6 animated wow fadeInRight">
					<div class="features_list">
						<h1 class="text-uppercase">O seu Clube de Ofertas!</h1>
						<p>Encontre as melhores ofertas de sua cidade de uma forma simples e rápida </p>
						<ul class="list-unstyled">
							<li class="camera_icon">
								<span>Ofertas irresístiveis.</span>
							</li>
							<li class="video_icon">
								<span>Os melhores restaurantes e bares.</span>
							</li>
							<li class="eye_icon">
								<span>Exclusivo para smartphones.</span>
							</li>
							<li class="pic_icon">
								<span>Totalmente Gratuito.</span>
							</li>
							<li class="loc_icon">
								<span>Quem ganha aqui é você.</span>
							</li>
						</ul>

						<a href="#" class="app_store_btn1 text-uppercase" id="play_video" data-video="http://www.youtube.com/embed/Bm3NV3gGB2w?autoplay=1&showinfo=0">
							<i class="play_icon"></i>
							<span>Assistir vídeo</span>
						</a>
						<a href="#hero" class="app_link">Instalar App</a>
					</div>					
				</div>
			</div>
		</div>

		<div class="about_video show_video">
			<a href="" class="close_video"></a>
		</div>
	</section>
	<!--  End About Section  -->






	<!--  App Features Section  -->
	<section class="app_features" id="app_features">
		<div class="container">
			<center><p style="font-size: 40px;padding: 0px 0px 40px;font-weight: bold; font-family:'open_semibold', Helvetica, Arial, sans-serif" > Como Funciona? </p><center>
			<div class="row text-center">
				<div class="col-sm-4 col-md-4 details animated wow fadeInDown" data-wow-delay="0s">
					<img src="img/icon_oferta.png" alt="" title="">
					<h1 class="text-uppercase">Criamos o clube</h1>
					<p class="text-lowercase"> de ofertas para facilitar suas compras e ficar de olhos nas ofertas de sua cidade. Reunimos diversas empresas que oferecem produtos e serviços com grande desconto para usuários do aplicativo.</p>
				</div>
				<div class="col-sm-4 col-md-4 details animated wow fadeInDown" data-wow-delay=".1s">
					<img src="img/icon_download.png" alt="" title="">
					<h1 class="text-uppercase">O usuário faz download </h1>
					<p class="text-lowercase"> do aplicativo, de forma gratuita em seu smartphone, faz seu cadastro e passa a usufruir de uma lista de produtos e serviços com desconto de dezenas de empresas de sua cidade.</p>
				</div>
				<div class="col-sm-4 col-md-4 details animated wow fadeInDown" data-wow-delay=".2s">
					<img src="img/icon_produto.png" alt="" title="">
					<h1 class="text-uppercase">Dependendo da oferta do produto ou serviço</h1>
					<p class="text-lowercase">você pode retirar no local, consumir o produto no local ou pedir para entrega (No caso de uma pizza, por exemplo). O pagamento é feito direto para a empresa que você escolheu.
</p>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-sm-4 col-md-4 details animated wow fadeInDown" data-wow-delay="0s">
					<img src="img/icon_divulgacao.png" alt="" title="">
					<h1 class="text-uppercase">O clube de ofertas</h1>
					<p class="text-lowercase"> é apenas um meio de divulgar os produtos de uma empresa para você, cliente. Produtos e serviços com desconto, sem custo algum para o consumidor final. Você só tem vantagens.
</p>
				</div>
				<div class="col-sm-4 col-md-4 details animated wow fadeInDown" data-wow-delay=".1s">
					<img src="img/icon_app.png" alt="" title="">
					<h1 class="text-uppercase">Com o aplicativo Clube de Ofertas</h1>
					<p class="text-lowercase"> em seu smartphone e feito seu cadastro, você resgata o cupom da oferta que deseja, verifica o local e demais dados da empresa que oferta o produto e dirigi-se até o local para consumir ou retirar o produto. </p>
				</div>
				<div class="col-sm-4 col-md-4 details animated wow fadeInDown" data-wow-delay=".2s">
					<img src="img/icon_contato.png" alt="" title="">
					<h1 class="text-uppercase">Deseja anunciar seu produto</h1>
					<p class="text-lowercase"> em nosso aplicativo de descontos? Entre em contato conosco para entender como funciona a relação com nossos parceiros e fechar uma parceria de sucesso. (Contato email telefone etc).</p>
				</div>
			</div>

		</div>
	</section>
	<!--  And App Features Section  -->


	<!--  Email Subscription Section  -->
	<section class="sub_box" id="testimonials" data-wow-duration="2s">
		<div class="formulario row"> 
		<p class="cta_text animated wow fadeInDown">Utilize o formulário abaixo ou envie um e-mail para contato@clubedeofertas.net</p><hr>
		 
			<form action="" metohd="post" class="animated wow fadeIn" data-wow-duration="2s" id="submit_form">
				 <div class="col-md-6">
				
				
				<span> Nome: </span><br> 
				<input type="text" id="mc-text" placeholder="Digite seu nome"/><br>
				<span> Email: </span><br> 
				<input type="email" id="mc-text" placeholder="Digite seu email"/><br>
				<span> Telefone: </span><br> 
				<input type="text" id="mc-text" placeholder="Digite seu telefone"/><br>
				<span> Cidade: </span><br> 
				<input type="text" id="mc-text" placeholder="Digite sua cidade"/><br>
				</div>
				 <div class="col-md-6">
				<span> Mensagem: </span><br> 
				<textarea id="mc-textarea"> </textarea><br>
				
				<button type="submit" id="mc_submit">
					<i class="icon"></i>
				</button>
				</div>
			</form>
		</div>
	</section>
	<!--  End Email Subscription Section  -->






	<!--  Footer Section  -->
	<footer>


		<p class="copyright animated wow fadeIn " data-wow-duration="2s">© 2017 <a href="http://clubedeofertas.net" target="_blank"><strong>Clubedeofertas.net</strong></a> Todos Direitos Reservados</p>
		


	</footer>


	<!--  End Footer Section  -->

<script>
function cad_empresa() {
    window.location.assign("cad_empresa.php")
}
function login() {
    window.location.assign("login.php")
}
</script>
	
	
</body>
</html>