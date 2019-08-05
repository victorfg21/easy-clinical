@extends('adminlte::page')

@section('title', 'CadMEI')

@section('content_header')
<script>
    $(document).ready(function() {
        var link = [ "{{route('admin.atendimentos') }}" ];
        console.log(link);
        swal({
                type: 'error',
                title: 'Ops!', 
                text: 'Acesso não autorizado',
                confirmButtonText: '<a href="' + link + '"><i class="fa fa-arrow-circle-left fa-lg"></i>  Ok</a>'
            });
    });
</script>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="{{ route('home') }}" style="font-size: 50px; text-decoration: none">
            <i class="fa fa-home fa-lg"></i>  Retornar para Dashboard
        </a>
    </div>
</div>

@stop