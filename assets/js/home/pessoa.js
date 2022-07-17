function testInput(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-zåäö ]/i);
    return pattern.test(value);
}
$('#pessoa_nome').bind('keypress', testInput);

$('[data-mask]').inputmask();

$(document).ready(function() {

    table_pessoa()

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#pessoa_logradouro").val("");
        $("#pessoa_bairro").val("");
        $("#pessoa_municipio").val("");
        $("#pessoa_estado").val("");
    }

    //Quando o campo cep perde o foco.
    $("#pessoa_cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#pessoa_logradouro").val("...");
                $("#pessoa_bairro").val("...");
                $("#pessoa_municipio").val("...");
                $("#pessoa_estado").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#pessoa_logradouro").val(dados.logradouro);
                        $("#pessoa_bairro").val(dados.bairro);
                        $("#pessoa_municipio").val(dados.localidade);
                        $("#pessoa_estado").val(dados.uf);

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        $.notify("CEP não encontrado.", 'warning');
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                $.notify("Formato de CEP inválido.", 'warning');
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
});
});
function table_pessoa() {

var table_pessoa = $('#table-pessoa').DataTable();
table_pessoa.destroy();
$('#table-pessoa').dataTable({
    "bProcessing": false,
    "pageLength": 10,
    "oLanguage": {
        "sLengthMenu": "Mostrar _MENU_ registros por página",
        "sZeroRecords": "Nenhum registro encontrado",
        "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
        "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
        "sInfoFiltered": "(filtrado de _MAX_ registros)",
        "sSearch": "Pesquisar: ",
        "oPaginate": {
            "sFirst": "Início",
            "sPrevious": "Anterior",
            "sNext": "Próximo",
            "sLast": "Último"
        }
    },
    "sAjaxSource": "fiesc/pessoa/table-pessoa",
    "aoColumns": [
        {data: 'Nome'},
        {data: 'CPF'},
        {data: 'Endereço', "sClass": "bold"},
        {data: 'Editar'},
        {data: 'Salvar'}
    ]
});
}

function salvar_pessoa() {

    var serializedData = new FormData();
    serializedData = $("#formularioPessoa").serializeArray();
    var pessoa_nome = $('#pessoa_nome').val();
    var pessoa_cpf = $('#pessoa_cpf').val();
    var pessoa_cep = $('#pessoa_cep').val();
    var id_pessoa = $('#id_pessoa').val();

    if (pessoa_nome != null && pessoa_nome != ""
            && pessoa_cpf != null && pessoa_cpf != ""
            && pessoa_cep != null && pessoa_cep != "")
    {

        if(id_pessoa > 0){
            bootbox.confirm("Confirma operação editar pessoa?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'fiesc/pessoa/edita-pessoa',
                        data: serializedData,
                        dataType: 'json',
                        success: function (data) {
                            $.notify('Cadastrado com sucesso!', "success");
                            table_pessoa();
                            limparInputs();
                        }, error: function (data) {
                            $.notify('Erro no Envio', "warning");
                        }
                    });
                }
            });
        }else{
            bootbox.confirm("Confirma operação inserir pessoa?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'fiesc/pessoa/insere-pessoa',
                        data: serializedData,
                        dataType: 'json',
                        success: function (data) {
                            $.notify('Cadastrado com sucesso!', "success");
                            table_pessoa();
                            limparInputs();
                        }, error: function (data) {
                            $.notify('Erro no Envio', "warning");
                        }
                    });
                }
            });
        }

    } else
    {
        if (pessoa_nome == null || pessoa_nome == "")
        {
            $.notify('Campo Nome é obrigatório.', "warning");
        }
        if (pessoa_cpf == null || pessoa_cpf == "")
        {
            $.notify('Campo CPF é obrigatório.', "warning");
        }
        if (pessoa_cep == null || pessoa_cep == "")
        {
            $.notify('Campo CEP é obrigatório.', "warning");
        }
    }
}

function limparInputs()
{
    // Limpar Select ou Select2 por ID
    limparItem('#id_pessoa');
    limparItem('#pessoa_nome');
    limparItem('#pessoa_cpf');
    limparItem('#pessoa_cep');
    limparItem('#pessoa_numero');
    limparItem('#pessoa_logradouro');
    limparItem('#pessoa_bairro');
    limparItem('#pessoa_estado');
    limparItem('#pessoa_municipio');
}


function limparItem($element, $value = null, $type = 0)
{
    var execute = true;
    // Object == select
    if ($type == 1)
    {
        if ($value == null)
            $value = -1;
        if ($($element + ' option').length == 0)
            execute = false;
    }
    if (execute)
    {
        $($element).val($value).trigger('change');
}
}

function editar(id, nome,cpf,cep,numero,logradouro,bairro,estado,municipio){
    $('#id_pessoa').val(id);
    $('#pessoa_nome').val(nome);
    $('#pessoa_cpf').val(cpf);
    $('#pessoa_cep').val(cep);
    $('#pessoa_numero').val(numero);
    $('#pessoa_logradouro').val(logradouro);
    $('#pessoa_bairro').val(bairro);
    $('#pessoa_estado').val(estado);
    $('#pessoa_municipio').val(municipio);
}

function remover(id) {

    bootbox.confirm("Confirma operação exclusão?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url:'fiesc/pessoa/excluir-pessoa',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluído com sucesso!', "success");
                    table_pessoa();
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}