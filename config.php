<?php

#configuracion localhost
if($_SERVER['SERVER_NAME']=='localhost'){
    $ruta = 'http://localhost/hainzersupply/';
    $pathProy = dirname(__FILE__);
    $raizProy = "/hainzersupply/";

    $dbHost='localhost';
    $dbName='hainzers_control';
    $dbUser='hainzers_admin';
    $dbPass='kFJUsNO7WQ7V4waM';
}

#ingenierosencomputacion
else if($_SERVER['SERVER_NAME']=='ingenierosencomputacion.com.mx') {
    $ruta = 'http://ingenierosencomputacion.com.mx/hainzersupply/';
    $pathProy = dirname(__FILE__);
    $raizProy = "/hainzersupply/";

    $dbHost='db614036781.db.1and1.com';
    $dbName='db614036781';
    $dbUser='dbo614036781';
    $dbPass='Desarrollo2016*';

}


#hainzersupply
else if($_SERVER['SERVER_NAME']=='hainzersupply.com') {
    $ruta = 'http://hainzersupply.com/new_site/control/';
    $pathProy = dirname(__FILE__);
    $raizProy = "/new_site/control/";

    $dbHost='localhost';
    $dbName='hainzers_control';
    $dbUser='hainzers_admin';
    $dbPass='kFJUsNO7WQ7V4waM';
}

?>