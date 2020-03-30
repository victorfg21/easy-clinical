@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Agendas</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblAgendas" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Profissional</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.agendas.create') }}', 'Adicionar Agenda', '#modal_Large', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblAgendas = $('#tblAgendas').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
      "order"       : [[ 1, "asc" ]],
      "processing"  : true,
      "serverSide"  : true,
       "language": {
            "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        },
      "ajax":{
              "url": "{!! route('admin.agendas.listaragendas') !!}",
              "dataType": "json",
              "type": "get"
         },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "nome", "width": "40%" },
            { "data": "inicio_periodo", "width": "20%" },
            { "data": "fim_periodo", "width": "20%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 3 },
            { responsivePriority: 5, targets: 4 }
        ]
  });
</script>

@stop


