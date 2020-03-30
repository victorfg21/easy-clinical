@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Medicamentos</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblMedicamentos" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome Fábrica</th>
                        <th>Nome Genérico</th>
                        <th>Fabricante</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.medicamentos.create') }}', 'Adicionar Medicamento', '#modal_CRUD', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblMedicamentos = $('#tblMedicamentos').DataTable({
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
                "url": "{!! route('admin.medicamentos.listarmedicamentos') !!}",
                "dataType": "json",
                "type": "get"
            },
            "columns": [
                {"render": function (data, type, full, meta) {
                        return "";
                    }, "width": "10%"},
                { "data": "nome_fabrica", "width": "30%" },
                { "data": "nome_generico", "width": "25%" },
                { "data": "fabricante", "width": "15%" },
                {"render": function (data, type, full, meta) {
                        return full.action;
                }, "width": "20%"},
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0, className: "control"},
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 4, targets: 2 },
                { responsivePriority: 5, targets: 3 },
                { responsivePriority: 3, targets: 4 },
                {
                    "targets": [0, 1, 2, 3, 4],
                    "orderable": false
                }
            ]
  });
</script>

@stop


