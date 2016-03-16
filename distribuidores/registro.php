<?php include '../config.php';
    //archivo con las rutas especificas del proyecto

    include_once ($pathProy."models/distribuidores/class.Distribuidores.php");
    $instDistribuidores=new Distribuidores();

?>
<html>
<head>
    <title>Registro Distribuidores </title>
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
    <div class="container formRegistro">
        <h3 class="form-signin-heading">Registro de distribuidor</h3>
        <form class="form-signin" method='post' action="controllers/controllerDistribuidores.php">
            <input type="hidden" name="accion" value="guardarDistribuidor">
            <div class="panel-group" id="accordion">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Datos generales</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">

                        <?php include_once 'templates/informacion-distribuidor.php' ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Datos de facturación</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">

                        <?php include_once 'templates/direccion-facturacion.php' ?>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Dirección de envío</a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body">
                            <?php include_once 'templates/direccion-envio.php' ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Registro</button>
                </div>
            </div>

        </form>
    </div>

</body>
<script>

    $(function() {
        $('#collapse2, #collapse3').collapse("show");
    });

</script>
</html>