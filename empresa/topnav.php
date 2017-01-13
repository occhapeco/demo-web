<?php
    $num = $service->call('empresa.select_nao_visualizadas', array($_SESSION["id"]));
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
                        if($page == "index")
                        {
                    ?>
                        <p class="navbar-brand">Meus cupons</p>
                    <?php
                        }
                        elseif($page == "cad_cupom")
                        {
                    ?>
                        <p class="navbar-brand">Cadastro de cupom</p>
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
                        <p class="navbar-brand">Detalhes do cupom</p>
                    <?php
                        }
                        elseif($page == "notificacoes")
                        {
                    ?>
                        <p class="navbar-brand">Central de notificações</p>
                    <?php
                        }
                    ?>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                              <a href="notificacoes.php">
                                    <i class="ti-bell"></i>
                                    <p class="notification"><?php $num ?></p>
                                    <p>Notificações</p>
                              </a>
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