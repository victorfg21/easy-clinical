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
        <div class="table-responsive">
            <table id="tblResultado" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1">ID</th>
                        <th class="col-xs-2 data-table">Data</th>
                        <th class="col-xs-4">Paciente</th>
                        <th class="col-xs-4">Profissional</th>
                        <th class="col-xs-1"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
            "type": "get"
        },
    "columns": [
        { "data": "id", "className": "id", "width": "5%" },
            { "data": "data", "className": "data", "width": "10%" },
            { "data": "paciente_nome", "className": "paciente_nome", "width": "30%" },
            { "data": "profissional_nome", "className": "profissional_nome", "width": "30%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
            }, "width": "5%"},
    ],
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: 1 },
        { responsivePriority: 3, targets: 2 },
        { responsivePriority: 4, targets: 3 },
        { responsivePriority: 5, targets: 4 },
        {
            "targets": [1],
            "orderable": false
        }
    ]
});
</script>

@stop


