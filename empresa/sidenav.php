<div class="sidebar" data-background-color="white" data-active-color="warning">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="index.php" class="simple-text">
                    <img src="../imgs/logo/escudo_corel.png" height="45px" width="220px">
                </a>
            </div>

            <ul class="nav">
            <?php
                if($page == "index")
                {
            ?>
                <li class="active">
                    <a href="#">
                        <i class="ti-panel"></i>
                        <p>Estatísticas</p>
                    </a>
                </li>
            <?php
                }
                else
                {
            ?>
                <li>
                    <a href="index.php">
                        <i class="ti-panel"></i>
                        <p>Estatísticas</p>
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
                if($page == "meus_cupons")
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
                    <a href="meus_cupons.php">
                        <i class="ti-layers-alt"></i>
                        <p>Meus cupons</p>
                    </a>
                </li>
            <?php } 
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