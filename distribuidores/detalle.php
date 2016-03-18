<?php session_start();
include '../config.php';

include_once ($pathProy."/models/distribuidores/class.Distribuidores.php");
$instDistribuidores=new Distribuidores();
if($_POST){
    extract($_POST);
}
else if(isset($_GET['id'])){
    $idDistribuidor = base64_decode($_GET['id']);
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

    <script src="<?php echo $raizProy?>distribuidores/js/jquery.min.js"></script>

    <link rel="stylesheet" href="<?php echo $raizProy?>distribuidores/css/styles-distribuidores.css">
    <script src="<?php echo $raizProy?>distribuidores/js/funciones-distribuidor.js"></script>

    <style type="text/css">
        .row h4{
            background-color: #2f96b4;
            padding: 7px;
            color: #FFF;
            margin-bottom: -1px;
        }
        #mismaDireccion{
            display: none;
        }
    </style>

</head>
<body>
    <?php include_once('../menu.php')?>

    <div class="container">
        <div class="row">
            <h3 class="form-signin-heading">Información de distribuidor</h3>
            <div class="col-md-4">
                <h4 class="form-signin-heading" style="padding: 14px">Datos de contacto</h4>
                <?php
                    $infoDistribuidor = $instDistribuidores->getInfoDistribuidor($idDistribuidor);
                    $facturacionDistribuidor = $instDistribuidores->getFacturacionDistribuidor($idDistribuidor);
                    $envioDistribuidor = $instDistribuidores->getEnvioDistribuidor($idDistribuidor);
                ?>
                <ul class="list-group">
                    <li class='list-group-item'>
                        <b>Nombre:</b><br />
                        <span class="nombre"><?php echo $infoDistribuidor['nombre']?></span>
                    </li>
                    <li class='list-group-item'>
                        <b>Representante:</b><br />
                        <span class="representante"><?php echo $infoDistribuidor['representante']?></span>
                    </li>
                    <li class='list-group-item'>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Tel. oficina:</b><br />
                                <span class="telefono"><?php echo $infoDistribuidor['telefono']?></span>
                            </div>
                            <div class="col-md-6">
                                <b>Celular:</b><br />
                                <span class="celular"><?php echo $infoDistribuidor['celular']?></span>
                            </div>
                        </div>
                    </li>
                    <li class='list-group-item'>
                        <b>Correo Electronico:</b><br />
                        <span class="correoElectronico"><?php echo $infoDistribuidor['correoElectronico']?></span>
                    </li>
                    <li class='list-group-item'>
                        <b>Nivel:</b><br />
                        <span class="nivel" style="display: none"><?php echo $infoDistribuidor['idNivel']?></span><?php echo $infoDistribuidor['descripcion']?>
                    </li>
                    <li class='list-group-item' style="text-align: right">
                        <button type='button' class='btn btn-info btn-editar-dist' data-id='<?php echo $idDistribuidor?>' data-toggle="modal" data-target="#myModal3">Editar</button>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="panel-header">
                    <div class="row">
                        <div class="col-md-7" style="padding-top: 7px">
                            Datos de facturación
                        </div>
                        <div class="col-md-5 text-right">
                            <button type="button" class="btn btn-warning btn-agregar-factura" data-toggle="modal" data-target="#myModal2">
                                Agregar
                            </button>
                        </div>
                    </div>
                </h4>
                <ul class="list-group">
                <?php
                foreach($facturacionDistribuidor as $factura) {
                ?>
                    <li style="list-style-type: none;">
                        <ul class='list-group'>
                            <li class="list-group-item" id="factura_<?php echo $factura['idDistribuidorFactura'] ?>">
                                <span class="rfc"><?php echo $factura['rfc'] ?></span><br />
                                <span class="razonSocial"><?php echo $factura['razonSocial'] ?></span><br />
                                <span class="calle"><?php echo $factura['calle'] ?></span><br />
                                <span class="numExt"><?php echo $factura['numExt']?></span>&nbsp;<span class="numInt"><?php echo $factura['numInt']?></span>&nbsp; C.P. <span class="cp"><?php echo $factura['codigoPostal'] ?></span><br />
                                <span class="colonia"><?php echo $factura['colonia'] ?></span><br />
                                <span class="delegacion"><?php echo $factura['delegacion'] ?></span><br />
                                <span class="estado"><?php echo $factura['estado']?></span>&nbsp;, <span class="pais"><?php echo $factura['pais']?></span><br />
                            </li>
                            <li class="list-group-item" style="text-align: right">
                                <button type='button' class='btn btn-info btn-editar-factura' data-toggle="modal" data-target="#myModal2" data-id="<?php echo $factura['idDistribuidorFactura'] ?>" data-idDireccion="<?php echo $factura['idDireccion'] ?>">Editar</button>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                </ul>

            </div>
            <div class="col-md-4">
                <h4 class="form-signin-heading">
                    <div class="row">
                        <div class="col-md-6" style="padding-top: 7px">
                            Datos de envío
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-warning btn-agregar-envio" data-toggle="modal" data-target="#myModal">
                                Agregar
                            </button>
                        </div>
                    </div>
                </h4>
                <ul class="list-group">
                    <?php
                    foreach($envioDistribuidor as $envio) {
                        ?>
                        <li style="list-style-type: none;">
                            <ul class='list-group'>
                                <li class="list-group-item" id="envio_<?php echo $envio['idDireccion'] ?>">

                                    <span class="calle"><?php echo $envio['calle'] ?></span><br />
                                    <span class="numExt"><?php echo $envio['numExt']?></span>&nbsp;<span class="numInt"><?php echo $envio['numInt']?></span>&nbsp; C.P. <span class="cp"><?php echo $envio['codigoPostal'] ?></span><br />
                                    <span class="colonia"><?php echo $envio['colonia'] ?></span><br />
                                    <span class="delegacion"><?php echo $envio['delegacion'] ?></span><br />
                                    <span class="estado"><?php echo $envio['estado']?></span>&nbsp;, <span class="pais"><?php echo $envio['pais']?></span><br />
                                </li>
                                <li class="list-group-item" style="text-align: right">
                                    <button type='button' class='btn btn-info btn-editar-envio' data-idDireccion='<?php echo $envio['idDireccion']?>' data-toggle="modal" data-target="#myModal">Editar</button>
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

    <!-- Modal agregar direccion envio-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">dirección de envío</h4>
                </div>
                <div class="modal-body form-signin">
                    <form name="form-envio" id="form-envio" action="controllers/controllerDistribuidores.php" method="post">
                        <input type="hidden" id="accion-envio" name="accion" value="" />
                        <input type="hidden" name="idDistribuidor" value="<?php echo $idDistribuidor?>" />
                        <input type="hidden" id="idDireccion" name="idDireccion" value="" />

                        <?php include_once 'templates/direccion-envio.php';?>

                        <input type="submit" name="" value="" style="display: none;"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="AccionEnvio">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal agregar facturacion-->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">dirección de facturación</h4>
                </div>
                <div class="modal-body form-signin">
                    <form name="envio-facturacion" id="envio-facturacion" action="controllers/controllerDistribuidores.php" method="post">
                        <input type="hidden" id="accion-facturacion" name="accion" value="" />
                        <input type="hidden" name="idDistribuidor" value="<?php echo $idDistribuidor?>" />
                        <input type="hidden" id="idDistribuidorFactura" name="idDistribuidorFactura" value="" />
                        <input type="hidden" id="idDireccionFactura" name="idDireccionFactura" value="" />

                        <?php include_once 'templates/direccion-facturacion.php';?>

                        <input type="submit" name="" value="" style="display: none;"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="AccionFacturacion">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar informacion contacto-->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">datos de contacto</h4>
                </div>
                <div class="modal-body form-signin">
                    <form name="form-contacto" id="form-contacto" action="controllers/controllerDistribuidores.php" method="post">
                        <input type="hidden" id="accion-distribuidor" name="accion" value="editarDistribuidor" />
                        <input type="hidden" name="idDistribuidor" value="<?php echo $idDistribuidor?>" />

                        <?php include_once 'templates/informacion-distribuidor.php';?>

                        <input type="submit" name="" value="" style="display: none;"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="actualizar-distribuidor">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>