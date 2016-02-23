<?php
include_once('login2.php'); // Includes Login Script
?>
<!DOCTYPE html>
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
<h2 align="center">Hainzer Supply Inventory System</h2>
	<form action="" method="post">
	
	<img id="profile-img" class="" width="300" src="img/Logo_HainzerSupply_003.png" /><br><br>
	
	<input id="email" name="email" placeholder="Email address" type="text" class="form-control" autofocus><br>

	<input id="password" name="password" placeholder="Password" type="password" class="form-control"><br>
	<input name="submit" type="submit" value="Sign in" class="btn btn-lg btn-primary btn-block"><br>
	<span><?php echo $error; ?></span>
</form>
<a href="#" class="forgot-password">
                Forgot the password?
            </a>
</div>
</div>
</body>
</html>