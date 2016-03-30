<?php
if(!empty($_POST["email"])){
	require_once('class/user_login.php');
	$login = new user_login();

	echo $login->pwd_recovery($_POST["email"]);
}
?>
