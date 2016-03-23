<?php
require_once('models/class.Orders.php');
$idDistribuidor = 1;
$order = New Order();

$ordersDistribuidor = $order->getOrders($idDistribuidor);
//print_r($ordersDistribuidor);
$tr_orders = '';
while(list($indice,$orden)=each($ordersDistribuidor)){
	
	$products = json_decode($orden["inv_orden_compra_productos"]);
	
	$numProducts = count($products->rows);
	
	$tr_orders.= '<tr data-title="bootstrap table">
		<td  class="td-class-1" data-title="bootstrap table">'.$orden["inv_orden_compra_status_desc"].'</td>
		<td>'.$numProducts.' Productos</td>
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_suma_precio_lista"],2).'</p></td>
		<td><p class="text-center">'.$orden["inv_orden_compra_factor_descuento"].'</p></td>
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_suma_promociones"],2).'</p></td>
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_subtotal"],2).'</p></td>
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_iva"],2).'</p></td>
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_total"],2).'</p></td>
		<td><p class="text-center">'.$orden["inv_orden_compra_created_date"].'</p></td>
	</tr>
	';	
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Solicitudes de Compra - Hainzer Supply</title>
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://issues.wenzhixin.net.cn/bootstrap-table/assets/bootstrap-table/src/bootstrap-table.css">
  

	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.0.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="http://issues.wenzhixin.net.cn/bootstrap-table/assets/bootstrap-table/src/bootstrap-table.js"></script>
 
	<style type="text/css" class="init">
		body{ padding:0px 10px;}
	</style>

</head>
<body>
<div class="container">
<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply - Lista de Solicitudes de Compra </h3> 
   
   
    <table data-toggle="table">
        <thead>
        <tr>
            <th>Status</th>
            <th>Productos</th>
            <th><p class="text-center">Suma Precios<br> de Lista</p></th>
            <th><p class="text-center">Factor de<br> Descuento</p></th>
			<th><p class="text-center">Suma de <br>Remates</p></th>
			<th><p class="text-center">Subtotal</p></th>
			<th><p class="text-center">IVA</p></th>
			<th><p class="text-center">Total Final</p></th>
			<th><p class="text-center">Fecha de Solicitud</p></th>
        </tr>
        </thead>
        <tbody>
			<?=$tr_orders?>        
        </tbody>
    </table>
</div>
</body>
</html>
