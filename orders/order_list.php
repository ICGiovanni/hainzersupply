<?php
require_once('models/class.Orders.php');
$idDistribuidor = 1;
$order = New Order();

$ordersDistribuidor = $order->getOrders($idDistribuidor);
//print_r($ordersDistribuidor);
$tr_orders = '';
while(list($indice,$orden)=each($ordersDistribuidor)){
	$tr_orders.= '<tr data-title="bootstrap table">
		<td  class="td-class-1" data-title="bootstrap table">'.$orden["inv_orden_compra_status_desc"].'</td>
		<td>'.$orden["inv_orden_compra_productos"].'</td>
		<td>'.$orden["inv_orden_compra_suma_precio_lista"].'</td>
		<td>'.$orden["inv_orden_compra_factor_descuento"].'</td>
		<td>'.$orden["inv_orden_compra_suma_promociones"].'</td>
		<td>'.$orden["inv_orden_compra_subtotal"].'</td>
		<td>'.$orden["inv_orden_compra_iva"].'</td>
		<td>'.$orden["inv_orden_compra_total"].'</td>
		<td>'.$orden["inv_orden_compra_created_date"].'</td>
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
            <th>Suma Precios de Lista</th>
            <th>Factor de<br> Descuento</th>
			<th>Suma de <br>Remates</th>
			<th>Subtotal</th>
			<th>IVA</th>
			<th>Total Final</th>
			<th>Fecha de Solicitud</th>
        </tr>
        </thead>
        <tbody>
			<?=$tr_orders?>        
        </tbody>
    </table>
</div>
</body>
</html>
