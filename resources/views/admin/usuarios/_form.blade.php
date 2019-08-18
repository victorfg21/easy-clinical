<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Dados Gerais</h3>
    </div>
    <div class="box-body">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="Name" class="control-label">Nome</label>
            <input for="Name" class="form-control" type="text" name="name" value="{{ isset($registro->name) ? $registro->name : old('name') }}" />
            @if($errors->has('name'))
                <small for="Name" class="control-label">{{ $errors->first('name') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="Email" class="control-label">Email</label>
            <input for="Email" class="form-control" type="email" name="email" value="{{ isset($registro->email) ? $registro->email : old('email') }}" {{ isset($registro->email) ? 'readonly' : ''}}/>
            @if($errors->has('email'))
                <small for="Email" class="control-label">{{ $errors->first('email') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="Password" class="control-label">Senha</label>
            <input for="Password" class="form-control" type="password" name="password" value="{{ isset($registro->password) ? $registro->password : old('password') }}" />
            @if($errors->has('password'))
                <small for="Password" class="control-label">{{ $errors->first('password') }}</small>
            @endif
        </div>
        <div class="form-group {{ $errors->has('tipo_cadastro') ? 'has-error' : '' }}">
            <label for="TipoCadastro" class="control-label">Tipo Cadastro</label>
            <select for="TipoCadastro" class="form-control js-example-responsive" name="tipo_cadastro" disabled>
                <option value="1" {{ isset($registro->tipo_cadastro) ? ($registro->tipo_cadastro === '1' ? 'selected' : '' ) : '' }}>Profissional</option>
                <option value="2" {{ isset($registro->tipo_cadastro) ? ($registro->tipo_cadastro === '2' ? 'selected' : '' ) : '' }}>Paciente</option>
                @if(isset($registro->tipo_cadastro))
                    <option value="3" {{ isset($registro->tipo_cadastro) ? ($registro->tipo_cadastro === '3' ? 'selected' : '' ) : '' }}>Administrativo</option>
                @else
                    <option value="3" {{ !isset($registro->tipo_cadastro) ? 'selected' : '' }}>Administrativo</option>
                @endif
            </select>
            @if($errors->has('tipo_cadastro'))
                <small for="TipoCadastro" class="control-label">{{ $errors->first('tipo_cadastro') }}</small>
            @endif
        </div>
    </div>
</div>
