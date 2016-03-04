<?php
require_once('PhpExcel/Classes/PHPExcel.php');
require_once('models/class.Inventory.php');
require_once('models/class.Upload.php');

$dirBase="tmp";
$output=[];
$ext=explode('.',$_FILES['fileUpload']['name']);
$ext=$ext[count($ext)-1];
$upload=new Upload();


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
	
	//move_uploaded_file($_FILES['fileUpload']['tmp_name'],);
	
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objReader->setReadDataOnly(true);

	$objPHPExcel=$objReader->load($dirBase.'/'.$nameFile);
	$objWorksheet=$objPHPExcel->getActiveSheet();

	$highestRow=$objWorksheet->getHighestRow(); 
	$highestColumn=$objWorksheet->getHighestColumn(); 

	$highestColumnIndex=PHPExcel_Cell::columnIndexFromString($highestColumn);
	/*
	$result='<table class="table">';
	$result.='<thead>';
	
	for($row=11;$row<=11;++$row)
	{
		$result.='<tr>';
		for($col=0;$col<=10; ++$col)
		{
			$result.='<th>'.$objWorksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue().'</th>';
		}
		$result.='</tr>';
	}
	$result.='</thead>';*/
	
	$result='<table class="table">';
	$result.='<thead>';
	$result.='<tr>';
	$result.='<th>'.'SKU'.'</th>';
	$result.='<th>'.'PRODUCTO'.'</th>';
	$result.='<th>'.'STOCK'.'</th>';
	$result.='<th>'.'PRECIO'.'</th>';
	$result.='<th>'.'STATUS'.'</th>';
	$result.='</tr>';
	
	$result.='<tbody>';
	
	$inventory=new Inventory();
	
	for($row=12;$row<=$highestRow;++$row)
	{
		
		$sku=$objWorksheet->getCellByColumnAndRow(0,$row)->getCalculatedValue();
		$product=$objWorksheet->getCellByColumnAndRow(1,$row)->getCalculatedValue();
		$stock=$objWorksheet->getCellByColumnAndRow(5,$row)->getCalculatedValue();
		$price=round($objWorksheet->getCellByColumnAndRow(6,$row)->getCalculatedValue(),2);
		
		
		if($sku!='')
		{	
			$ID='';
			$ID=$inventory->getSku($sku);
			
			$result.='<tr>';
			$result.='<th>'.$sku.'</th>';
			$result.='<th>'.$product.'</th>';
			$result.='<th>'.$stock.'</th>';
			$result.='<th>$'.$price.'</th>';
			
			if(!$ID)
			{
				$inventory->InsertProduct($sku,$product,$stock,$price);
				$result.='<th>'.'Nuevo Producto'.'</th>';
				//echo "Nuevo";
			}
			else
			{
				$inventory->UpdateStock($ID,$stock);
				$result.='<th>'.'Existe'.'</th>';
				//echo "Existe";
			}
			
			$result.='</tr>';
			//die();
		}
		
		/*
		$rowA='';
		for($col=0;$col<=10; ++$col)
		{
			if($objWorksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue())
			{
				$rowA.='<th>'.$objWorksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue().'</th>';
			}
		}
		
		if($rowA)
		{
			$result.='<tr>'.$rowA.'</tr>';
		}
		*/
	}
	$result.='</tbody>';
	
	
	
	$result.='</table>';
	
	$output=['result'=>$result];
	
/*
	resul '<table class="table" align="center">';
	for($row=1;$row<=4;++$row)
	{
		echo '<tr>';
		for($col=0;$col<=10; ++$col)
		{
			if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()!='')
			{
				echo '<td>'.$objWorksheet->getCellByColumnAndRow($col, $row)->getValue().'</td>';
			}
		}
		echo '</tr>';
	}
echo '</table>';*/

	unlink($dirBase.'/'.$nameFile);
	
	
}
echo json_encode($output);
?>