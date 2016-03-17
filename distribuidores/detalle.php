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

    <style type="text/css">
        h4{
            background-color: #2f96b4;
            padding: 7px;
            color: #FFF;
            margin-bottom: -1px;
        }
    </style>

</head>
<body>
    <?php include_once('../menu.php')?>

    <div class="container">
        <div class="row">
            <h3 class="form-signin-heading">Información de distribuidor</h3>
            <div class="col-md-4">
                <h4 class="form-signin-heading">Datos de contacto</h4>
                <?php
                    $infoDistribuidor = $instDistribuidores->getInfoDistribuidor($idDistribuidor);
                    $facturacionDistribuidor = $instDistribuidores->getFacturacionDistribuidor($idDistribuidor);
                    $envioDistribuidor = $instDistribuidores->getEnvioDistribuidor($idDistribuidor);
                ?>
                <ul class="list-group">
                    <li class='list-group-item'>
                        <b>Nombre:</b><br />
                        <?php echo $infoDistribuidor['nombre']?>
                    </li>
                    <li class='list-group-item'>
                        <b>Representante:</b><br />
                        <?php echo $infoDistribuidor['representante']?>
                    </li>
                    <li class='list-group-item'>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Tel. oficina:</b><br />
                                <?php echo $infoDistribuidor['telefono']?>
                            </div>
                            <div class="col-md-6">
                                <b>Celular:</b><br />
                                <?php echo $infoDistribuidor['celular']?>
                            </div>
                        </div>
                    </li>
                    <li class='list-group-item'>
                        <b>Correo Electronico:</b><br />
                        <?php echo $infoDistribuidor['correoElectronico']?>
                    </li>
                    <li class='list-group-item' style="text-align: right">
                        <button type='button' class='btn btn-info btn-detalle-dist' idDist='<?php echo $idDistribuidor?>'>Editar</button>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="panel-header">Datos de facturación</h4>
                <ul class="list-group">
                <?php
                foreach($facturacionDistribuidor as $factura) {
                ?>
                    <li style="list-style-type: none;">
                        <ul class='list-group'>
                            <li class="list-group-item">
                                <?php echo $factura['rfc'] ?><br />
                                <?php echo $factura['razonSocial'] ?><br />
                                <?php echo $factura['calle'] ?><br />
                                <?php echo $factura['numExt']."&nbsp;".$factura['numInt']."&nbsp; C.P. ".$factura['codigoPostal'] ?><br />
                                <?php echo $factura['colonia'] ?><br />
                                <?php echo $factura['delegacion'] ?><br />
                                <?php echo $factura['estado']."&nbsp;, ".$factura['pais']?><br />
                            </li>
                            <li class="list-group-item" style="text-align: right">
                                <button type='button' class='btn btn-info btn-detalle-dist' idDist='<?php echo $factura['idDistribuidorFactura']?>'>Editar</button>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                </ul>

            </div>
            <div class="col-md-4">
                <h4 class="form-signin-heading">Datos de envío</h4>
                <ul class="list-group">
                    <?php
                    foreach($envioDistribuidor as $envio) {
                        ?>
                        <li style="list-style-type: none;">
                            <ul class='list-group'>
                                <li class="list-group-item">

                                    <?php echo $envio['calle'] ?><br />
                                    <?php echo $envio['numExt']."&nbsp;".$envio['numInt']."&nbsp; C.P. ".$envio['codigoPostal'] ?><br />
                                    <?php echo $envio['colonia'] ?><br />
                                    <?php echo $envio['delegacion'] ?><br />
                                    <?php echo $envio['estado']."&nbsp;, ".$envio['pais']?><br />
                                </li>
                                <li class="list-group-item" style="text-align: right">
                                    <button type='button' class='btn btn-info btn-detalle-dist' idDist='<?php echo $envio['idDireccion']?>'>Editar</button>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>