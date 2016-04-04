<?php
include_once('models/class.Orders.php');
$order = New Order();

$productos = $order->getProducts();


$jsonRows = array();
$initiate_quantitys = '';
$count = 0;

while(list($idNum,$product)=each($productos)){

	
	$flag_discount = "normal";
	$span_tags='';
	$categories = explode(",",$product["Category"]);
	if(in_array("descuento",$categories)){
		$flag_discount = "discount";
		$span_tags='<span class="glyphicon glyphicon-tags"></span>';
	}
	$count++;

	$jsonRows[]='{
        "id": '.$idNum.',
		"sku": "'.$product["Sku"].'",
        "name": "'.str_replace('"','\"',$product["Name"]).'",
		"brand": "'.str_replace('"','\"',$product["Trademark"]).'",
		"color": "'.$product["Color"].'",
		"size": "'.$product["Size"].'",
		"stock": "'.$product["Stock"].'",
        "price": "'.$product["Price"].'",
		"type_price": "'.$flag_discount.'",
		"image": "'.$product["Img"].'"
    }';
}

$jsonString = '{ "rows": ['.implode(",",$jsonRows).'] }';

$jsonPathFile = 'json/data_product.json';

$handler = fopen($jsonPathFile, "w");
fwrite($handler, $jsonString);
fclose($handler);
?>
