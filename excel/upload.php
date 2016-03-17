<?php
require_once('models/class.Upload.php');
require_once('models/class.Inventory.php');

$upload=new Upload();
$inventory=new Inventory();

$dirBase="inventory";
$output=[];


if(!is_uploaded_file($_FILES['fileUpload']['tmp_name']))
{
	$output=['error'=>'No se pudo leer el archivo.'];
}
else
{
	if(!file_exists('uploads/'.$dirBase))
	{
		mkdir('../../hainzersupply/wp-content/uploads/'.$dirBase,0775,true);
	}
	
	$nameFile=$_FILES['fileUpload']['name'];
	$route='../../hainzersupply/wp-content/uploads/'.$dirBase.'/'.$nameFile;
	$upload->UploadFile($_FILES['fileUpload']['tmp_name'],$route);
	
	$r=$inventory->InsertImage($nameFile,$dirBase.'/'.$nameFile);
	
	$result='<div class="alert alert-info">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>'.$r.' '.$nameFile.'</strong>
			</div>';
	
	$output=['result'=>$result];
}


echo json_encode($output);

?>