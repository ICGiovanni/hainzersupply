<?php
require_once($_SERVER["REDIRECT_PATH_CONFIG"]."orders/tcpdf/tcpdf.php");
require_once($_SERVER["REDIRECT_PATH_CONFIG"].'models/connection/class.Connection.php');
require_once('class.Orders.php');

class PDF
{
	function __construct()
	{
		$c=new Connection();
		$this->connect=$c->db;
	}
	
	public function CreatePDF($idOrder,$type='W')
	{
		$order=new Order();
		$r=$order->getOrderData($idOrder);
		
		$idDistribuidor=$r[0]['idDistribuidor'];
		$d=$this->getDataDistribuidor($idDistribuidor);		
				
		$descuento="";
		
		if($descuento)
		{
			$descuento=(($r[0]['inv_orden_compra_factor_descuento'])*100)."%";
		}
		
		$productos=json_decode($r[0]['inv_orden_compra_productos']);
		
		$img=imagecreatefromjpeg($_SERVER["REDIRECT_PATH_CONFIG"].'orders/plantillas/plantilla.jpg');
		$negro = imagecolorallocate($img, 0, 0, 0);
		$fuente=$_SERVER["REDIRECT_PATH_CONFIG"].'orders/css/arial.ttf';

		//No. Pedido
		$noPedido=$idOrder;
		$posX=1140-strlen($noPedido);
		imagettftext($img, 13,0,$posX, 143,$negro, $fuente,$noPedido);

		//Date
		$f=explode('-',$r[0]['inv_orden_compra_created_date']);
		$date=$f[2].'/'.$f[1].'/'.$f[0];
		imagettftext($img, 13,0,1105,172,$negro, $fuente,$date);

		//Distribuidor
		$distribuidor=$d[0]['nombre'];
		imagettftext($img, 13,0, 290, 244,$negro, $fuente,$distribuidor);

		//Direcci�n
		$direccion=$d[0]['direccion'];
		imagettftext($img, 13,0, 290, 293,$negro, $fuente,$direccion);

		//Telefono
		$telefono=$d[0]['telefono'];
		imagettftext($img, 13,0, 290, 344,$negro, $fuente,$telefono);

		//E-mail
		$email=$d[0]['correoElectronico'];
		imagettftext($img, 13,0, 774, 344,$negro, $fuente,$email);

		//Direcci�n
		$direccionE=$d[0]['direccion'];
		imagettftext($img, 13,0, 290, 392,$negro, $fuente,$direccionE);
		
		
		$posIniY=520;
		$importeSubotal=0;
		foreach($productos->rows as $j)
		{
			//SKU
			$sku=$j->sku;
			imagettftext($img, 10,0, 65, $posIniY,$negro, $fuente,$sku);

			//Product
			$product=$j->name;
			imagettftext($img, 13,0, 222, $posIniY,$negro, $fuente,$product);

			//Unidad
			$unidad='PZA';
			imagettftext($img, 13,0, 703, $posIniY,$negro, $fuente,$unidad);


			//Cantidad
			$cantidad=$j->quantity;
			$posX=805-strlen($cantidad);
			imagettftext($img, 13,0, $posX, $posIniY,$negro, $fuente,$cantidad);

			//Precio
			$precio=$j->unit_list_price;
			$precio=round($precio,2);
			
			$p=explode('.',$precio);
			if(count($p)==1)
			{
				$precio.='.00';
			}
			
			imagettftext($img, 13,0,882,$posIniY,$negro, $fuente,'$'.$precio);

			//Descuento
			$descuento='20%';
			imagettftext($img, 13,0,1010,$posIniY,$negro, $fuente,$descuento);

			//Descuento
			$importe=$j->amount_price;
			$p=explode('.',$importe);
			if(count($p)==1)
			{
				$importe.='.00';
			}
			
			imagettftext($img, 13,0,1090,$posIniY,$negro, $fuente,'$'.$importe);
			
			$importeSubotal=$importeSubotal+$importe;
			
			$posIniY=$posIniY+27;
		}

		//Subtotal
		$importeSubotal=round(($importeSubotal),2);
		$p=explode('.',$importeSubotal);
		if(count($p)==1)
		{
			$importeSubotal.='.00';
		}
		imagettftext($img, 13,0,1050,1358,$negro, $fuente,'$'.$importeSubotal);


		//IVA
		$iva=$importeSubotal*0.16;
		$iva=round(($iva),2);
		$p=explode('.',$iva);
		if(count($p)==1)
		{
			$iva.='.00';
		}
		imagettftext($img, 13,0,1050,1418,$negro, $fuente,'$'.$iva);


		//Total
		$importeTotal=$importeSubotal+$iva;
		$importeTotal=round(($importeTotal),2);
		$p=explode('.',$importeTotal);
		if(count($p)==1)
		{
			$importeTotal.='.00';
		}
		imagettftext($img, 13,0,1050,1479,$negro, $fuente,'$'.$importeTotal);


		//Cantidad en Letra
		$letra=$this->num2letras($importeTotal);
		imagettftext($img, 13,0,73,1386,$negro, $fuente,$letra);

		if(!file_exists($_SERVER["REDIRECT_PATH_CONFIG"].'orders/plantillas/'))
		{
			mkdir($_SERVER["REDIRECT_PATH_CONFIG"].'orders/plantillas/',0775,true);
		}

		$namePlantilla=$_SERVER["REDIRECT_PATH_CONFIG"].'orders/plantillas/plantilla_'.$noPedido.'.jpg';
		imagejpeg($img,$namePlantilla);

		imagedestroy($img);
		
		$pdf=new TCPDF('P','mm','A4', true, 'UTF-8', false);

		$pdf->SetCreator('HAINZER');
		$pdf->SetAuthor('HAINZER SUPPLY');
		$pdf->SetTitle('Orden');

		$pdf->SetDefaultMonospacedFont('courier');
		$pdf->SetMargins(0,0,0);
		//$pdf->SetAutoPageBreak(TRUE,25);
		//$pdf->setImageScale(2);

		$pdf->AddPage();
		$pdf->setJPEGQuality(100);
		$pdf->Image($namePlantilla);
		ob_start();
		if($type=='W')
		{
			$pdf->Output('Pedido_'.$noPedido.'.pdf', 'D');
		}
		else if($type=='I')
		{
			$pdf->Output('Pedido_'.$noPedido.'.pdf', 'I');
		}
		else if($type=='L')
		{
			$rute=$_SERVER["REDIRECT_PATH_CONFIG"]."orders/pdf/";
			
			if(!file_exists($rute))
			{
				mkdir($rute,0775,true);
			}
			
			$pdf->Output($rute.'pedido_'.$noPedido.'.pdf', 'F');
		}
		else
		{
			$pdf->Output('pedido_'.$noPedido.'.pdf', 'D');
		}
		ob_end_flush();

		unlink($namePlantilla);
	}

