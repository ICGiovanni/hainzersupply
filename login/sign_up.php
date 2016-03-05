<?php
require_once('class/user_login.php');
$login = new user_login();
?><!DOCTYPE html>
<html>
<head>
<title>Hainzer Supply Inventory System</title>
<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/login.css" rel="stylesheet" >
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div class="card card-container">
<h2 align="center">Sing Up</h2>
	<form action="create_account.php" method="post"  autocomplete="off">
	
	<img id="profile-img" class="" width="300" src="img/Logo_HainzerSupply_003.png" /><br><br>
	<input id="firstName" name="firstName" placeholder="First Name" type="text" class="form-control" autofocus><br>
	<input id="lastName" name="lastName" placeholder="Last Name" type="text" class="form-control"><br>
	<?=$login->selectProfiles()?>
	<br>

	<input id="email" name="email" placeholder="Email address" type="text" class="form-control" ><br>

	<input id="password" name="password" placeholder="Password" type="password" class="form-control" autocomplete="new-password"><br>
	<input id="create_user" name="create_user" type="hidden" value="true">
	<input name="submit" type="submit" value="Create account" class="btn btn-lg btn-primary btn-block"><br>
	
	<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>