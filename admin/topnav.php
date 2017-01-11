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
                        <p class="navbar-brand">Requisições</p>
                    <?php
                        }
                        elseif($page == "cad_cidade")
                        {
                    ?>
                        <p class="navbar-brand">Cidades</p>
                    <?php
                        }
                        elseif($page == "cad_categoria")
                        {
                    ?>
                        <p class="navbar-brand">Categoria de cupom</p>
                    <?php
                        }
                        elseif($page == "empresa")
                        {
                    ?>
                        <p class="navbar-brand">Empresas</p>
                    <?php
                        }
                        elseif($page == "cupom")
                        {
                    ?>
                        <p class="navbar-brand">Cupons</p>
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
                    </ul>

                </div>
            </div>
        </nav>