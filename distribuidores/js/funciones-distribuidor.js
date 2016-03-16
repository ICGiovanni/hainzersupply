

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

});

