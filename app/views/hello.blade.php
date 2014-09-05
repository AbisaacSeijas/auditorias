extends('layout.base')

@section('content')

<h1>Bienvenido {{ Auth::user()->name; }}</h1>
<a href="{{url('/logout')}}">Cerrar sesión.</a><br>
<a href="{{url('/visita/create')}}">Crear visita.</a><br>
<a href="{{url('/visita/')}}">Ver visitas.</a><br>

@stop
    