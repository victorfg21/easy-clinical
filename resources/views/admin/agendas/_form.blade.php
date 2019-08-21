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
        <div class="form-group col-md-2">
            <input type="checkbox" id="segunda" name="segunda[]" value="{{ isset($registro->segunda) ? $registro->segunda : "false" }}" />
            <label for="segunda" class="control-label">Segunda</label>
        </div>
        <div class="form-group col-md-2">
            <input type="checkbox" id="terca" name="terca[]" value="{{ isset($registro->terca) ? $registro->terca : "false" }}" />
            <label for="terca" class="control-label">Terça</label>
        </div>
        <div class="form-group col-md-2">
            <input type="checkbox" id="quarta" name="quarta[]" value="{{ isset($registro->quarta) ? $registro->quarta : "false" }}" />
            <label for="quarta" class="control-label">Quarta</label>
        </div>
        <div class="form-group col-md-2">
            <input type="checkbox" id="quinta" name="quinta[]" value="{{ isset($registro->quinta) ? $registro->quinta : "false" }}" />
            <label for="quinta" class="control-label">Quinta</label>
        </div>
        <div class="form-group col-md-2">
            <input type="checkbox" id="sexta" name="sexta[]" value="{{ isset($registro->sexta) ? $registro->sexta : "false" }}" />
            <label for="sexta" class="control-label">Sexta</label>
        </div>
        <div class="form-group col-md-2">
            <input type="checkbox" id="sabado" name="sabado[]" value="{{ isset($registro->sabado) ? $registro->sabado : "false" }}" />
            <label for="sabado" class="control-label">Sábado</label>
        </div>
        <div class="form-group col-md-2">
            <input type="checkbox" id="domingo" name="domingo[]" value="{{ isset($registro->domingo) ? $registro->domingo : "false" }}" />
            <label for="domingo" class="control-label">Domingo</label>
        </div>
        <div class="row">
            <label class="control-label col-md-12">Período</label>
            <div class="form-group col-md-3">
                <label for="inicio_periodo" class="control-label">Início</label>
                <input for="inicio_periodo" class="form-control" type="date" name="inicio_periodo" value="{{ isset($registro->inicio_periodo) ? $registro->inicio_periodo : '' }}" />
            </div>
            <div class="form-group col-md-3">
                <label for="fim_periodo" class="control-label">Fim</label>
                <input for="fim_periodo" class="form-control" type="date" name="fim_periodo" value="{{ isset($registro->fim_periodo) ? $registro->fim_periodo : '' }}" />
            </div>
        </div>
        <div class="form-group col-md-3">
            <label for="tempo_consulta" class="control-label">Tempo da Consulta</label>
            <input for="tempo_consulta" class="form-control" type="time" name="tempo_consulta" value="{{ isset($registro->tempo_consulta) ? $registro->tempo_consulta : '' }}" />
        </div>
        <div class="row">
            <label class="control-label col-md-12">1º Horário</label>
            <div class="form-group col-md-2">
                <label for="inicio_horario_1" class="control-label">Início</label>
                <input for="inicio_horario_1" class="form-control" type="time" name="inicio_horario_1" value="{{ isset($registro->inicio_horario_1) ? $registro->inicio_horario_1 : '' }}" />
            </div>
            <div class="form-group col-md-2">
                <label for="fim_horario_1" class="control-label">Fim</label>
                <input for="fim_horario_1" class="form-control" type="time" name="fim_horario_1" value="{{ isset($registro->fim_horario_1) ? $registro->fim_horario_1 : '' }}" />
            </div>
        </div>
        <div class="row">
            <label class="control-label col-md-12">2º Horário</label>
            <div class="form-group col-md-2">
                <label for="inicio_horario_2" class="control-label">Início</label>
                <input for="inicio_horario_2" class="form-control" type="time" name="inicio_horario_2" value="{{ isset($registro->inicio_horario_2) ? $registro->inicio_horario_2 : '' }}" />
            </div>
            <div class="form-group col-md-2">
                <label for="fim_horario_2" class="control-label">Domingo</label>
                <input for="fim_horario_2" class="form-control" type="time" name="fim_horario_2" value="{{ isset($registro->fim_horario_2) ? $registro->fim_horario_2 : '' }}" />
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/adicionaLinhaEspecialidade.js') }}"></script>
<script src="{{ asset('js/adicionaLinhaAreaAtuacao.js') }}"></script>

