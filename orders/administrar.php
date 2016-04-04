<?php
include $_SERVER['REDIRECT_PATH_CONFIG'].'login/session.php';
    include $_SERVER['REDIRECT_PATH_CONFIG'].'config.php';
include_once('models/class.Orders.php');

$order = New Order();
$productos = $order->getProductoSinStock();

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
	            <td><input type="checkbox" id="checkItem" class="checkbox" value="'.$product["Sku"].'"></td>
                <td class="Sku">'.$product["Sku"].'</td>
                <td class="Name">'.$product["Name"].'</td>
                <td class="Trademark">'.$product["Trademark"].'</td>
                <td class="Color">'.$product["Color"].'</td>
                <td class="Size">'.$product["Size"].'</td>
                <td class="Stock">'.$product["Stock"].'</td>
                <td class="Precio" align="right">$'.number_format($product["Price"], 2, '.', '').'</td>
                <td class="botones" align="right"><button class="btn btn-primary" onclick="editarProducto(\''.$product["Sku"].'\')"><span class="glyphicon glyphicon-pencil"></span></button></td>
            </tr>';
}
?>

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
        .before-sticky{
            width: 142% !important;
        }
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


    <?php include $_SERVER['REDIRECT_PATH_CONFIG'].'header.php';?>
    <?php include $_SERVER['REDIRECT_PATH_CONFIG'].'menu.php';?>
    <div class="container">
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
				<h3 class="page_title">Actualizar inventario</h3>
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
                            <th onclick="editCheck()" data-toggle="modal" data-target="#myModal">Editar <br />varios</th>
							<th>SKU</th>
							<th>Nombre</th>
							<th>Marca</th>
							<th>Color</th>
							<th>Talla</th>
							<th>Existencia</th>
							<th>Precio</th>
                            <th>Editar</th>
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

    <!-- Modal actualizar varios-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Actualizar varios productos</h4>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table>
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Existencias</td>
                                    <td>Precio</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" id="nombreModal" value=""></td>
                                    <td><input type="text" id="existenciaModal" value=""></td>
                                    <td><input type="text" id="precioModal" value=""></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="AccionEnvio">Guardar</button>
                </div>
            </div>
        </div>
    </div>
		

</body>
    <script>
        var init_items = '{ "rows" : [] }';
        var items_ordered = JSON.parse(init_items);;

        function findId(idToLookFor) {
            var itemsArray = items_ordered.rows;
            for (var i = 0; i < itemsArray.length; i++) {
                if (itemsArray[i].sku == idToLookFor) {
                    return(i);
                }
            }
        }

        function editarProducto(sku){

            var row = "#row_prod_"+sku;
            $(row).html("<td>&nbsp;</td>"+
                        "<td class='Sku'>"+$(row + " .Sku").html()+"</td>" +
                        "<td><input type='text' id='"+sku+"_inputName' value='"+$(row + " .Name").html()+"' /></td>" +
                        "<td class='Trademark'>"+$(row + " .Trademark").html()+"</td>" +
                        "<td class='Color'>"+$(row + " .Color").html()+"</td>" +
                        "<td class='Size'>"+$(row + " .Size").html()+"</td>" +
                        "<td><input type='text' id='"+sku+"_inputStock' value='"+$(row + " .Stock").html()+"' /></td>" +
                        "<td><input type='text' id='"+sku+"_inputPrecio' value='"+$(row + " .Precio").html().replace("$", "")+"' /></td>" +
                        "<td><button class='btn btn-danger' onclick=\"guardarProducto('"+sku+"')\"><span class='glyphicon glyphicon-ok'></span></button></td>"
            );
        }

        function guardarProducto(sku){
            var row = "#row_prod_"+sku;

            var nombre = $("#"+sku+"_inputName").val();
            var stock = $("#"+sku+"_inputStock").val();
            var precio = $("#"+sku+"_inputPrecio").val();
            $(row).html(
                "<td><input type='checkbox' class='checkbox' value='"+sku+"'></td>"+
                "<td class='Sku'>"+$(row + " .Sku").html()+"</td>" +
                "<td class='Name'>"+nombre+"</td>" +
                "<td class='Trademark'>"+$(row + " .Trademark").html()+"</td>" +
                "<td class='Color'>"+$(row + " .Color").html()+"</td>" +
                "<td class='Size'>"+$(row + " .Size").html()+"</td>" +
                "<td class='Stock'>"+stock+"</td>" +
                "<td class='Precio'>$"+precio+"</td>" +
                "<td><button class='btn btn-primary' onclick=\"editarProducto('"+sku+"')\"><span class='glyphicon glyphicon-pencil'></span></button></td>"
            );


            var json='{"Sku":"'+sku+'","Name":"'+nombre+'","Stock":"'+stock+'","Price":"'+precio+'"}';
            $.ajax({
                method: "POST",
                url: '<?php echo $raizProy?>excel/updateProducts.php',
                data: { json: json}
            }).done(function( msg ){
                $('#result').html(msg);

                $.get("<?php echo $raizProy?>orders/create_json.php", function( data ) {
                    console.log(data);
                });

            });

        }

        function editCheck(){
            var elem = 0;
            $.each($(".checkbox"), function (){
                if($(this).prop('checked') && elem==0){

                    var sku = $(this).val();
                    var row = "#row_prod_"+sku;

                    $("#nombreModal").val($(row + " .Name").html());
                    $("#existenciaModal").val($(row + " .Stock").html());
                    $("#precioModal").val($(row + " .Precio").html());
                    elem = 1
                }

            });
        }

    </script>
</html>