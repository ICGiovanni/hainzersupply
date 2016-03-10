<?php

if($_POST){
    extract($_POST);

    switch($accion){
        case "guardarDistribuidor":
            echo "guardar distribuidor";
            print_r($_POST);
        break;

    }
    
}

?>
