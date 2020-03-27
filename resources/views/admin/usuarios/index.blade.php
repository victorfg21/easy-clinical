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
                        <th class="col-xs-4">Email</th>
                        <th class="col-xs-5">Nome</th>
                        <th class="col-xs-3"></th>
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
      "order"       : [[ 0, "asc" ]],
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
              { "data": "email", "width": "40%" },
              { "data": "name", "width": "40%" },
              {"render": function (data, type, full, meta) {
                        return full.action;
                    }, "width": "20%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            {
                "targets": [2],
                "orderable": false
            }
        ]
  });
</script>

@stop


