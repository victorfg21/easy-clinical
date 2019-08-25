<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Dados Gerais</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label for="Profissional" class="control-label">Profissionais</label>
            <select for="Profissional" class="form-control js-example-responsive" name="profissional_id">
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
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <input type="checkbox" id="segunda" name="segunda" {{ isset($registro->segunda) ? ($registro->segunda ? 'checked="checked"' : "") : "" }} />
                <label for="segunda" class="control-label">Segunda</label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="terca" name="terca" {{ isset($registro->terca) ? ($registro->terca ? 'checked="checked"' : "") : "" }} />
                <label for="terca" class="control-label">Terça</label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="quarta" name="quarta" {{ isset($registro->quarta) ? ($registro->quarta ? 'checked="checked"' : "") : "" }} />
                <label for="quarta" class="control-label">Quarta</label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="quinta" name="quinta" {{ isset($registro->quinta) ? ($registro->quinta ? 'checked="checked"' : "") : "" }} />
                <label for="quinta" class="control-label">Quinta</label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="sexta" name="sexta" {{ isset($registro->sexta) ? ($registro->sexta ? 'checked="checked"' : "") : "" }} />
                <label for="sexta" class="control-label">Sexta</label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="sabado" name="sabado" {{ isset($registro->sabado) ? ($registro->sabado ? 'checked="checked"' : "") : "" }} />
                <label for="sabado" class="control-label">Sábado</label>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" id="domingo" name="domingo" {{ isset($registro->domingo) ? ($registro->domingo ? 'checked="checked"' : "") : "" }} />
                <label for="domingo" class="control-label">Domingo</label>
            </div>
        </div>
        <div class="row">
            <label class="control-label col-md-12">Período</label>
            <div class="form-group col-md-3">
                <label for="inicio_periodo" class="control-label">Início</label>
                <input for="inicio_periodo" class="form-control" type="date" name="inicio_periodo" value="{{ isset($registro->inicio_periodo) ? date("Y-m-d", strtotime($registro->inicio_periodo)) : '' }}" />
            </div>
            <div class="form-group col-md-3">
                <label for="fim_periodo" class="control-label">Fim</label>
                <input for="fim_periodo" class="form-control" type="date" name="fim_periodo" value="{{ isset($registro->fim_periodo) ? date("Y-m-d", strtotime($registro->fim_periodo)) : '' }}" />
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="tempo_consulta" class="control-label">Tempo da Consulta</label>
                <input for="tempo_consulta" class="form-control" type="time" name="tempo_consulta" value="{{ isset($registro->tempo_consulta) ? date("H:i", strtotime($registro->tempo_consulta)) : '' }}" />
            </div>
        </div>
        <div class="row">
            <label class="control-label col-md-12">1º Horário</label>
            <div class="form-group col-md-2">
                <label for="inicio_horario_1" class="control-label">Início</label>
                <input for="inicio_horario_1" class="form-control" type="time" name="inicio_horario_1" value="{{ isset($registro->inicio_horario_1) ? date("H:i", strtotime($registro->inicio_horario_1)) : '' }}" />
            </div>
            <div class="form-group col-md-2">
                <label for="fim_horario_1" class="control-label">Fim</label>
                <input for="fim_horario_1" class="form-control" type="time" name="fim_horario_1" value="{{ isset($registro->fim_horario_1) ? date("H:i", strtotime($registro->fim_horario_1)) : '' }}" />
            </div>
        </div>
        <div class="row">
            <label class="control-label col-md-12">2º Horário</label>
            <div class="form-group col-md-2">
                <label for="inicio_horario_2" class="control-label">Início</label>
                <input for="inicio_horario_2" class="form-control" type="time" name="inicio_horario_2" value="{{ isset($registro->inicio_horario_2) ? date("H:i", strtotime($registro->inicio_horario_2)) : '' }}" />
            </div>
            <div class="form-group col-md-2">
                <label for="fim_horario_2" class="control-label">Domingo</label>
                <input for="fim_horario_2" class="form-control" type="time" name="fim_horario_2" value="{{ isset($registro->fim_horario_2) ? date("H:i", strtotime($registro->fim_horario_2)) : '' }}" />
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/adicionaLinhaEspecialidade.js') }}"></script>
<script src="{{ asset('js/adicionaLinhaAreaAtuacao.js') }}"></script>

