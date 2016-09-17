$(document).ready(function() {
    //Al escribr dentro del input con id="service"
    $('#compartirEmail').keyup(function(){

        //si esta en blanco borramos las sugerencias
        if($(this).val().length==0 ){
            $('#suggestions').html("");
        }
         //no buscamos hasta que no haya escrito 3 caracteres
        if($(this).val().length<3 ){
            return;
        }

        //Obtenemos el value del input
        var email = "email="+$(this).val();

        //limpiamos las sugerencias anteriores
        $('#suggestions').html("");
        //Le pasamos el valor del input al ajax
        $.ajax({
            type: "POST",
            url: "user/get",
            data: email,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                email="";
                $.each(data,function (i,val) {
                    if(val == " "){
                        var capaDiasSemana = $('<div class="suggest-element" value="'+email+'">'+email+'</div>');
                        capaDiasSemana.appendTo('#suggestions');
                        email="";
                    }else{
                        email+=val;
                    }
                });

                //Al hacer click en algua de las sugerencias
                $('.suggest-element').live('click', function(){
                    //Obtenemos la id unica de la sugerencia pulsada
                    $('#compartirEmail').attr('value', $(this).attr('value'));
                    //Editamos el valor del input con data de la sugerencia pulsada

                    //Hacemos desaparecer el resto de sugerencias
                    $('#suggestions').html("");
                });
            }
        });
    });
});

function mostarCompartir(){
    $(".compartir").show();
}