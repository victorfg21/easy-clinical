<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Dados Gerais</h3>
    </div>
    <div class="box-body">
        <div class="form-group {{ $errors->has('nome_generico') ? 'has-error' : '' }}">
            <label for="Nome_Generico" class="control-label">Nome Genérico</label>
            <input for="Nome_Generico" class="form-control" type="text" name="nome_generico" value="{{ isset($registro->nome_generico) ? $registro->nome_generico : old('nome_generico') }}" />
            @if($errors->has('nome_generico'))
                <small for="Nome_Generico" class="control-label">{{ $errors->first('nome_generico') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('nome_fabrica') ? 'has-error' : '' }}">
            <label for="Nome_Fabrica" class="control-label">Nome Fábrica</label>
            <input for="Nome_Fabrica" class="form-control" type="text" name="nome_fabrica" value="{{ isset($registro->nome_fabrica) ? $registro->nome_fabrica : old('nome_fabrica') }}" />
            @if($errors->has('nome_fabrica'))
                <small for="Nome_Fabrica" class="control-label">{{ $errors->first('nome_fabrica') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('fabricante_id') ? 'has-error' : '' }}">
            <label for="Fabricante" class="control-label">Fabricante</label>
            <select for="Fabricante" class="form-control js-example-responsive" name="fabricante_id">
                @if(!isset($registro->fabricante_id))
                    <option value="" selected></option>
                    @foreach ($fabricante_list as $fabricante)
                        <option value="{{ $fabricante->id }}">{{ $fabricante->nome }}</option>
                    @endforeach
                @else
                {
                    @foreach ($fabricante_list as $fabricante)
                        @if($fabricante->id == $registro->fabricante_id)
                            <option value="{{ $fabricante->id }}" selected>{{ $fabricante->nome }}</option>
                        @else
                            <option value="{{ $fabricante->id }}">{{ $fabricante->nome }}</option>
                        @endif
                    @endforeach
                }
                @endif
            </select>
            @if($errors->has('fabricante_id'))
                <small for="Fabricante" class="control-label">{{ $errors->first('fabricante_id') }}</small>
            @endif
        </div>
    </div>
</div>
