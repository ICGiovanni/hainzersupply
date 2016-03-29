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
                    <p><img src='' alt='HainzerSupply'/></p>
                    <table>
                        <tr>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        </tr>
                        <tr>
                        <td>John</td>
                        <td>Doe</td>
                        </tr>
                    </table>
                </body>
            </html>";
    $headers = "From: ventas@hainzersupply.com \r\n";
    mail($to,$subject,$txt,$headers);


	if(isset($_POST['registroExterno'])){
		header('location: index.php');
	}else{
		echo $user_id;
	}
}