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
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Observação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($solicitacoes_exames))
                                        @foreach ($solicitacoes_exames as $exame)
                                            <tr>
                                                <td></td>
                                                <td>{{ $exame->id }}</td>
                                                <td type="date" >{{ date('d/m/Y', strtotime($exame->created_at)) }}</td>
                                                <td>{{ strlen($exame->observacao) >= 85 ? substr($exame->observacao, 0, 85) . '...' : $exame->observacao }}</td>
                                                <td><a class="printExame" href="{{ route('medico.acompanhamento.printexame', $exame->id) }}" target="_blank"><i class="fa fa-print fa-lg"></i></a></td>
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
                                        <th></th>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Observação</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($receitas))
                                        @foreach ($receitas as $receita)
                                            <tr>
                                                <td></td>
                                                <td>{{ $receita->id }}</td>
                                                <td>{{ date('d/m/Y', strtotime($receita->created_at)) }}</td>
                                                <td>{{ strlen($receita->observacao) >= 85 ? substr($receita->observacao, 0, 85) . '...' : $receita->observacao }}</td>
                                                <td><a class="printReceita" href="{{ route('medico.acompanhamento.printreceita', $receita->id) }}" target="_blank"><i class="fa fa-print fa-lg"></i></a></td>
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

<script>
    var tblUsuarios = $('#tblHistExame').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        "responsive"  : true,
        "processing"  : false,
        "serverSide"  : false,
        "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "ID", "width": "15%" },
            { "data": "Data", "width": "45%" },
            { "data": "Observação", "width": "20%" },
            { "data": "", "width": "10%" },
        ],
        "columnDefs": [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 4, targets: 2 },
            { responsivePriority: 5, targets: 3 },
            { responsivePriority: 3, targets: 4 }
        ]
    });

    var tblUsuarios = $('#tblHistReceita').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        "responsive"  : true,
        "processing"  : false,
        "serverSide"  : false,
        "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            },
        "columns": [
            {"render": function (data, type, full, meta) {
                    return "";
                }, "width": "10%"},
            { "data": "ID", "width": "15%" },
            { "data": "Data", "width": "45%" },
            { "data": "Observação", "width": "20%" },
            { "data": "", "width": "20%" },
        ],
        "columnDefs": [
            { responsivePriority: 1, targets: 0, className: "control"},
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 4, targets: 2 },
            { responsivePriority: 5, targets: 3 },
            { responsivePriority: 3, targets: 4 }
        ]
    });
</script>
