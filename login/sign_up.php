<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
    require_once('class/user_login.php');
    $login = new user_login();
?>
    <link href="<?php echo $raizProy;?>css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo $raizProy;?>css/buttons.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/login.css" rel="stylesheet" >
    <script src="<?php echo $raizProy;?>js/jquery.min.js"></script>
    <script src="<?php echo $raizProy;?>js/bootstrap.min.js"></script>

    <?php include $_SERVER['REDIRECT_PATH_CONFIG'].'header.php';?>

    <div class="container">
        <div class="card card-container">
            <h3 align="center">Registrarse</h3>
	        <form action="create_account.php" method="post"  autocomplete="off">
                <input type="hidden" name="registroExterno" value="1" />
	            <input id="firstName" name="firstName" placeholder="Nombre" type="text" class="form-control" autofocus><br>
	            <input id="lastName" name="lastName" placeholder="Apellidos" type="text" class="form-control"><br>
                <select class="form-control" name="profile" id="profile">
                    <option value="2">Distribuidor</option>
                </select>
	            <input id="email" name="email" placeholder="Correo electrónico" type="text" class="form-control" ><br>
	            <input id="password" name="password" placeholder="Contraseña" type="password" class="form-control" autocomplete="new-password"><br>
	            <input id="create_user" name="create_user" type="hidden" value="true">
	            <input name="submit" type="submit" value="Crear cuenta" class="btn btn-lg btn-primary btn-block"><br>
	            <span><?php if(isset($error))echo $error; ?></span>
	        </form>
        </div>
    </div>
