@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Acompanhamento Médico</h3>
    </div>
    <div class="box-body">
        <div class="form-group col-md-4">
            <label for="profissional_id" class="control-label">Profissional</label>
            <select for="profissional_id" class="form-control js-example-responsive" name="profissional_id">
                <option value="" selected></option>
                @foreach ($profissional_list as $profissional)
                    @if ($user == $profissional->user_id)
                        <option value="{{ $profissional->id }}" selected>{{ $profissional->nome }}</option>

                    @else
                        <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="table-responsive col-md-12">
            <table id="tblConsultas" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Cod.</th>
                        <th style="display:none;">Paciente ID</th>
                        <th>Paciente</th>
                        <th>Horário</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($consulta_list))
                    @foreach ($consulta_list as $consulta)
                        <tr>
                            <td></td>
                            <td>{{ $consulta->id }}</td>
                            <td style="display:none;">{{ $consulta->paciente_id }}</td>
                            <td>{{ $consulta->nome }}</td>
                            <td class="hora">{{ $consulta->horario_consulta }}</td>
                            <td><a class="btnExecutarConsulta" href="{{ route('medico.acompanhamento.realizar', $consulta->id) }}"><i class="fa fa-check fa-lg"></i></a></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
var tblConsultas = $('#tblConsultas').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        "responsive"  : true,
        "processing"  : false,
        "serverSide"  : false,
        "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "Cod.", "width": "15%"},
            { "data": "ID", "width": "15%", "visible": false },
            { "data": "Paciente", "width": "30%" },
            { "data": "Horário", "width": "20%" },
            { "data": "", "width": "10%" },
        ],
        "columnDefs": [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 5, targets: 2 },
            { responsivePriority: 6, targets: 3 },
            { responsivePriority: 4, targets: 4 },
            { responsivePriority: 3, targets: 5 }
        ]
    });

</script>

@stop
