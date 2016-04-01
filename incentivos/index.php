<?php
    include $_SERVER['REDIRECT_PATH_CONFIG'].'login/session.php';
    include_once($_SERVER['REDIRECT_PATH_CONFIG'].'config.php');
?>

<script src="<?php echo $raizProy?>js/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $raizProy?>css/buttons.css">
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


<?php include_once($_SERVER['REDIRECT_PATH_CONFIG'].'header.php')?>
<?php include_once($_SERVER['REDIRECT_PATH_CONFIG'].'menu.php')?>

<script src="<?php echo $raizProy?>incentivos/js/funcionesIncentivos.js"></script>




<div class="container">
    <h3 class="form-signin-heading">Listado de incentivos</h3>
    <br/>

        <div class="row">
            <div class="col-md-5">
                <input type="hidden" id="idIncentivo" value="">
                <label for="textoMostrar">Texto a mostrar: </label>
                <input type="text" id="textoMostrar" name="textoMostrar" class="form-control" placeholder="Texto a mostrar">
                <label for="textoMostrar">Detalle del incentivo:</label>
                <textarea class="form-control" id="detalleIncentivo" name="detalleIncentivo"></textarea>
                <br/>
                <button class="btn btn-primary right" id="guardarIncentivo">Guardar</button>

            </div>
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-6">
                <table class="table table-hover " width="100%">
                    <thead>
                        <tr>
                            <th>Texto</th>
                            <th>Detalle</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody id="listaIncentivos"></tbody>
                </table>
            </div>
        </div>


</div>