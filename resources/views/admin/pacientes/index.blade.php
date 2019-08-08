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
                        <th class="col-xs-4">IH</th>
                        <th class="col-xs-6">Nome</th>
                        <th class="col-xs-4">CPF</th>
                        <th class="col-xs-1">Editar</th>
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
      'lengthChange': false,
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
              "url": "{!! route('admin.pacientes.listarpacientes') !!}",
              "dataType": "json",
              "type": "get"
         },
        "columns": [    
              { "data": "ih", "width": "10%" },
              { "data": "nome", "width": "40%" },
              { "data": "cpf", "width": "20%" },
              {"render": function (data, type, full, meta) {
                        return full.action;
                    }, "width": "10%"},              
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { responsivePriority: 3, targets: -2 },
            { responsivePriority: 4, targets: -3 },
        ]
  });
</script>

@stop


