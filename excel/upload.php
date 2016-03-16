<?php
require_once('models/class.Upload.php');

$upload=new Upload();

$dirBase="upload/inventory";
$output=[];


if(!is_uploaded_file($_FILES['fileUpload']['tmp_name']))
{
	$output=['error'=>'No se pudo leer el archivo.'];
}
else
{
	mkdir($dirBase,0775,true);
	
	$nameFile=$_FILES['fileUpload']['name'];
	$route=$dirBase.'/'.$nameFile;
	$upload->UploadFile($_FILES['fileUpload']['tmp_name'],$route);
	$result='<div class="alert alert-info">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>'.$nameFile.'</strong>
			</div>';
	
	$output=['result'=>$result];
}


echo json_encode($output);

?>