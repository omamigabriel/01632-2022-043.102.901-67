$('#openConta a').click(function () {

    table_conta();
    $(".select_2").select2();

    $.ajax({
        type: 'POST',
        url: 'fiesc/conta/lista-conta-pessoa',
        dataType: 'json',
        success: function (data) {
            var lista = $('select[id=conta_pessoa]');
            lista.html('');
            lista.append('<option value="" selected >Selecione</option>');
            var val = data.id;
            var tam = val.length;
            for (var i = 0; i < tam; i++) {
                lista.append('<option value="' + data.id[i] + '">' + data.nome[i] + ' - ' + data.cpf[i] + '</option>');
            }
        }
    });
});

function table_conta() {

    var table_conta = $('#table-conta').DataTable();
    table_conta.destroy();
    $('#table-conta').dataTable({
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
        "sAjaxSource": "fiesc/conta/table-conta",
        "aoColumns": [
            {data: 'Nome'},
            {data: 'CPF'},
            {data: 'NumeroConta', "sClass": "bold"},
            {data: 'Editar'},
            {data: 'Salvar'}
        ]
    });
}

function salvar_conta() {

    var serializedData = new FormData();
    serializedData = $("#formularioConta").serializeArray();
    var conta_pessoa = $('#conta_pessoa').val();
    var id_conta = $('#id_conta').val();

    if (conta_pessoa != null && conta_pessoa != "")
    {
        if(id_conta > 0){
            bootbox.confirm("Confirma operação editar conta?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'fiesc/conta/edita-conta',
                        data: serializedData,
                        dataType: 'json',
                        success: function (data) {
                            $.notify(data.mensagem, data.color);
                            table_conta();
                            limparInputs();
                        }, error: function (data) {
                            $.notify('Erro no Envio', "warning");
                        }
                    });
                }
            });
        }else{
            bootbox.confirm("Confirma operação inserir conta?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'fiesc/conta/insere-conta',
                        data: serializedData,
                        dataType: 'json',
                        success: function (data) {
                            $.notify(data.mensagem, data.color);
                            table_conta();
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
        if (conta_pessoa == null || conta_pessoa == "")
        {
            $.notify('Campo Pessoa é obrigatório.', "warning");
        }
    }
}

function limparInputs()
{
    // Limpar Select ou Select2 por ID
    limparItem('#id_conta');
    limparItem('#conta_pessoa');
    limparItem('#conta_numero');
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

function editar_conta(id_conta, id,conta_numero){
    $('#id_conta').val(id_conta);
    //$('#conta_pessoa').val(id);
    $("#conta_pessoa").val(id).change();
    $('#conta_numero').val(conta_numero);
}

function remover_conta(id) {

    bootbox.confirm("Confirma operação exclusão?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url:'fiesc/conta/excluir-conta',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluído com sucesso!', "success");
                    table_conta();
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}