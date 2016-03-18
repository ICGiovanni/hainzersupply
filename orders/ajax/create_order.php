<?php 
if(isset($_POST)){
require_once('../models/class.Orders.php');
$order = new Order();
$_POST['inv_orden_compra_status_id'] = '1';
print_r($_POST);

$order->insertOrder($_POST);
}
?>