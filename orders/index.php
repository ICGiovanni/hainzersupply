<?php
include_once('models/class.Orders.php');
$order = New Order();

$productos = $order->getProducts();

$rows='';
$initiate_quantitys = '';
$count = 0;

while(list(,$product)=each($productos)){

	$flag_discount = "normal";
	$span_tags='';
	if($count%3==0){
		$flag_discount = "discount";
		$span_tags='<span class="glyphicon glyphicon-tags"></span>';
	}
	$count++;
	$rows.='<tr id="row_prod_'.$product["Sku"].'">
							<td>'.$product["Sku"].'</td>
							<td>'.$product["Name"].'</td>
							<td>'.$product["Trademark"].'</td>
							<td>'.$product["Color"].'</td>							
							<td>'.$product["Size"].'</td>
							<td>'.$product["Stock"].'</td>

							<td align="right">$'.number_format($product["Price"], 2, '.', '').'</td>
							<td><div id="dv_quantity_'.$product["Sku"].'" class="td_price"><input id="quantity_'.$product["Sku"].'" type="text" value="" name="quantity_'.$product["Sku"].'"></div><div id="dv_quantity_info_'.$product["Sku"].'"></div></td>
							<td><span class="glyphicon glyphicon-shopping-cart" id="add_prod_'.$product["Sku"].'" custom-data-1="'.$product["Price"].'" custom-data-2="'.$flag_discount.'"></span> '.$span_tags.'</td>
						</tr>';
	$initiate_quantitys.='$("input[name=\'quantity_'.$product["Sku"].'\']").TouchSpin({initval: 1,min: 1,max: '.$product["Stock"].',});
	';
}
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	
	<title>Hainzer Supply Solicitud de Compra</title>
	
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
	<link href="//cdn.virtuosoft.eu/virtuosoft.eu/resources/prettify/prettify.css" rel="stylesheet" type="text/css" media="all">
	<link href="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
	
	<link href="css/simple-sidebar.css" rel="stylesheet">
	<style type="text/css" class="init">
		body{ padding:0px 10px;}
		.td_price{width:120px; margin:auto;}
		.glyphicon-shopping-cart { cursor:pointer; }
		.glyphicon-pencil { cursor:pointer; }
		.bg-success { background-color:#000; }
	</style>
	
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.0.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js">
	</script>
	<script src="//cdn.virtuosoft.eu/virtuosoft.eu/resources/prettify/prettify.js"></script>
	<script src="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.js"></script>
	<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#example').DataTable({
        "lengthMenu": [[-1], ["All"]]
    });
	
	
} );

	</script>
</head>
<body>


<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
		
		
		<ul class="sidebar-nav">			
                <li class="sidebar-brand"  style="font-size:13px; color:#999">				                    
        <h2 style="color:#337AB7; margin-left:8px;"><span class="glyphicon glyphicon-eye-open"></span> Detalle</h2>
		<table class="table table-sm" >
			<tr>
				<td>Productos s/promoción</td>
				<td align="right"><span id="span_prod_s_prom"  style="color:#DF0404">$0.00</span></td>
			</tr>
			<tr>
				<td>Ud esta ahorrando <br><b>Nivel de ahorro: </b> <img id="img_save_level" src="img/low.png" width="40" /> <span id="span_save_level" style="color:#DF0404">LOW</span><br> <span id="span_desc_info" style="color:#fff; font-size:15px;">15% de descuento hasta $20mil</span>  </td>
				<td align="right"><span id="span_desc"  style="color:#DF0404">$0.00</span></td>
			</tr>
			<tr>
				<td>Productos s/promoción<br>con descuento aplicado</td>
				<td align="right">$<span id="span_prod_s_prom_c_desc" >0.00</span></td>
			</tr>
			<tr>
				<td>Productos<br> c/Remate</td>
				<td align="right">$<span id="span_prod_c_prom">0.00</span></td>
			</tr>
			<tr>
				<td>Total Pedido</td>
				<td align="right">$<span id="span_total_ped">0.00</span></td>
			</tr>
			<tr>
				<td>IVA</td>
				<td align="right">$<span id="span_iva">0.00</span></td>
			</tr>
			<tr>
				<td><b>Total final</b></td>
				<td align="right"><b>$<span id="span_total_final">0.00</span></b></td>
			</tr>
			
			
			<tr>
				<td colspan="2" >
				
				<div align="right"><br>
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" onclick="insertOrder();" >
						<span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar solicitud de compra
				</button>
				</div>
				<div align="left" style="margin-right:25px;">
					<br><br><br><br><b>ICONOGRAFIA</b><br>
					<br> <span class="glyphicon glyphicon-shopping-cart" ></span> Agregar al carrito
					<br> <span class="glyphicon glyphicon-pencil"></span> Editar Compra
					<br> <span class="glyphicon glyphicon-tags"></span> Producto con Remate
				</div>
				</td>
			</tr>
		</table>                    
                </li>
				
            </ul>
			
			
        </div>
		<!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
				<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply - Nueva Solicitud de Compra <button style="float:right;" onclick="changeStyleSpanDetailOrder();" class="btn btn-sm btn-primary" id="menu-toggle"><span id="span_btn_detail_order" class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> Detalle de solicitud</button></h3> 
				
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>SKU</th>
							<th>Name</th>
							<th>Brand</th>
							<th>Color</th>
							<th>Size</th>
							<th>Stock</th>

							<th>Price</th>

							<th>Quantity</th>
							<th>Order</th>
						</tr>
					</tfoot>
					<tbody>
						<?=$rows?>					
					</tbody>
				</table>
		
