<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Dados Gerais</h3>
    </div>
    <div class="box-body">
        <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
            <label for="Nome" class="control-label">Descrição</label>
            <input for="Nome" class="form-control" type="text" name="nome" value="{{ isset($registro->nome) ? $registro->nome : old('nome') }}" />
            @if($errors->has('nome'))
                <small for="Nome" class="control-label">{{ $errors->first('nome') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label for="exame_metodo_id" class="control-label">Método</label>
            <select for="exame_metodo_id" class="form-control js-example-responsive" name="exame_metodo_id" >
                @if(!isset($registro->exame_metodo_id))
                {
                    <option value="" selected></option>
                    @foreach ($exame_metodo_list as $exame_metodo)
                        <option value="{{ $exame_metodo->id }}">{{ $exame_metodo->nome }}</option>
                    @endforeach
                }
                @else
                {
                    @foreach ($exame_metodo_list as $exame_metodo)
                        @if($exame_metodo->id == $registro->exame_metodo_id)
                            <option value="{{ $exame_metodo->id }}" selected>{{ $exame_metodo->nome }}</option>
                        @else
                            <option value="{{ $exame_metodo->id }}">{{ $exame_metodo->nome }}</option>
                        @endif
                    @endforeach
                }
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="exame_material_id" class="control-label">Material</label>
            <select for="exame_material_id" class="form-control js-example-responsive" name="exame_material_id" >
                @if(!isset($registro->exame_material_id))
                {
                    <option value="" selected></option>
                    @foreach ($exame_material_list as $exame_material)
                        <option value="{{ $exame_material->id }}">{{ $exame_material->nome }}</option>
                    @endforeach
                }
                @else
                {
                    @foreach ($exame_material_list as $exame_material)
                        @if($exame_material->id == $registro->exame_material_id)
                            <option value="{{ $exame_material->id }}" selected>{{ $exame_material->nome }}</option>
                        @else
                            <option value="{{ $exame_material->id }}">{{ $exame_material->nome }}</option>
                        @endif
                    @endforeach
                }
                @endif
            </select>
        </div>
        <div class="tab-pane fade" id="area">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="valor_referencia_id" class="control-label">Área de Atuação</label>
                                <select for="valor_referencia_id" class="form-control js-example-responsive" name="valor_referencia_id">
                                    @foreach ($valor_referencia_list as $valor_referencia)
                                            <option value="{{ $valor_referencia->id }}">{{ $valor_referencia->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <a class="btn btn-primary btn-md" id="btnSetItemValorRef">Adicionar</a>
                            </div>
                        </div>
                    </div>
                    <div class="row panel panel-default">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" id="tblValorReferencia">
                                <thead>
                                    <tr>
                                        <th class="col-xs-1">ID</th>
                                        <th class="col-xs-10">Descrição</th>
                                        <th class="col-xs-1">Remover</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($valores_referencia_exame))
                                        @foreach ($valores_referencia_exame as $valorReferencia)
                                            <tr>
                                                <td class="col-xs-1">{{ $valorReferencia->id }}</td>
                                                <td class="col-xs-10">{{ $valorReferencia->nome }}</td>
                                                <td class="col-xs-1"><a class="btnDelLinhaValorRef"><i class="fa fa-trash fa-lg"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
