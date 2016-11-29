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
                        <p class="navbar-brand">Estatísticas</p>
                    <?php
                        }
                        elseif($page == "cad_cupom")
                        {
                    ?>
                        <p class="navbar-brand">Cadastro de cupom</p>
                    <?php
                        }
                        elseif($page == "cupons")
                        {
                    ?>
                        <p class="navbar-brand">Meus cupons</p>
                    <?php
                        }
                        elseif($page == "config")
                        {
                    ?>
                        <p class="navbar-brand">Configurações</p>
                    <?php
                        }
                    ?>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
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
                            <a href="config.php">
                                <i class="ti-settings"></i>
                                <p>Configurações</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>