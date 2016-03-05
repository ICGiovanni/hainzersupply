<?php
if(!empty($_POST["login_id"])){
	require_once('class/user_login.php');
	$login = new user_login();

	$loginId = sprintf("%d", $_POST["login_id"]);	

	$login->user_delete($loginId);
}
?>