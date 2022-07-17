$(document).ready(function () {
    $("#btn-entrar").click(function () { 
        if ($("#nume_matricula").val() == "") {
            $.notify("Por favor, informe o seu email.", 'warning');
            return false;
        }
        if ($("#codi_senha").val() == "") {
            $.notify("Por favor, informe a sua senha.", 'warning');
            return false;
        }
        var serializedData = $("#form_login").serialize();
        $.ajax({
            url: 'index.php/Login/validar_login',
            type: 'POST',
            data: serializedData,
            success: function (retorno) {
                $.ajax({
                    url: 'index.php/Login/ajax_redirect',
                    type: 'POST',
                    data: {location: 'index.php/Home'}
                });
            }
        });
    });
});
//------------------------------------------------------------------------------
$(document).keypress(function (e) {
    if (e.which == 13) {
        $("#btn-entrar").click();
    }
});