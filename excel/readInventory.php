<?php
require_once('PhpExcel/Classes/PHPExcel.php');
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(true);

$objPHPExcel=$objReader->load("inventario.xlsx");
$objWorksheet=$objPHPExcel->getActiveSheet();

$highestRow=$objWorksheet->getHighestRow(); 
$highestColumn=$objWorksheet->getHighestColumn(); 

$highestColumnIndex=PHPExcel_Cell::columnIndexFromString($highestColumn);

echo '<table border="1" align="center">';
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
echo '</table>';

?>