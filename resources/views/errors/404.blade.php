@extends('adminlte::page')

@section('title', 'CadMEI')

@section('content_header')

@stop

@section('content')

@stop

@section('js')
<script>
    $(document).ready(function() {
        Swal.fire({
            position: 'center',
            type: 'error',
            title: 'Ops!',
            text: 'Página não encontrada!',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            window.location.href = "/home";
        })
    });
</script>
@stop
