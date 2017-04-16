<?php
	$data = array(
		'access_token' => $_SESSION["empresa_token"],
		'classe' => 'empresa',
		'metodo' => 'select_nao_visualizadas',
		'empresa_id' => $_SESSION["empresa_id"]
	);
    $num = call($data);
?>
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
                    <?php 
                        if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] > 0)
                        {
                    ?>
                    <a href="../admin/empresa.php" class="btn btn-primary btn-danger" name="painel" style="margin-left:10px;font-size: 14px"><i class="ti-arrow-left"></i> Voltar Admin</a>
                    <?php
                        }
                        elseif($page == "index")
                        {
                    ?>
                        <p class="navbar-brand">Minhas Ofertas</p>
                    <?php
                        }
                        elseif($page == "cad_cupom")
                        {
                    ?>
                        <p class="navbar-brand">Cadastro de ofertas</p>
                    <?php
                        }
						elseif($page == "config")
                        {
                    ?>
                        <p class="navbar-brand">Configurações</p>
                    <?php
                        }
                        elseif($page == "endereco")
                        {
                    ?>
                        <p class="navbar-brand">Novo endereço</p>
                    <?php
                        }
                        elseif($page == "meus_enderecos")
                        {
                    ?>
                        <p class="navbar-brand">Meus endereços</p>
                    <?php
                        }
                        elseif($page == "cupom")
                        {
                    ?>
                        <p class="navbar-brand">Detalhes da oferta</p>
                    <?php
                        }
                        elseif($page == "notificacoes")
                        {
                    ?>
                        <p class="navbar-brand">Central de notificações</p>
                    <?php
                        }
					elseif($page == "financeiro")
                        {
                    ?>
                        <p class="navbar-brand">Financeiro</p>
                    <?php
                        }
                    ?>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
						<?php
							if($num > 0)
							{
						?>
                              <a href="notificacoes.php">
                                    <i class="ti-bell" style="color:#F5A217"></i>
                                    <p class="notification" style="color:#F5A217"><?php echo $num ?></p>
                                    <p style="color:#F5A217">Notificações</p>
                              </a>
						<?php
							}
							else
							{
						?>
                              <a href="notificacoes.php">
                                    <i class="ti-bell"></i>
                                    <p class="notification"></p>
                                    <p>Notificações</p>
                              </a>
						<?php
							}	
						?>
                        </li>
                        <li>
                            <a href="config.php">
                                <i class="ti-settings"></i>
                                <p>Configurações</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>