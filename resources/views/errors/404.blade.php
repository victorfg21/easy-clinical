@extends('adminlte::page')

@section('title', 'CadMEI')

@section('content_header')
<script>
    $(document).ready(function(e) {
        swal({
                type: 'error',
                title: 'Ops!', 
                text: 'Página não encontrada!',
                confirmButtonText: 'Ok'
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