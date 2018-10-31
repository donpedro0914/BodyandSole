<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Body and Sole') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/front/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front/webfont.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" rel="stylesheet">
</head>
@if(\Request::is('login'))
<body class="bg-account-pages">
@else
<body>
@endif
    <div id="app">
        @yield('content')
        @include('global.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/jquery.core.js') }}"></script>
    <script src="{{ asset('js/jquery.app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/jquery.select-multiple.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.form-advanced.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    @stack('scripts');
</body>
</html>
