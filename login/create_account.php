<?php
if(!empty($_POST["create_user"])){
	require_once('class/user_login.php');
	$login = new user_login();

	$firstName=stripslashes($_POST['firstName']);
	$lastName=stripslashes($_POST['lastName']);
	$profile=stripslashes($_POST['profile']);
	$email=stripslashes($_POST['email']);
	$password=stripslashes($_POST['password']);

	$user_id = $login->sign_up($firstName, $lastName, $profile, $email, $password);

	if(isset($_POST['registroExterno'])){
		header('location: index.php');
	}else{
		echo $user_id;
	}
}