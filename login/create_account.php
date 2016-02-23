<?php
if(!empty($_POST["create_user"])){
	require_once('class/user_login.php');
	$login = new user_login('db614036781.db.1and1.com','db614036781', 'dbo614036781', 'Desarrollo2016*');

	$firstName=stripslashes($_POST['firstName']);
	$lastName=stripslashes($_POST['lastName']);
	$profile=stripslashes($_POST['profile']);
	$email=stripslashes($_POST['email']);
	$password=stripslashes($_POST['password']);

	$login->sign_up($firstName, $lastName, $profile, $email, $password);
}