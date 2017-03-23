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
                        <p class="navbar-brand">Cadastro de cidades</p>
                    <?php
                        }
						elseif($page == "cad_categoria")
                        {
                    ?>
                        <p class="navbar-brand">Categoria de Ofertas</p>
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
                        <p class="navbar-brand">Ofertas</p>
                    <?php
                        }
                        elseif($page == "detalhes")
                        {
                    ?>
                        <p class="navbar-brand">Detalhes da Oferta</p>
                    <?php
                        }
						elseif($page == "financeiro")
                        {
                    ?>
                        <p class="navbar-brand">Financeiro</p>
                    <?php
                        }
                        elseif($page == "notificar")
                        {
                    ?>
                        <p class="navbar-brand">Notificar usuários</p>
                    <?php
                        }elseif($page == "usuarios")
                        {
                    ?>
                        <p class="navbar-brand">Usuários</p>
                    <?php
                        }
                    ?>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                       
                    </ul>

                </div>
            </div>
        </nav>