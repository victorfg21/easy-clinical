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
            <label for="exame_grupo_id" class="control-label">Grupo</label>
            <select for="exame_grupo_id" class="form-control js-example-responsive" name="exame_grupo_id" >
                @if(!isset($registro->exame_grupo_id))
                {
                    <option value="" selected></option>
                    @foreach ($exame_grupo_list as $exame_grupo)
                        <option value="{{ $exame_grupo->id }}">{{ $exame_grupo->nome }}</option>
                    @endforeach
                }
                @else
                {
                    @foreach ($exame_grupo_list as $exame_grupo)
                        @if($exame_grupo->id == $registro->exame_grupo_id)
                            <option value="{{ $exame_grupo->id }}" selected>{{ $exame_grupo->nome }}</option>
                        @else
                            <option value="{{ $exame_grupo->id }}">{{ $exame_grupo->nome }}</option>
                        @endif
                    @endforeach
                }
                @endif
            </select>
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
        <div class="form-group {{ $errors->has('observacao') ? 'has-error' : '' }}">
            <label for="observacao" class="control-label">Descrição</label>
            <textarea for="observacao" class="form-control" name="observacao"><!--{{ isset($registro->observacao) ? $registro->observacao : '' }}--></textarea>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="exame_linha">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row panel panel-default">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered" id="tblExameLinha">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">ID</th>
                                            <th class="col-md-4">Descrição</th>
                                            <th class="col-md-2">Mínimo</th>
                                            <th class="col-md-2">Máximo</th>
                                            <th class="col-md-2">Unidade</th>
                                            <th class="col-md-1">Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-info btn-md pull-right" id="btnAddLinhaExame"><i class="fa fa-plus fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/adicionaLinhaExame.js') }}"></script>
