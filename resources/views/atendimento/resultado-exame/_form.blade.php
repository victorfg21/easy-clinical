<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Lançamento de Resultado de Exame</h3>
    </div>
    <div class="box-body">
        <input type="hidden" name="solicitacao_exame_id" value="{{ $solicitacao_exame_id }}" />
        <div class="form-group col-md-12">
            <label for="profissional_id" class="control-label">Profissional</label>
            <select for="profissional_id" class="form-control js-example-responsive" name="profissional_id">
                @if(!isset($registro->profissional_id))
                {
                    <option value="" selected></option>
                    @foreach ($profissional_list as $profissional)
                        <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                    @endforeach
                }
                @endif
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="paciente_nome" class="control-label">Paciente</label>
            <input for="paciente_nome" class="form-control" type="text" name="paciente_nome" value="{{ isset($paciente) ? $paciente : '' }}" readonly />
        </div>
        <div class="form-group col-md-12">
            <div class="panel panel-default">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered" id="tblResultadoLinha">
                        <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-8">Exame</th>
                                <th class="col-md-3">Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($registro))
                                @foreach ($registro as $linha)
                                    <tr>
                                        <td class="col-md-1">{{ $linha->id }}</td>
                                        <td class="col-md-8"><input for="exame_nome" class="form-control" type="text" name="exame_nome" value="{{ $linha->exame_nome }}" readonly/></td>
                                        <td class="col-md-3"><input for="val_resultado" class="form-control" type="text" name="val_resultado" value="" /></td>
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
