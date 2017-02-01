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
                        <p>Meus cupons</p>
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
                        <p>Meus cupons</p>
                    </a>
                </li>
			<?php
				}
                if($page == "cad_cupom")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-bookmark-alt"></i>
                        <p>Novo cupom</p>
                    </a>
                </li>
            <?php
                }
                else
                {
            ?>
                <li>
                    <a href="cad_cupom.php">
                        <i class="ti-bookmark-alt"></i>
                        <p>Novo cupom</p>
                    </a>
                </li>
            <?php
                } 
                if($page == "cad_endereco")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-map"></i>
                        <p>Novo Endereço</p>
                    </a>
                </li>
            <?php
                }
                else
                {
            ?>
                <li>
                    <a href="cad_endereco.php">
                        <i class="ti-map"></i>
                        <p>Novo Endereço</p>
                    </a>
                </li>
            <?php 
                } 
                if($page == "meus_enderecos")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-direction-alt"></i>
                        <p>Meus Endereços</p>
                    </a>
                </li>
            <?php
                }
                else
                {
            ?>
                <li>
                    <a href="meus_enderecos.php">
                        <i class="ti-direction-alt"></i>
                        <p>Meus Endereços</p>
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