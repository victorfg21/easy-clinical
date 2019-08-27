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
                value="{{ isset($registro->inicio_periodo) ? date("Y-m-d", strtotime($registro->inicio_periodo)) : '' }}" />
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
        <div class="form-group col-md-12">
            <a href="#" class="btn btn-info col-md-1" id="btnListarAgenda"><i class="fa fa-search fa-lg"></i>
                <strong>Filtrar</strong></a>
        </div>
        <div class="table-responsive col-md-12">
            <table id="tblAgendamentos" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="display:none;">Profissional ID</th>
                        <th class="col-xs-3">Profissional</th>
                        <th style="display:none;">Paciente ID</th>
                        <th class="col-xs-3">Paciente</th>
                        <th class="col-xs-2">Data</th>
                        <th class="col-xs-2">Horário</th>
                        <th class="col-xs-3">Status</th>
                        <th class="col-xs-2">Ações</th>
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
            "url": "{!! route('atendimento.agendamento-consulta.listaragenda') !!}",
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
                { "data": "profissional_id", "width": "50%", "visible": false },
                { "data": "profissional_nome", "width": "20%" },
                { "data": "paciente_id", "width": "20%", "visible": false },
                { "data": "paciente_nome", "width": "50%" },
                { "data": "data", "width": "20%" },
                { "data": "hora", "width": "20%" },
                { "data": "status", "width": "50%" },
                {"render": function (data, type, full, meta) {
                        return full.action;
                }, "width": "10%"},
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 3 },
            { responsivePriority: 5, targets: 4 },
            { responsivePriority: 6, targets: 5 },
            { responsivePriority: 7, targets: 6 },
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

    /*$("#btnListarAgenda").unbind("click").click(function (e) {
        e.preventDefault();

        var data = $('input[name=data]').val();
        var profissional_id = $('select[name=profissional_id]').val();
        var especialidade_id = $('select[name=especialidade_id]').val();
        var area_atuacao_id = $('select[name=area_atuacao_id]').val();

        $.ajax({
            url: "{{ route('atendimento.agendamento-consulta.listaragenda') }}",
            type: "get",
            data: {data:data, profissional_id:profissional_id, especialidade_id:especialidade_id, area_atuacao_id:area_atuacao_id, },
            success: function(response) {

                Swal.fire({
                    type: 'success',
                    showConfirmButton: false,
                    timer: 700
                })

                $("#tblAgendamentos").empty();
                $("#tblAgendamentos").addClass("table table-hover table-striped");
                $("#tblAgendamentos").append("<thead>" +
                            "<tr>" +
                                "<th style=\"display:none;\">Profissional ID</th>" +
                                "<th class=\"col-xs-3\">Profissional</th>" +
                                "<th style=\"display:none;\">Paciente ID</th>" +
                                "<th class=\"col-xs-3\">Paciente</th>" +
                                "<th class=\"col-xs-2\">Data</th>" +
                                "<th class=\"col-xs-2\">Horário</th>" +
                                "<th class=\"col-xs-3\">Status</th>" +
                                "<th class=\"col-xs-2\">Ações</th>" +
                            "</tr>" +
                        "</thead>"
                );

                $("#tblAgendamentos").append("<tbody>");
                $.each(response, function (a, b) {
                    var statusMarcacao = "";
                    switch (b.status) {
                        case "0":
                            statusMarcacao = "<font color=\"green\">Disponível</font>";
                            break;

                        case "1":
                            statusMarcacao = "<font color=\"yellow\">Em Marcação</font>";
                            break;

                        case "2":
                            statusMarcacao = "<font color=\"blue\">Marcado</font>";
                            break;

                        case "3":
                            statusMarcacao = "<font color=\"red\">Cancelado</font>";
                            break;

                        case "4":
                            statusMarcacao = "<font color=\"orange\">Não Disponivel</font>";
                            break;
                        case "5":
                            statusMarcacao = "<font color=\"LightSkyBlue  \">Realizado</font>";
                            break;
                        case "6":
                            statusMarcacao = "<font color=\"FireBrick \">Faltou</font>";
                            break;
                    }

                    $("#tblAgendamentos").append("<tr>" +
                        "<td style=\"display:none;\">" + b.profissional_id + "</td>" +
                        "<td>" + b.profissional_nome + "</td>" +
                        "<td style=\"display:none;\">" + b.paciente_id + "</td>" +
                        "<td>" + b.paciente_nome + "</td>" +
                        "<td>" + b.data + "</td>" +
                        "<td>" + b.hora + "</td>" +
                        "<td>" + statusMarcacao + "</td>" +
                        "<td><a href='#'><span class='glyphicon glyphicon-edit'></span></a><a href='#'><span class='glyphicon glyphicon-trash'></span></a></td>" +
                        "</tr>"
                    );
                });

                $("#tblAgendamentos").append("</tbody>");
            }
        }).fail(function (response){

            Swal.fire({
                type: 'error',
                showConfirmButton: false,
                timer: 700
            })
        });
    });
*/

</script>

@stop