</div>
                </div>
            </div>
        </div>
		
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Procesando Solicitud de Compra...</h4>
      </div>
      <div class="modal-body" id="dv_body_modal">
			Su solicitud ha sido procesada		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
		<span id="span_delete_user"></span>
      </div>
    </div>
  </div>
</div>
</body>
<script>

	var init_items = '{ "rows" : [] }';
	var items_ordered = JSON.parse(init_items);;
	
	var factor_discount = 0.15;
	var factor_discount_description = '15% de descuento hasta $20mil';
	var img_save_level = 'low.png';
	var span_save_level = 'LOW';
	var span_save_level_color = '#DF0404';

	var productos_s_promocion = Number(0).toFixed(2);
	var discount = Number(0).toFixed(2);
	var productos_s_promocion_c_descuento = Number(0).toFixed(2);
	var productos_c_promocion = Number(0).toFixed(2);
	var total_pedido = Number(0).toFixed(2);
	var iva = Number(0).toFixed(2);
	var total_final = Number(0).toFixed(2);
	

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });	
	 $("input[name='demo3']").TouchSpin({
				initval: 1,
                min: 1,
                max: 999,
              
            });
			$("input[name='demo4']").TouchSpin({
				initval: 1,
                min: 1,
                max: 100,
              
            });
			$("input[name='demo5']").TouchSpin({
				initval: 1,
                min: 1,
                max: 100,
              
            });
	
	function addProductOrder(){
		
		id_prod = $(this).attr("id");
		id_prod = id_prod.replace("add_prod_","");
		
		add_price=$(this).attr("custom-data-1");
		type_price=$(this).attr("custom-data-2");
		
		quantity = $("#quantity_"+id_prod).val();
		
		add_price = Number(add_price) * Number(quantity);
		add_price = add_price.toFixed(2);
		
		items_ordered.rows.push({"sku":id_prod, "quantity":quantity, "price":add_price});		
		
		if(type_price=='discount'){
			
			productos_c_promocion = Number(productos_c_promocion) + Number(add_price);
			productos_c_promocion = productos_c_promocion.toFixed(2);
			
		} else if(type_price=='normal'){
			
			productos_s_promocion = Number(productos_s_promocion) + Number(add_price);
			productos_s_promocion = productos_s_promocion.toFixed(2);
			
			if( Number(productos_s_promocion) <= 20000 ){
				factor_discount = 0.15;
				factor_discount_description = '15% de descuento hasta $20mil';
				img_save_level = 'low.png';
				span_save_level = 'LOW';
				span_save_level_color = '#DF0404';
			}
			if( Number(productos_s_promocion) > 20000 ){
				factor_discount = 0.3;
				factor_discount_description = '30% de descuento hasta $199mil';
				img_save_level = 'medium.png';
				span_save_level = 'MEDIUM';
				span_save_level_color = '#EA8C00';
			}
			if( Number(productos_s_promocion) > 200000 ){
				factor_discount = 0.35;
				factor_discount_description = '35% de descuento apartir de $200mil';
				img_save_level = 'high.png';
				span_save_level = 'HIGH';
				span_save_level_color = '#26BC01';
			}
			
			discount = Number(productos_s_promocion) * Number(factor_discount);
			discount = discount.toFixed(2);
			
			productos_s_promocion_c_descuento = Number(productos_s_promocion) - Number(discount);
			productos_s_promocion_c_descuento = productos_s_promocion_c_descuento.toFixed(2);
			
		}
		
		total_pedido = Number(productos_s_promocion_c_descuento) + Number(productos_c_promocion);
		total_pedido = total_pedido.toFixed(2);
		
		iva = (Number(total_pedido)*0.16);
		iva = iva.toFixed(2);
		
		total_final = Number(total_pedido) + Number(iva);
		total_final = total_final.toFixed(2);
		
		$("#span_prod_s_prom").html("$"+productos_s_promocion);
		$("#span_desc").html("$"+discount);
		$("#span_prod_s_prom").css("color",span_save_level_color);
		$("#span_desc").css("color",span_save_level_color);
		$("#span_prod_s_prom_c_desc").html(productos_s_promocion_c_descuento);
		$("#span_prod_c_prom").html(productos_c_promocion);
		$("#span_total_ped").html(total_pedido);
		$("#span_iva").html(iva);
		$("#span_total_final").html(total_final);
		
		
		$(this).removeClass().addClass("glyphicon glyphicon-pencil");
		$("#row_prod_"+id_prod).css("background-color","#DFF0D8");
		$("#dv_quantity_"+id_prod).css("display","none");
		$("#dv_quantity_info_"+id_prod).html(quantity+" ordered");
		$("#span_desc_info").html(factor_discount_description);
		
		$("#img_save_level").attr("src","img/"+img_save_level);
		$("#span_save_level").html(span_save_level);
		$("#span_save_level").css("color",span_save_level_color);
		
		$(this).unbind("click");
		$(this).click(editProductOrder);
	}	
	
	function findId(idToLookFor) {
		var itemsArray = items_ordered.rows;
		for (var i = 0; i < itemsArray.length; i++) {
			if (itemsArray[i].sku == idToLookFor) {
				return(i);
			}
		}
	}
	
	function editProductOrder(){
		id_prod = $(this).attr("id");
		id_prod = id_prod.replace("add_prod_","");
		
		add_price=$(this).attr("custom-data-1");
		type_price=$(this).attr("custom-data-2");
		
		quantity = $("#quantity_"+id_prod).val();
		
		add_price = Number(add_price) * Number(quantity);
		add_price = add_price.toFixed(2);		
		
		rowIdJson = findId(id_prod);
		items_ordered.rows.splice(rowIdJson,1);
		
		if(type_price=='discount'){			
			
			productos_c_promocion = Number(productos_c_promocion) - Number(add_price);
			productos_c_promocion = productos_c_promocion.toFixed(2);
			
		} else if(type_price=='normal'){
			
			productos_s_promocion = Number(productos_s_promocion) - Number(add_price);
			productos_s_promocion = productos_s_promocion.toFixed(2);
			
			if( Number(productos_s_promocion) <= 20000 ){
				factor_discount = 0.15;
				factor_discount_description = '15% de descuento hasta $20mil';
				img_save_level = 'low.png';
				span_save_level = 'LOW';
				span_save_level_color = '#DF0404';
			}
			if( Number(productos_s_promocion) > 20000 ){
				factor_discount = 0.3;
				factor_discount_description = '30% de descuento hasta $199mil';
				img_save_level = 'medium.png';
				span_save_level = 'MEDIUM';
				span_save_level_color = '#EA8C00';
			}
			if( Number(productos_s_promocion) > 200000 ){
				factor_discount = 0.35;
				factor_discount_description = '35% de descuento apartir de $200mil';
				img_save_level = 'high.png';
				span_save_level = 'HIGH';
				span_save_level_color = '#26BC01';
			}
			
			discount = Number(productos_s_promocion) * Number(factor_discount) ;
			discount = discount.toFixed(2);

			productos_s_promocion_c_descuento = Number(productos_s_promocion) - Number(discount);
			productos_s_promocion_c_descuento = productos_s_promocion_c_descuento.toFixed(2);
			
		}
		
		total_pedido = Number(productos_s_promocion_c_descuento) + Number(productos_c_promocion);
		total_pedido = total_pedido.toFixed(2);
		
		iva = (Number(total_pedido)*0.16);
		iva = iva.toFixed(2);
		
		total_final = Number(total_pedido) + Number(iva);
		total_final = total_final.toFixed(2);

		$("#span_prod_s_prom").html("$"+productos_s_promocion);
		$("#span_desc").html("$"+discount);
		$("#span_prod_s_prom").css("color",span_save_level_color);
		$("#span_desc").css("color",span_save_level_color);
		$("#span_prod_s_prom_c_desc").html(productos_s_promocion_c_descuento);
		$("#span_prod_c_prom").html(productos_c_promocion);
		$("#span_total_ped").html(total_pedido);
		$("#span_iva").html(iva);
		$("#span_total_final").html(total_final);
		
	
		$(this).removeClass().addClass("glyphicon glyphicon-shopping-cart");
		$("#row_prod_"+id_prod).css("background-color","#fff");
		$("#dv_quantity_"+id_prod).css("display","block");
		$("#dv_quantity_info_"+id_prod).html("");
		$("#span_desc_info").html(factor_discount_description);
		
		$("#img_save_level").attr("src","img/"+img_save_level);
		$("#span_save_level").html(span_save_level);
		$("#span_save_level").css("color",span_save_level_color);
		
		
		$(this).unbind("click");
		$(this).click(addProductOrder);
	}
	
	$(".glyphicon-shopping-cart").click(addProductOrder);
	
	/////////////////////////
	
	function insertOrder(){
	
		if(items_ordered.rows.length > 0){
		
			inv_orden_compra_productos = JSON.stringify(items_ordered);
			inv_orden_compra_suma_precio_lista = productos_s_promocion;
			inv_orden_compra_factor_descuento = factor_discount;
			inv_orden_compra_suma_precio_lista_descuento_aplicado = productos_s_promocion_c_descuento;
			inv_orden_compra_suma_promociones = productos_c_promocion;
			inv_orden_compra_subtotal = total_pedido;
			inv_orden_compra_iva = iva;
			inv_orden_compra_total = total_final;
			
			
			msjModal = "<span class=\"glyphicon glyphicon-hourglass\" style=\"color:orange\"></span> Procesando... "; 
			$("#dv_body_modal").html(msjModal);
			
			$.ajax({
					type: "POST",
					url: "ajax/create_order.php",
					data: {
							inv_orden_compra_productos: inv_orden_compra_productos, 
							inv_orden_compra_suma_precio_lista: inv_orden_compra_suma_precio_lista, 
							inv_orden_compra_factor_descuento: inv_orden_compra_factor_descuento,
							inv_orden_compra_suma_precio_lista_descuento_aplicado: inv_orden_compra_suma_precio_lista_descuento_aplicado,
							inv_orden_compra_suma_promociones: inv_orden_compra_suma_promociones, 
							inv_orden_compra_subtotal: inv_orden_compra_subtotal, 
							inv_orden_compra_iva: inv_orden_compra_iva, 
							inv_orden_compra_total:inv_orden_compra_total
					},
					success: function(msg){
							/*$("#myModal").modal('hide'); */
							msjModal = "<span class=\"glyphicon glyphicon-ok\" style=\"color:green\"></span> Solicitud de compra ha sido procesada exitosamente. "; 
							$("#dv_body_modal").html(msjModal);
					}
				
				});
		} else { 
			msjModal = "<span class=\"glyphicon glyphicon-remove\" style=\"color:red\"></span> <span style=\"color:red\">Solicitud NO procesada,</span> debe existir al menos 1 producto "; 
			$("#dv_body_modal").html(msjModal);
		}
	}

	function changeStyleSpanDetailOrder(){
		currentClass = $("#span_btn_detail_order").attr("class");
		if(currentClass == 'glyphicon glyphicon-eye-close'){
			$("#span_btn_detail_order").removeClass().addClass("glyphicon glyphicon-eye-open");
		} else {
			$("#span_btn_detail_order").removeClass().addClass("glyphicon glyphicon-eye-close");
		}
	}
	
	<?=$initiate_quantitys?>

    </script>

</html>

