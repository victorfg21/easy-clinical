@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Lançamento de Resultado de Exame</h3>
    </div>
    <div class="box-body">
        <div class="form-group col-md-3">
            <label for="solicitacao_data" class="control-label">Data</label>
            <input for="solicitacao_data" class="form-control" type="date" name="solicitacao_data"
                value="{{ date("Y-m-d") }}" />
        </div>
        <div class="form-group col-md-2">
            <label for="solicitacao_id" class="control-label">ID Solicitação</label>
            <input for="solicitacao_id" class="form-control numero" name="solicitacao_id" value="" />
        </div>
        <div class="form-group col-md-7">
            <label for="profissional_id" class="control-label">Profissional</label>
            <select for="profissional_id" class="form-control js-example-responsive" name="profissional_id">
                <option value="" selected></option>
                @foreach ($profissional_list as $profissional)
                    <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="table-responsive col-md-12">
            <table id="tblResultado" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1">ID</th>
                        <th class="col-xs-2">Data</th>
                        <th class="col-xs-4">Paciente</th>
                        <th class="col-xs-4">Profissional</th>
                        <th class="col-xs-1"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('atendimento.resultado-exame.create') }}', 'Adicionar Resultado', '#modal_CRUD', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblResultado = $('#tblResultado').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false,
    "order"       : [[ 0, "asc" ]],
    "processing"  : true,
    "serverSide"  : true,
    "language": {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
    },
    "ajax":{
        "url": "{!! route('atendimento.resultado-exame.listarsolicitacoes') !!}",
        "dataType": "json",
        "type": "get",
        "data": function (d) {
            d.solicitacao_data = $("input[name=solicitacao_data]").val(),
            d.profissional_id = $('select[name=profissional_id]').val(),
            d.solicitacao_id = $('select[name=solicitacao_id]').val()
        },
    },
    "columns": [
            { "data": "id", "className": "id", "width": "5%" },
            { "data": "data", "className": "data", "width": "5%" },
            { "data": "paciente_nome", "className": "paciente_nome", "width": "30%", "visible": false },
            { "data": "profissional_nome", "className": "profissional_nome", "width": "30%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
            }, "width": "20%"},
    ],
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: 1 },
        { responsivePriority: 4, targets: 2 },
        { responsivePriority: 5, targets: 3 },
        {
            "targets": [7],
            "orderable": false
        }
    ]
});

$('input[name=solicitacao_data]').change(function () {
    tblResultado.ajax.reload();
});

$('select[name=profissional_id]').change(function () {
    tblResultado.ajax.reload();
});

$('select[name=solicitacao_id]').change(function () {
    tblResultado.ajax.reload();
});

/*$(document).on('click', '.addConsulta', function () {
    var profissional_id = $(this).closest("tr").find(".profissional_id").text();
    var data = moment($(this).closest("tr").find(".data").text(), 'DD/MM/YYYY').format("YYYY-MM-DD");
    var hora = $(this).closest("tr").find(".hora").text();
    $.ajax({
        url: "{{ route('atendimento.resultado-exame.create') }}",
        type: 'GET',
        data: {profissional_id: profissional_id, data: data, hora: hora},

        success: function (data) {
            modalBootstrapView(data, 'Resultado', '#modal_CRUD', '', 'true', 'true', 'false', 'Adicionar', 'Fechar')
        }
    }).fail(function (response){

    });
});*/
</script>

@stop


