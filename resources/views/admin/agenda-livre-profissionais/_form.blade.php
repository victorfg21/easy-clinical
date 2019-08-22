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
            <div class="form-group col-md-3">
                <label for="data_livre" class="control-label">Data Livre</label>
                <input for="data_livre" class="form-control" type="date" name="data_livre" value="{{ isset($registro->data_livre) ? date("Y-m-d", strtotime($registro->data_livre)) : '' }}" />
            </div>
            <div class="form-group col-md-2">
                <label for="inicio_periodo" class="control-label">Início</label>
                <input for="inicio_periodo" class="form-control" type="time" name="inicio_periodo" value="{{ isset($registro->inicio_periodo) ? date("H:i", strtotime($registro->inicio_periodo)) : '' }}" />
            </div>
            <div class="form-group col-md-2">
                <label for="fim_periodo" class="control-label">Fim</label>
                <input for="fim_periodo" class="form-control" type="time" name="fim_periodo" value="{{ isset($registro->fim_periodo) ? date("H:i", strtotime($registro->fim_periodo)) : '' }}" />
            </div>
            <div class="form-group col-md-12">
                    <label for="motivo" class="control-label">Motivo</label>
                    <input for="motivo" class="form-control" type="text" name="motivo" value="{{ isset($registro->motivo) ? $registro->motivo : '' }}" />
                </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/adicionaLinhaEspecialidade.js') }}"></script>
<script src="{{ asset('js/adicionaLinhaAreaAtuacao.js') }}"></script>

