<?php

#configuracion localhost
if($_SERVER['SERVER_NAME']=='localhost'){
    $ruta = 'http://localhost/hainzersupply/';
    $pathProy = dirname(__FILE__);
    $raizProy = "/hainzersupply/";
}

#ingenierosencomputacion
else if($_SERVER['SERVER_NAME']=='ingenierosencomputacion.com.mx') {
    $ruta = 'http://ingenierosencomputacion.com.mx/hainzersupply/';
    $pathProy = dirname(__FILE__);
    $raizProy = "/hainzersupply/";

}


#hainzersupply
else if($_SERVER['SERVER_NAME']=='hainzersupply.com') {
    $ruta = 'http://hainzersupply.com/new_site/control/';
    $pathProy = dirname(__FILE__);
    $raizProy = "/new_site/control/";
}

?>