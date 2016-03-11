

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

});

