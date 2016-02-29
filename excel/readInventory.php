<?php
require_once('PhpExcel/Classes/PHPExcel.php');
date_default_timezone_set("America/Mexico_City");

$dirBase="tmp";
$output=[];
$ext=explode('.',$_FILES['fileUpload']['name']);
$ext=$ext[count($ext)-1];


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
	
	move_uploaded_file($_FILES['fileUpload']['tmp_name'],$dirBase.'/'.$nameFile);
	
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objReader->setReadDataOnly(true);

	$objPHPExcel=$objReader->load($dirBase.'/'.$nameFile);
	$objWorksheet=$objPHPExcel->getActiveSheet();

	$highestRow=$objWorksheet->getHighestRow(); 
	$highestColumn=$objWorksheet->getHighestColumn(); 

	$highestColumnIndex=PHPExcel_Cell::columnIndexFromString($highestColumn);
	
	$result='<table class="table">';
	$result.='<thead>';
	
	for($row=1;$row<=1;++$row)
	{
		$result.='<tr>';
		for($col=0;$col<=10; ++$col)
		{
			$result.='<th>'.$objWorksheet->getCellByColumnAndRow($col, $row)->getValue().'</th>';
		}
		$result.='</tr>';
	}
	$result.='</thead>';
	
	
	$result.='<tbody>';
	
	for($row=2;$row<=$highestRow;++$row)
	{
		$rowA='';
		for($col=0;$col<=10; ++$col)
		{
			if($objWorksheet->getCellByColumnAndRow($col, $row)->getValue())
			{
				$rowA.='<th>'.$objWorksheet->getCellByColumnAndRow($col, $row)->getValue().'</th>';
			}
		}
		
		if($rowA)
		{
			$result.='<tr>'.$rowA.'</tr>';
		}
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