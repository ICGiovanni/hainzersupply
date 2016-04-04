<?php
include_once $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
require_once('models/class.Inventory.php');

$inventory=new Inventory();

$json=json_decode($_REQUEST["json"]);

$sku=$json->{'Sku'};
$name=$json->{'Name'};
$stock=$json->{'Stock'};
$price=$json->{'Price'};

$ID=$inventory->getSku($sku);

if($ID)
{
	echo $inventory->UpdateDataProduct($ID,$name,$stock,$price);
	$handler = curl_init($ruta."orders/create_json.php");
	$response = curl_exec ($handler);
	curl_close($handler);
}
else
{
	echo "No existe SKU";
}

?>