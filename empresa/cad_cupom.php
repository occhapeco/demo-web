<?php
    require_once("permissao.php");
    
    $page = basename(__FILE__, '.php');
    require_once("../conectar_service.php");

    function img_resize($target,$newcopy,$ext,$w=720,$h=480)
    {
        list($w_orig, $h_orig) = getimagesize($target);
        $scale_ratio = $w_orig / $h_orig;
        if (($w / $h) > $scale_ratio) {
               $w = $h * $scale_ratio;
        } else {
               $h = $w / $scale_ratio;
        }
        $img = "";
        $ext = strtolower($ext);
        if($ext =="png"){ 
            $img = imagecreatefrompng($target);
        } else { 
            $img = imagecreatefromjpeg($target);
        }
        $tci = imagecreatetruecolor($w, $h);
        // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
        imagejpeg($tci, $newcopy, 80);
    }

    $alert = "";
    
    $endereco_id = 0;
    $imagem = "";
    $titulo = "";
    $regras = "";
    $descricao = "";
    $preco_normal = "";
    $preco_cupom = "";
    $prazo = "";
    $quantidade = "";
    $pagamento = 0;
    $delivery = 0;
    $type = NULL;
    $operacao = '<input type="hidden" name="cadastrar">';

    if(isset($_POST["cadastrar"]))
    {
        $delivery = 0;
        if(isset($_POST["delivery"]))
            $delivery = 1;

        $pagamento = 0;
        if(isset($_POST["debito"]))
            $pagamento++;
        if(isset($_POST["credito"]))
            $pagamento += 2;

        $types = array();
        $data = array(
            'metodo' => 'select_tipos'
        );
        $json = call($data);
        $type = json_decode($json);
        for($i=0;$i<count($type);$i++)
            if(isset($_POST[$type[$i]->id]))
                $types[] = $type[$i]->id;

        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'insert_cupom',
            'empresa_id' => $_SESSION["empresa_id"],
            'endereco_id' => $_POST["endereco_id"],
            'imagem' => "",
            'titulo' => $_POST["titulo"],
            'regras' => $_POST["regras"],
            'descricao' => $_POST["descricao"],
            'preco_normal' => $_POST["preco_normal"],
            'preco_cupom' => $_POST["preco_cupom"],
            'prazo' => $_POST["prazo"],
            'quantidade' => $_POST["quantidade"],
            'pagamento' => $pagamento,
            'delivery' => $delivery,
            'tipos' => json_encode($types)
           
        );
        $insert = call($data);

        $caminho = $_SERVER['DOCUMENT_ROOT'].'imgs/';
        $arquivo = $_FILES['wizard-picture'];
        $extension = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
        $arquivo["name"] = 'cupom'.$insert.'.'.$extension;
        move_uploaded_file($arquivo['tmp_name'],$caminho.$arquivo["name"]);
        img_resize($caminho.$arquivo["name"],$caminho.$arquivo["name"],$extension);
        chmod($caminho.$arquivo["name"],0777);

        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'update_imagem',
            'id' => $insert,
            'imagem' => $arquivo['name']
           
        );
        $insert = call($data);

        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
        else
            header("location: index.php?aprovar=0");
    }

    if(isset($_POST["reutilizar_cad"]))
    {
        $delivery = 0;
        if(isset($_POST["delivery"]))
            $delivery = 1;

        $pagamento = 0;
        if(isset($_POST["debito"]))
            $pagamento++;
        if(isset($_POST["credito"]))
            $pagamento += 2;

        $types = array();
        $data = array(
            'metodo' => 'select_tipos'
        );
        $json = call($data);
        $type = json_decode($json);
        for($i=0;$i<count($type);$i++)
            if(isset($_POST[$type[$i]->id]))
                $types[] = $type[$i]->id;

        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'insert_cupom',
            'empresa_id' => $_SESSION["empresa_id"],
            'endereco_id' => $_POST["endereco_id"],
            'imagem' => "",
            'titulo' => $_POST["titulo"],
            'regras' => $_POST["regras"],
            'descricao' => $_POST["descricao"],
            'preco_normal' => $_POST["preco_normal"],
            'preco_cupom' => $_POST["preco_cupom"],
            'prazo' => $_POST["prazo"],
            'quantidade' => $_POST["quantidade"],
            'pagamento' => $pagamento,
            'delivery' => $delivery,
            'tipos' => json_encode($types)
        );
        $insert = call($data);

        $imagem = $_POST["imagem"];
        $caminho = $_SERVER['DOCUMENT_ROOT'].'imgs/';
        if($imagem == "upload")
        {
            $arquivo = $_FILES['wizard-picture'];
            $extension = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
            $arquivo["name"] = 'cupom'.$insert.'.'.$extension;
            move_uploaded_file($arquivo['tmp_name'],$caminho.$arquivo["name"]);
            img_resize($caminho.$arquivo["name"],$caminho.$arquivo["name"],$extension);
            chmod($caminho.$arquivo["name"],0777);
            $imagem = $arquivo['name'];
        }
        else
        {
            $extension = explode(".",$imagem);
            $new = "cupom$insert.".end($extension);
            copy($caminho.$imagem,$caminho.$new);
            chmod($caminho.$new,0777);
            $imagem = $new;
        }        

        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'update_imagem',
            'id' => $insert,
            'imagem' => $imagem
           
        );
        $insert = call($data);

        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
        else
            header("location: index.php?aprovar=0");
    }

    if(isset($_POST["editar"]))
    {
        $cupom_id = $_POST["cupom_id"];
        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'select_cupom',
            'id' => $cupom_id
           
        );
        $json = call($data);
        $cupom = json_decode($json);
        $endereco_id = $cupom->endereco_id;
        $imagem = $cupom->imagem;
        $titulo = $cupom->titulo;
        $regras = $cupom->regras;
        $descricao = $cupom->descricao;
        $preco_normal = $cupom->preco_normal;
        $preco_cupom = $cupom->preco_cupom;
        $prazo = $cupom->prazo;
        $quantidade = $cupom->quantidade;
        $pagamento = $cupom->pagamento;
        $delivery = $cupom->delivery;
        $type = $cupom->tipo;
        $operacao = '<input type="hidden" name="edit" value="'.$cupom_id.'">';
    }

    if(isset($_POST["reutilizar"]))
    {
        $cupom_id = $_POST["cupom_id"];
        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'select_cupom',
            'id' => $cupom_id
           
        );
        $json = call($data);
        $cupom = json_decode($json);
        $endereco_id = $cupom->endereco_id;
        $imagem = $cupom->imagem;
        $titulo = $cupom->titulo;
        $regras = $cupom->regras;
        $descricao = $cupom->descricao;
        $preco_normal = $cupom->preco_normal;
        $preco_cupom = $cupom->preco_cupom;
        $quantidade = $cupom->quantidade;
        $pagamento = $cupom->pagamento;
        $delivery = $cupom->delivery;
        $type = $cupom->tipo;
        $operacao = '<input type="hidden" name="reutilizar_cad" value="'.$cupom_id.'">';
    }

    if(isset($_POST["edit"]))
    {
        $imagem = $_POST["imagem"];
        $caminho = $_SERVER['DOCUMENT_ROOT'].'imgs/';

        if($_POST["imagem"] == "upload")
        {
            $arquivo = $_FILES['wizard-picture'];
            $extension = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
            $arquivo["name"] = 'cupom'.$_POST["edit"].'.'.$extension;

            unlink($caminho.'cupom'.$_POST["old_img"]);
            move_uploaded_file($arquivo['tmp_name'],$caminho.$arquivo["name"]);
            img_resize($caminho.$arquivo["name"],$caminho.$arquivo["name"],$extension);
            chmod($caminho.$arquivo["name"],0777);
            $imagem = $arquivo['name'];
        }

        $delivery = 0;
        if(isset($_POST["delivery"]))
            $delivery = 1;

        $pagamento = 0;
        if(isset($_POST["debito"]))
            $pagamento++;
        if(isset($_POST["credito"]))
            $pagamento += 2;

        $types = array();
         $data = array(
            'metodo' => 'select_tipos'
        );
        $json = call($data);
        $type = json_decode($json);
        for($i=0;$i<count($type);$i++) {
            if(isset($_POST[$type[$i]->id])){
                $types[] = $type[$i]->id;
            }
        }

        $data = array(
            'access_token' => $_SESSION["empresa_token"],
            'classe' => 'empresa',
            'metodo' => 'update_cupom',
            'id' => $_POST["edit"],
            'endereco_id' => $_POST["endereco_id"],
            'imagem' => $imagem,
            'titulo' => $_POST["titulo"],
            'regras' => $_POST["regras"],
            'descricao' => $_POST["descricao"],
            'preco_normal' => $_POST["preco_normal"],
            'preco_cupom' => $_POST["preco_cupom"],
            'prazo' => $_POST["prazo"],
            'quantidade' => $_POST["quantidade"],
            'pagamento' => $pagamento,
            'delivery' => $delivery,
            'tipos' => json_encode($types)
        );
        $insert = call($data);

        if($insert == 0)
            $alert = '<div class="alert alert-danger" style="margin: 10px 10px -20px 10px;"><span><b>Algo deu errado!</b> Reveja seus dados.</span></div>';
        else
            header("location: index.php?aprovar=0");
    }
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Clube de Ofertas</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="96x76" href="../imgs/logo/escudo_clube.png">

    <style type="text/css">
        label{
            margin-right:5px;
        }
        .icon{
            margin-top: -5px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    
    <?php 
        require_once("sidenav.php");
        require_once("topnav.php");
        echo $alert;
    ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="orange" id="wizardProfile">
                            <form action="#" method="POST" id="frm" enctype="multipart/form-data">
                                <?php echo $operacao; ?>
                                <div class="wizard-navigation">
                                    <div class="progress-with-circle">
                                         <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 83.3333%;"></div>
                                    </div>
                                    <ul class="nav nav-pills">
                                        <li class="active" style="width: 33.3333%;">
                                            <a href="#about" data-toggle="tab" aria-expanded="true">
                                                <div class="icon-circle checked">
                                                    <i class="ti-info icon"></i>
                                                </div>
                                                Informações
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#account" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-settings icon"></i>
                                                </div>
                                                Opções
                                            </a>
                                        </li>
                                        <li class="" style="width: 33.3333%;">
                                            <a href="#address" data-toggle="tab" aria-expanded="false">
                                                <div class="icon-circle checked">
                                                    <i class="ti-map icon"></i>
                                                </div>
                                                Imagem de fundo
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="about">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label>Título <small>(obrigatório)</small></label>
                                                        <input name="titulo" type="text" class="form-control" placeholder="Promoção de picanha..." aria-required="true" aria-invalid="false" value="<?php echo $titulo; ?>" required autofocus><label id="titulo-error" class="error" for="titulo" style="display: none;"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Número de ofertas <small>(obrigatório)</small></label>
                                                        <input name="quantidade" type="number" class="form-control" placeholder="50" aria-required="true" aria-invalid="false" value="<?php echo $quantidade; ?>" required><label id="quatidade-error" class="error" for="quatidade" style="display: none;"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Prazo <small>(obrigatório)</small></label>
                                                        <input name="prazo" id="prazo" type="text" class="form-control" placeholder="02/06/2017 20:00" aria-required="true" aria-invalid="false" value="<?php echo $prazo.'"'; if($prazo != "") echo "readonly"; ?> required><label id="prazo-error" class="error" for="prazo" style="display: none;"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Valor de cardápio <small>(obrigatório)</small></label>
                                                        <input name="preco_normal" id="preco_normal" type="number" class="form-control" placeholder="25,90" aria-required="true" aria-invalid="false" value="<?php echo $preco_normal; ?>" required><label id="preco_normal-error" class="error" for="preco_normal" style="display: none;"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Valor promocional <small>(obrigatório)</small></label>
                                                        <input name="preco_cupom" id="preco_cupom" type="number" class="form-control" placeholder="20,90" aria-required="true" aria-invalid="false" value="<?php echo $preco_cupom; ?>" required><label id="preco_cupom-error" class="error" for="preco_cupom" style="display: none;"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Desconto (%)</label>
                                                        <input id="desconto" type="text" class="form-control" placeholder="35%" aria-required="true" aria-invalid="false" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Descrição <small>(obrigatório)</small></label>
                                                        <textarea name="descricao" class="form-control" placeholder="Porção picanha ao molho de churrasco..." aria-required="true" aria-invalid="false" required><?php echo $descricao; ?></textarea><label id="descricao-error" class="error" for="descricao" style="display: none;"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Regras <small>(obrigatório)</small></label>
                                                        <textarea name="regras" class="form-control" placeholder="Para realmente usar o cupom, deve-se levar um amigo até o estabelecimento..." aria-required="true" aria-invalid="false" required><?php echo $regras; ?></textarea><label id="regras-error" class="error" for="regras" style="display: none;"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-sm-12  text-center"><label>Selecione o endereço desta oferta</label></div>
                                        <?php
                                            $data = array(
                                                'access_token' => $_SESSION["admin_token"],
                                                'classe' => 'empresa',
                                                'metodo' => 'select_enderecos',
                                                'empresa_id' => $_SESSION["empresa_id"]
                                            );
                                            $json = call($data);
                                            $endereco = json_decode($json);
                                            for($i=0;$i<count($endereco);$i++)
                                            {
                                                $first = "checked";
                                                $class_first = 'class="choice active"';
                                                if($endereco[$i]->id != $endereco_id && $endereco_id != 0)
                                                {
                                                    $first = "";
                                                    $class_first = 'class="choice"';
                                                }
                                                elseif($i > 0)
                                                {
                                                    $first = "";
                                                    $class_first = 'class="choice"';
                                                }
                                                $str = "<p>".$endereco[$i]->rua." nº".$endereco[$i]->num.", ".$endereco[$i]->bairro.", ".$endereco[$i]->nome." - ".$endereco[$i]->uf."</p>";
                                        ?>
                                            <div class="col-sm-3" >
                                                <label <?php echo $class_first; ?> data-toggle="wizard-radio">
                                                    <input type="radio" name="endereco_id" <?php echo 'value="'.$endereco[$i]->id.'" '.$first; ?>>
                                                    <div class="card card-radioss card-hover-effect">
                                                    <?php echo $str; ?>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="account">
                                        <div class="row">
                                            <div class="col-sm-12 text-center"><label>Escolha as opções que se aplicam a esta oferta</label></div>
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($delivery == 1) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="delivery" <?php if($delivery == 1) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-truck"></i>
                                                        <p>Delivery</p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($pagamento == 1 || $pagamento == 3) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="credito" <?php if($pagamento == 1  || $pagamento == 3) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-credit-card"></i>
                                                        <p>Cartão de crédito</p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="choice <?php if($pagamento >= 2) echo "active"; ?>" data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="debito" <?php if($pagamento >= 2) echo "checked"; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <i class="ti-credit-card"></i>
                                                        <p>Cartão de débito</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12  text-center"><label>Selecione as categorias que se aplicam nesta oferta</label></div>
                                        <?php
                                            $data = array(
                                                'metodo' => 'select_tipos',
                                            );
                                            $json = call($data);
                                            $types = json_decode($json);
                                            for($i=0;$i<count($types);$i++)
                                            {
                                                $check = "";
                                                $class_check = 'class="choice"';
                                                $selected = false;
                                                if(count($type) > 0)
                                                {
                                                    for($j=0;$j<count($type);$j++)
                                                        if($type[$j]->tipo_id == $types[$i]->id)
                                                        {
                                                            $check = "checked";
                                                            $class_check = 'class="choice active"';
                                                        }
                                                }

                                                $str = "<p>".$types[$i]->nome."</p>";
                                        ?>
                                            <div class="col-sm-2">
                                                <label <?php echo $class_check; ?> data-toggle="wizard-checkbox">
                                                    <input type="checkbox" name="<?php echo $types[$i]->id; ?>" <?php echo $check; ?>>
                                                    <div class="card card-checkboxes card-hover-effect">
                                                        <?php echo $str; ?>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-4">
                                                <input type="file" id="wizard-picture" name="wizard-picture" accept="image/x-png,image/jpeg">
                                                <label class="choice" data-toggle="wizard-radio"  onclick="$('#wizard-picture').click();">
                                                    <input type="radio" name="imagem" value="upload">
                                                    <?php
                                                        if($imagem != "")
                                                        {
                                                    ?>
                                                    <input type="hidden" name="old_img" value="<?php echo $imagem; ?>">
                                                    <?php } ?>
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img src="" class="picture-src" id="wizardPicturePreview" title="">
                                                            <p style="margin-top: 40px;">Fazer upload</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                                if($imagem != "")
                                                {
                                            ?>
                                            <div class="col-sm-4">
                                                <label class="choice active" data-toggle="wizard-radio">
                                                    <input type="radio" name="imagem" <?php echo 'value="'.$imagem.'" checked'; ?>>
                                                    <div class="card card-radios card-hover-effect">
                                                        <div class="picture">
                                                            <img <?php echo 'src="../imgs/'.$imagem.'"'; ?> class="picture-src" id="wizardPicturePreview" title="">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="col-sm-2"></div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type="button" class="btn btn-next btn-fill btn-info btn-wd disabled" name="next" value="Próximo" style="display: none;">
                                            <input type="submit" class="btn btn-finish btn-fill btn-info btn-wd" name="finish" value="Concluir" style="display: inline-block;">
                                        </div>

                                        <div class="pull-left">
                                            <input type="button" class="btn btn-previous btn-default btn-wd" name="previous" value="Anterior">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div> 
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

    <!--   Core JS Files   -->
    <script src="../assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="../assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="../assets/js/paper-dashboard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/  -->
    <script src="../assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.validate.js" type="text/javascript"></script>

    <script type="text/javascript">

        $("#wizard-picture").hide();

        jQuery(function($){
           $("#prazo").mask("99/99/9999 99:99");
        });

        setInterval(function (){
            if(document.getElementById("preco_normal").value.length != 0 && document.getElementById("preco_cupom").value.length != 0)
            {
                var desconto = ((document.getElementById("preco_normal").value-document.getElementById("preco_cupom").value) * 100)/document.getElementById("preco_normal").value;
                desconto = Math.round(desconto);
                document.getElementById("desconto").value = desconto+"%";
            }
        },10);

        jQuery.validator.addMethod("limite", function(value, element) {
            var string = value.split(" ");
            var hora = string[1].split(":");
            var data = string[0].split("/");

            var prazo = new Date(data[2],parseInt(data[1])-1,data[0],hora[0],hora[1])
            var agora = new Date();

            var dia = 24*60*60*1000;
            var dias = (prazo.getTime() - agora.getTime())/(dia);
            return dias < 4 && dias > 0;
        }, "Máximo de 4 dias!");

        $('#frm').validate({
            rules : {
                prazo : { limite: true }
            }
        });


    </script>

</html>
