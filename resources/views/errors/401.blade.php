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
            text: 'Acesso não autorizado',
            showConfirmButton: false,
            timer: 2500
        }).then((result) => {
            window.location.href = "/home";
        })


    });
</script>
@stop
