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
                        <th></th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>IH</th>
                        <th>CPF</th>
                        <th></th>
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
        "responsive"  : true,
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
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "id", "width": "5%" },
            { "data": "nome", "width": "60%" },
            { "data": "ih", "width": "15%" },
            { "data": "cpf", "width": "20%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 5, targets: 3 },
            { responsivePriority: 6, targets: 4 },
            { responsivePriority: 4, targets: 5 },
            {
                "targets": [0, 1, 2, 3, 4, 5],
                "orderable": false
            }
        ]
    });
</script>

@stop
