@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Fabricantes</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblFabricantes" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.fabricantes.create') }}', 'Adicionar Fabricante', '#modal_CRUD', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblFabricantes = $('#tblFabricantes').DataTable({
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
                "url": "{!! route('admin.fabricantes.listarfabricantes') !!}",
                "dataType": "json",
                "type": "get"
            },
        "columns": [
            {"render": function (data, type, full, meta) {
                        return "";
                    }, "width": "10%"},
            { "data": "nome", "width": "40%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            {
                "targets": [0, 1, 2],
                "orderable": false
            }
        ]
  });
</script>

@stop


