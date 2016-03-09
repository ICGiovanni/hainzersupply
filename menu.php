<?php $ruta = 'http://hainzersupply.com/new_site/control/';?>

    <script src="distribuidores/js/jquery.min.js"></script>
    <script src="distribuidores/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="distribuidores/css/bootstrap.min.css">
    <link rel="stylesheet" href="distribuidores/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="distribuidores/css/styles-distribuidores.css">

<div class="container" style="margin-bottom:50px">
    <ul class="nav navbar-nav navbar navbar-default navbar-fixed-top">
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
                Invetarios <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $ruta?>excel">importar</a></li>
                <li><a href="<?php echo $ruta?>excel/images.html">subir imagenes</a></li>
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


