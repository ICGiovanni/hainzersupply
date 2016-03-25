<!DOCTYPE html>
<html>
<head>
    <title>Hainzer Supply Solicitud de Compra</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-table.css">
	<link href="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/simple-sidebar.css" rel="stylesheet">
	
	<style type="text/css" class="init">
		body{ padding:0px 10px;}
		.td_price{width:120px; margin:auto;}
		.glyphicon-shopping-cart { cursor:pointer; }
		.glyphicon-pencil { cursor:pointer; }
		.bg-success { background-color:#000; }
	</style>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-table-filter-control.js"></script>
	<script src="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.js"></script>
	<style type="text/css" class="init">
		body{ padding:0px 10px;}
		.td_price{width:120px; margin:auto;}
		.glyphicon-shopping-cart { cursor:pointer; }
		.glyphicon-pencil { cursor:pointer; }
		.bg-success { background-color:#000; }
	</style>
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
		
		<div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
				<h3 class="page_title"> <img src="http://ingenierosencomputacion.com.mx/login/img/logo.png" width="50" /> Hainzer Supply - Nueva Solicitud de Compra <button style="float:right;" onclick="changeStyleSpanDetailOrder();" class="btn btn-sm btn-primary" id="menu-toggle"><span id="span_btn_detail_order" class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> Detalle de solicitud</button></h3> 

				<table id="table"
					   data-side-pagination="server"
					   data-url="json/data_product.json"         
					   data-filter-control="true">
					   <thead>
					<tr>
						<th>Sku</th>
						<th data-filter-control="input">Name</th>
						<th data-filter-control="select">Brand</th>
						<th>Color</th>
						<th>Size</th>
						<th>Stock</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Operate</th>
					</tr>
					</thead>
					  
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="redirectList();" >Aceptar</button>
		<span id="span_delete_user"></span>
      </div>
    </div>
  </div>
</div>

</body>

<script>
    var $table = $('#table');

    function initTable() {
        $table.bootstrapTable({
           columns: [
                [
                    {
						field: 'sku',  
                        title: 'Sku',
                        align: 'left',
                        valign: 'middle'
                    }, {
                        field: 'name',
                        title: 'Nombre',                       
                        align: 'left'
                    }, {
                        field: 'brand',
                        title: 'Marca',						
                        align: 'left',
						width: '80px'
                    }, {
                        field: 'color',
                        title: 'Color',						
                        align: 'left'
                    }, {
                        field: 'size',
                        title: 'Talla',						
                        align: 'center'
                    }, {
                        field: 'stock',
                        title: 'Existencia',						
                        align: 'right'
                    }, {
                        field: 'price',
                        title: 'Precio',                        
                        align: 'right'                        
                    }, {
                        
                        title: 'Cantidad',
                        align: 'center',
						formatter: quantityFormatter
                    }, {
                        field: 'operate',
                        title: 'Acción',
                        align: 'left',
                        events: operateEvents,
                        formatter: operateFormatter
                    }
                ]
            ]
            
        });
        
    }

    function operateFormatter(value, row, index) {
	
		flag_discount = '';
		if(row.type_price == 'discount'){
			flag_discount = '<span class="glyphicon glyphicon-tags"></span>';
		}
		
			return [
				'<a class="like" href="javascript:void(0)" title="Like">',
				'<i class="glyphicon glyphicon-shopping-cart"></i>',
				'</a>  ',
				flag_discount
			].join('');
    }
	
	function quantityFormatter(value, row, index) {
	
		return [
				'<div class="td_price"> <input id="demo5" type="text" value="" name="demo5"> </div>',
				'<script> $("input[name=\'demo5\']").TouchSpin({initval: 1,min: 1,max: 100,}); <\/script>'
					
			].join('');
	}

    window.operateEvents = {
        'click .like': function (e, value, row, index) {
            alert('You click like action, row: ' + JSON.stringify(row));
        }
    };



    $(function () {
        var scripts = [
                location.search.substring(1) || 'js/bootstrap-table.js', 'js/bootstrap-table-filter-control.js'
            ],
            eachSeries = function (arr, iterator, callback) {
                callback = callback || function () {};
                if (!arr.length) {
                    return callback();
                }
                var completed = 0;
                var iterate = function () {
                    iterator(arr[completed], function (err) {
                        if (err) {
                            callback(err);
                            callback = function () {};
                        }
                        else {
                            completed += 1;
                            if (completed >= arr.length) {
                                callback(null);
                            }
                            else {
                                iterate();
                            }
                        }
                    });
                };
                iterate();
            };

        eachSeries(scripts, getScript, initTable);
    });

    function getScript(url, callback) {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.src = url;

        var done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState ||
                    this.readyState == 'loaded' || this.readyState == 'complete')) {
                done = true;
                if (callback)
                    callback();

                // Handle memory leak in IE
                script.onload = script.onreadystatechange = null;
            }
        };

        head.appendChild(script);

        // We handle everything using the script element injection
        return undefined;
    }
/*version original*/

/*version original*/
	
	
	
</script>
</html>