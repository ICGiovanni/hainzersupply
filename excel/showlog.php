<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log</title>
  <!--<meta charset="utf-8">-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
  <script src="js/jquery.js"></script>
  <script src="js/fileinput.js" type="text/javascript"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/fileinput_locale_es.js" type="text/javascript"></script>

  <script type="text/javascript">
        $(document).ready(function () {
            (function ($) {
				refresh();
				$('#filtrar').focus();           
                $('#filtrar').keyup(function () {
                    
                    var rex = new RegExp($(this).val(), 'i');
                    $('.buscar tr').hide();
                    $('.buscar tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });

        function restoreLog(restore)
        {
            var msj="�Desea restaurar la informaci�n?";
        	if (confirm(msj) == true)
            {
        		$.ajax({
          		  method: "POST",
          		  url: "log.php",
          		  data: { action: "restore",restore:restore}
          		})
          		.done(function( msg )
				{
          			alert( "Datos restaurados");
				});
            }
        }

        function deleteLog(id)
        {
        	var msj="�Desea eliminar el Registro?";
        	if (confirm(msj) == true)
            {
        		$.ajax(
                {
					method: "POST",
					url: "log.php",
            		data: { action: "delete",id:id}
            	})
            	.done(function( msg )
  				{
            		refresh();
            		alert( "Registro Eliminado");
  				});
            }
        }

        function refresh()
        {
			$.ajax(
			{
				method: "POST",
				url: "log.php",
				data: { action: "refresh"}
			})
			.done(function( msg )
			{
      			$('#result').html(msg);	
			});
        }

	</script>
  
</head>
<body>

<?php include $_SERVER['REDIRECT_PATH_CONFIG'].'header.php';?>
<?php include $_SERVER['REDIRECT_PATH_CONFIG'].'menu.php';?>

<div class="container">
	<div class="input-group">
  	<span class="input-group-addon">Buscar</span>
  	<input id="filtrar" type="text" class="form-control">
	</div>
	
	<div id="result" style="padding-top:10px;">
	</div>
</div>

</body>
</html>