<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log</title>
  <!--<meta charset="utf-8">-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="js/jquery.js"></script>
 

  <script type="text/javascript">
        $(document).ready(function () {

            send();

       
        });

        function send()
        {
            var json='{"Sku":"7018140","Name":"Casco Para Moto","Stock":"12","Price":"700"}';
			$.ajax(
			{
				method: "POST",
				url: "updateProducts.php",
				data: { json: json}
			})
			.done(function( msg )
			{
      			$('#result').html(msg);	
			});
        }
	</script>
  
</head>
<body>
<div class="container">
	
	<div id="result" style="padding-top:10px;">
	</div>
</div>

</body>
</html>