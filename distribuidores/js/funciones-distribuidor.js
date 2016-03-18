

$(function() {

    $("#copiarDireccion").click(function(){

        if($(this).prop("checked")) {
            $("#calleEnvio").val($("#calleFacturacion").val());
            $("#numExtEnvio").val($("#numExtFacturacion").val());
            $("#numIntEnvio").val($("#numIntFacturacion").val());
            $("#cpEnvio").val($("#cpFacturacion").val());
            $("#coloniaEnvio").val($("#coloniaFacturacion").val());
            $("#delegacionEnvio").val($("#delegacionFacturacion").val());
            $("#estadoEnvio").val($("#estadoFacturacion").val());
            $("#paisEnvio").val($("#paisFacturacion").val());
        }
        else{
            $("#calleEnvio").val('');
            $("#numExtEnvio").val('');
            $("#numIntEnvio").val('');
            $("#cpEnvio").val('');
            $("#coloniaEnvio").val('');
            $("#delegacionEnvio").val('');
            $("#estadoEnvio").val('');
            $("#paisEnvio").val('');
        }

    });

    $(".btn-info-dist").click(function(){
        var idDistribuidor = $(this).attr('idform');
        $("#idDistribuidor").val(idDistribuidor);
        $("#infoDistribuidor").submit();
    });

    $(".btn-del-dist").click(function(){
        //$(this).parent().parent().remove();
    });

    $(".btn-editar-factura").click(function(){

        var idFactura = $(this).attr('data-id');
        var idDireccion = $(this).attr('data-idDireccion');
        $("#rfc").val($("#factura_"+idFactura+" .rfc").html());
        $("#razonSocial").val($("#factura_"+idFactura+" .razonSocial").html());
        $("#calleFacturacion").val($("#factura_"+idFactura+" .calle").html());
        $("#numExtFacturacion").val($("#factura_"+idFactura+" .numExt").html());
        $("#numIntFacturacion").val($("#factura_"+idFactura+" .numInt").html());
        $("#cpFacturacion").val($("#factura_"+idFactura+" .cp").html());
        $("#coloniaFacturacion").val($("#factura_"+idFactura+" .colonia").html());
        $("#delegacionFacturacion").val($("#factura_"+idFactura+" .delegacion").html());
        $("#estadoFacturacion").val($("#factura_"+idFactura+" .estado").html());
        $("#paisFacturacion").val($("#factura_"+idFactura+" .pais").html());

        $("#accion").val('actualizarFacturacion');
        $("#idDistribuidorFactura").val(idFactura);
        $("#idDireccionFactura").val(idDireccion);
        $("#AccionFacturacion").html("Actualizar");

    });

    $(".btn-agregar-factura").click(function(){
        $("#rfc").val('');
        $("#razonSocial").val('');
        $("#calleFacturacion").val('');
        $("#numExtFacturacion").val('');
        $("#numIntFacturacion").val('');
        $("#cpFacturacion").val('');
        $("#coloniaFacturacion").val('');
        $("#delegacionFacturacion").val('');
        $("#estadoFacturacion").val('');
        $("#paisFacturacion").val('');

        $("#accion").val('agregarFacturacion');
        $("#idDistribuidorFactura").val('');
        $("#idDireccionFactura").val('');
        $("#AccionFacturacion").html("Guardar");

    });

    $(".btn-agregar-envio").click(function(){

        $("#calleEnvio").val('');
        $("#numExtEnvio").val('');
        $("#numIntEnvio").val('');
        $("#cpEnvio").val('');
        $("#coloniaEnvio").val('');
        $("#delegacionEnvio").val('');
        $("#estadoEnvio").val('');
        $("#paisEnvio").val('');

        $("#accion").val('agregarDirEnvio');
        $("#idDireccion").val('');
        $("#AccionEnvio").html("Guardar");
    });

    $(".btn-editar-envio").click(function(){
        var idDireccion = $(this).attr('data-idDireccion');

        $("#calleEnvio").val($("#envio_"+idDireccion+" .calle").html());
        $("#numExtEnvio").val($("#envio_"+idDireccion+" .numExt").html());
        $("#numIntEnvio").val($("#envio_"+idDireccion+" .numInt").html());
        $("#cpEnvio").val($("#envio_"+idDireccion+" .cp").html());
        $("#coloniaEnvio").val($("#envio_"+idDireccion+" .colonia").html());
        $("#delegacionEnvio").val($("#envio_"+idDireccion+" .delegacion").html());
        $("#estadoEnvio").val($("#envio_"+idDireccion+" .estado").html());
        $("#paisEnvio").val($("#envio_"+idDireccion+" .pais").html());

        $("#accion").val('editarDirEnvio');
        $("#idDireccion").val(idDireccion);
        $("#AccionEnvio").html("Actualizar");

    });

    $(".btn-editar-dist").click(function(){
        $("#nombreDistribuidor").val($(".nombre").html());
        $("#representanteDistribuidor").val($(".representante").html());
        $("#telefonoDistribuidor").val($(".telefono").html());
        $("#celularDistribuidor").val($(".celular").html());
        $("#emailDistribuidor").val($(".correoElectronico").html());

        $("#nivelDistribuidor option[value='"+$(".nivel").html()+"']").prop('selected', true);
    });

    $("#AccionFacturacion").click(function(){
        $("#envio-facturacion").submit();
    });

    $("#AccionEnvio").click(function(){
        $("#form-envio").submit();
    });

    $("#actualizar-distribuidor").click(function(){
        $("#form-contacto").submit();
//
    });
});

