<?php
    include_once $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
	include_once('login2.php'); // Includes Login Script
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hainzer Supply</title>

    <link href="<?php echo $raizProy;?>css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?php echo $raizProy;?>css/buttons.css" rel="stylesheet" >


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
            <a href="#" class="forgot-password"  data-target="#pwdModal" data-toggle="modal">Olvide mi contraseña</a>
        </div>
    </div>
	
<!--modal-->
<div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h1 class="text-center">Asignarme un nuevo password</h1>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                          
                          <p>Si ya haz olvidado tu password, aquí puedes asignar uno nuevo.</p>
                            <div class="panel-body">
                                <fieldset>
                                    <div class="form-group">
                                        <input id="findEmail" class="form-control input-lg" placeholder="E-mail Address" name="findEmail" type="findEmail">
                                    </div>
									
										<input id="button_send_new_pwd" class="btn btn-lg btn-primary btn-block" value="Enviarme un nuevo password" type="submit" onclick="sendNewPwd();">
									
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
		  </div>	
      </div>
  </div>
  </div>
</div>
</body>

<script>
	function sendNewPwd(){
		$("#button_send_new_pwd").addClass("disabled");
		findEmail = $("#findEmail").val();
		
		$.ajax({
    		type: "POST",
			url: "pwd_recovery.php",
			data: {email: findEmail},
        	success: function(msg){
				
					if(msg == "true"){
						alert("Ha sido asignado un nuevo password a su cuenta y ha sido enviado a su correo.");
						$("#pwdModal").modal('hide');
					} else {						 
						alert("La cuenta de correo especificada no existe, favor de verificar.");
					}
					$("#button_send_new_pwd").removeClass().addClass("btn btn-lg btn-primary btn-block");
			}
		
      	});
	}
</script>
</html>
