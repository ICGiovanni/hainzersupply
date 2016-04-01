<?php
require($_SERVER["REDIRECT_PATH_CONFIG"]."orders/tcpdf/tcpdf.php");
require_once('class.Orders.php');

class PDF
{
	public function CreatePDF($idOrder)
	{
		$order=new Order();
		$r=$order->getOrderData($idOrder);
		die(var_dump($r));
		$IdDistribuidor=$r[0]['idDistribuidor'];
		$descuento="";
		
		if($descuento)
		{
			$descuento=(($r[0]['inv_orden_compra_factor_descuento'])*100)."%";
		}
		
		$productos=json_decode($r[0]['inv_orden_compra_productos']);
		
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

		$img=imagecreatefromjpeg('plantillas/plantilla.jpg');
		$negro = imagecolorallocate($img, 0, 0, 0);
		$fuente='css/arial.ttf';

		//No. Pedido
		$noPedido=$idOrder;
		$posX=1140-strlen($noPedido);
		imagettftext($img, 13,0,$posX, 143,$negro, $fuente,$noPedido);

		//Date
		$date=date('d-m-Y');
		imagettftext($img, 13,0,1105,172,$negro, $fuente,$date);

		//Distribuidor
		$distribuidor='ALFREDO URIEL MEDINA GARCIA';
		imagettftext($img, 13,0, 290, 244,$negro, $fuente,$distribuidor);

		//Direcci�n
		$direccion='MANUEL COTERO 144-B COL.CARLOS HANK GONZALEZ TOLUCA,MEXICO CP. 50026';
		imagettftext($img, 13,0, 290, 293,$negro, $fuente,$direccion);

		//Telefono
		$telefono='7222306547';
		imagettftext($img, 13,0, 290, 344,$negro, $fuente,$telefono);

		//E-mail
		$email='umedina86@yahoo.com.mx';
		imagettftext($img, 13,0, 774, 344,$negro, $fuente,$email);

		//Direcci�n
		$direccionE='MANUEL COTERO 144-B COL.CARLOS HANK GONZALEZ TOLUCA,MEXICO CP. 50026';
		imagettftext($img, 13,0, 290, 392,$negro, $fuente,$direccionE);
		
		
		$posIniY=520;
		$importeSubotal=0;
		foreach($productos->rows as $j)
		{
			//SKU
			$sku=$j->sku;
			imagettftext($img, 13,0, 85, $posIniY,$negro, $fuente,$sku);

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

		if(!file_exists('plantillas'))
		{
			mkdir('plantillas',0775,true);
		}

		$namePlantilla='plantillas/plantilla_'.$noPedido.'.jpg';
		imagejpeg($img,$namePlantilla);

		imagedestroy($img);

		$pdf->Image($namePlantilla);

		$pdf->Output('Pedido_'.$noPedido.'.pdf', 'I');
		//$pdf->Output('Pedido_'.$noPedido.'.pdf', 'D');

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

}

?>