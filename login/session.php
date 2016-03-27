<?php
    session_start();// Starting Session

    $login_session =$_SESSION['login_user'];

    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
    include $_SERVER['REDIRECT_PATH_CONFIG'].'login/class/user_login.php';

    if(!isset($login_session)){
        header('Location: index.php'); // Redirecting To Home Page
    }

    else{
        $inslogin = new user_login();
        $pages = $inslogin->pagesProfile($login_session['profile_id']);

        $inArrayPages = array();
        foreach($pages as $page){
            array_push($inArrayPages, $raizProy.$page['page']);
        }

        $pagina = $_SERVER['SCRIPT_NAME'];

        if(!in_array($pagina, $inArrayPages)){
            header('location: '.$raizProy.'login/profile.php');
        }

    }



?>