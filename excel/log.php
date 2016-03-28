<?php
require_once('models/class.Log.php');

$action=$_REQUEST["action"];
$log=new Log();

if($action=='restore')
{
	$restore=$_REQUEST['restore'];
	$log->Restore($restore);
}
else if($action=='delete')
{
	$logId=$_REQUEST['id'];
	$log->DeleteLog($logId);
}
else if($action=='refresh')
{
	$log->CleanLog();
	
	$result=$log->GetLog('','');
	
	$table='<table class="table table-hover">';
	$table.='<thead>';
	$table.='<tr>';
	$table.='<th>Name</th>';
	$table.='<th>E-mail</th>';
	$table.='<th>Estatus</th>';
	$table.='<th>Total</th>';
	$table.='<th>Fecha</th>';
	$table.='<th>'.utf8_encode('Opción').'</th>';
	$table.='</tr>';
	$table.='</thead>';
	
	$table.='<tbody class="buscar">';
	foreach($result as $r)
	{
		$logId=$r['log_id'];
		$name=$r['Name'];
		$email=$r['email'];
		$status=$r['status'];
		$total=$r['total'];
		$file=$r['file'];
		$restore=$r['restore'];
		$date=$r['date'];
	
		$table.='<tr>';
		$table.='<th>'.$name.'</th>';
		$table.='<th>'.$email.'</th>';
		$table.='<th>'.$status.'</th>';
		$table.='<th>'.$total.'</th>';
		$table.='<th>'.$date.'</th>';
		$table.='<th>';
		$table.='<a href="'.$file.'" download><span class="glyphicon glyphicon-arrow-down"></span></a>';
		$table.='<a id="restore" href="#" onCLick="restoreLog('.$restore.');"><span class="glyphicon glyphicon-backward"></span></a>';
		$table.='<a id="restore" href="#" onCLick="deleteLog('.$logId.');"><span class="glyphicon glyphicon-trash"></span></a>';
		$table.='</th>';
		$table.='</tr>';
	
	
	}
	
	$table.='</tbody>';
	$table.='</table>';
	echo $table;
}

?>