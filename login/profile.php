<?php
    include_once('session.php');

    //para el caso de distribuidores
    if($login_session['profile_id']==2){

        $infoDistribuidor = $inslogin->getUserDistribuidor($login_session['login_id']);

        if(!$infoDistribuidor){
            header('location: distribuidores/registro.php');
        }
        else{
            $_SESSION['login_user']['idDistribuidor']=$infoDistribuidor['idDistribuidor'];
            $_SESSION['login_user']['nombre']=$infoDistribuidor['nombre'];
            $_SESSION['login_user']['representante']=$infoDistribuidor['representante'];
            $_SESSION['login_user']['idNivel']=$infoDistribuidor['idNivel'];
            header('location: '.$raizProy.'distribuidores/detalle.php');
        }
    }


    else if($login_session['profile_id']==3){
        header('location: '.$raizProy.'login/user_list.php');
    }
    /*
    else{

    }
    */

?>