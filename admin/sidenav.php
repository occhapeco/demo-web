<div class="sidebar" data-background-color="white" data-active-color="danger">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="index.php" class="simple-text">
                    <img src="../imgs/logo/escudo_corel.png" height="45px" width="200px">
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
                        <p>Categorias de cupom</p>
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
                        <p>Categorias de cupom</p>
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
                        <p>Cupons</p>
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
                        <p>Cupons</p>
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