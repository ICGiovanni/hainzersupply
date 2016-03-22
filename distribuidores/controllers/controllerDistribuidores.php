<?php
include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';

if($_POST){
    extract($_POST);

    include_once ($pathProy."/models/distribuidores/class.Distribuidores.php");

    $instDistribuidores = new Distribuidores();

    switch($accion){
        case "guardarDistribuidor":

            $infoDistribuidor = array(
                'nombre'=>$nombreDistribuidor,
                'representante'=>$representanteDistribuidor,
                'telefono'=>$telefonoDistribuidor,
                'celular'=>$celularDistribuidor,
                'correoElectronico'=>$emailDistribuidor,
                'idNivel'=>$nivelDistribuidor
            );
            $idDistribuidor = $instDistribuidores->insertDistribuidor($infoDistribuidor);

            $infoDireccionFacturacion = array(
                'calle'=>$calleFacturacion,
                'numExt'=>$numExtFacturacion,
                'numInt'=>$numIntFacturacion,
                'codigoPostal'=>$cpFacturacion,
                'colonia'=>$coloniaFacturacion,
                'delegacion'=>$delegacionFacturacion,
                'estado'=>$estadoFacturacion,
                'pais'=>$paisFacturacion
            );

            $idDireccionFacturacion = $instDistribuidores->insertDireccion($infoDireccionFacturacion);

            $infoFacturacion = array(
                'rfc'=>$rfc,
                'razonSocial'=>$razonSocial,
                'idDireccion'=>$idDireccionFacturacion,
                'idDistribuidor'=>$idDistribuidor
            );
            $instDistribuidores->insertFacturacion($infoFacturacion);

            $infoDireccionEnvio = array(
                'calle'=>$calleEnvio,
                'numExt'=>$numExtEnvio,
                'numInt'=>$numIntEnvio,
                'codigoPostal'=>$cpEnvio,
                'colonia'=>$coloniaEnvio,
                'delegacion'=>$delegacionEnvio,
                'estado'=>$estadoEnvio,
                'pais'=>$paisEnvio
            );

            $idDireccionEnvio = $instDistribuidores->insertDireccion($infoDireccionEnvio);

            $infoEnvio = array(
                'idDireccion'=>$idDireccionEnvio,
                'idDistribuidor'=>$idDistribuidor
            );
            $instDistribuidores->insertEnvioDistribuidor($infoEnvio);

            header("location: ../lista.php");

        break;

        case "agregarFacturacion":
            $infoDireccionFacturacion = array(
                'calle'=>$calleFacturacion,
                'numExt'=>$numExtFacturacion,
                'numInt'=>$numIntFacturacion,
                'codigoPostal'=>$cpFacturacion,
                'colonia'=>$coloniaFacturacion,
                'delegacion'=>$delegacionFacturacion,
                'estado'=>$estadoFacturacion,
                'pais'=>$paisFacturacion
            );

            $idDireccionFacturacion = $instDistribuidores->insertDireccion($infoDireccionFacturacion);

            $infoFacturacion = array(
                'rfc'=>$rfc,
                'razonSocial'=>$razonSocial,
                'idDireccion'=>$idDireccionFacturacion,
                'idDistribuidor'=>$idDistribuidor
            );
            $instDistribuidores->insertFacturacion($infoFacturacion);

            header("location: ../detalle.php?id=".base64_encode($idDistribuidor));

        break;

        case "actualizarFacturacion":
            $infoDireccionFacturacion = array(
                'calle'=>$calleFacturacion,
                'numExt'=>$numExtFacturacion,
                'numInt'=>$numIntFacturacion,
                'codigoPostal'=>$cpFacturacion,
                'colonia'=>$coloniaFacturacion,
                'delegacion'=>$delegacionFacturacion,
                'estado'=>$estadoFacturacion,
                'pais'=>$paisFacturacion,
                'idDireccion'=>$idDireccionFactura
            );

            $idDireccionFacturacion = $instDistribuidores->actualizarDireccion($infoDireccionFacturacion);

            $infoFacturacion = array(
                'rfc'=>$rfc,
                'razonSocial'=>$razonSocial,
                'idDistribuidorFactura'=>$idDistribuidorFactura,
            );
            $instDistribuidores->actualizarFacturacion($infoFacturacion);

            header("location: ../detalle.php?id=".base64_encode($idDistribuidor));

        break;

        case "agregarDirEnvio":

            $infoDireccionEnvio = array(
                'calle'=>$calleEnvio,
                'numExt'=>$numExtEnvio,
                'numInt'=>$numIntEnvio,
                'codigoPostal'=>$cpEnvio,
                'colonia'=>$coloniaEnvio,
                'delegacion'=>$delegacionEnvio,
                'estado'=>$estadoEnvio,
                'pais'=>$paisEnvio
            );

            $idDireccionEnvio = $instDistribuidores->insertDireccion($infoDireccionEnvio);

            $infoEnvio = array(
                'idDireccion'=>$idDireccionEnvio,
                'idDistribuidor'=>$idDistribuidor
            );
            $instDistribuidores->insertEnvioDistribuidor($infoEnvio);

            header("location: ../detalle.php?id=".base64_encode($idDistribuidor));

        break;

        case "editarDirEnvio":
            $infoDireccionEnvio = array(
                'calle'=>$calleEnvio,
                'numExt'=>$numExtEnvio,
                'numInt'=>$numIntEnvio,
                'codigoPostal'=>$cpEnvio,
                'colonia'=>$coloniaEnvio,
                'delegacion'=>$delegacionEnvio,
                'estado'=>$estadoEnvio,
                'pais'=>$paisEnvio,
                'idDireccion'=>$idDireccion
            );

            $instDistribuidores->actualizarDireccion($infoDireccionEnvio);

            header("location: ../detalle.php?id=".base64_encode($idDistribuidor));
        break;

        case "editarDistribuidor":
            $infoDistribuidor = array(
                'nombre'=>$nombreDistribuidor,
                'representante'=>$representanteDistribuidor,
                'telefono'=>$telefonoDistribuidor,
                'celular'=>$celularDistribuidor,
                'correoElectronico'=>$emailDistribuidor,
                'idNivel'=>$nivelDistribuidor,
                'idDistribuidor'=>$idDistribuidor
            );
            $instDistribuidores->actualizarDistribuidor($infoDistribuidor);

            header("location: ../detalle.php?id=".base64_encode($idDistribuidor));
        break;
    }
    
}

?>
