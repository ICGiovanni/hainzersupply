<?php session_start();
include '../config.php';

include_once ($pathProy."/models/distribuidores/class.Distribuidores.php");
$instDistribuidores=new Distribuidores();
if($_POST){
    extract($_POST);
}
else{

    if(isset($_SESSION['idDistribuidor'])){
        $idDistribuidor = $_SESSION['idDistribuidor'];
    }else{
        header("location: registro.php");
    }
}

?>

<html>

<head>
    <title>Información de distribuidor</title>
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
        <div class="row">
            <h3 class="form-signin-heading">Información de distribuidor</h3>
            <div class="col-md-4">
                <h4 class="form-signin-heading">Información de contacto</h4>
                <?php
                    $infoDistribuidor = $instDistribuidores->getInfoDistribuidor($idDistribuidor);
                    //print_r($infoDistribuidor);
                ?>
                <table class="table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <b>Nombre:</b><br />
                                <?php echo $infoDistribuidor['nombre']?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b>Representante:</b><br />
                                <?php echo $infoDistribuidor['representante']?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Tel. oficina:</b><br />
                                <?php echo $infoDistribuidor['telefono']?>
                            </td>
                            <td><b>Celular:</b><br />
                                <?php echo $infoDistribuidor['celular']?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Correo Electronico:</b><br />
                                <?php echo $infoDistribuidor['correoElectronico']?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="right"><button type='button' class='btn btn-info btn-detalle-dist' idDist='<?php echo $infoDistribuidor['correoElectronico']?>'>Editar</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-md-4">
                <h4 class="form-signin-heading">Facturación</h4>

            </div>
            <div class="col-md-4">
                <h4 class="form-signin-heading">Envío</h4>
            </div>
        </div>
    </div>

</body>
</html>