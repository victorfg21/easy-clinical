@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Pacientes</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="tblPacientes" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>IH</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.pacientes.create') }}', 'Adicionar Paciente', '#modal_Large', '', 'true', 'true', 'true', 'Salvar', 'Fechar')"><i class="fa fa-plus fa-lg"></i></a>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblPacientes = $('#tblPacientes').DataTable({
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
              "url": "{!! route('admin.pacientes.listarpacientes') !!}",
              "dataType": "json",
              "type": "get"
         },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "ih", "width": "10%" },
            { "data": "nome", "width": "50%" },
            { "data": "cpf", "width": "20%" },
            {"render": function (data, type, full, meta) {
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 3, targets: 1 },
            { responsivePriority: 4, targets: 2 },
            { responsivePriority: 5, targets: 3 },
            { responsivePriority: 2, targets: 4 },
            {
                "targets": [0, 1, 2, 3, 4],
                "orderable": false
            }
        ]
  });
</script>

@stop


