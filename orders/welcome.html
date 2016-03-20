<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Table Examples</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-table.css">
	<link href="http://www.virtuosoft.eu/code/bootstrap-touchspin/bootstrap-touchspin/v3.0.1/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
    
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
<div class="container">
    <h1>Bootstrap Table Examples </h1>
  
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
                        title: 'Name',                       
                        align: 'left'
                    }, {
                        field: 'brand',
                        title: 'Brand',						
                        align: 'left'
                    }, {
                        field: 'color',
                        title: 'Color',						
                        align: 'left'
                    }, {
                        field: 'size',
                        title: 'Size',						
                        align: 'center'
                    }, {
                        field: 'stock',
                        title: 'Stock',						
                        align: 'right'
                    }, {
                        field: 'price',
                        title: 'Price',                        
                        align: 'right'                        
                    }, {
                        
                        title: 'Quantity',
                        align: 'center',
						formatter: quantityFormatter
                    }, {
                        field: 'operate',
                        title: 'Operate',
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
	
</script>
</body>
</html>