<?php 

if(!empty($_POST)){
	
	$idOrder = $_POST["idOrder"];
	$newStatusId = $_POST["newStatusId"];
	$jsonProducts = $_POST["jsonProducts"];
		
	require_once('../models/class.Orders.php');
	$order = new Order();

	$respuesta = $order->changeOrderStatus($idOrder, $newStatusId, $jsonProducts);
	
	if($respuesta == "success update"){
		//aqui linea del gio
		include_once $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
		$handler = curl_init($ruta."orders/create_json.php");
		$response = curl_exec ($handler);
		curl_close($handler);
	}
	echo $respuesta;
}
?>
