<html>

<head>
    <title>Registro Distribuidores </title>
    <meta charset="UTF-8">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/styles-distribuidores.css">

</head>

<body>
    <div class="container">
        <h3 class="form-signin-heading">Registro de distribuidor</h3>
        <form class="form-signin" method='post' action="">

            <div class="panel-group" id="accordion">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Datos generales</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">

                        <?php include_once 'templates/direccion-facturacion.html'?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Dirección de facturación</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">

                        <?php include_once 'templates/direccion-facturacion.html'?>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Direccion de envio</a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body">
                            envio
                        </div>
                    </div>
                </div>

            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Registro</button>
        </form>
    </div>

</body>

</html>