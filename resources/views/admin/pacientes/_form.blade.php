<div class="box box-solid box-primary">
    <div class="box-header with-border"> 
        <h3 class="box-title">Dados Gerais</h3>
    </div>
    <div class="box-body">
        <div class="form-group {{ $errors->has('ih') ? 'has-error' : '' }}">
            <label for="IH" class="control-label">Identidade Hospitalar</label>
            <input for="IH" class="form-control ih" type="text" name="ih" value="{{ isset($registro->ih) ? $registro->ih : old('ih') }}" disabled/>
            @if($errors->has('ih'))
                <small for="IH" class="control-label">{{ $errors->first('ih') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
            <label for="Nome" class="control-label">Nome</label>
            <input for="Nome" class="form-control" type="text" name="nome" value="{{ isset($registro->nome) ? $registro->nome : old('nome') }}" />
            @if($errors->has('nome'))
                <small for="Nome" class="control-label">{{ $errors->first('nome') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('rg') ? 'has-error' : '' }}">
            <label for="RG" class="control-label">RG</label>
            <input for="RG" class="form-control" type="text" name="rg" value="{{ isset($registro->rg) ? $registro->rg :  old('rg') }}" />
            @if($errors->has('rg'))
                <small for="RG" class="control-label">{{ $errors->first('rg') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('cpf') ? 'has-error' : '' }}">
            <label for="CPF" class="control-label">CPF</label>
            <input for="CPF" class="form-control cpf" type="text" name="cpf" value="{{ isset($registro->cpf) ? $registro->cpf : old('cpf') }}" />
            @if($errors->has('cpf'))
                <small for="CPF" class="control-label">{{ $errors->first('cpf') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('dt_nasc') ? 'has-error' : '' }}">
            <label for="Nasc" class="control-label">Data de Nascimento</label>
            <input for="Nasc" class="form-control data" type="text" name="dt_nasc" value="{{ isset($registro->dt_nasc) ? date('d-m-Y', strtotime($registro->dt_nasc)) : old('dt_nasc') }}" />
            @if($errors->has('dt_nasc'))
                <small for="Nasc" class="control-label">{{ $errors->first('dt_nasc') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('sexo') ? 'has-error' : '' }}">
            <label for="Sexo" class="control-label">Sexo</label>
            <select for="Sexo" class="form-control js-example-responsive" name="sexo" >                
                <option value="M" {{ isset($registro->sexo) ? ($registro->sexo === 'M' ? 'selected' : '' ) : '' }}>Masculino</option>
                <option value="F" {{ isset($registro->sexo) ? ($registro->sexo === 'F' ? 'selected' : '' ) : '' }}>Feminino</option>
            </select>
            @if($errors->has('sexo'))
                <small for="Sexo" class="control-label">{{ $errors->first('sexo') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="Email" class="control-label">Email</label>
            <input for="Email" class="form-control" type="text" name="email" value="{{ isset($registro->email) ? $registro->email : old('email') }}"/>
            @if($errors->has('email'))
                <small for="Email" class="control-label">{{ $errors->first('email') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('celular') ? 'has-error' : '' }}">
            <label for="Celular" class="control-label">Celular</label>
            <input for="Celular" class="form-control telCel" type="text" name="celular" value="{{  isset($registro->celular) ? $registro->celular : old('celular') }}"/>
            @if($errors->has('celular'))
                <small for="Celular" class="control-label">{{ $errors->first('celular') }}</small>
            @endif
        </div>
    </div>

    <div class="box-header with-border"> 
        <h3 class="box-title">Endereço</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('cep') ? 'has-error' : '' }}">
                    <label for="Cep" class="control-label">CEP</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input for="Cep" class="form-control cep" type="text" name="cep" value="{{ isset($registro->cep) ? $registro->cep : old('cep') }}"/>
                            @if($errors->has('cep'))
                                <small for="Cep" class="control-label">{{ $errors->first('cep') }}</small>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-default" id="cep">Buscar CEP</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('endereco') ? 'has-error' : '' }}">
                    <label for="Endereco" class="control-label">Endereço</label>
                    <input for="Endereco" class="form-control" type="text" name="endereco" value="{{ isset($registro->endereco) ? $registro->endereco : old('endereco') }}" />
                    @if($errors->has('endereco'))
                        <small for="Endereco" class="control-label">{{ $errors->first('endereco') }}</small>
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('numero') ? 'has-error' : '' }}">
                    <label for="Numero" class="control-label">Número</label>
                    <input for="Numero" class="form-control" type="text" name="numero" value="{{ isset($registro->numero) ? $registro->numero : old('numero') }}" />
                    @if($errors->has('numero'))
                        <small for="Numero" class="control-label">{{ $errors->first('numero') }}</small>
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('complemento') ? 'has-error' : '' }}">
                    <label for="Complemento" class="control-label">Complemento</label>
                    <input for="Complemento" class="form-control" type="text" name="complemento" value="{{ isset($registro->complemento) ? $registro->complemento : old('complemento') }}"/>
                    @if($errors->has('complemento'))
                        <small for="Complemento" class="control-label">{{ $errors->first('complemento') }}</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('bairro') ? 'has-error' : '' }}">
                    <label for="Bairro" class="control-label">Bairro</label>
                    <input for="Bairro" class="form-control" type="text" name="bairro" value="{{ isset($registro->bairro) ? $registro->bairro : old('bairro') }}" />
                    @if($errors->has('bairro'))
                        <small for="Bairro" class="control-label">{{ $errors->first('bairro') }}</small>
                    @endif
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group {{ $errors->has('cidade') ? 'has-error' : '' }}">
                    <label for="Cidade" class="control-label">Cidade</label>
                    <input for="Cidade" class="form-control" type="text" name="cidade" value="{{ isset($registro->cidade) ? $registro->cidade : old('cidade') }}" />
                    @if($errors->has('cidade'))
                        <small for="Cidade" class="control-label">{{ $errors->first('cidade') }}</small>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group {{ $errors->has('estado') ? 'has-error' : '' }}">
                    <label for="UF" class="control-label">UF</label>
                    <input type="text" name="hiddenEstadoSigla" value="{{ isset($registro->estado) ? $registro->estado : old('estado') }}" hidden>
                    <select id="comboEstado" for="UF" name="estado" class="form-control js-example-responsive"></select>
                    @if($errors->has('estado'))
                        <small for="UF" class="control-label">{{ $errors->first('estado') }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>