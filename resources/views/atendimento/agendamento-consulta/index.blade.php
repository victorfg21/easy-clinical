@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Agendamento Consultas</h3>
    </div>
    <div class="box-body">
        <div class="form-group col-md-2">
            <label for="inicio_periodo" class="control-label">Data</label>
            <input for="inicio_periodo" class="form-control" type="date" name="data"
                value="{{ date("Y-m-d") }}" />
        </div>
        <div class="form-group col-md-4">
            <label for="profissional_id" class="control-label">Profissional</label>
            <select for="profissional_id" class="form-control js-example-responsive" name="profissional_id">
                <option value="" selected></option>
                @foreach ($profissional_list as $profissional)
                    <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="especialidade_id" class="control-label">Especialidade</label>
            <select for="especialidade_id" class="form-control js-example-responsive" name="especialidade_id">
                <option value="" selected></option>
                @foreach ($especialidade_list as $especialidade)
                    <option value="{{ $especialidade->id }}">{{ $especialidade->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="area_atuacao_id" class="control-label">Área de Atuação</label>
            <select for="area_atuacao_id" class="form-control js-example-responsive" name="area_atuacao_id">
                <option value="" selected></option>
                @foreach ($area_atuacao_list as $area_atuacao)
                    <option value="{{ $area_atuacao->id }}">{{ $area_atuacao->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <a href="#" class="btn btn-info"
                onclick="modalBootstrap('{{ route('admin.agenda-livre-profissionais.create-consulta') }}', 'Adicionar Agenda', '#modal_Large', '', 'true', 'true', 'true', 'Salvar', 'Fechar')">
                <strong>Liberar Agenda do Profissional</strong></a>
        </div>
        <div class="table-responsive col-md-12">
            <table id="tblAgendamentos" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th style="display:none;">Cod.</th>
                        <th>Profissional</th>
                        <th style="display:none;">Paciente ID</th>
                        <th>Paciente</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
    var tblAgendamentos = $('#tblAgendamentos').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : false,
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
            {"render": function (data, type, full, meta) {//0
                        return "";
                }, "width": "10%"},
            { "data": "profissional_id", "className": "profissional_id", "width": "5%" },//1
            { "data": "profissional_nome", "className": "profissional_nome", "width": "25%" },//2
            { "data": "paciente_id", "className": "paciente_id", "width": "5%", "visible": false },//3
            { "data": "paciente_nome", "className": "paciente_nome", "width": "25%" },//4
            { "data": "data", "className": "data", "width": "10%" },//5
            { "data": "hora", "className": "hora", "width": "10%" },//6
            {"render": function (data, type, full, meta) {//7
                    return full.status;
            }, "width": "10%"},
            {"render": function (data, type, full, meta) {//8
                    return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 7, targets: 3 },
            { responsivePriority: 8, targets: 4 },
            { responsivePriority: 9, targets: 5 },
            { responsivePriority: 4, targets: 6 },
            { responsivePriority: 6, targets: 7 },
            { responsivePriority: 5, targets: 8 },
            {
                "targets": [1, 2, 3, 4, 5, 6, 7, 8],
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
