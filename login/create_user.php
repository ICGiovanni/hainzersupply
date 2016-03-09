<?php
if(!empty($_POST["email"])){
	require_once('class/user_login.php');
	$login = new user_login();

	$firstName=stripslashes($_POST['firstName']);
	$lastName=stripslashes($_POST['lastName']);
	$profile=stripslashes($_POST['profile']);
	$email=stripslashes($_POST['email']);
	$password=stripslashes($_POST['password']);

	$login->sign_up($firstName, $lastName, $profile, $email, $password);
}