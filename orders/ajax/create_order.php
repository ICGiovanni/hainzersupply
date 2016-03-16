<?php 
require_once('../models/class.Orders.php');

$order = new Order();

print_r($_POST);
die();

$order->insertOrder();
?>