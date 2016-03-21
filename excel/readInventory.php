<?php
require_once('PhpExcel/Classes/PHPExcel.php');
require_once('models/class.Inventory.php');
require_once('models/class.Upload.php');

$dirBase="tmp";
$output=[];
$ext=explode('.',$_FILES['fileUpload']['name']);
$ext=$ext[count($ext)-1];
$upload=new Upload();
$inventory=new Inventory();
$result="";

if(!is_uploaded_file($_FILES['fileUpload']['tmp_name']))
{
	$output=['error'=>'No se pudo leer el archivo.'];
}
else if($ext!='xls' && $ext!='xlsx')
{
	$output=['error'=>'La extensión del Archivo no es valida('.$ext.').'];
}
else
{
	$nameFile=date('YmdHis').'.'.$ext;
	
	$upload->UploadFile($_FILES['fileUpload']['tmp_name'],$dirBase.'/'.$nameFile);
	
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objReader->setReadDataOnly(true);

	$objPHPExcel=$objReader->load($dirBase.'/'.$nameFile);
	$objWorksheet=$objPHPExcel->getActiveSheet();

	$highestRow=$objWorksheet->getHighestRow(); 
	$highestColumn=$objWorksheet->getHighestColumn(); 

	$highestColumnIndex=PHPExcel_Cell::columnIndexFromString($highestColumn);
	
	if($highestColumn=='R')
	{	
		$result='<table class="table">';
		$result.='<thead>';
		$result.='<tr>';
		$result.='<th>'.'SKU PADRE'.'</th>';
		$result.='<th>'.'SKU'.'</th>';
		$result.='<th>'.'PRODUCTO'.'</th>';
		$result.='<th>'.'DESCRIPCION CORTA'.'</th>';
		$result.='<th>'.'CATEGORIAS'.'</th>';
		$result.='<th>'.'MARCA'.'</th>';
		$result.='<th>'.'GENERO'.'</th>';
		$result.='<th>'.'COLOR'.'</th>';
		$result.='<th>'.'TALLA'.'</th>';
		$result.='<th>'.'STOCK'.'</th>';
		$result.='<th>'.'PRECIO'.'</th>';
		$result.='<th>'.'STATUS'.'</th>';
		$result.='<th>'.'PREFIJO'.'</th>';
		$result.='</thead>';
		$result.='</tr>';
		
		$result.='<tbody>';
		
		
		
		for($row=2;$row<=$highestRow;++$row)
		{
			$skuSenior=trim($objWorksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue());
			$sku=trim($objWorksheet->getCellByColumnAndRow(1,$row)->getCalculatedValue());
			$product=trim($objWorksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue());
			$description=trim($objWorksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue());
			$descriptionShort=trim($objWorksheet->getCellByColumnAndRow(4,$row)->getCalculatedValue());
			$trademark=trim($objWorksheet->getCellByColumnAndRow(5,$row)->getCalculatedValue());
			$categories=trim($objWorksheet->getCellByColumnAndRow(6,$row)->getCalculatedValue());
			$type=trim($objWorksheet->getCellByColumnAndRow(7,$row)->getCalculatedValue());
			$line=trim($objWorksheet->getCellByColumnAndRow(8,$row)->getCalculatedValue());
			$gender=trim($objWorksheet->getCellByColumnAndRow(9,$row)->getCalculatedValue());
			$color=trim($objWorksheet->getCellByColumnAndRow(10,$row)->getCalculatedValue());
			$size=trim($objWorksheet->getCellByColumnAndRow(11,$row)->getCalculatedValue());
			$stock=$objWorksheet->getCellByColumnAndRow(12,$row)->getCalculatedValue();
			$priceWIVA=round($objWorksheet->getCellByColumnAndRow(13,$row)->getCalculatedValue(),2);
			
			if($sku!="")
			{	
				$ID="";
				$ID=$inventory->getSku($sku);
				
				if(!$priceWIVA)
				{
					$priceWIVA=0;
				}
				
				if($skuSenior)
				{
					$skuPrefix=$skuSenior;
					$parent=1;
				}
				else
				{
					$skuPrefix=$sku;
					$parent=0;
				}
						
				$prefix=$inventory->getPrefix($skuPrefix,$color,$trademark,$product,$parent);
				
				
				$result.='<tr>';
				$result.='<th>'.$skuSenior.'</th>';
				$result.='<th>'.$sku.'</th>';
				$result.='<th>'.$product.'</th>';
				$result.='<th>'.$descriptionShort.'</th>';
				$result.='<th>'.$categories.'</th>';
				$result.='<th>'.$trademark.'</th>';
				$result.='<th>'.$gender.'</th>';
				$result.='<th>'.$color.'</th>';
				$result.='<th>'.$size.'</th>';
				$result.='<th>'.$stock.'</th>';
				$result.='<th>$'.($priceWIVA+($priceWIVA*0.16)).'</th>';
				
				
				if(!$ID)
				{
					if(!$skuSenior)
					{
						$inventory->InsertProductRoot($sku,$product,$description,$descriptionShort,$categories,$stock,$priceWIVA,$trademark,$type,$line,$gender);
						$result.='<th>'.'Nuevo Producto'.'</th>';
					}
					else
					{
						$IDParent=$inventory->getSku($skuSenior);
						
						if($IDParent)
						{
							
							$inventory->InsertProductVariable($sku,$IDParent,$product,$stock,$priceWIVA,$color,$size,$trademark,$type,$line,$gender);
							$result.='<th>'.'Producto Hijo'.'</th>';
						}
						else
						{
							$result.='<th>'.'No existe Producto Padre'.'</th>';
						}
					}
				}
				else
				{
					//$inventory->UpdateStock($ID,$stock);
					$result.='<th>'.'Existe'.'</th>';
				}
				
				$result.='<th>'.$prefix.'</th>';
				
				$result.='</tr>';
			}
			
		}
		$result.='</tbody>';
		
		
		
		$result.='</table>';
		
		$html='<html><head><head><body>';
		$html.=$result;
		$html.='</body></html>';
		
		$file=fopen("result.html", "w");
		fwrite($file,$html);
		fclose($file);
	}
	else if($highestColumn=='D')
	{
		$result='<table class="table">';
		$result.='<thead>';
		$result.='<tr>';
		$result.='<th>'.'SKU'.'</th>';
		$result.='<th>'.'PRODUCTO'.'</th>';
		$result.='<th>'.'STOCK'.'</th>';
		$result.='<th>'.'PRECIO'.'</th>';
		$result.='<th>'.'STATUS'.'</th>';
		$result.='</thead>';
		$result.='</tr>';
		
		for($row=2;$row<=$highestRow;++$row)
		{
			$sku=trim($objWorksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue());
			$product=trim($objWorksheet->getCellByColumnAndRow(1,$row)->getCalculatedValue());
			$stock=$objWorksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();
			$priceWIVA=round($objWorksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue(),2);
			
			$ID=$inventory->getSku($sku);
			
			$result.='<tr>';
			$result.='<th>'.$sku.'</th>';
			$result.='<th>'.$product.'</th>';
			$result.='<th>'.$stock.'</th>';
			$result.='<th>$'.($priceWIVA+($priceWIVA*0.16)).'</th>';
			
			if($ID)
			{
				//$inventory->UpdateProduct($ID,$stock,$priceWIVA);
				$result.='<th>'.'Producto Actualizado'.'</th>';
				$result.='</tr>';
			}
			else
			{
				$result.='<th>'.'Producto Inexistente'.'</th>';
				$result.='</tr>';
			}
		}
	}
	
	$output=['result'=>$result];

	unlink($dirBase.'/'.$nameFile);

}
echo json_encode($output);
?>