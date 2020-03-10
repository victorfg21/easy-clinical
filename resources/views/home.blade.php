@extends('adminlte::page')

@section('title', 'eClinical')

@section('content_header')
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Total Consultas x Profissionais</h3>

            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body" style="">
            <div class="chart">
                <canvas id="consultaChart" style="height: 200px; width: 500px;" width="547" height="254"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Total Exames</h3>

            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body" style="">
            <div class="chart">
                <canvas id="exameChart" style="height: 200; width: 500px;" width="547" height="254"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var ctx = document.getElementById("consultaChart").getContext('2d');
        var consultaChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [ @foreach ($dados_consultas as $consulta)
                                [ "{{ $consulta->nome }}" ],
                            @endforeach ],
                datasets: [{
                    label: 'Total execução consultas',
                    data: [ @foreach ($dados_consultas as $consulta)
                                [ "{{ $consulta->qtd }}" ],
                            @endforeach ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(173, 71, 16, 0.2)',
                        'rgba(173, 118, 16, 0.2)',
                        'rgba(173, 173, 16, 0.2)',
                        'rgba(149, 173, 16, 0.2)',
                        'rgba(102, 173, 16, 0.2)',
                        'rgba(47, 173, 16, 0.2)',
                        'rgba(16, 173, 40, 0.2)',
                        'rgba(16, 173, 107, 0.2)',
                        'rgba(16, 173, 162, 0.2)',
                        'rgba(16, 68, 173, 0.2)',
                        'rgba(16, 21, 173, 0.2)',
                        'rgba(73, 16, 173, 0.2)',
                        'rgba(115, 16, 173, 0.2)',
                        'rgba(154, 16, 173, 0.2)',
                        'rgba(173, 16, 66, 0.2)',
                        'rgba(16, 173, 47, 0.2)',
                        'rgba(173, 100, 16, 0.2)',
                        'rgba(16, 97, 173, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(173, 71, 16, 1)',
                        'rgba(173, 118, 16, 1)',
                        'rgba(173, 173, 16, 1)',
                        'rgba(149, 173, 16, 1)',
                        'rgba(102, 173, 16, 1)',
                        'rgba(47, 173, 16, 1)',
                        'rgba(16, 173, 40, 1)',
                        'rgba(16, 173, 107, 1)',
                        'rgba(16, 173, 162, 1)',
                        'rgba(16, 68, 173, 1)',
                        'rgba(16, 21, 173, 1)',
                        'rgba(73, 16, 173, 1)',
                        'rgba(115, 16, 173, 1)',
                        'rgba(154, 16, 173, 1)',
                        'rgba(173, 16, 66, 1)',
                        'rgba(16, 173, 47, 1)',
                        'rgba(173, 100, 16, 1)',
                        'rgba(16, 97, 173, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 10
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 10,
                            autoSkip: false
                        }
                    }]
                },
                legend: {
                    display: false,
                    position: 'top',
                    labels: {
                        fontColor: 'rgb(255, 99, 132)'
                    }
                },
                responsive: true,
            }
        });
    });

    $(document).ready(function() {
        var ctx = document.getElementById("exameChart").getContext('2d');
        var exameChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [ @foreach ($dados_exames as $exame)
                                [ "{{ $exame->nome }}" ],
                            @endforeach ],
                datasets: [{
                    label: 'Total realização de exames',
                    data: [ @foreach ($dados_exames as $exame)
                                [ "{{ $exame->qtd }}" ],
                            @endforeach ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(173, 71, 16, 0.2)',
                        'rgba(173, 118, 16, 0.2)',
                        'rgba(173, 173, 16, 0.2)',
                        'rgba(149, 173, 16, 0.2)',
                        'rgba(102, 173, 16, 0.2)',
                        'rgba(47, 173, 16, 0.2)',
                        'rgba(16, 173, 40, 0.2)',
                        'rgba(16, 173, 107, 0.2)',
                        'rgba(16, 173, 162, 0.2)',
                        'rgba(16, 68, 173, 0.2)',
                        'rgba(16, 21, 173, 0.2)',
                        'rgba(73, 16, 173, 0.2)',
                        'rgba(115, 16, 173, 0.2)',
                        'rgba(154, 16, 173, 0.2)',
                        'rgba(173, 16, 66, 0.2)',
                        'rgba(16, 173, 47, 0.2)',
                        'rgba(173, 100, 16, 0.2)',
                        'rgba(16, 97, 173, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(173, 71, 16, 1)',
                        'rgba(173, 118, 16, 1)',
                        'rgba(173, 173, 16, 1)',
                        'rgba(149, 173, 16, 1)',
                        'rgba(102, 173, 16, 1)',
                        'rgba(47, 173, 16, 1)',
                        'rgba(16, 173, 40, 1)',
                        'rgba(16, 173, 107, 1)',
                        'rgba(16, 173, 162, 1)',
                        'rgba(16, 68, 173, 1)',
                        'rgba(16, 21, 173, 1)',
                        'rgba(73, 16, 173, 1)',
                        'rgba(115, 16, 173, 1)',
                        'rgba(154, 16, 173, 1)',
                        'rgba(173, 16, 66, 1)',
                        'rgba(16, 173, 47, 1)',
                        'rgba(173, 100, 16, 1)',
                        'rgba(16, 97, 173, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 5
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 10,
                            autoSkip: false
                        }
                    }]
                },
                legend: {
                    display: false,
                    position: 'top',
                    labels: {
                        fontColor: 'rgb(255, 99, 132)'
                    }
                },
                responsive: true,
            }
        });
    });
</script>
@stop
