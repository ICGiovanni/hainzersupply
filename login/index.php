<?php
    include_once $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
	include_once('login2.php'); // Includes Login Script
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hainzer Supply</title>

    <link href="<?php echo $raizProy;?>css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


    <link href="css/login.css" rel="stylesheet" >
    <script src="<?php echo $raizProy;?>js/jquery.min.js"></script>
    <script src="<?php echo $raizProy;?>js/bootstrap.min.js"></script>

</head>
<body>

    <?php include $_SERVER['REDIRECT_PATH_CONFIG'].'header.php';?>
    <div class="container">
	    <div class="card card-container">
		    <form action="" method="post">
                <h3>
                    Modulo de distribuidores
                </h3>
                <br />
                <input id="email" name="email" placeholder="correo electrónico" type="text" class="form-control" autofocus><br>

                <input id="password" name="password" placeholder="contraseña" type="password" class="form-control" autocomplete="new-password"><br>
                <input name="submit" type="submit" value="Ingresar" class="btn btn-lg btn-primary btn-block"><br>
                <span><?php if(isset($error)) echo $error; ?></span>

            </form>
            <a href="sign_up.php" class="forgot-password">Registrar</a><br /><br />
            <a href="#" class="forgot-password">Recordar contraseña?</a>
        </div>
    </div>
</body>
</html>