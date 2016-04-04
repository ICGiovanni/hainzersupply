<?php
require_once $_SERVER['REDIRECT_PATH_CONFIG'].'login/session.php';
require_once $_SERVER["REDIRECT_PATH_CONFIG"]."orders/models/class.PDF.php";

if(isset($_SESSION['login_user'])){
	
	if(isset($_SESSION['login_user']['correoElectronico'])){
		
		if(isset($_POST["inv_orden_compra_productos"]) && !empty($_POST["inv_orden_compra_productos"])) {
			require_once('../models/class.Orders.php');
			$order = new Order();
			$pdf=new PDF();
			$_POST['inv_orden_compra_status_id'] = '1';
			
			$idOrder = $order->insertOrder($_POST);
			
			$pdf->CreatePDF($idOrder,'L');				
			
			$fileA=$rute=$_SERVER["REDIRECT_PATH_CONFIG"]."orders/pdf/".'pedido_'.$noPedido.'.pdf';
			$fileatt_type = 'application/pdf';
			$fileatt_name = 'pedido_'.$noPedido.'.pdf';
			
			$file = fopen($fileA,'rb');
			$data = fread($file,filesize($fileA));
			fclose($file);
			
			// Generate a boundary string
			$semi_rand = md5(time());
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
			
			/*Uriel*/
			$to = $_SESSION['login_user']['correoElectronico'];
			$subject = "Haizer Supply - Se ha creado el pedido #".$idOrder;
			
			$txt = "<html>
                <body style='background-color: #000'>
                    <p style='text-align: center; width: 300px'>
                        <img src='http://hainzersupply.com/new_site/control/images/Logotipo_HainzerSupply.png' width='200px' alt='HainzerSupply'/>
                    </p>
					
                    <div style='background-color: #FFF'>	
						<br><br>					
                        <table align='center'>
                            <tr>
                                <td><b>SU PEDIDO FUE PROCESADO Y ENVIADO CON EXITO, EN BREVE NOS PONDREMOS
								EN CONTACTO CON USTEDES PARA VERIFICAR ORDEN Y PAGO.</b></td>
                            </tr>
                            <tr>
                                <td><b>NUMERO DE PEDIDO:</b> #".$idOrder."</td>
                            </tr>
                            <tr>
                                <td><b>FECHA:</b> ".date("d/m/Y")."</td>
                            </tr>
                            <tr>
                                <td><b>DISTRIBUIDOR: </b>".$_SESSION['login_user']['nombre']."</td>
                            </tr>
							<tr>
                                <td><b>MONTO A PAGAR:</b> $".number_format($_POST["inv_orden_compra_total"],2)." (Envío no incluido)</td>
                            </tr>
                            <tr>
                                <td><br>EL PEDIDO VA <b>ADJUNTO</b> EN FORMATO <b>PDF</b> A ESTE CORREO.</td>
                            </tr>
							<tr>
                                <td>REVISAR PEDIDO EN LINEA <a href='http://hainzersupply.com/new_site/control/login/' target='_blank'>AQUI</a></td>
                            </tr>
							<tr>
                                <td>GUARDA ESTA INFORMACIÓN PARA FUTURAS REFERENCIAS.</td>
                            </tr>
                        </table>
						--------------------------------------------------------------------------------------------------------
						<table align='center'>
                            <tr>
                                <td width='160'><img src='http://creditos.mejortrato.com.mx/image.axd?picture=2012%2F10%2Fbco+bajio+4.jpg' width='150' /></td>
								<td>
									DATOS PARA TRANSFERENCIA O DEPÓSITO BANCARIO<br>
									BANCO: <b>BANBAJIO</b><br>
									TITULAR: SUPPLY S.A. DE C.V.<br>
									CUENTA CLASICA: 0143072680201<br>
									CLABE INTERBANCARIA: 030180900006460692<br>									
								</td>
                            </tr>
							 <tr>
                                <td colspan='2'>
									<span style='color:red; font-size:11px;'>Favor de enviar su comprabante de pago al siguiente correo: distribuidores@hainzersupply.com,
									con titulo \"Pago de pedido #___\", para su procedimiento de entrega.</span>
								</td>								
                            </tr>                            
                        </table>
                        <br><br>
                    </div>
					<p style='text-align: center; padding:16px 0px; color:#fff;'>
                           <b>www.hainzersupply.com / VISITA NUESTRO AVISO DE PRIVACIDAD PARA MAS INFORMACIÓN</b>
                    </p>
                </body>
            </html>";
			
			$txt.="This is a multi-part message in MIME format.\n\n" .
             "--{$mime_boundary}\n" .
             "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
             "Content-Transfer-Encoding: 7bit\n\n";
			
			$txt .= "--{$mime_boundary}\n" .
			"Content-Type: {$fileatt_type};\n" .
			" name=\"{$fileatt_name}\"\n" .
			//"Content-Disposition: attachment;\n" .
			//" filename=\"{$fileatt_name}\"\n" .
			"Content-Transfer-Encoding: base64\n\n" .
			$data . "\n\n" .
			"--{$mime_boundary}--\n";
			
			$headers = "From: test@hainzersupply.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			$headers .= "Content-Type: multipart/mixed;\n" .
					" boundary=\"{$mime_boundary}\"";
			$data = chunk_split(base64_encode($data));
				
			mail($to, $subject, $txt, $headers);
			
			if(file_exists($fileA))
			{
				unlink($fileA);
			}
			
			/*Uriel*/
			echo "order_id=".$idOrder;
		}
		else echo "insufficient data";
	}	
}
?>
