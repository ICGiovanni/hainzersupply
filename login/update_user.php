<?php
if(!empty($_POST["login_id"])){
	require_once('class/user_login.php');
	$login = new user_login();

	$loginId = sprintf("%d", $_POST["login_id"]);
	$firstName=stripslashes($_POST['firstName']);
	$lastName=stripslashes($_POST['lastName']);
	$profile=stripslashes($_POST['profile']);
	$email=stripslashes($_POST['email']);
	$password=stripslashes($_POST['password']);
	$status=stripslashes($_POST['status']);

	$login->user_update($loginId, $firstName, $lastName, $profile, $email, $password, $status);
}
?>