<?php
require_once('models/class.Orders.php');
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
							<td></td>
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
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js">
	</script>
	<script src="//cdn.virtuosoft.eu/virtuosoft.eu/resources/prettify/prettify.js"></script>
	<script src="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.js"></script>
	<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#example').DataTable({
        "lengthMenu": [[50, -1], [50, "All"]],
		select: true
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
        <h3 style="color:orange;"><span class="glyphicon glyphicon-eye-open"></span> Detalle Solicitud</h3>
		<table class="table table-sm" >
			<tr>
				<td>Productos<br> s/promoción</td>
				<td align="right">$<span id="span_prod_s_prom">0.00</span></td>
			</tr>
			<tr>
				<td>Ud esta ahorrando <br><span id="span_desc_info" style="color:#fff">15% hasta $20mil</span> <br> <b style="color:#fff;">Nivel de ahorro: </b></td>
				<td align="right">$<span id="span_desc">0.00</span></td>
			</tr>
			<tr>
				<td>Productos<br> s/promoción c/descuento</td>
				<td align="right">$<span id="span_prod_s_prom_c_desc">0.00</span></td>
			</tr>
			<tr>
				<td>Productos<br> c/promoción</td>
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
				<button type="button" class="btn btn-primary btn-sm" onclick="insertOrder();" >
						<span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar Solicitud
				</button>
				</div>
				<div align="center" style="margin-right:25px;">
					<br>ICONOGRAFIA
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
				<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply Solicitud de Compra <a style="float:right;" href="#menu-toggle" class="btn btn-sm btn-warning" id="menu-toggle"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detalle de solicitud</a></h3> 
				
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
</body>
<script>
	var init_items = '{ "rows" : [] }';
	var items_ordered = JSON.parse(init_items);;
	
	

	var productos_s_promocion = Number(0).toFixed(2);
	var descuento = Number(0).toFixed(2);
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
		
		items_ordered.rows.push({"sku":id_prod});
		
		
		if(type_price=='discount'){
			
			productos_c_promocion = Number(productos_c_promocion) + Number(add_price);
			productos_c_promocion = productos_c_promocion.toFixed(2);
			
		} else if(type_price=='normal'){
			
			productos_s_promocion = Number(productos_s_promocion) + Number(add_price);
			productos_s_promocion = productos_s_promocion.toFixed(2);
			
			factor_discount = 0.15;
			factor_discount_description = '15% hasta $20mil';
			if( Number(productos_s_promocion) > 20000 ){
				factor_discount = 0.3;
				factor_discount_description = '30% hasta $199mil';
			}
			if( Number(productos_s_promocion) > 200000 ){
				factor_discount = 0.35;
				factor_discount_description = '35% apartir de $200mil';
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
		
		$("#span_prod_s_prom").html(productos_s_promocion);
		$("#span_desc").html(discount);
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
		
		$(this).unbind("click");
		$(this).click(editProductOrder);
	}	
	
	function editProductOrder(){
		id_prod = $(this).attr("id");
		id_prod = id_prod.replace("add_prod_","");
		
		add_price=$(this).attr("custom-data-1");
		type_price=$(this).attr("custom-data-2");
		
		quantity = $("#quantity_"+id_prod).val();
		
		add_price = Number(add_price) * Number(quantity);
		add_price = add_price.toFixed(2);
				
		if(type_price=='discount'){			
			
			productos_c_promocion = Number(productos_c_promocion) - Number(add_price);
			productos_c_promocion = productos_c_promocion.toFixed(2);
			
		} else if(type_price=='normal'){
			
			productos_s_promocion = Number(productos_s_promocion) - Number(add_price);
			productos_s_promocion = productos_s_promocion.toFixed(2);
			
			factor_discount = 0.15;
			factor_discount_description = '15% hasta $20mil';
			if( Number(productos_s_promocion) > 20000 ){
				factor_discount = 0.3;
				factor_discount_description = '30% hasta $199mil';
			}
			if( Number(productos_s_promocion) > 200000 ){
				factor_discount = 0.35;
				factor_discount_description = '35% apartir de $200mil';
			}
			
			discount = Number(productos_s_promocion) * Number(factor_discount) ;
			discount = discount.toFixed(2);

			productos_s_promocion_c_descuento = Number(productos_s_promocion) - Number(discount);
			productos_s_promocion_c_descuento = productos_s_promocion_c_descuento.toFixed(2);
			
		}
		
		total_pedido = Number(productos_s_promocion) + Number(productos_s_promocion_c_descuento) + Number(productos_c_promocion);
		total_pedido = total_pedido.toFixed(2);
		
		iva = (Number(total_pedido)*0.16);
		iva = iva.toFixed(2);
		
		total_final = Number(total_pedido) + Number(iva);
		total_final = total_final.toFixed(2);

		$("#span_prod_s_prom").html(productos_s_promocion);
		$("#span_desc").html(discount);
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
		
		
		$(this).unbind("click");
		$(this).click(addProductOrder);
	}
	
	$(".glyphicon-shopping-cart").click(addProductOrder);
	
	/////////////////////////
	
	function insertOrder(){
		
	inv_orden_compra_productos = JSON.stringify(items_ordered);
	alert(inv_orden_compra_productos);
	
	return;
	inv_orden_compra_productos = ''; 
	inv_orden_compra_suma_precio_lista = 0; 
	inv_orden_compra_factor_descuento = 0;
	inv_orden_compra_suma_promociones = 0;
	inv_orden_compra_subtotal = 0;
	inv_orden_compra_iva = 0;
	inv_orden_compra_total = 0;
	
	$.ajax({
    		type: "POST",
			url: "ajax/create_order.php",
			data: {
					inv_orden_compra_productos: inv_orden_compra_productos, 
					inv_orden_compra_suma_precio_lista: inv_orden_compra_suma_precio_lista, 
					inv_orden_compra_factor_descuento: inv_orden_compra_factor_descuento,
					inv_orden_compra_suma_promociones: inv_orden_compra_suma_promociones, 
					inv_orden_compra_subtotal: inv_orden_compra_subtotal, 
					inv_orden_compra_iva: inv_orden_compra_iva, 
					inv_orden_compra_total:inv_orden_compra_total
			},
        	success: function(msg){
					$("#myModal").modal('hide'); 
					$("#button_save_changes").removeClass().addClass("btn btn-primary");
					$("#span_save_changes").removeClass();
					$("#img_profile_"+login_id).attr("src","/login/img/profile_"+profile+".jpg");
					$("#full_name_"+login_id).html(firstName+" "+lastName);
					$("#profile_name_"+login_id).html(profileName);
					$("#status_name_"+login_id).html(statusName);
					$("#status_name_"+login_id).removeClass().addClass("label label-"+CssStatus);
					
					$("#user_mail_"+login_id).html(email);
			}
		
      	});
	}

	
	<?=$initiate_quantitys?>

    </script>

</html>

