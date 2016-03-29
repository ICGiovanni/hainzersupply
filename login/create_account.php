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


    $to = $email;
    $subject = "Registro Hainzersupply";
    $txt = "<html>
                <body style='background-color: #000'>
                    <p style='text-align: center; width: 300px'>
                        <img src='http://hainzersupply.com/new_site/control/images/Logotipo_HainzerSupply.png' width='200px' alt='HainzerSupply'/>
                    </p>
                    <div style='background-color: #FFF'>
                        <table align='center'>
                            <tr>
                                <td colspan='2'>BIENVENIDOS A LA SECCIÓN DE DISTRIBUIDORES DE HAINZER SUPPLY</td>
                            </tr>
                            <tr>
                                <td colspan='2'>Su usuario y contraseña es a siguiente</td>
                            </tr>
                            <tr>
                                <td>Usuario: </td>
                                <td>".$email."</td>
                            </tr>
                            <tr>
                                <td>Contraseña: </td>
                                <td>".$password."</td>
                            </tr>
                            <tr>
                                <td colspan='2'>GUARDA ESTA INFORMACIÓN PARA FUTURAS REFERENCIAS.</td>
                            </tr>
                        </table>
                        <p style='text-align: center; width: 300px'>
                            www.hainzersupply.com / VISITA NUESTRO AVISO DE PRIVACIDAD PARA MAS INFORMACIÓN
                        </p>
                    </div>
                </body>
            </html>";
    $headers = "From: vagio12345@gmail.com";

    mail($to,$subject,$txt,$headers);

	if(isset($_POST['registroExterno'])){
		header('location: index.php');
	}else{
		echo $user_id;
	}
}