	public function num2letras($num, $fem = false, $dec = true)
	{ 
	   $matuni[2]  = "dos"; 
	   $matuni[3]  = "tres"; 
	   $matuni[4]  = "cuatro"; 
	   $matuni[5]  = "cinco"; 
	   $matuni[6]  = "seis"; 
	   $matuni[7]  = "siete"; 
	   $matuni[8]  = "ocho"; 
	   $matuni[9]  = "nueve"; 
	   $matuni[10] = "diez"; 
	   $matuni[11] = "once"; 
	   $matuni[12] = "doce"; 
	   $matuni[13] = "trece"; 
	   $matuni[14] = "catorce"; 
	   $matuni[15] = "quince"; 
	   $matuni[16] = "dieciseis"; 
	   $matuni[17] = "diecisiete"; 
	   $matuni[18] = "dieciocho"; 
	   $matuni[19] = "diecinueve"; 
	   $matuni[20] = "veinte"; 
	   $matunisub[2] = "dos"; 
	   $matunisub[3] = "tres"; 
	   $matunisub[4] = "cuatro"; 
	   $matunisub[5] = "quin"; 
	   $matunisub[6] = "seis"; 
	   $matunisub[7] = "sete"; 
	   $matunisub[8] = "ocho"; 
	   $matunisub[9] = "nove"; 

	   $matdec[2] = "veint"; 
	   $matdec[3] = "treinta"; 
	   $matdec[4] = "cuarenta"; 
	   $matdec[5] = "cincuenta"; 
	   $matdec[6] = "sesenta"; 
	   $matdec[7] = "setenta"; 
	   $matdec[8] = "ochenta"; 
	   $matdec[9] = "noventa"; 
	   $matsub[3]  = 'mill'; 
	   $matsub[5]  = 'bill'; 
	   $matsub[7]  = 'mill'; 
	   $matsub[9]  = 'trill'; 
	   $matsub[11] = 'mill'; 
	   $matsub[13] = 'bill'; 
	   $matsub[15] = 'mill'; 
	   $matmil[4]  = 'millones'; 
	   $matmil[6]  = 'billones'; 
	   $matmil[7]  = 'de billones'; 
	   $matmil[8]  = 'millones de billones'; 
	   $matmil[10] = 'trillones'; 
	   $matmil[11] = 'de trillones'; 
	   $matmil[12] = 'millones de trillones'; 
	   $matmil[13] = 'de trillones'; 
	   $matmil[14] = 'billones de trillones'; 
	   $matmil[15] = 'de billones de trillones'; 
	   $matmil[16] = 'millones de billones de trillones'; 
	   
	   //Zi hack
	   $float=explode('.',$num);
	   $num=$float[0];

	   $num = trim((string)@$num); 
	   if ($num[0] == '-') { 
		  $neg = 'menos '; 
		  $num = substr($num, 1); 
	   }else 
		  $neg = ''; 
	   while ($num[0] == '0') $num = substr($num, 1); 
	   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	   $zeros = true; 
	   $punt = false; 
	   $ent = ''; 
	   $fra = ''; 
	   for ($c = 0; $c < strlen($num); $c++) { 
		  $n = $num[$c]; 
		  if (! (strpos(".,'''", $n) === false)) { 
			 if ($punt) break; 
			 else{ 
				$punt = true; 
				continue; 
			 } 

		  }elseif (! (strpos('0123456789', $n) === false)) { 
			 if ($punt) { 
				if ($n != '0') $zeros = false; 
				$fra .= $n; 
			 }else 

				$ent .= $n; 
		  }else 

			 break; 

	   } 
	   $ent = '     ' . $ent; 
	   if ($dec and $fra and ! $zeros) { 
		  $fin = ' coma'; 
		  for ($n = 0; $n < strlen($fra); $n++) { 
			 if (($s = $fra[$n]) == '0') 
				$fin .= ' cero'; 
			 elseif ($s == '1') 
				$fin .= $fem ? ' una' : ' un'; 
			 else 
				$fin .= ' ' . $matuni[$s]; 
		  } 
	   }else 
		  $fin = ''; 
	   if ((int)$ent === 0) return 'Cero ' . $fin; 
	   $tex = ''; 
	   $sub = 0; 
	   $mils = 0; 
	   $neutro = false; 
	   while ( ($num = substr($ent, -3)) != '   ') { 
		  $ent = substr($ent, 0, -3); 
		  if (++$sub < 3 and $fem) { 
			 $matuni[1] = 'una'; 
			 $subcent = 'as'; 
		  }else{ 
			 $matuni[1] = $neutro ? 'un' : 'uno'; 
			 $subcent = 'os'; 
		  } 
		  $t = ''; 
		  $n2 = substr($num, 1); 
		  if ($n2 == '00') { 
		  }elseif ($n2 < 21) 
			 $t = ' ' . $matuni[(int)$n2]; 
		  elseif ($n2 < 30) { 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  }else{ 
			 $n3 = $num[2]; 
			 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
			 $n2 = $num[1]; 
			 $t = ' ' . $matdec[$n2] . $t; 
		  } 
		  $n = $num[0]; 
		  if ($n == 1) { 
			 $t = ' ciento' . $t; 
		  }elseif ($n == 5){ 
			 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
		  }elseif ($n != 0){ 
			 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
		  } 
		  if ($sub == 1) { 
		  }elseif (! isset($matsub[$sub])) { 
			 if ($num == 1) { 
				$t = ' mil'; 
			 }elseif ($num > 1){ 
				$t .= ' mil'; 
			 } 
		  }elseif ($num == 1) { 
			 $t .= ' ' . $matsub[$sub] . '?n'; 
		  }elseif ($num > 1){ 
			 $t .= ' ' . $matsub[$sub] . 'ones'; 
		  }   
		  if ($num == '000') $mils ++; 
		  elseif ($mils != 0) { 
			 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
			 $mils = 0; 
		  } 
		  $neutro = true; 
		  $tex = $t . $tex; 
	   } 
	   $tex = $neg . substr($tex, 1) . $fin; 
	   //Zi hack --> return ucfirst($tex);
	   $end_num=ucfirst($tex).' pesos '.$float[1].'/100 M.N.';
	   return $end_num; 
	}
	
	public function getDataDistribuidor($idDistribuidor)
	{
		$sql="SELECT id.nombre,id.representante,id.telefono,id.correoElectronico,
				(SELECT CONCAT(calle,' ,',numExt,' ',IF(numInt!='',CONCAT('Int. ',numInt),''),' ,',colonia,
				' ,C.P. ',codigoPostal,' ,',estado,',',pais) AS direccion
				FROM inv_distribuidores id2
				INNER JOIN inv_distribuidor_envio ide USING(idDistribuidor)
				INNER JOIN inv_direcciones idir USING(idDireccion)
				WHERE id2.idDistribuidor=id.idDistribuidor
				LIMIT 0,1) AS direccion
				FROM inv_distribuidores id
				WHERE id.idDistribuidor=:idDistribuidor";
	
		$statement=$this->connect->prepare($sql);
		$statement->bindParam(':idDistribuidor', $idDistribuidor, PDO::PARAM_STR);
	
		$statement->execute();
		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	
		return $result;
	}

}

?>