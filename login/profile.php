<?php
    include_once('session.php');

    //para el caso de distribuidores
    if($login_session['profile_id']==2){

        $infoDistribuidor = $inslogin->getUserDistribuidor($login_session['login_id']);

        if(!$infoDistribuidor){
            header('location: '.$raizProy.'distribuidores/registro.php');
        }
        else{
            $_SESSION['login_user']['idDistribuidor']=$infoDistribuidor['idDistribuidor'];
            $_SESSION['login_user']['nombre']=$infoDistribuidor['nombre'];
            $_SESSION['login_user']['representante']=$infoDistribuidor['representante'];
            $_SESSION['login_user']['idNivel']=$infoDistribuidor['idNivel'];
            $_SESSION['login_user']['correoElectronico']=$infoDistribuidor['correoElectronico'];
            header('location: '.$raizProy.'distribuidores/detalle.php');
        }
    }

    //para el caso de root
    else if($login_session['profile_id']==3){
        header('location: '.$raizProy.'login/user_list.php');
    }

    //para el caso de administrador
    else if($login_session['profile_id']==1){
        header('location: '.$raizProy.'orders/administrar.php');
    }

?>