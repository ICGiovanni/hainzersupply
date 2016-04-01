
$(function() {

    loadList();

    $("#guardarIncentivo").click(function(){

        var etiqueta = $("#textoMostrar").val();
        var descripcion = $("#detalleIncentivo").val();
        var idIncentivo = $("#idIncentivo").val();

        if(etiqueta.length>0 && descripcion.length>0 && idIncentivo==''){
            $.ajax({
                method: "POST",
                url: "controllers/incentivosController.php",
                data: {
                    accion:'agregarIncentivo',
                    etiqueta: etiqueta,
                    descripcion: descripcion
                }
            }).done(function( result ) {
                console.log(result);
                $("#idIncentivo").val('');
                $("#textoMostrar").val('');
                $("#detalleIncentivo").val('');
                loadList();
            });
        }
        else if(etiqueta.length>0 && descripcion.length>0 && idIncentivo!=''){
            $.ajax({
                method: "POST",
                url: "controllers/incentivosController.php",
                data: {
                    accion:'actualizarIncentivo',
                    etiqueta: etiqueta,
                    descripcion: descripcion,
                    idIncentivo: idIncentivo

                }
            }).done(function( result ) {
                console.log(result);
                $("#idIncentivo").val('');
                $("#textoMostrar").val('');
                $("#detalleIncentivo").val('');
                loadList();
            });
        }
        else{
            alert('los campos no pueden ir vacios');
        }
    });

});

function loadList(){

    $.ajax({
        method: "POST",
        url: "controllers/incentivosController.php",
        data: {
            accion: "getIncentivos"
        }
    }).done(function( result ) {
        $("#listaIncentivos").html(result);
    });
}

function borrar(idIncentivo){
    var conf = confirm('desea borrar el incentivo?');
    if(conf){
        $.ajax({
            method: "POST",
            url: "controllers/incentivosController.php",
            data: {
                accion: "borrarIncentivos",
                idIncentivo:idIncentivo
            }
        }).done(function( result ) {
            loadList();
        });
    }
}

function loadIncentivo(idIncentivo){
    $.ajax({
        method: "POST",
        url: "controllers/incentivosController.php",
        data: {
            accion: "getIncentivo",
            idIncentivo:idIncentivo
        }
    }).done(function( result ) {

        var data = JSON.parse(result);
        $("#idIncentivo").val(data.idIncentivo);
        $("#textoMostrar").val(data.etiqueta);
        $("#detalleIncentivo").val(data.descripcion);

    });
}
