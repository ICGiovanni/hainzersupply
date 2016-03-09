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
                <th>Id Distribuidor</th>
                <th>Nombre Distribuidor</th>
                <th>Representante</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <td>123</td>
                <td>Distribuidor Reconocido S.A de C.V</td>
                <td>Juan Garcia Lopez</td>
                <td>1234567890</td>
                <td>correo@dominio.com</td>
                <td><button type="button" class="btn btn-info">+ Info</button></td>
                <td><button type="button" class="btn btn-danger">Borrar</button></td>
            </tr>
            <tr>
                <td>1234</td>
                <td>Distribuidor S.C</td>
                <td>Hector Diaz Salazar</td>
                <td>1234567890</td>
                <td>correo2@dominio.com</td>
                <td><button type="button" class="btn btn-info">+ Info</button></td>
                <td><button type="button" class="btn btn-danger">Borrar</button></td>
            </tr>
        </thead>
    </table>
</div>

</body>

</html>