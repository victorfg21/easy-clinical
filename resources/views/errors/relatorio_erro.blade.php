@extends('adminlte::page')

@section('title', 'CadMEI')

@section('content_header')
<script>
    $(document).ready(function(e) {
        swal({
                type: 'error',
                title: 'Ops!', 
                text: 'Filtro do relatório não retornou dados!',
                confirmButtonText: 'Ok'
            });
    });
</script>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.relatorios') }}" style="font-size: 50px; text-decoration: none">
            <i class="fa fa-line-chart fa-lg"></i>  Retornar para Relatórios
        </a>
    </div>
</div>

@stop