<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
@yield('title', config('adminlte.title', 'eClinical'))
@yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.20/af-2.3.4/cr-1.5.2/fc-3.3.0/fh-3.1.6/r-2.2.3/datatables.min.css"/>
    @endif

    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Icon -->
    <link rel="shortcut icon" href="https://img.icons8.com/cotton/64/000000/clinic.png" />

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- SwertAler -->
    <link rel="stylesheet" href="sweetalert2.min.css">
</head>
<body class="hold-transition @yield('body_class')">

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>

@yield('body')

<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.2/dist/sweetalert2.all.min.js" integrity="sha256-e4Wd1TBf+OAA5INF7vCXGpnGqiXYg7WVvkXviW2XQKY=" crossorigin="anonymous"></script>

<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.20/af-2.3.4/cr-1.5.2/fc-3.3.0/fh-3.1.6/r-2.2.3/datatables.min.js"></script>
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif

<!--JavaScript do Sistema-->
<link rel="stylesheet" href="{{ asset('css/sweet-font.css') }}">
<script src="{{ asset('js/cep.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/mascaraform.js') }}"></script>

@yield('adminlte_js')

</body>
</html>
