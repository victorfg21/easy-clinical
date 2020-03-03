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
                        <th class="col-xs-1">Cod.</th>
                        <th style="display:none;">Paciente ID</th>
                        <th class="col-xs-7">Paciente</th>
                        <th class="col-xs-2">Horário</th>
                        <th class="col-xs-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($consulta_list))
                    @foreach ($consulta_list as $consulta)
                        <tr>
                            <td class="col-xs-1">{{ $consulta->id }}</td>
                            <td style="display:none;">{{ $consulta->paciente_id }}</td>
                            <td class="col-xs-10">{{ $consulta->nome }}</td>
                            <td class="col-xs-2 hora">{{ $consulta->horario_consulta }}</td>
                            <td class="col-xs-2"><a class="btnExecutarConsulta" href="{{ route('medico.acompanhamento.realizar', $consulta->id) }}"><i class="fa fa-check fa-lg"></i></a></td>
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
    /*var tblAgendamentos = $('#tblAgendamentos').DataTable({
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
            "url": "{!! route('atendimento.agendamento-consulta.listarconsultas') !!}",
            "dataType": "json",
            "type": "get",
            "data": function (d) {
                d.data = $("input[name=data]").val(),
                d.profissional_id = $('select[name=profissional_id]').val(),
                d.especialidade_id = $('select[name=especialidade_id]').val(),
                d.area_atuacao_id = $('select[name=area_atuacao_id]').val()
            },
        },
        "columns": [
                { "data": "profissional_id", "className": "profissional_id", "width": "5%" },
                { "data": "profissional_nome", "className": "profissional_nome", "width": "35%" },
                { "data": "paciente_id", "className": "paciente_id", "width": "10%", "visible": false },
                { "data": "paciente_nome", "className": "paciente_nome", "width": "35%" },
                { "data": "data", "className": "data", "width": "10%" },
                { "data": "hora", "className": "hora", "width": "10%" },
                {"render": function (data, type, full, meta) {
                        return full.status;
                }, "width": "20%"},
                {"render": function (data, type, full, meta) {
                        return full.action;
                }, "width": "20%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 4, targets: 2 },
            { responsivePriority: 5, targets: 3 },
            { responsivePriority: 6, targets: 4 },
            { responsivePriority: 7, targets: 5 },
            { responsivePriority: 3, targets: 6 },
            { responsivePriority: 8, targets: 7 },
            {
                "targets": [7],
                "orderable": false
            }
        ]
    });

    $('input[name=data]').change(function () {
        tblAgendamentos.ajax.reload();
    });

    $('select[name=profissional_id]').change(function () {
        tblAgendamentos.ajax.reload();
    });

    $('select[name=especialidade_id]').change(function () {
        tblAgendamentos.ajax.reload();
    });

    $('select[name=area_atuacao_id]').change(function () {
        tblAgendamentos.ajax.reload();
    });

    $(document).on('click', '.addConsulta', function () {
        var profissional_id = $(this).closest("tr").find(".profissional_id").text();
        var data = moment($(this).closest("tr").find(".data").text(), 'DD/MM/YYYY').format("YYYY-MM-DD");
        var hora = $(this).closest("tr").find(".hora").text();
        $.ajax({
            url: "{{ route('atendimento.agendamento-consulta.create') }}",
            type: 'GET',
            data: {profissional_id: profissional_id, data: data, hora: hora},

            success: function (data) {
                modalBootstrapView(data, 'Criar Consulta', '#modal_CRUD', '', 'true', 'true', 'false', 'Adicionar', 'Fechar')
            }
        }).fail(function (response){

        });
    });
</script>

@stop
