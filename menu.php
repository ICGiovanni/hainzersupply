<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';

    if(stristr($_SERVER['PHP_SELF'],'distribuidores') || stristr($_SERVER['PHP_SELF'],'login') || stristr($_SERVER['PHP_SELF'],'incentivos')) {
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

    <div class="container" id="menu" <?php if(stristr($_SERVER['PHP_SELF'],'orders/index.php')) echo'style="width: 100%"'?> >
        <ul class="nav navbar-nav ">

            <?php
            if($_SESSION['login_user']['profile_id']=='3') {
            ?>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Usuarios <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $ruta ?>login/sign_up.php">Registro</a></li>
                        <li><a href="<?php echo $ruta ?>login/user_list.php">Lista</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Distribuidores <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $ruta ?>distribuidores/registro.php">Registro</a></li>
                        <li><a href="<?php echo $ruta ?>distribuidores/lista.php">Lista</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Inventarios <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $ruta ?>excel/index.php">Importar</a></li>
                        <li><a href="<?php echo $ruta ?>excel/images.php">Subir imagenes</a></li>
                        <li><a href="<?php echo $ruta ?>excel/showlog.php">Log</a></li>
                        <li><a href="<?php echo $ruta ?>orders/administrar.php">Administrar</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Pedidos <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $ruta ?>orders/index.php">Nuevo</a></li>
                        <li><a href="<?php echo $ruta ?>orders/order_list.php">Lista</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $ruta?>incentivos/index.php">
                        Incentivos
                    </a>
                </li>
            <?php
            }
            ?>
            <?php
                if($_SESSION['login_user']['profile_id']=='2') {
                    ?>
                    <li>
                        <a href="<?php echo $ruta ?>distribuidores/detalle.php">
                            Información
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Pedidos <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $ruta ?>orders/index.php">Nuevo</a></li>
                            <li><a href="<?php echo $ruta ?>orders/order_list.php">Lista</a></li>
                        </ul>
                    </li>
                    <?php
                }
            ?>
            <?php
                if($_SESSION['login_user']['profile_id']=='1') {
                    ?>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Inventarios <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $ruta ?>excel/index.php">Importar</a></li>
                            <li><a href="<?php echo $ruta ?>excel/images.php">Subir imagenes</a></li>
                            <li><a href="<?php echo $ruta ?>orders/administrar.php">Administrar</a></li>
                        </ul>
                    </li>
                    <?php
                }
            ?>

            <li>
                <a href="<?php echo $ruta?>login/logout.php">
                    Salir
                </a>
            </li>

        </ul>
    </div>
