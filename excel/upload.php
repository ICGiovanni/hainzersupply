<?php
require_once('models/class.Inventory.php');

$inventory=new Inventory();
$general=new General();
$images=count($_FILES['fileUpload']['name']);
$dirBase="inventory";
$output=[];
$result="";

for($i=0;$i<$images;$i++)
{
	$tmpName=$_FILES['fileUpload']['tmp_name'][$i];
	$nameFileO=$_FILES['fileUpload']['name'][$i];
	
	if(!is_uploaded_file($tmpName))
	{
		$output=['error'=>'No se pudo leer el archivo.'];
	}
	else
	{
		if(!file_exists($_SERVER["REDIRECT_UPLOAD_FILE"].'uploads/'.$dirBase))
		{
			mkdir($_SERVER["REDIRECT_UPLOAD_FILE"].'uploads/'.$dirBase,0775,true);
		}
		
		
		$n=explode('.',$nameFileO);
		$nameFile=$general->NameToURL($n[0]).".".$n[1];
		$route=$_SERVER["REDIRECT_UPLOAD_FILE"].'uploads/'.$dirBase.'/'.$nameFile;
		
		$r=$inventory->InsertImage($nameFileO,$tmpName,$dirBase.'/'.$nameFile,$route);
		
		$result.='<div class="alert alert-info">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <strong>'.$r.' File: '.$nameFileO.'</strong>
				</div>';
		
		$output=['result'=>$result];
	}
}


echo json_encode($output);

?>