<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventario</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
  <script src="js/jquery.js"></script>
  <script src="js/fileinput.js" type="text/javascript"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/fileinput_locale_es.js" type="text/javascript"></script>
  
</head>
<body>
<?php
	include ('../menu.php');
?>
<div class="container">
	<h1>Subir Inventario</h1>
	<form enctype="multipart/form-data">
	<input id="fileUpload" name="fileUpload" class="file" type="file" data-min-file-count="1" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
	</form>
	<div id="result" style="padding-top:10px;">	
	</div>
</div>

<script>

$("#fileUpload").fileinput(
{
	language: 'es',
	showCaption: true,
	browseClass: "btn btn-primary btn-lg",
	fileType: "xls,xlsx",
	uploadUrl: 'readInventory.php',
	allowedFileExtensions:['xls', 'xlsx']
});

$('#fileUpload').on('change', function(event)
{
    $('#result').html('');
});

$('#fileUpload').on('fileuploaded', function(event, data, previewId, index)
{
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response, reader = data.reader;
    console.log(response);
	$('#fileUpload').fileinput('clear');
	$('#fileUpload').fileinput('unlock');
	$('#result').html(response['result']);
});

</script>
</body>
</html>