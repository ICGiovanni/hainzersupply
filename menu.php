<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';

    if(stristr($_SERVER['PHP_SELF'],'distribuidores')) {
?>
        <script src="<?php echo $raizProy?>distribuidores/js/jquery.min.js"></script>
        <script src="<?php echo $raizProy ?>distribuidores/js/bootstrap.min.js"></script>
<?php
    }
?>

<link rel="stylesheet" href="<?php echo $raizProy?>distribuidores/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $raizProy?>distribuidores/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $raizProy?>css/buttons.css">

<style type="text/css">
    .container{
        width: 75%;
    }
</style>

    <div class="container" id="menu">
        <ul class="nav navbar-nav ">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Usuarios <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $ruta?>login/sign_up.php">Registro</a></li>
                    <li><a href="<?php echo $ruta?>login/user_list.php">Lista</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Distribuidores <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $ruta?>distribuidores/registro.php">Registro</a></li>
                    <li><a href="<?php echo $ruta?>distribuidores/lista.php">Lista</a></li>
                </ul>
            </li>

            <li >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Inventarios <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $ruta?>excel">importar</a></li>
                    <li><a href="<?php echo $ruta?>excel/images.php">subir imagenes</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Pedidos <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $ruta?>orders/index.php">nuevo</a></li>
                    <li><a href="<?php echo $ruta?>orders/order_list.php">Lista</a></li>
                </ul>
            </li>

            <li>
                <a href="<?php echo $ruta?>login/logout.php">
                    Salir
                </a>
            </li>
        </ul>
    </div>
