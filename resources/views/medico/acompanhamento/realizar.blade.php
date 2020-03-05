@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<form id="frmAcompanhamento">
    {{ csrf_field() }}
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Acompanhamento Médico</h3>
        </div>
        <div class="box-body">
            <div class="form-group {{ $errors->has('id') ? 'has-error' : '' }} col-md-3">
                <label for="id" class="control-label">ID</label>
                <input for="id" class="form-control" type="text" name="id"
                    value="{{ isset($consulta->id) ? $consulta->id : old('id') }}" readonly />
                @if($errors->has('id'))
                <small for="id" class="control-label">{{ $errors->first('id') }}</small>
                @endif
            </div>
            <div class="form-group {{ $errors->has('paciente') ? 'has-error' : '' }} col-md-10">
                <label for="paciente" class="control-label">Paciente</label>
                <input for="paciente" class="form-control" type="text" name="paciente"
                    value="{{ isset($consulta->paciente) ? $consulta->paciente : old('paciente') }}" readonly />
                @if($errors->has('paciente'))
                <small for="paciente" class="control-label">{{ $errors->first('paciente') }}</small>
                @endif
            </div>
            <div class="form-group {{ $errors->has('horario_consulta') ? 'has-error' : '' }} col-md-2">
                <label for="horario_consulta" class="control-label">Horário</label>
                <input for="horario_consulta" class="form-control hora" type="text" name="horario_consulta"
                    value="{{ isset($consulta->horario_consulta) ? $consulta->horario_consulta : old('horario_consulta') }}"
                    readonly />
                @if($errors->has('horario_consulta'))
                <small for="horario_consulta" class="control-label">{{ $errors->first('horario_consulta') }}</small>
                @endif
            </div>

            <div class="form-group {{ $errors->has('observacao') ? 'has-error' : '' }} col-md-12">
                <label for="observacao" class="control-label">Observação</label>
                <textarea for="observacao" class="form-control" name="observacao">{{ isset($consulta->observacao) ? $consulta->observacao : '' }}</textarea>
            </div>

            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav active"><a href="#exame" data-toggle="tab">Solicitar Exame</a></li>
                    <li class="nav"><a href="#receita" data-toggle="tab">Emitir Receita</a></li>
                </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="exame">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group {{ $errors->has('observacaoSolic') ? 'has-error' : '' }} col-md-12">
                                    <br>
                                    <label for="observacaoSolic" class="control-label">Observação Exame</label>
                                    <textarea for="observacaoSolic" class="form-control" name="observacaoSolic"></textarea>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered" id="tblSolicExame">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">ID</th>
                                                <th class="col-xs-10">Exame</th>
                                                <th class="col-xs-1">Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a class="btn btn-info btn-md pull-right" id="btnAddLinhaExameConsulta"><i class="fa fa-plus fa-lg"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="receita">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group {{ $errors->has('observacaoReceita') ? 'has-error' : '' }} col-md-12">
                                    <br>
                                    <label for="observacaoReceita" class="control-label">Observação Receita</label>
                                    <textarea for="observacaoReceita" class="form-control" name="observacaoReceita"></textarea>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered" id="tblReceita">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">ID</th>
                                                <th class="col-xs-4">Medicação</th>
                                                <th class="col-xs-6">Dosagem</th>
                                                <th class="col-xs-1">Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a class="btn btn-info btn-md pull-right" id="btnAddLinhaReceitaConsulta"><i class="fa fa-plus fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="col-md-12">
                <h3><i class="fa fa-clock-o fa-lg"></i> <strong id="timer">00:00:00</strong></h3>
                <button id="stop" class="btn btn-danger"><i class="fa fa-stop fa-lg"></i> <strong>Parar</strong></button>
            </div>
        </div>
    </div>
    <!-- DIV ERROS -->
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('medico.acompanhamento') }}"><i class="fa fa-arrow-circle-left fa-lg"></i> Retornar
            Acompanhamento</a>
    </div>
