<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Dados Gerais</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label for="profissional_id" class="control-label">Profissional</label>
            <select for="profissional_id" class="form-control js-example-responsive" name="profissional_id" disabled>
                @if(!isset($registro->profissional_id))
                {
                    <option value="" selected></option>
                    @foreach ($profissional_list as $profissional)
                        <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                    @endforeach
                }
                @else
                {
                    @foreach ($profissional_list as $profissional)
                        @if($profissional->id == $registro->profissional_id)
                            <option value="{{ $profissional->id }}" selected>{{ $profissional->nome }}</option>
                        @else
                            <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                        @endif
                    @endforeach
                }
                @endif
            </select>
            <input type="hidden" name="profissional_id" value="" />
        </div>
        <div class="form-group">
            <label for="paciente_id" class="control-label">Paciente</label>
            <select for="paciente_id" class="form-control js-example-responsive" name="paciente_id" {{ isset($registro->paciente_id) ? "disabled" : '' }}>
                @if(!isset($registro->paciente_id))
                {
                    <option value="" selected></option>
                    @foreach ($paciente_list as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                    @endforeach
                }
                @else
                {
                    @foreach ($paciente_list as $paciente)
                        @if($paciente->id == $registro->paciente_id)
                            <option value="{{ $paciente->id }}" selected>{{ $paciente->nome }}</option>
                        @else
                            <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                        @endif
                    @endforeach
                }
                @endif
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="data_consulta" class="control-label">Data</label>
            <input for="data_consulta" class="form-control" type="date" name="data_consulta" value="{{ isset($registro->data_consulta) ? date("Y-m-d", strtotime($registro->data_consulta)) : '' }}" readonly />
        </div>
        <div class="form-group col-md-3">
            <label for="horario_consulta" class="control-label">Horário</label>
            <input for="horario_consulta" class="form-control" type="time" name="horario_consulta" value="{{ isset($registro->horario_consulta) ? date("H:i", strtotime($registro->horario_consulta)) : '' }}" readonly />
        </div>
        @if(isset($registro->id))
            <div class="row col-md-12">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="cancelado" name="cancelado"
                        {{ isset($registro->cancelado) ? ($registro->cancelado ? 'checked="checked"' : "") : "" }} disabled/>
                    <label for="cancelado" class="control-label">Cancelado</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="checkbox" id="bloqueado" name="bloqueado"
                        {{ isset($registro->bloqueado) ? ($registro->bloqueado ? 'checked="checked"' : "") : "" }} disabled/>
                    <label for="bloqueado" class="control-label">Bloqueado</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="checkbox" id="realizado" name="realizado"
                        {{ isset($registro->realizado) ? ($registro->realizado ? 'checked="checked"' : "") : "" }} disabled/>
                    <label for="realizado" class="control-label">Realizado</label>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="{{ asset('js/adicionaLinhaEspecialidade.js') }}"></script>
<script src="{{ asset('js/adicionaLinhaAreaAtuacao.js') }}"></script>

<script>
    $('select[name=profissional_id]').change(function () {
        $(this).val();
    });

    $(function() {
        $('input[name=profissional_id]').val($('select[name=profissional_id]').val());
    });
</script>
