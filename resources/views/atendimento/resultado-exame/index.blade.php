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
                        <th></th>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Paciente</th>
                        <th>Profissional</th>
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
var tblResultado = $('#tblResultado').DataTable({
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
                "url": "{!! route('atendimento.resultado-exame.listarsolicitacoes') !!}",
                "dataType": "json",
                "type": "get"
            },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "id", "className": "id", "width": "10%" },
            { "data": "data", "className": "data", "width": "10%" },
            { "data": "paciente_nome", "className": "paciente_nome", "width": "30%" },
            { "data": "profissional_nome", "className": "profissional_nome", "width": "30%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 4, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 5, targets: 3 },
            { responsivePriority: 6, targets: 4 },
            { responsivePriority: 3, targets: 5 },
            {
                "targets": [0, 1, 2, 3, 4, 5],
                "orderable": false
            }
        ]
});
</script>

@stop


