@extends('layout.base')

@section('content')

<div class="panel panel-default">
    <div class="panel-body col-md-6 col-md-offset-3">
        {{-- Preguntamos si hay algún mensaje de error y si hay lo mostramos  --}}
        @if(Session::has('mensaje_error'))
            <div class="alert alert-danger">{{ Session::get('mensaje_error') }}</div>
        @endif
        {{ Form::open(array('url' => '/login')) }}
            <legend>Iniciar sesión</legend>
            <div class="form-group">
                {{ Form::label('usuario', 'Nombre de usuario') }}
                {{ Form::text('username', Input::old('username'), array('class' => 'form-control')); }}
            </div>
            <div class="form-group">
                {{ Form::label('contraseña', 'Contraseña') }}
                {{ Form::password('password', array('class' => 'form-control')); }}
            </div>
            {{ Form::submit('Enviar', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
</div>

@stop

