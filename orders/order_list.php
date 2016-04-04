<?php
include $_SERVER['REDIRECT_PATH_CONFIG'].'login/session.php';
include $_SERVER['REDIRECT_PATH_CONFIG'].'models/incentivos/class.Incentivos.php';
$insIncentivos = new Incentivos();

require_once('models/class.Orders.php');
if(isset($_SESSION['login_user']['idDistribuidor'])){
	$idDistribuidor = $_SESSION['login_user']['idDistribuidor'];
}
else{
	$idDistribuidor = 0;
}

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
	$html_boton_envio = '';
	$html_header_envio = '';
	
	if($idDistribuidor == 0){
		$html_boton_envio = '<td><button type="button" class="btn btn-primary btn-sm btn-agregar-incentivo" data-toggle="modal" data-target="#modalIncentivos" onclick="getIncentivos('.$orden["inv_orden_compra_id"].')">+</button></td>';
		$html_header_envio = '<th style="font-size: 8px !important;">Incentivos <br />y/o envío</th>';
	}
	
	
	$tr_orders.= '<tr>
		'.$html_boton_envio.'
		<td id="td_status_order_'.$orden["inv_orden_compra_id"].'">'.$td_status.'</td>
		<td>'.$orden["nombre"].'</td>
		
	<!--	<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_suma_precio_lista"],2).'</p></td> -->
		<td><p class="text-center">'.$orden["inv_orden_compra_factor_descuento"].'</p></td>
	<!--	<td><p class="text-right">$ '.number_format($orden["inv_orden_compra_suma_promociones"],2).'</p></td> -->
		<td><p class="text-right">$&nbsp;'.number_format($orden["inv_orden_compra_subtotal"],2).'</p></td>
		<td><p class="text-right">$&nbsp;'.number_format($orden["inv_orden_compra_iva"],2).'</p></td>
		<td>$&nbsp;'.number_format($orden["inv_orden_compra_costo_envio"],2).'</td>
		<td><p class="text-right"><b>$&nbsp;'.number_format($orden["inv_orden_compra_total"],2).'</b></p></td>
		<td><p class="text-center">'.$orden["inv_orden_compra_created_date"].'</p></td>
		<td><a href="pdf.php?idOrder='.$orden["inv_orden_compra_id"].'" target="_blank" class="btn btn-sm btn-primary" ><span class="glyphicon glyphicon-download-alt" style="color:white" aria-hidden="true"></span></a></td>
	</tr>
	';	
}
?>
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


<?php include $_SERVER['REDIRECT_PATH_CONFIG'].'header.php';?>
<?php include $_SERVER['REDIRECT_PATH_CONFIG'].'menu.php';?>

<div class="container">
<h3 class="page_title">Lista de Solicitudes de Compra </h3>
   
    <table data-toggle="table">
        <thead>
        <tr>
            <?=$html_header_envio?>
			<th>Estado</th>
			<th>Distribuidor</th>            
           <!-- <th><p class="text-center">Suma Precios<br> de Lista</p></th>-->
            <th>Factor de <br />Descuento</th>
			<!-- <th><p class="text-center">Suma de <br>Remates</p></th> -->
			<th>Subtotal</th>
			<th>IVA</th>
			<th>Costo<br> Envío</th>
			<th>Total Final</th>
			<th>Fecha de <br>Solicitud</th>
			<th></th>
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

<!-- Modal editar informacion contacto-->
<div class="modal fade" id="modalIncentivos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Incentivos</h4>
            </div>
            <div class="modal-body form-signin">
                <b>Incentivos aplicados</b>
                <div id="incentivosAplicados">
                    No hay registros
                </div>
                <br />
                <br />
                <b>Agregar Nuevo</b>
                <div id="agregarIncentivos">
                    <?php
                        $listaIncentivos = $insIncentivos->getList();
                        echo "<select id='incentivos' onchange='selectOption(this.value)'>";
                                echo "<option value='0'>selecciona una opción</option>";
                                echo "<option value='999'>Costo de envío</option>";
                            foreach($listaIncentivos as $incentivo){
                                echo "<option value='".$incentivo['idIncentivo']."'>".$incentivo['etiqueta']."</option>";
                            }
                        echo "</select>";
                        echo "<div id='envioContainer' style='display: none'>
                                <br />
                                Costo de envío:&nbsp;&nbsp;&nbsp;&nbsp; $ <input style='width: auto; display: inline;' type='text' id='costoEnvio' name='costoEnvio' value='' /> MX
                              </div>";
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="idOrdenModal" value="">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" onclick="agregarIncentivo();">Agregar incentivo</button>
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
	var inDiv = '<table class="table"> <thead> <tr> <th><div class="text-left">Name</div></th> <th>Cantidad</th> <th>Precio de Lista</th> </tr> </thead> <tbody>';
	for (var i = 0; i < jsonObj.rows.length; i++) {
		var object = jsonObj.rows[i];		
		// If property names are known beforehand, you can also just do e.g.
		// alert(object.sku + ',' + object.quantity + ',' + object.price);
		 
		 inDiv+='<tr> <td><div class="text-left">' + object.name + '</div></td><td>' + object.quantity + '</td><td>$ ' + object.price + '</td></tr>'; 
	}
	inDiv+=' </tbody> </table><div style="width:300px;"><b>Cambiar status de la solicitud de compra:</b><br> <?=$order->selectOrderStatus('orderStatus', '1', $idDistribuidor)?></div>';
	
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

function getIncentivos(idOrden){
    $("#idOrdenModal").val(idOrden);
    $.ajax({
        method: "POST",
        url: "ajax/incentivos_order.php",
        data: {
            accion: 'listIncentivosOrden',
            idOrden: idOrden
        }
    }).done(function( result ) {
        var data = JSON.parse(result);
        if(data.result){
            $("#incentivosAplicados").html('');
            $.each(data.result, function( index, value ) {
                $("#incentivosAplicados").append("<br /><b>°</b>&nbsp;"+value.descripcion);
            });
        }
        else{
            $("#incentivosAplicados").html('No hay incentivos aplicados a esta orden');
        }
    });
}

function selectOption(value){
    if(value==999){
        $("#envioContainer").show();
        $("#costoEnvio").val('');
    }
    else{
        $("#costoEnvio").val('');
        $("#envioContainer").hide();
    }
}

function agregarIncentivo(){
    var idOrder = $("#idOrdenModal").val();
    var idIncentivo = $("#incentivos").val();

    if(idIncentivo==999){
        console.log('guardar envio');
		costoEnvio = $("#costoEnvio").val();
		
		$.ajax({
			type: "POST",
			url: "ajax/change_shipping_cost.php",
			data: {
					idOrder: idOrder,
					costoEnvio: costoEnvio
			},
			success: function(msg){
				if(msg == "success update"){
					alert("El costo del envio ha sido actualizado para la orden seleccionada.");
					location.reload();
				}
			}
		});
		
    }else{
        $.ajax({
            method: "POST",
            url: "ajax/incentivos_order.php",
            data: {
                accion: 'agregarOrdenIncentivo',
                idOrder: idOrder,
                idIncentivo: idIncentivo
            }
        }).done(function( result ) {
            getIncentivos(idOrder);
            return false;
        });
    }

    
}

</script>
</body>
</html>
