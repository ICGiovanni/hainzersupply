<?php 
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
}
else
{
	echo "No existe SKU";
}

?>