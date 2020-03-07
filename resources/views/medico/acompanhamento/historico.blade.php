<div class="box-body">

    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#histExame" data-toggle="tab">Exames</a></li>
            <li class="nav"><a href="#histReceita" data-toggle="tab">Receitas</a></li>
        </ul>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="histExame">
            <div class="box-body">
                <div class="col-md-12">
                    <br>
                    <div class="panel panel-default">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" id="tblHistExame">
                                <thead>
                                    <tr>
                                        <th class="col-xs-1">ID</th>
                                        <th class="col-xs-2">Data</th>
                                        <th class="col-xs-8">Observação</th>
                                        <th class="col-xs-1 center-block"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($solicitacoes_exames))
                                        @foreach ($solicitacoes_exames as $exame)
                                            <tr>
                                                <td class="col-xs-1">{{ $exame->id }}</td>
                                                <td class="col-xs-2 data" type="date" >{{ date('d-m-Y', strtotime($exame->created_at)) }}</td>
                                                <td class="col-xs-8">{{ strlen($exame->observacao) >= 85 ? substr($exame->observacao, 0, 85) . '...' : $exame->observacao }}</td>
                                                <td class="col-xs-1"><a class="printExame"><i class="fa fa-print fa-lg"></i></a></td>
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
        <div class="tab-pane fade" id="histReceita">
            <div class="box-body">
                <div class="col-md-12">
                    <br>
                    <div class="panel panel-default">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" id="tblHistReceita">
                                <thead>
                                    <tr>
                                        <th class="col-xs-1">ID</th>
                                        <th class="col-xs-2">Data</th>
                                        <th class="col-xs-8">Observação</th>
                                        <th class="col-xs-1 center-block"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($receitas))
                                        @foreach ($receitas as $receita)
                                            <tr>
                                                <td class="col-xs-1">{{ $receita->id }}</td>
                                                <td class="col-xs-2 data">{{ date('d-m-Y', strtotime($receita->created_at)) }}</td>
                                                <td class="col-xs-8">{{ strlen($receita->observacao) >= 85 ? substr($receita->observacao, 0, 85) . '...' : $receita->observacao }}</td>
                                                <td class="col-xs-1"><a class="printReceita" href="{{ route('medico.acompanhamento.printreceita', $receita->id) }}" target="_blank"><i class="fa fa-print fa-lg"></i></a></td>
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

<script src="{{ asset('js/mascaraform.js') }}"></script>
