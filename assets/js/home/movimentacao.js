$('#openMovimentacao a').click(function () {

    $(".select_2").select2();

    $.ajax({
        type: 'POST',
        url: 'fiesc/movimentacao/lista-pessoa-conta',
        dataType: 'json',
        success: function (data) {
            var lista = $('select[id=movimentacao_pessoa]');
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

function changeNumeroConta(id){
    if(id != '' || id != null){
        $.ajax({
            type: 'POST',
            url: 'fiesc/movimentacao/lista-conta-numero',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                var lista = $('select[id=movimentacao_numero]');
                lista.html('');
                lista.append('<option value="" selected >Selecione</option>');
                var val = data.id_conta;
                var tam = val.length;
                for (var i = 0; i < tam; i++) {
                    lista.append('<option value="' + data.id_conta[i] + '">' + data.conta_numero[i] + ' - R$ <span id="teste">' + data.valor[i] + '</span></option>');
                }
            }
        });
    }
}

function verificaSaldo(id){
    if(id != '' || id != null){
        $.ajax({
            type: 'POST',
            url: 'fiesc/movimentacao/verifica-saldo',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (data) {
                $('#saldo').text(data.valor);
            }
        });
    }
}

function table_movimentacao(id_conta) {

    var table_movimentacao = $('#table-movimentacao').DataTable();
    table_movimentacao.destroy();
    $('#table-movimentacao').dataTable({
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
        "order": [[ 0, "desc" ]],
        "sAjaxSource": "fiesc/movimentacao/table-movimentacao",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "id_conta", "value": id_conta});
        },
        "aoColumns": [
            {data: 'Data'},
            {data: 'Valor'}
        ]
    });
}

function salvar_movimentacao() {

    var serializedData = new FormData();
    serializedData = $("#formularioMovimentacao").serializeArray();
    var movimentacao_pessoa = $('#movimentacao_pessoa').val();
    var movimentacao_numero = $('#movimentacao_numero').val();
    var movimentacao_depositar_retirar = $('#movimentacao_depositar_retirar').val();
    var movimentacao_valor = $('#movimentacao_valor').val();


    if (movimentacao_pessoa != null && movimentacao_pessoa != ""
            && movimentacao_numero != null && movimentacao_numero != ""
            && movimentacao_depositar_retirar != null && movimentacao_depositar_retirar != ""
            && movimentacao_valor != null && movimentacao_valor != "")
    {

        bootbox.confirm("Confirma operação inserir movimentação?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: 'fiesc/movimentacao/insere-movimentacao',
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        $.notify(data.mensagem, data.color);
                        table_movimentacao(movimentacao_numero);
                        verificaSaldo(movimentacao_numero);
                        changeNumeroConta(movimentacao_pessoa);
                        limparInputs();
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });

    } else
    {
        if (movimentacao_pessoa == null || movimentacao_pessoa == "")
        {
            $.notify('Campo Pessoa é obrigatório.', "warning");
        }
        if (movimentacao_numero == null || movimentacao_numero == "")
        {
            $.notify('Campo Conta é obrigatório.', "warning");
        }
        if (movimentacao_depositar_retirar == null || movimentacao_depositar_retirar == "")
        {
            $.notify('Campo Depósito/Retirada é obrigatório.', "warning");
        }
        if (movimentacao_valor == null || movimentacao_valor == "")
        {
            $.notify('Campo Valor é obrigatório.', "warning");
        }
    }
}

function limparInputs()
{
    // Limpar Select ou Select2 por ID
    //limparItem('#movimentacao_pessoa');
    //limparItem('#movimentacao_numero');
    limparItem('#movimentacao_depositar_retirar');
    limparItem('#movimentacao_valor');
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