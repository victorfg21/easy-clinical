@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Usuários</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblUsuarios" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Email</th>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.usuarios.create') }}', 'Adicionar Usuário', '#modal_CRUD', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblUsuarios = $('#tblUsuarios').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        "order"       : [[ 1, "asc" ]],
        "responsive"  : true,
        "processing"  : true,
        "serverSide"  : true,
        "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            },
        "ajax":{
                "url": "{!! route('admin.usuarios.listarusuarios') !!}",
                "dataType": "json",
                "type": "get"
            },
            "columns": [
                {"render": function (data, type, full, meta) {
                        return "";
                    }, "width": "10%"},
                { "data": "email", "width": "40%" },
                { "data": "name", "width": "30%" },
                {"render": function (data, type, full, meta) {
                        return full.action;
                    }, "width": "20%"},
            ],
            "columnDefs": [
                { responsivePriority: 1, targets: 0, className: "control"},
                { responsivePriority: 4, targets: 1 },
                { responsivePriority: 2, targets: 2 },
                { responsivePriority: 3, targets: 3 },
                {
                    "targets": [0, 1, 2, 3],
                    "orderable": false
                }
            ]
  });
</script>

@stop


