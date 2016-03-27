<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if(isset($_POST['submit'])) {
	if (empty($_POST['email']) || empty($_POST['password'])) {
	    $error = "Username or Password is empty";
	} else {
	
		// Define $email and $password
		// To protect MySQL injection for Security purpose
		$email=stripslashes($_POST['email']);
		$password=stripslashes($_POST['password']);
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter

		require_once('class/user_login.php');
		$login = new user_login();

		$login_status = $login->auth($email,$password);
		 
		if($login_status==true){

		    $_SESSION['login_user']=$login_status;
			header("location: profile.php"); // Redirecting To Other Page

		 }
		 else{
			 $error = "Username or Password is invalid";
		}
		//mysql_close($connection); // Closing Connection
	}
}
?>