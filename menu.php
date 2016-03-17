<?php
    include 'config.php';
?>
<script src="<?php echo $path.$proyecto?>/distribuidores/js/jquery.min.js"></script>
<script src="<?php echo $path.$proyecto?>/distribuidores/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="<?php echo $path.$proyecto?>/distribuidores/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $path.$proyecto?>/distribuidores/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?php echo $path.$proyecto?>/distribuidores/css/styles-distribuidores.css">

<div class="container" style="margin-bottom:50px; padding-left: 20%">
    <ul class="nav navbar-nav navbar-default navbar-static-top-">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Usuarios <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $ruta?>login/sign_up.php">Registro</a></li>
                <li><a href="<?php echo $ruta?>login/user_list.php">Lista</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Distribuidores <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $ruta?>distribuidores/registro.php">Registro</a></li>
                <li><a href="<?php echo $ruta?>distribuidores/lista.php">Lista</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Inventarios <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $ruta?>excel">importar</a></li>
                <li><a href="<?php echo $ruta?>excel/images.php">subir imagenes</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Pedidos <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $ruta?>orders">nuevo</a></li>
                <li><a href="#">...</a></li>
            </ul>
        </li>
    </ul>
</div>