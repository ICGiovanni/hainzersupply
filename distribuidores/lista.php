<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'login/session.php';
    include_once($_SERVER['REDIRECT_PATH_CONFIG'].'config.php');

    include_once ($pathProy."/models/distribuidores/class.Distribuidores.php");
    $instDistribuidores=new Distribuidores();

    $listaDistribuidores = $instDistribuidores->listaDistribuidores();
?>

<html>

<head>
    <title>Listado Distribuidores <?php echo $raizProy?></title>
    <meta charset="UTF-8">

    <script src="<?php echo $raizProy?>distribuidores/js/jquery.min.js"></script>
    <script src="<?php echo $raizProy?>distribuidores/js/funciones-distribuidor.js"></script>

</head>

<body>
<?php include_once($_SERVER['REDIRECT_PATH_CONFIG'].'menu.php')?>
<div class="container">
    <h3 class="form-signin-heading">Listado de distribuidores</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre Distribuidor</th>
                <th>Representante</th>
                <th>Telefono</th>
                <th>Celular</th>
                <th>Correo</th>
                <th>Nivel</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <form id="infoDistribuidor" action="detalle.php" method="post">
                <input type="hidden" name="idDistribuidor" id="idDistribuidor" value="" />
                <input type="submit" name="enviar" value="" style="display: none" />
            </form>
            <?php
                foreach($listaDistribuidores as $distribuidor){
                    echo "<tr>";
                        echo "<td>".$distribuidor['idDistribuidor']."</td>";
                        echo "<td>".$distribuidor['nombre']."</td>";
                        echo "<td>".$distribuidor['representante']."</td>";
                        echo "<td>".$distribuidor['telefono']."</td>";
                        echo "<td>".$distribuidor['celular']."</td>";
                        echo "<td>".$distribuidor['correoElectronico']."</td>";
                        echo "<td>".$distribuidor['descripcion']."</td>";
                        echo "<td><button type='button' class='btn btn-info btn-info-dist' idform='".$distribuidor['idDistribuidor']."'>+ Info</button></td>";
                        echo "<td><button type='button' class='btn btn-danger btn-del-dist' idform='".$distribuidor['idDistribuidor']."'>Desactivar</button></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

</body>

</html>