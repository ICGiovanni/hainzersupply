<?php

if(!empty($_POST)){
	
	$idOrder = $_POST["idOrder"];
	$costoEnvio = $_POST["costoEnvio"];
		
	require_once('../models/class.Orders.php');
	$order = new Order();

	echo $order->changeShippingCost($idOrder, $costoEnvio);
}
?>
