@extends('layout.base')

@section('content')
@if (Session::has('message'))
	<div class="alert alert-success">{{Session::get('message');}}</div>
@endif
{{ Form::open(array('url' => 'auditorias/orden', 'method' => 'post')) }}
<div class="panel panel-primary">
<div class="panel-heading center"><p align="center">Cargar Orden</p></div>
	<ul class="list-group">
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Tipo de Cuenta</strong></div>
				<div class="col-md-6">
					<ul class="list-group">
						<li class="list-group-item">
							{{Form::select('tipo_cuenta', array('tax_account_number' => 'Cuenta Nueva', 'rent_account' => 'Cuenta Renta'), NULL, ['class' => 'form-control'])}}
						</li>
						<li class="list-group-item">
								{{Form::text('tax_account_number', NULL, ['class' => 'form-control'])}}
								{{Form::text('rent_account', NULL, ['class' => 'form-control'])}}
						</li>			
					</ul>
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Razón Social</strong></div>
				<div class="col-md-6"></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Actividades</strong></div>
				<div class="col-md-6"></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Dirección</strong></div>
				<div class="col-md-6"></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Teléfono</strong></div>
				<div class="col-md-6"></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Fecha de Asignación</strong></div>
				<div class="col-md-6">{{Form::input('date', 'fecha_asignacion', NULL, ['class' => 'form-control'])}}</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Motivo de la Auditoria</strong></div>
				<div class="col-md-6">{{Form::select('motivo', Auditoria::$motivos, NULL, ['class' => 'form-control'])}}</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><strong>Observaciones</strong></div>
				<div class="col-md-6">{{Form::textarea('observaciones', NULL, ['class' => 'form-control'])}}</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-6"><p align="right">{{Form::submit('Enviar')}}</p></div>
				@if(@$mostrar_formulario)
				<div class="col-md-6">{{Form::submit('Nuevo')}}</div>
				@endif
			</div>
		</li>
	</ul>
</div>
{{ Form::close() }}
@stop