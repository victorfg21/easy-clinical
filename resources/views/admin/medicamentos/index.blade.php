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
                        <th class="col-xs-4">Nome Fábrica</th>
                        <th class="col-xs-4">Nome Genérico</th>
                        <th class="col-xs-4">Fabricante</th>
                        <th class="col-xs-4"></th>
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
                { "data": "nome_fabrica", "width": "30%" },
                { "data": "nome_generico", "width": "30%" },
                { "data": "fabricante", "width": "25%" },
                {"render": function (data, type, full, meta) {
                        return full.action;
                }, "width": "15%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 3 },
            {
                "targets": [3],
                "orderable": false
            }
        ]
  });
</script>

@stop