</div>

<script src="{{ asset('js/adicionaLinhaExameConsulta.js') }}"></script>
<script src="{{ asset('js/adicionaLinhaReceitaConsulta.js') }}"></script>

@stop

@section('js')

<script>
    Number.prototype.pad = function(size) {
        var s = String(this);
        while (s.length < (size || 2)) {s = "0" + s;}
        return s;
    }

    var Clock = {
        totalSeconds: 0,

        start: function () {
            var self = this;

            this.interval = setInterval(function () {
                self.totalSeconds += 1;
                $("#timer").text(Math.floor(self.totalSeconds / 3600).pad(2) + ':' + Math.floor(self.totalSeconds / 60 % 60).pad(2) + ':' + parseInt(self.totalSeconds % 60).pad(2));
            }, 1000);
        },

        pause: function () {
            clearInterval(this.interval);
            delete this.interval;

            Swal.fire({
                title: 'Deseja encerrar a consulta?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d9534f',
                cancelButtonColor: '#5cb85c',
                confirmButtonText: 'Finalizar',
                cancelButtonText: 'Continuar'
            }).then((result) => {
                if (result.value) {
                    $('#stop').prop('disabled', true);

                    var form = $("#frmAcompanhamento").serialize();
                    var exameLinha = [];
                    var id = "";
                    var exame_id = "";

                    var receitaLinha = [];
                    var idLinhaMedicamento = "";
                    var medicamento_id = "";
                    var dosagem = "";

                    $("#tblSolicExame tbody tr").each(function () {
                        idLinhaExame = $(this).find("td:nth-child(1)").text();
                        id = $(this).find("td:nth-child(2)>input").val();

                        exameLinha.push({
                            "id": id,
                            "exame_id": exame_id
                        });
                    });
                    exameLinha = JSON.stringify(exameLinha);

                    $("#tblReceita tbody tr").each(function () {
                        id = $(this).find("td:nth-child(1)").text();
                        medicamento_id = $(this).find("td:nth-child(2)>input").val();
                        dosagem = $(this).find("td:nth-child(3)>input").val();

                        medicamentoLinha.push({
                            "id": id,
                            "medicamento_id": medicamento_id,
                            "dosagem": dosagem
                        });
                    });
                    receitaLinha = JSON.stringify(receitaLinha);

                    form = form + "&exameLinha=" + exameLinha + "&receitaLinha=" + receitaLinha;

                    $.ajax({
                        type: "POST",
                        url: "{{ route('medico.acompanhamento.store') }}",
                        data: form,
                        success: function (data) {

                            if (data == "Cadastrado com sucesso!") {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Consulta finalizada com sucesso',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                            else {
                                $("#modalMensagens .modal-body").html(data);
                                $("#modalMensagens .modal-title").html("Erros");
                                $('#modalMensagens').modal('toggle');
                                $('#modalMensagens').modal('show');
                            }
                        }
                    }).fail(function (response){
                        associate_errors(response['responseJSON']['errors'], $("#frmAcompanhamento"));

                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: "Erro ao finalizar consulta",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                }else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire({
                        type: 'info',
                        title: 'Consulta em andamento',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    Clock.resume();
                }
            })

        },

        resume: function () {
            if (!this.interval) this.start();
            Swal.fire({
                type: 'info',
                title: 'Consulta em andamento',
                showConfirmButton: false,
                timer: 1500
            })
            $('#start').prop('disabled', true);
            $('#stop').prop('disabled', false);
        }
    };

    Clock.start();
    Swal.fire({
        type: 'info',
        title: 'Consulta iniciada',
        showConfirmButton: false,
        timer: 1500
    })

    $('#stop').unbind("click").click(function (event) { 
        event.preventDefault();
        Clock.pause(); 
    });
    //$('#start').click(function () { Clock.resume(); });

</script>

@stop
