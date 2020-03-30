@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Profissionais</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblProfissionais" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>Conselho</th>
                        <th>Nº Registro</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.profissionais.create') }}', 'Adicionar Profissional', '#modal_Large', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblProfissionais = $('#tblProfissionais').DataTable({
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
              "url": "{!! route('admin.profissionais.listarprofissionais') !!}",
              "dataType": "json",
              "type": "get"
         },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "nome", "width": "40%" },
            { "data": "conselho", "width": "20%" },
            { "data": "numero_registro", "width": "20%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 3 },
            { responsivePriority: 5, targets: 4 },
            {
                "targets": [0, 1, 2, 3, 4],
                "orderable": false
            }
        ]
  });
</script>

@stop


