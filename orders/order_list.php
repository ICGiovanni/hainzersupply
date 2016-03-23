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
	
	if($orden["inv_orden_compra_status_id"] == 1){
		$td_status = '<a data-toggle="modal" style="cursor:pointer;" data-target="#myModal" onclick="checkOrder(this);" data-custom-00="'.$orden["inv_orden_compra_id"].'" data-custom-01="'.trim(str_replace('"',"'",$orden["inv_orden_compra_productos"])).'">
						<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> '.$orden["inv_orden_compra_status_desc"].'
				</a>';
	}
	elseif($orden["inv_orden_compra_status_id"] == 2){
		$td_status = '<span class="glyphicon glyphicon-ok-circle" style="color:green" aria-hidden="true"></span> '.$orden["inv_orden_compra_status_desc"];
	}
	elseif($orden["inv_orden_compra_status_id"] == 3){
		$td_status = '<span class="glyphicon glyphicon-ban-circle" style="color:red" aria-hidden="true"></span> '.$orden["inv_orden_compra_status_desc"];
	}
		
	
	$tr_orders.= '<tr>
		<td id="td_status_order_'.$orden["inv_orden_compra_id"].'">'.$td_status.'</td>
		<td>'.$orden["nombre"].'</td>
		<td>'.$numProducts.' Productos</td>
	<!--	<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_suma_precio_lista"],2).'</p></td> -->
		<td><p class="text-center">'.$orden["inv_orden_compra_factor_descuento"].'</p></td>
	<!--	<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_suma_promociones"],2).'</p></td> -->
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_subtotal"],2).'</p></td>
		<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_iva"],2).'</p></td>
		<td><p class="text-right"><b>$ '.number_format($orden["inv_orden_compra_total"],2).'</b></p></td>
		<td><p class="text-center">'.$orden["inv_orden_compra_created_date"].'</p></td>
	</tr>
	';	
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Solicitudes de Compra - Hainzer Supply</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://issues.wenzhixin.net.cn/bootstrap-table/assets/bootstrap-table/src/bootstrap-table.css">
  

	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.0.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="http://issues.wenzhixin.net.cn/bootstrap-table/assets/bootstrap-table/src/bootstrap-table.js"></script>
 
	<style type="text/css" class="init">
		body{ padding:0px 10px;}
		.table td, .table th {
   text-align: center;   
}
	</style>

</head>
<body>
<?php include '../menu.php'?>
<div class="container">
<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply - Lista de Solicitudes de Compra </h3>    
   
    <table data-toggle="table">
        <thead>
        <tr>
			<th>Status</th>
			<th>Distribuidor</th>
            <th>Productos</th>
           <!-- <th><p class="text-center">Suma Precios<br> de Lista</p></th>-->
            <th><p class="text-center">Factor de<br> Descuento</p></th>
			<!-- <th><p class="text-center">Suma de <br>Remates</p></th> -->
			<th><p class="text-center">Subtotal</p></th>
			<th><p class="text-center">IVA</p></th>
			<th><p class="text-center">Total Final</p></th>
			<th><p class="text-center">Fecha de <br>Solicitud</p></th>
        </tr>
        </thead>
        <tbody>
			<?=$tr_orders?>        
        </tbody>
    </table>
	<h5 class="page_title"> Se listaran siempre solicitudes en status "Por revisar".<br> Se listaran solicitudes "Cancelada" y "Compra Realizada" no mayores a 2 semanas. </h5> 
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de productos</h4>
      </div>
      <div class="modal-body" id="dv_body_modal">
				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
		<button id="button_create_user" type="button" class="btn btn-danger" onclick="changeOrderStatus();">Guardar nuevo status</button>
		<span id="span_delete_user"></span>
      </div>
    </div>
  </div>
</div>

<script>

function checkOrder(elem){
	idOrder = $(elem).attr("data-custom-00");
	jsonProducts = $(elem).attr("data-custom-01");
	jsonProducts = jsonProducts.replace(/'/g,'"');
	
	//$("#button_create_user").removeClass().addClass("btn btn-danger");
	$("#button_create_user").removeAttr("disabled");
	
	var jsonObj = $.parseJSON( jsonProducts );
	var inDiv = '<table class="table"> <thead> <tr> <th>Sku</th> <th>Cantidad</th> <th>Precio</th> </tr> </thead> <tbody>';
	for (var i = 0; i < jsonObj.rows.length; i++) {
		var object = jsonObj.rows[i];		
		// If property names are known beforehand, you can also just do e.g.
		// alert(object.sku + ',' + object.quantity + ',' + object.price);
		 
		 inDiv+='<tr> <td>' + object.sku + '</td><td>' + object.quantity + '</td><td>$ ' + object.price + '</td></tr>'; 
	}
	inDiv+=' </tbody> </table><div style="width:300px;"><b>Cambiar status de la solicitud de compra:</b><br> <?=$order->selectOrderStatus()?></div>';
	
	$("#dv_body_modal").html(inDiv);
}

function changeOrderStatus(){
	
	newStatusId = $("#orderStatus").val();
	newStatusName=$("#orderStatus option:selected" ).text();
	if(newStatusId == 1){
		alert("El status de la orden no ha sido cambiada, seleccione un nuevo status.");
	} else {
		
		//$("#button_create_user").addClass("disabled");
		$("#button_create_user").attr("disabled","disabled");
		msjModal = "<span class=\"glyphicon glyphicon-hourglass\" style=\"color:orange\"></span> Procesando... "; 
		$("#dv_body_modal").html(msjModal);
		
		$.ajax({
			type: "POST",
			url: "ajax/change_order_status.php",
			data: {
					idOrder: idOrder,
					newStatusId: newStatusId, 
					jsonProducts: jsonProducts
			},
			success: function(msg){
					/*$("#myModal").modal('hide'); */
					if(msg == "success update"){
						msjModal = "<span class=\"glyphicon glyphicon-ok\" style=\"color:green\"></span> El status de la solicitud de compra ha sido actualizada exitosamente. ";
						$("#dv_body_modal").html(msjModal);
						
						if(newStatusId == 2){
							newSpanStatus = '<span class="glyphicon glyphicon-ok-circle" style="color:green" aria-hidden="true"></span> '+newStatusName;
						} else if(newStatusId == 3){
							newSpanStatus = '<span class="glyphicon glyphicon-ban-circle" style="color:red" aria-hidden="true"></span> '+newStatusName;
						}
						
						$("#td_status_order_"+idOrder).html(newSpanStatus);						
					} else {
						if(newStatusId == 2){
							msjModal = "La solicitud no puede ser actualizada como <b>Compra Realizada</b>, inventario insuficiente en los productos:<br>"+msg;
						} else {
							msjModal = msg;
						}
						
						$("#dv_body_modal").html(msjModal);
					}
			}

		});
	}
}

</script>
</body>
</html>