<?php

if($_POST){
    extract($_POST);

    $path = $_SERVER['DOCUMENT_ROOT'];
    $proyecto = 'hainzersupply';
    include_once ($path."/".$proyecto."/models/distribuidores/class.Distribuidores.php");

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

    }
    
}

?>
