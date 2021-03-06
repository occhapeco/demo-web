<div class="sidebar" data-background-color="white" data-active-color="danger">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="index.php" class="simple-text">
                    <img src="../imgs/logo/escudo_corel.png" height="45px" width="230px" class="img-responsive">
                </a>
            </div>

            <ul class="nav">
            <?php
                if($page == "index")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-layers-alt"></i>
                        <p>Requisições</p>
                    </a>
                </li>
            <?php
                }
                else
                {
            ?>
                <li>
                    <a href="index.php">
                        <i class="ti-layers-alt"></i>
                        <p>Requisições</p>
                    </a>
                </li>
            <?php
                }
				if($page == "cad_cidade")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-direction-alt"></i>
                        <p>Cidades</p>
                    </a>
                </li>
			<?php
				}
			else
                {
            ?>
                <li>
                    <a href="cad_cidade.php">
                        <i class="ti-direction-alt"></i>
                        <p>Cidades</p>
                    </a>
                </li>
            <?php
                }
			if($page == "cad_categoria")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-star"></i>
                        <p>Categorias</p>
                    </a>
                </li>
			<?php
				}
			else
                {
            ?>
                <li>
                    <a href="cad_categoria.php">
                        <i class="ti-star"></i>
                        <p>Categorias</p>
                    </a>
                </li>
            <?php
                }
			if($page == "empresa")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-home"></i>
                        <p>Empresas</p>
                    </a>
                </li>
			<?php
				}
			else
                {
            ?>
                <li>
                    <a href="empresa.php">
                        <i class="ti-home"></i>
                        <p>Empresas</p>
                    </a>
                </li>
            <?php
                }
			if($page == "cupom")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-bookmark-alt"></i>
                        <p>Ofertas</p>
                    </a>
                </li>
			<?php
				}
			else
                {
            ?>
                <li>
                    <a href="cupom.php">
                        <i class="ti-bookmark-alt"></i>
                        <p>Ofertas</p>
                    </a>
                </li>
            <?php
                }
				if($page == "financeiro")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-money"></i>
                        <p>Financeiro</p>
                    </a>
                </li>
			<?php
				}
			else
                {
            ?>
                <li>
                    <a href="financeiro.php">
                        <i class="ti-money"></i>
                        <p>Financeiro</p>
                    </a>
                </li>
            <?php
                }
                if($page == "notificar")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-announcement"></i>
                        <p>Notificar usuários</p>
                    </a>
                </li>
            <?php
                }
            else
                {
            ?>
                <li>
                    <a href="notificar.php">
                        <i class="ti-announcement"></i>
                        <p>Notificar usuários</p>
                    </a>
                </li>
            <?php
                }
                if($page == "usuarios")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-user"></i>
                        <p>Usuários</p>
                    </a>
                </li>
            <?php
                }
            else
                {
            ?>
                <li>
                    <a href="usuarios.php">
                        <i class="ti-user"></i>
                        <p>Usuários</p>
                    </a>
                </li>
            <?php
                }
            ?>
                <li>
                    <a href="../logout.php">
                        <i class="ti-arrow-left"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>