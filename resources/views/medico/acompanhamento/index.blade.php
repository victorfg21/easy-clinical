@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')

@stop

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Acompanhamento Médico</h3>
    </div>
    <div class="box-body">
        <div class="form-group col-md-4">
            <label for="profissional_id" class="control-label">Profissional</label>
            <select for="profissional_id" class="form-control js-example-responsive" name="profissional_id">
                <option value="" selected></option>
                @foreach ($profissional_list as $profissional)
                    @if ($user == $profissional->user_id)
                        <option value="{{ $profissional->id }}" selected>{{ $profissional->nome }}</option>

                    @else
                        <option value="{{ $profissional->id }}">{{ $profissional->nome }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="table-responsive col-md-12">
            <table id="tblConsultas" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1">Cod.</th>
                        <th style="display:none;">Paciente ID</th>
                        <th class="col-xs-7">Paciente</th>
                        <th class="col-xs-2">Horário</th>
                        <th class="col-xs-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($consulta_list))
                    @foreach ($consulta_list as $consulta)
                        <tr>
                            <td class="col-xs-1">{{ $consulta->id }}</td>
                            <td style="display:none;">{{ $consulta->paciente_id }}</td>
                            <td class="col-xs-10">{{ $consulta->nome }}</td>
                            <td class="col-xs-2 hora">{{ $consulta->horario_consulta }}</td>
                            <td class="col-xs-2"><a class="btnExecutarConsulta" href="{{ route('medico.acompanhamento.realizar', $consulta->id) }}"><i class="fa fa-check fa-lg"></i></a></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')

@stop
