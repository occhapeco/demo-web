<div class="sidebar" data-background-color="white" data-active-color="danger">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="index.php" class="simple-text">
                    Nome
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