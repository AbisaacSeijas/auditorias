<!DOCTYPE html>
<html>
<head>
    <title>
        @section('title')
        Auditorias
        @show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('css_js')

    <script>var base_url = '{{url('/')}}'</script>
    <!-- Bootstrap -->
    {{HTML::style('css/bootstrap.css')}}
    {{HTML::style('css/bootstrap-custom.css')}}
    {{HTML::script('js/jquery-1.11.0.min.js')}}
    {{HTML::script('js/bootstrap.min.js')}}
    {{HTML::script('js/main.js')}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- MY STYLESHEETS -->
    {{HTML::style('css/affix-menu/affix.css')}}

    @show
</head>
<body>
    @if (!Auth::check()) {{-- USUARIO LOGUEADO --}}
        @include('layout.menu')
    @else {{-- USUARIO NO LOGUEADO --}}
        @yield('content')
    @endif
        
    @section('scripts')
    <!-- My scripts-->
    @show
</body>
</html>