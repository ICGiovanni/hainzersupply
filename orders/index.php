<?php
	require_once('models/class.Orders.php');
$order = New Order();

$productos = $order->getProducts();

$rows='';

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
							<td><div class="td_price"><input id="demo5" type="text" value="" name="demo5"></div></td>
							<td><span class="glyphicon glyphicon-shopping-cart" id="add_prod_'.$product["Sku"].'" custom-data-1="'.$product["Price"].'" custom-data-2="'.$flag_discount.'"></span> '.$span_tags.'</td>
						</tr>';
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	
	<title>Hainzer Supply Orders</title>
	
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
        <h3 style="color:orange;"><span class="glyphicon glyphicon-shopping-cart"></span> Order Detail</h3>
		<table class="table table-sm" >
			<tr>
				<td>Productos<br> s/promoción</td>
				<td align="right">$<span id="span_prod_s_prom">   0.00 </span></td>
			</tr>
			<tr>
				<td>Descuento</td>
				<td align="right">$<span id="span_desc">  0.00 </span></td>
			</tr>
			<tr>
				<td>Productos<br> s/promoción c/descuento</td>
				<td align="right">$<span id="span_prod_s_prom_c_desc">  0.00 </span></td>
			</tr>
			<tr>
				<td>Productos<br> c/promoción</td>
				<td align="right">$<span id="span_prod_c_prom">  0.00 </span></td>
			</tr>
			<tr>
				<td>Total Pedido</td>
				<td align="right">$<span id="span_total_ped">  0.00 </span></td>
			</tr>
			<tr>
				<td>IVA</td>
				<td align="right">$<span id="span_iva">  0.00 </span></td>
			</tr>
			<tr>
				<td><b>Total final</b></td>
				<td align="right"><b>$<span id="span_total_final">  0.00 </span></b></td>
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
				<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply Orders <a style="float:right;" href="#menu-toggle" class="btn btn-sm btn-warning" id="menu-toggle"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Order Detail</a></h3> 

				
				
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
				
		if(type_price=='discount'){
			
			productos_c_promocion+=Number(add_price);
			
		} else if(type_price=='normal'){
			
			discount=(Number(add_price)*0.3).toFixed(2);
			
			aquidescuento = Number(add_price) - Number(discount);
			productos_s_promocion = Number(productos_s_promocion) + Number(aquidescuento);
			descuento+=Number(discount);
			
		}
		
		total_pedido = Number(productos_s_promocion) + Number(productos_s_promocion_c_descuento) + Number(productos_c_promocion);
		iva=(total_pedido*0.16).toFixed(2);
		total_final=Number(total_pedido)+Number(iva);
		total_final = total_final.toFixed(2);
		$("#span_prod_s_prom").html(productos_s_promocion);
		$("#span_desc").html(descuento);
		$("#span_prod_s_prom_c_desc").html(productos_s_promocion_c_descuento);
		$("#span_prod_c_prom").html(productos_c_promocion);
		$("#span_total_ped").html(total_pedido);
		$("#span_iva").html(iva);
		$("#span_total_final").html(total_final);
		
		
		$(this).removeClass().addClass("glyphicon glyphicon-pencil");
		color=$("#row_prod_"+id_prod).css("background-color","#DFF0D8");
		
		$(this).unbind("click");
		$(this).click(editProductOrder);
	}	
	
	function editProductOrder(){
		id_prod = $(this).attr("id");
		id_prod = id_prod.replace("add_prod_","");
		
		add_price=$(this).attr("custom-data-1");
		type_price=$(this).attr("custom-data-2");
				
		if(type_price=='discount'){			
			
			productos_c_promocion-=Number(add_price);
			
		} else if(type_price=='normal'){
			
			discount=(Number(add_price)*0.3).toFixed(2);
			quitar_a_s_promocion=(Number(add_price)-Number(discount)).toFixed(2);
			
			productos_s_promocion=(Number(productos_s_promocion)-Number(quitar_a_s_promocion)).toFixed(2);			
			
			descuento-=Number(discount);
			
		}
		
		total_pedido = Number(productos_s_promocion) + Number(productos_s_promocion_c_descuento) + Number(productos_c_promocion);
		
		
		
		iva=(total_pedido*0.16).toFixed(2);
		total_final=Number(total_pedido)+Number(iva);
		total_final = total_final.toFixed(2);
		$("#span_prod_s_prom").html(productos_s_promocion);
		$("#span_desc").html(descuento);
		$("#span_prod_s_prom_c_desc").html(productos_s_promocion_c_descuento);
		$("#span_prod_c_prom").html(productos_c_promocion);
		$("#span_total_ped").html(total_pedido);
		$("#span_iva").html(iva);
		$("#span_total_final").html(total_final);
		
	
		$(this).removeClass().addClass("glyphicon glyphicon-shopping-cart");
		color=$("#row_prod_"+id_prod).css("background-color","#fff");
		$(this).unbind("click");
		$(this).click(addProductOrder);
	}
	
	$(".glyphicon-shopping-cart").click(addProductOrder);
	
	/////////////////////////
	
	$("input[name='demo5']").TouchSpin({initval: 1,min: 1,max: 100,});

    </script>

</html>

