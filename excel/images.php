<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'login/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Imagenes</title>
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

<?php include_once($_SERVER['REDIRECT_PATH_CONFIG'].'header.php')?>
<?php include_once($_SERVER['REDIRECT_PATH_CONFIG'].'menu.php')?>
<div class="container">
	<h1>Subir Imagenes</h1>
	<form enctype="multipart/form-data">
	<input id="fileU" name="fileUpload[]" type="file" multiple=true class="file-loading">
	</form>
	<div id="result" style="padding-top:10px;">	
	</div>
</div>

<script>

$("#fileU").fileinput({
    language: 'es',
	showCaption: true,
	browseClass: "btn btn-primary btn-lg",
	dropZoneEnabled:true,
	fileType: "jpg,jpge,png,bit",
	uploadUrl: "upload.php",
    uploadAsync: false,
    minFileCount:1
});

/*$("#fileUpload").fileinput(
{
	language: 'es',
	showCaption: true,
	browseClass: "btn btn-primary btn-lg",
	fileType: "xls,xlsx",
	uploadUrl: 'readInventory.php',
	allowedFileExtensions:['xls', 'xlsx']
});*/

$('#fileU').on('change', function(event)
{
    $('#result').html('');
});

$('#fileU').on('filebatchuploadsuccess', function(event, data, previewId, index)
{
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response, reader = data.reader;
    console.log(response);
	$('#fileU').fileinput('clear');
	$('#fileU').fileinput('unlock');
	$('#result').append(response['result']);	
});

</script>
</body>
</html>