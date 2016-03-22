<?php 
if(isset($_POST)){
	
	$idOrder = $_POST["idOrder"];
	$newStatusId = $_POST["newStatusId"];
	$jsonProducts = $_POST["jsonProducts"];
		
	require_once('../models/class.Orders.php');
	$order = new Order();

	$order->changeOrderStatus($idOrder, $newStatusId, $jsonProducts);
}
?>