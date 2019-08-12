@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Métodos</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblExameMetodos" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-6">Descrição</th>
                        <th class="col-xs-1"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.exame-metodos.create') }}', 'Adicionar Método', '#modal_CRUD', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblExameMetodos = $('#tblExameMetodos').DataTable({
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
              "url": "{!! route('admin.exame-metodos.listarexamemetodos') !!}",
              "dataType": "json",
              "type": "get"
         },
        "columns": [
              { "data": "nome", "width": "40%" },
              {"render": function (data, type, full, meta) {
                        return full.action;
                    }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            {
                "targets": [1],
                "orderable": false
            }
        ]
  });
</script>

@stop


