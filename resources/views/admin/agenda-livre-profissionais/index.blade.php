@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Agenda Livre de Profissionais</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblAgendasLivre" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-7">Profissional</th>
                        <th class="col-xs-2">Data Livre</th>
                        <th class="col-xs-1">Editar</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.agenda-livre-profissionais.create') }}', 'Adicionar Agenda', '#modal_Large', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblAgendasLivre = $('#tblAgendasLivre').DataTable({
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
              "url": "{!! route('admin.agenda-livre-profissionais.listaragendalivreprofissionais') !!}",
              "dataType": "json",
              "type": "get"
         },
        "columns": [
              { "data": "nome", "width": "70%" },
              { "data": "data_livre", "width": "20%" },
              {"render": function (data, type, full, meta) {
                        return full.action;
                    }, "width": "10%"},
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


