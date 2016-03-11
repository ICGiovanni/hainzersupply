<?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    $proyecto = 'hainzersupply';
    include_once ($path."/".$proyecto."/models/distribuidores/class.Distribuidores.php");
    $instDistribuidores=new Distribuidores();

    $listaDistribuidores = $instDistribuidores->listaDistribuidores();
?>

<html>

<head>
    <title>Listado Distribuidores </title>
    <meta charset="UTF-8">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/styles-distribuidores.css">

    <script src="js/funciones-distribuidor.js"></script>

</head>

<body>
<?php include_once('../menu.php')?>
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
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($listaDistribuidores as $distribuidor){
                    echo "<tr>";
                        echo "<td>".$distribuidor['idDistribuidor']."</td>";
                        echo "<td>".$distribuidor['nombre']."</td>";
                        echo "<td>".$distribuidor['representante']."</td>";
                        echo "<td>".$distribuidor['telefono']."</td>";
                        echo "<td>".$distribuidor['celular']."</td>";
                        echo "<td>".$distribuidor['correoElectronico']."</td>";
                        echo "<td><button type='button' class='btn btn-info'>+ Info</button></td>";
                        echo "<td><button type='button' class='btn btn-danger'>Desactivar</button></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

</body>

</html>