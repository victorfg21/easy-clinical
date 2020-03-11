@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Histórico Paciente</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblPaciente" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1">ID</th>
                        <th class="col-xs-6">Nome</th>
                        <th class="col-xs-2">IH</th>
                        <th class="col-xs-2">CPF</th>
                        <th class="col-xs-1">Histórico</th>
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
    var tblPacientes = $('#tblPaciente').DataTable({
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
                "url": "{!! route('admin.historico-paciente.listarpacienteshistorico') !!}",
                "dataType": "json",
                "type": "get"
            },
        "columns": [
                { "data": "id", "width": "5%" },
                { "data": "nome", "width": "60%" },
                { "data": "ih", "width": "15%" },
                { "data": "cpf", "width": "20%" },
                {"render": function (data, type, full, meta) {
                        return full.action;
                    }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 3 },
            {
                "targets": [1],
                "orderable": false
            }
        ]
    });
</script>

@stop
