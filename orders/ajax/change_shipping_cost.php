<?php

if(!empty($_POST)){
	
	$idOrder = $_POST["idOrder"];
	$costoEnvio = $_POST["costoEnvio"];
		
	require_once('../models/class.Orders.php');
	$order = new Order();

	$result = $order->changeShippingCost($idOrder, $costoEnvio);
	if($result == "success update"){
		$order->sendEmailOrder($idOrder,2);
		echo $result;
	}
	
}
?>
